<?php

namespace App\Imports;

use App\Models\Resident;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ResidentsImport implements SkipsEmptyRows, SkipsOnFailure, ToModel, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
    use Importable;
    use SkipsFailures;

    private int $skippedDuplicates = 0;

    /** @var array<string, true> */
    private array $seenFingerprints = [];

    public function model(array $row): ?Resident
    {
        $name = trim((string) ($row['nama'] ?? ''));

        if ($name === '') {
            return null;
        }

        $phone = trim((string) ($row['no_hp'] ?? ''));
        $phone = $phone !== '' ? $phone : null;

        $attributes = [
            'name' => $name,
            'address' => trim((string) ($row['alamat'] ?? '')),
            'occupation' => trim((string) ($row['pekerjaan'] ?? '')),
            'gender' => $this->normalizeGender((string) ($row['jenis_kelamin'] ?? '')),
            'phone' => $phone,
            'marital_status' => $this->normalizeMaritalStatus((string) ($row['status_perkawinan'] ?? '')),
            'religion' => trim((string) ($row['agama'] ?? '')),
        ];

        $fingerprint = $this->fingerprint($attributes);

        if (isset($this->seenFingerprints[$fingerprint]) || $this->residentExists($attributes)) {
            $this->skippedDuplicates++;
            $this->seenFingerprints[$fingerprint] = true;

            return null;
        }

        $this->seenFingerprints[$fingerprint] = true;

        return new Resident($attributes);
    }

    public function skippedDuplicates(): int
    {
        return $this->skippedDuplicates;
    }

    /**
     * @return array<string, list<mixed>>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'pekerjaan' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['laki-laki', 'perempuan'])],
            'no_hp' => ['nullable', 'string', 'max:50'],
            'status_perkawinan' => ['required', Rule::in(['belum-kawin', 'kawin', 'cerai-hidup', 'cerai-mati'])],
            'agama' => ['required', 'string', 'max:50'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function customValidationAttributes(): array
    {
        return [
            'nama' => 'nama',
            'alamat' => 'alamat',
            'pekerjaan' => 'pekerjaan',
            'jenis_kelamin' => 'jenis kelamin',
            'no_hp' => 'no HP',
            'status_perkawinan' => 'status perkawinan',
            'agama' => 'agama',
        ];
    }

    /**
     * @param  array<string, mixed>  $row
     * @return array<string, mixed>
     */
    public function prepareForValidation(array $row, int $index): array
    {
        if (array_key_exists('jenis_kelamin', $row)) {
            $row['jenis_kelamin'] = $this->normalizeGender((string) $row['jenis_kelamin']);
        }

        if (array_key_exists('status_perkawinan', $row)) {
            $row['status_perkawinan'] = $this->normalizeMaritalStatus((string) $row['status_perkawinan']);
        }

        if (array_key_exists('no_hp', $row) && $row['no_hp'] !== null) {
            $row['no_hp'] = trim((string) $row['no_hp']);
            if ($row['no_hp'] === '') {
                $row['no_hp'] = null;
            }
        }

        return $row;
    }

    public function batchSize(): int
    {
        return 200;
    }

    public function chunkSize(): int
    {
        return 200;
    }

    /**
     * @param  array{name: string, address: string, occupation: string, gender: string, phone: ?string, marital_status: string, religion: string}  $attributes
     */
    private function residentExists(array $attributes): bool
    {
        return Resident::query()
            ->where('name', $attributes['name'])
            ->where('address', $attributes['address'])
            ->where('occupation', $attributes['occupation'])
            ->where('gender', $attributes['gender'])
            ->where('phone', $attributes['phone'])
            ->where('marital_status', $attributes['marital_status'])
            ->where('religion', $attributes['religion'])
            ->exists();
    }

    /**
     * @param  array{name: string, address: string, occupation: string, gender: string, phone: ?string, marital_status: string, religion: string}  $attributes
     */
    private function fingerprint(array $attributes): string
    {
        return implode('|', [
            Str::lower($attributes['name']),
            Str::lower($attributes['address']),
            Str::lower($attributes['occupation']),
            $attributes['gender'],
            $attributes['phone'] ?? '',
            $attributes['marital_status'],
            Str::lower($attributes['religion']),
        ]);
    }

    private function normalizeGender(string $value): string
    {
        $normalized = Str::lower(trim($value));

        return match ($normalized) {
            'laki-laki', 'laki laki', 'laki', 'l', 'pria', 'male' => 'laki-laki',
            'perempuan', 'wanita', 'p', 'female' => 'perempuan',
            default => $normalized,
        };
    }

    private function normalizeMaritalStatus(string $value): string
    {
        $normalized = Str::lower(trim(str_replace('_', '-', $value)));

        return match ($normalized) {
            'belum-kawin', 'belum kawin' => 'belum-kawin',
            'kawin', 'menikah', 'married' => 'kawin',
            'cerai-hidup', 'cerai hidup' => 'cerai-hidup',
            'cerai-mati', 'cerai mati' => 'cerai-mati',
            default => Str::slug($normalized, '-'),
        };
    }
}
