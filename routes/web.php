<?php

use App\Livewire\Admin\CommoditiesIndex;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\DownloadablesIndex;
use App\Livewire\Admin\FishermenIndex;
use App\Livewire\Admin\FleetsIndex;
use App\Livewire\Admin\InfrastructuresIndex;
use App\Livewire\Admin\MapZonesIndex;
use App\Livewire\Admin\NewsIndex;
use App\Livewire\Admin\PlansIndex;
use App\Livewire\Admin\PopulationIndex;
use App\Livewire\Admin\PotentialsIndex;
use App\Livewire\Admin\ProductionsIndex;
use App\Livewire\Admin\ProfilesIndex;
use App\Livewire\Admin\WelfareIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Pages\Beranda;
use App\Livewire\Pages\BeritaDetail;
use App\Livewire\Pages\BeritaIndex;
use App\Livewire\Pages\KebijakanPrivasi;
use App\Livewire\Pages\Kependudukan;
use App\Livewire\Pages\Kesejahteraan;
use App\Livewire\Pages\Kontak;
use App\Livewire\Pages\Laporan;
use App\Livewire\Pages\Nelayan;
use App\Livewire\Pages\Perencanaan;
use App\Livewire\Pages\Peta;
use App\Livewire\Pages\Potensi;
use App\Livewire\Pages\Profil;
use App\Livewire\Pages\Sarana;
use App\Livewire\Pages\Tentang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', Beranda::class)->name('home');
Route::get('/profil', Profil::class)->name('profil');
Route::get('/kependudukan', Kependudukan::class)->name('kependudukan');
Route::get('/nelayan', Nelayan::class)->name('nelayan');
Route::get('/sarana', Sarana::class)->name('sarana');
Route::get('/potensi', Potensi::class)->name('potensi');
Route::get('/kesejahteraan', Kesejahteraan::class)->name('kesejahteraan');
Route::get('/perencanaan', Perencanaan::class)->name('perencanaan');
Route::get('/peta', Peta::class)->name('peta');
Route::get('/laporan', Laporan::class)->name('laporan');
Route::get('/berita', BeritaIndex::class)->name('berita.index');
Route::get('/berita/{post}', BeritaDetail::class)->name('berita.show');
Route::get('/tentang', Tentang::class)->name('tentang');
Route::get('/kontak', Kontak::class)->name('kontak');
Route::get('/kebijakan-privasi', KebijakanPrivasi::class)->name('kebijakan-privasi');

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
});

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect()->route('home');
})->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboard::class)->name('dashboard');
    Route::get('/nelayan', FishermenIndex::class)->name('fishermen');
    Route::get('/armada', FleetsIndex::class)->name('fleets');
    Route::get('/produksi', ProductionsIndex::class)->name('productions');
    Route::get('/komoditas', CommoditiesIndex::class)->name('commodities');
    Route::get('/sarana', InfrastructuresIndex::class)->name('infrastructures');
    Route::get('/berita', NewsIndex::class)->name('news');
    Route::get('/unduhan', DownloadablesIndex::class)->name('downloadables');
    Route::get('/profil', ProfilesIndex::class)->name('profiles');
    Route::get('/kependudukan', PopulationIndex::class)->name('population');
    Route::get('/potensi', PotentialsIndex::class)->name('potentials');
    Route::get('/kesejahteraan', WelfareIndex::class)->name('welfare');
    Route::get('/perencanaan', PlansIndex::class)->name('plans');
    Route::get('/peta', MapZonesIndex::class)->name('map-zones');
});
