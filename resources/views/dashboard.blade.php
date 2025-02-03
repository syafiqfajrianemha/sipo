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
</x-app-layout>
