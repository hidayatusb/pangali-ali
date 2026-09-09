<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Commodity;
use App\Models\DevelopmentPlan;
use App\Models\Downloadable;
use App\Models\Fisherman;
use App\Models\FisheryProduction;
use App\Models\Infrastructure;
use App\Models\MapZone;
use App\Models\NewsPost;
use App\Models\PopulationStat;
use App\Models\RegionalPotential;
use App\Models\Resident;
use App\Models\User;
use App\Models\VillageProfile;
use App\Models\WelfareIndicator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin Kelurahan',
            'email' => 'admin@pangali-ali.test',
            'password' => 'password',
            'role' => UserRole::Admin,
        ]);

        VillageProfile::query()->create([
            'name' => 'Kelurahan Pangali-Ali',
            'district' => 'Majene',
            'regency' => 'Kabupaten Majene',
            'province' => 'Sulawesi Barat',
            'vision' => 'Mewujudkan kelurahan pesisir yang sejahtera, berdaya saing, dan berkelanjutan berbasis data nelayan.',
            'mission' => "1. Meningkatkan kapasitas aparatur dan nelayan.\n2. Memperkuat data monografi untuk perencanaan.\n3. Melestarikan ekosistem laut dan mangrove.",
            'history' => 'Kelurahan Pangali-Ali merupakan kawasan pesisir dengan mayoritas penduduk bermata pencaharian sebagai nelayan.',
            'description' => 'Dashboard monografi ini mendukung perencanaan pembangunan berbasis data nelayan melalui pendampingan aparatur kelurahan.',
            'area_km2' => 4.85,
            'lurah_name' => 'Lurah Pangali-Ali',
        ]);

        PopulationStat::query()->create(['year' => 2023, 'total' => 3380, 'male' => 1690, 'female' => 1690, 'growth_percent' => 1.80]);
        PopulationStat::query()->create(['year' => 2024, 'total' => 3452, 'male' => 1728, 'female' => 1724, 'growth_percent' => 2.10]);

        Resident::factory()->count(250)->create(['occupation' => 'Nelayan']);
        Resident::factory()->count(100)->create();

        // Distribusi usia sesuai desain: 15-24 12.5%, 25-34 24.8%, 35-44 32.4%, 45-54 18.6%, ≥55 11.7% dari 612
        $ageBuckets = [
            [15, 24, 76],
            [25, 34, 152],
            [35, 44, 198],
            [45, 54, 114],
            [55, 70, 72],
        ];

        foreach ($ageBuckets as [$min, $max, $count]) {
            Fisherman::factory()->count($count)->create([
                'age' => fake()->numberBetween($min, $max),
            ]);
        }

        $productions = [
            [2020, 980, 12_500_000_000],
            [2021, 1050, 13_800_000_000],
            [2022, 1120, 15_200_000_000],
            [2023, 1190, 17_600_000_000],
            [2024, 1285, 18_700_000_000],
        ];

        foreach ($productions as [$year, $ton, $value]) {
            FisheryProduction::query()->create([
                'year' => $year,
                'total_ton' => $ton,
                'economic_value' => $value,
            ]);
        }

        $commodities = [
            ['Ikan Pelagis', 45, 578.25, '#3b82f6'],
            ['Ikan Demersal', 25, 321.25, '#22c55e'],
            ['Cumi-cumi', 12, 154.20, '#f97316'],
            ['Udang', 8, 102.80, '#ef4444'],
            ['Lainnya', 10, 128.50, '#a855f7'],
        ];

        foreach ($commodities as [$name, $pct, $ton, $color]) {
            Commodity::query()->create([
                'name' => $name,
                'percentage' => $pct,
                'tonnage' => $ton,
                'color' => $color,
                'year' => 2024,
            ]);
        }

        $infrastructures = [
            ['Pelabuhan Perikanan', 1, 'anchor', 1],
            ['TPI', 1, 'store', 2],
            ['Cold Storage', 2, 'snowflake', 3],
            ['SPBU Nelayan', 1, 'fuel', 4],
            ['Bengkel Kapal', 3, 'wrench', 5],
        ];

        foreach ($infrastructures as [$name, $count, $icon, $order]) {
            Infrastructure::query()->create([
                'name' => $name,
                'count' => $count,
                'unit' => 'unit',
                'icon' => $icon,
                'category' => 'perikanan',
                'sort_order' => $order,
            ]);
        }

        RegionalPotential::query()->insert([
            ['title' => 'Zona Penangkapan Ikan', 'category' => 'perikanan', 'description' => 'Wilayah tangkap tradisional nelayan Pangali-Ali.', 'icon' => 'fish', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Kawasan Mangrove', 'category' => 'lingkungan', 'description' => 'Hutan mangrove sebagai penyangga ekosistem pesisir.', 'icon' => 'leaf', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pariwisata Bahari', 'category' => 'ekonomi', 'description' => 'Potensi wisata pantai dan budaya nelayan.', 'icon' => 'sun', 'created_at' => now(), 'updated_at' => now()],
        ]);

        WelfareIndicator::query()->insert([
            ['name' => 'Keluarga Nelayan Penerima Bantuan', 'value' => '186', 'unit' => 'KK', 'year' => 2024, 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kepemilikan Asuransi Nelayan', 'value' => '42', 'unit' => '%', 'year' => 2024, 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Akses Air Bersih', 'value' => '91', 'unit' => '%', 'year' => 2024, 'notes' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DevelopmentPlan::query()->insert([
            ['title' => 'Revitalisasi TPI', 'year' => 2025, 'status' => 'berjalan', 'description' => 'Peningkatan fasilitas TPI dan cold chain.', 'budget' => 850_000_000, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pelatihan Kapasitas Nelayan', 'year' => 2025, 'status' => 'rencana', 'description' => 'Pendampingan aparatur dan pelatihan nelayan.', 'budget' => 120_000_000, 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Rehabilitasi Mangrove', 'year' => 2024, 'status' => 'selesai', 'description' => 'Penanaman mangrove di zona pesisir.', 'budget' => 95_000_000, 'created_at' => now(), 'updated_at' => now()],
        ]);

        MapZone::query()->insert([
            ['name' => 'Zona Penangkapan', 'type' => 'fishing', 'color' => '#3b82f6', 'latitude' => -3.5400000, 'longitude' => 118.9700000, 'geojson' => null, 'description' => 'Area tangkap utama', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Permukiman', 'type' => 'residential', 'color' => '#f97316', 'latitude' => -3.5420000, 'longitude' => 118.9680000, 'geojson' => null, 'description' => 'Kawasan hunian', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pelabuhan', 'type' => 'port', 'color' => '#ef4444', 'latitude' => -3.5390000, 'longitude' => 118.9720000, 'geojson' => null, 'description' => 'Pelabuhan perikanan', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mangrove', 'type' => 'mangrove', 'color' => '#22c55e', 'latitude' => -3.5450000, 'longitude' => 118.9650000, 'geojson' => null, 'description' => 'Kawasan mangrove', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $news = [
            ['Pelatihan Peningkatan Kapasitas Nelayan', '2025-08-12', 'Kegiatan pelatihan teknik penangkapan dan pengelolaan hasil laut.'],
            ['Bantuan Alat Tangkap dari Pemerintah Daerah', '2025-07-28', 'Penyaluran bantuan alat tangkap kepada kelompok nelayan.'],
            ['Sosialisasi Asuransi Nelayan', '2025-07-05', 'Sosialisasi perlindungan asuransi bagi nelayan tradisional.'],
        ];

        foreach ($news as [$title, $date, $excerpt]) {
            NewsPost::query()->create([
                'title' => $title,
                'slug' => Str::slug($title),
                'excerpt' => $excerpt,
                'body' => $excerpt.' '.fake()->paragraphs(2, true),
                'published_at' => $date,
                'is_published' => true,
            ]);
        }

        Downloadable::query()->insert([
            ['title' => 'Laporan Monografi Kelurahan 2024', 'category' => 'laporan', 'file_path' => null, 'file_name' => 'monografi-2024.pdf', 'file_size' => null, 'description' => 'Ringkasan data monografi tahunan.', 'published_at' => '2025-01-15', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Data Produksi Perikanan 2020-2024', 'category' => 'data', 'file_path' => null, 'file_name' => 'produksi-perikanan.xlsx', 'file_size' => null, 'description' => 'Rekap produksi perikanan lima tahun.', 'published_at' => '2025-02-01', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
