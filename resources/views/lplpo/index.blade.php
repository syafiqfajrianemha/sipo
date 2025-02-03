<x-app-layout>
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Data LPLPO {{ Auth::user()->unit->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="w-full bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal Input</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bulan Pelaporan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bulan Permintaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->input_date }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->report_month }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->request_month }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <x-primary-href :href="route('lplpo.index')">
                                                {{ __('Detail') }}
                                            </x-primary-href>
                                            <x-primary-href :href="route('lplpo.index')">
                                                {{ __('Cetak') }}
                                            </x-primary-href>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-red-800 text-center p-6" colspan="8">Belum Ada Pesanan Satupun.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script src="{{ asset('js/main.js') }}"></script>
    @endpush
</x-app-layout>
