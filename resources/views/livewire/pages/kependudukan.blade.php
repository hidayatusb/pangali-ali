<div>
    <x-page-header title="Data Kependudukan" subtitle="Ringkasan agregat penduduk Kelurahan Pangali-Ali" />

    <div class="mb-6 grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">Total Penduduk</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($totalResidents, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">Laki-laki</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($maleCount, 0, ',', '.') }}</p>
        </div>
        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium tracking-wide text-slate-500 uppercase">Perempuan</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ number_format($femaleCount, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="mb-6 grid gap-4 lg:grid-cols-2" wire:ignore>
        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Berdasarkan Jenis Kelamin</h2>
            <div class="mx-auto h-56 max-w-xs">
                <canvas id="genderChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Berdasarkan Status Perkawinan</h2>
            <div class="mx-auto h-56 max-w-xs">
                <canvas id="maritalChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Berdasarkan Pekerjaan</h2>
            <div class="h-64">
                <canvas id="occupationChart"></canvas>
            </div>
        </div>

        <div class="rounded-xl border border-ocean-200 bg-white p-5 shadow-sm">
            <h2 class="mb-4 text-sm font-bold text-slate-800">Berdasarkan Agama</h2>
            <div class="mx-auto h-56 max-w-xs">
                <canvas id="religionChart"></canvas>
            </div>
        </div>
    </div>

    @auth
        @if (auth()->user()->isAdmin())
            <div class="rounded-xl border border-ocean-200 bg-ocean-50 px-4 py-3 text-sm text-ocean-900">
                Data detail penduduk bersifat privat.
                <a href="{{ route('admin.population') }}" class="font-semibold text-ocean-700 underline hover:text-ocean-900">Kelola di Panel Admin</a>
            </div>
        @endif
    @endauth
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (!window.Chart) return;

        const doughnutOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } }
            }
        };

        const makeDoughnut = (id, data) => {
            const el = document.getElementById(id);
            if (!el || !data.labels.length) return;
            new Chart(el, {
                type: 'doughnut',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        backgroundColor: data.colors,
                        borderWidth: 0,
                        cutout: '58%'
                    }]
                },
                options: doughnutOptions
            });
        };

        makeDoughnut('genderChart', @json($genderChart));
        makeDoughnut('maritalChart', @json($maritalChart));
        makeDoughnut('religionChart', @json($religionChart));

        const occupationEl = document.getElementById('occupationChart');
        const occupationData = @json($occupationChart);
        if (occupationEl && occupationData.labels.length) {
            new Chart(occupationEl, {
                type: 'bar',
                data: {
                    labels: occupationData.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: occupationData.values,
                        backgroundColor: occupationData.colors,
                        borderRadius: 6,
                        maxBarThickness: 36
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#e2e8f0' } },
                        x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 0, font: { size: 10 } } }
                    }
                }
            });
        }
    });
</script>
@endpush
