<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @can('access-admin')
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <a href="{{ route('user.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        User <span class="bg-pink-100 rounded p-1">{{ $totalUser }}</span>
                                    </p>
                                </div>
                            </a>
                            <a href="{{ route('unit.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Unit <span class="bg-yellow-100 rounded p-1">{{ $totalUnit }}</span>
                                    </p>
                                </div>
                            </a>
                            <a href="{{ route('obat.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Obat <span class="bg-orange-100 rounded p-1">{{ $totalObat }}</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="bg-white rounded-lg shadow p-4">
                                <p class="text-lg font-medium">
                                    Anggaran <span class="bg-blue-100 rounded p-1">{{ $totalAnggaran }}</span>
                                </p>
                            </div>
                            <a href="{{ route('lplpo.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Total LPLPO <span class="bg-green-100 rounded p-1">{{ $totalLplpoSelesai }}</span>
                                    </p>
                                </div>
                            </a>
                            <div class="bg-white rounded-lg shadow p-4">
                                <p class="text-lg font-medium">
                                    Pesanan LPLPO <span class="bg-red-100 rounded p-1">{{ $totalLplpoBelumSelesai }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Grafik Permintaan --}}
                        <div class="bg-white p-4 rounded shadow my-6">
                            <h2 class="text-lg font-semibold mb-2">Grafik Permintaan Obat per Bulan</h2>
                            <canvas id="rekapChart" height="120"></canvas>
                        </div>

                        <div class="flex gap-2 mb-6">
                            <a href="{{ route('dashboard.export.excel', request()->query()) }}"
                               class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700" target="_blank">Export Excel</a>
                            <a href="{{ route('dashboard.export.pdf', request()->query()) }}"
                               class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700" target="_blank">Export PDF</a>
                        </div>

                        {{-- Obat Kosong --}}
                        <div class="bg-white p-4 rounded shadow">
                            <h2 class="text-lg font-semibold mb-2">Laporan Stok Obat Kosong</h2>
                            <table class="min-w-full text-left border">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="p-2 border">Nama Obat</th>
                                        <th class="p-2 border">Sumber Anggaran</th>
                                        <th class="p-2 border">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($obatKosong as $item)
                                        <tr>
                                            <td class="p-2 border">{{ $item->drug_name }}</td>
                                            <td class="p-2 border">{{ $item->budget_name }}</td>
                                            <td class="p-2 border text-red-600">{{ $item->stock }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="p-2 border text-center">Semua obat tersedia</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endcan

                @can('access-petugas-farmasi')
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <a href="{{ route('unit.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Unit <span class="bg-yellow-100 rounded p-1">{{ $totalUnit }}</span>
                                    </p>
                                </div>
                            </a>
                            <a href="{{ route('obat.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Obat <span class="bg-orange-100 rounded p-1">{{ $totalObat }}</span>
                                    </p>
                                </div>
                            </a>
                            <div class="bg-white rounded-lg shadow p-4">
                                <p class="text-lg font-medium">
                                    Anggaran <span class="bg-blue-100 rounded p-1">{{ $totalAnggaran }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('lplpo.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Total LPLPO <span class="bg-green-100 rounded p-1">{{ $totalLplpoSelesai }}</span>
                                    </p>
                                </div>
                            </a>
                            <div class="bg-white rounded-lg shadow p-4">
                                <p class="text-lg font-medium">
                                    Pesanan LPLPO <span class="bg-red-100 rounded p-1">{{ $totalLplpoBelumSelesai }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endcan

                @can('access-petugas-puskesmas')
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <a href="{{ route('unit.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Unit <span class="bg-yellow-100 rounded p-1">{{ $totalUnit }}</span>
                                    </p>
                                </div>
                            </a>
                            <a href="{{ route('lplpo.index') }}">
                                <div class="bg-white rounded-lg shadow p-4">
                                    <p class="text-lg font-medium">
                                        Total LPLPO <span class="bg-blue-100 rounded p-1">{{ $totalLplpoByUser }}</span>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
    @push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const rawData = @json($rekap);

        // Grup data berdasarkan obat
        const grouped = {};
        rawData.forEach(item => {
            const key = `${item.year}-${String(item.month).padStart(2, '0')}`;
            if (!grouped[item.drug_name]) grouped[item.drug_name] = {};
            grouped[item.drug_name][key] = item.total;
        });

        const allLabels = [...new Set(rawData.map(i => `${i.year}-${String(i.month).padStart(2, '0')}`))].sort();
        const datasets = Object.entries(grouped).map(([drugName, values]) => ({
            label: drugName,
            data: allLabels.map(label => values[label] || 0),
            borderWidth: 2,
            fill: false,
            tension: 0.2
        }));

        new Chart(document.getElementById('rekapChart'), {
            type: 'line',
            data: {
                labels: allLabels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
