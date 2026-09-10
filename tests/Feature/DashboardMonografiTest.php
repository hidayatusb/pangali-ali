<?php

use App\Enums\UserRole;
use App\Exports\ResidentsExport;
use App\Livewire\Admin\DownloadablesIndex;
use App\Livewire\Admin\FishermenIndex;
use App\Livewire\Admin\NewsIndex;
use App\Livewire\Admin\PopulationIndex;
use App\Livewire\Auth\Login;
use App\Models\Downloadable;
use App\Models\Fisherman;
use App\Models\NewsPost;
use App\Models\Resident;
use App\Models\User;
use App\Models\VillageProfile;
use App\Services\DashboardStatsService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

it('allows guests to view the beranda dashboard', function () {
    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Dashboard Monografi Kelurahan Pangali-Ali');
});

it('shows population and fishermen KPI from residents on beranda', function () {
    Resident::factory()->count(5)->create(['occupation' => 'Pedagang']);
    Resident::factory()->count(3)->create(['occupation' => 'Nelayan']);

    $kpis = app(DashboardStatsService::class)->kpis();

    expect($kpis['population']['value'])->toBe('8')
        ->and($kpis['fishermen']['value'])->toBe('3');

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Jumlah Penduduk')
        ->assertSee('Jumlah Nelayan');
});

it('allows guests to view public menu pages', function () {
    VillageProfile::factory()->create();

    foreach ([
        'profil',
        'kependudukan',
        'sarana',
        'potensi',
        'kesejahteraan',
        'perencanaan',
        'peta',
        'laporan',
        'tentang',
        'kontak',
        'kebijakan-privasi',
    ] as $route) {
        $this->get(route($route))->assertSuccessful();
    }
});

it('redirects guests away from admin dashboard', function () {
    $this->get(route('admin.dashboard'))
        ->assertRedirect(route('login'));
});

it('forbids non-admin users from accessing admin', function () {
    $viewer = User::factory()->create(['role' => UserRole::Viewer]);

    $this->actingAs($viewer)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('allows admin to access the admin dashboard', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Ringkasan Admin');
});

it('authenticates an admin via the login page', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'login-test@pangali-ali.test',
        'password' => 'password',
    ]);

    Livewire::test(Login::class)
        ->set('email', $admin->email)
        ->set('password', 'password')
        ->call('login')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.dashboard'));

    $this->assertAuthenticatedAs($admin);
});

it('allows admin to create a fisherman', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(FishermenIndex::class)
        ->call('create')
        ->set('name', 'Nelayan Uji')
        ->set('age', '40')
        ->set('gender', 'laki-laki')
        ->set('boat_type', 'Perahu Motor')
        ->call('save')
        ->assertHasNoErrors();

    expect(Fisherman::query()->where('name', 'Nelayan Uji')->exists())->toBeTrue();
});

it('allows admin to sort fishermen table columns', function () {
    $admin = User::factory()->admin()->create();
    Fisherman::factory()->create(['name' => 'Budi Sort', 'age' => 50]);
    Fisherman::factory()->create(['name' => 'Andi Sort', 'age' => 30]);

    Livewire::actingAs($admin)
        ->test(FishermenIndex::class)
        ->call('sort', 'name')
        ->assertSet('sortBy', 'name')
        ->assertSet('sortDirection', 'asc')
        ->call('sort', 'name')
        ->assertSet('sortDirection', 'desc')
        ->assertOk();
});

it('allows admin to create a resident', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(PopulationIndex::class)
        ->call('create')
        ->set('name', 'Siti Penduduk')
        ->set('address', 'Lingkungan 2, Pangali-Ali')
        ->set('occupation', 'Pedagang')
        ->set('gender', 'perempuan')
        ->set('phone', '081234567890')
        ->set('marital_status', 'kawin')
        ->set('religion', 'Islam')
        ->call('save')
        ->assertHasNoErrors();

    expect(Resident::query()->where('name', 'Siti Penduduk')->exists())->toBeTrue();
});

it('allows admin to export residents to excel', function () {
    Excel::fake();
    Excel::matchByRegex();

    $admin = User::factory()->admin()->create();
    Resident::factory()->create(['name' => 'Penduduk Ekspor']);

    Livewire::actingAs($admin)
        ->test(PopulationIndex::class)
        ->call('export');

    Excel::assertDownloaded('/^data-penduduk-.*\.xlsx$/', function ($export): bool {
        return $export instanceof ResidentsExport;
    });
});

it('allows admin to import residents from excel', function () {
    $admin = User::factory()->admin()->create();

    $path = 'imports/test-residents.xlsx';

    Excel::store(new class implements FromArray, WithHeadings
    {
        public function array(): array
        {
            return [
                ['Budi Import', 'Lingkungan 3, Pangali-Ali', 'Nelayan', 'Laki-laki', '081122334455', 'Kawin', 'Islam'],
                ['Ani Import', 'Lingkungan 4, Pangali-Ali', 'Pedagang', 'Perempuan', '', 'Belum Kawin', 'Islam'],
            ];
        }

        public function headings(): array
        {
            return ['nama', 'alamat', 'pekerjaan', 'jenis_kelamin', 'no_hp', 'status_perkawinan', 'agama'];
        }
    }, $path);

    $upload = UploadedFile::fake()->createWithContent(
        'test-residents.xlsx',
        Storage::get($path)
    );

    Livewire::actingAs($admin)
        ->test(PopulationIndex::class)
        ->call('openImport')
        ->set('importFile', $upload)
        ->call('import')
        ->assertHasNoErrors();

    expect(Resident::query()->where('name', 'Budi Import')->where('occupation', 'Nelayan')->exists())->toBeTrue()
        ->and(Resident::query()->where('name', 'Ani Import')->where('gender', 'perempuan')->exists())->toBeTrue();
});

it('skips duplicate residents when the same excel file is imported again', function () {
    $admin = User::factory()->admin()->create();

    $path = 'imports/test-residents-duplicates.xlsx';

    Excel::store(new class implements FromArray, WithHeadings
    {
        public function array(): array
        {
            return [
                ['Sari Duplikat', 'Lingkungan 1, Pangali-Ali', 'Nelayan', 'Perempuan', '081199988877', 'Kawin', 'Islam'],
            ];
        }

        public function headings(): array
        {
            return ['nama', 'alamat', 'pekerjaan', 'jenis_kelamin', 'no_hp', 'status_perkawinan', 'agama'];
        }
    }, $path);

    $upload = fn () => UploadedFile::fake()->createWithContent(
        'test-residents-duplicates.xlsx',
        Storage::get($path)
    );

    Livewire::actingAs($admin)
        ->test(PopulationIndex::class)
        ->call('openImport')
        ->set('importFile', $upload())
        ->call('import')
        ->assertHasNoErrors();

    expect(Resident::query()->where('name', 'Sari Duplikat')->count())->toBe(1);

    Livewire::actingAs($admin)
        ->test(PopulationIndex::class)
        ->call('openImport')
        ->set('importFile', $upload())
        ->call('import')
        ->assertHasNoErrors()
        ->assertSee('1 data duplikat dilewati');

    expect(Resident::query()->where('name', 'Sari Duplikat')->count())->toBe(1);
});

it('allows guests to view a published news detail page', function () {
    $post = NewsPost::factory()->create([
        'title' => 'Detail Berita Publik',
        'slug' => 'detail-berita-publik',
        'excerpt' => 'Ringkasan berita publik',
        'body' => 'Isi lengkap berita untuk pengujian halaman detail.',
        'published_at' => now()->subDay(),
        'is_published' => true,
    ]);

    $this->get(route('berita.show', $post))
        ->assertSuccessful()
        ->assertSee('Detail Berita Publik')
        ->assertSee('Isi lengkap berita untuk pengujian halaman detail.');
});

it('hides unpublished news from public detail', function () {
    $post = NewsPost::factory()->create([
        'slug' => 'berita-draft',
        'is_published' => false,
        'published_at' => now(),
    ]);

    $this->get(route('berita.show', $post))->assertNotFound();
});

it('allows guests to view the berita index', function () {
    NewsPost::factory()->create([
        'title' => 'Berita di Indeks',
        'slug' => 'berita-di-indeks',
        'published_at' => now()->subDay(),
        'is_published' => true,
    ]);

    $this->get(route('berita.index'))
        ->assertSuccessful()
        ->assertSee('Berita di Indeks');
});

it('allows admin to create a news post', function () {
    $admin = User::factory()->admin()->create();

    Livewire::actingAs($admin)
        ->test(NewsIndex::class)
        ->call('create')
        ->set('title', 'Berita Uji Dashboard')
        ->set('excerpt', 'Ringkasan berita uji')
        ->set('body', 'Isi berita uji')
        ->set('published_at', now()->format('Y-m-d'))
        ->set('is_published', true)
        ->call('save')
        ->assertHasNoErrors();

    expect(NewsPost::query()->where('title', 'Berita Uji Dashboard')->exists())->toBeTrue();
});

it('allows admin to upload a news image', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $image = UploadedFile::fake()->image('berita-pantai.jpg', 800, 450);

    Livewire::actingAs($admin)
        ->test(NewsIndex::class)
        ->call('create')
        ->set('title', 'Berita Dengan Gambar')
        ->set('excerpt', 'Ringkasan dengan foto')
        ->set('body', 'Isi berita dengan foto')
        ->set('published_at', now()->format('Y-m-d'))
        ->set('is_published', true)
        ->set('image', $image)
        ->call('save')
        ->assertHasNoErrors();

    $post = NewsPost::query()->where('title', 'Berita Dengan Gambar')->first();

    expect($post)->not->toBeNull()
        ->and($post->image_path)->not->toBeNull();

    Storage::disk('public')->assertExists($post->image_path);
});

it('allows admin to upload a downloadable file', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $upload = UploadedFile::fake()->create('monografi-2024.pdf', 120, 'application/pdf');

    Livewire::actingAs($admin)
        ->test(DownloadablesIndex::class)
        ->call('create')
        ->set('title', 'Laporan Uji Unduhan')
        ->set('category', 'laporan')
        ->set('description', 'Dokumen uji unggah')
        ->set('published_at', now()->format('Y-m-d'))
        ->set('file', $upload)
        ->call('save')
        ->assertHasNoErrors();

    $item = Downloadable::query()->where('title', 'Laporan Uji Unduhan')->first();

    expect($item)->not->toBeNull()
        ->and($item->file_name)->toBe('monografi-2024.pdf')
        ->and($item->file_path)->not->toBeNull();

    Storage::disk('public')->assertExists($item->file_path);
});
