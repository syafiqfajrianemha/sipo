<x-app-layout>
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pesanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-primary-href :href="route('order.create')" class="mb-3">
                        {{ __('Tambah Pesanan') }}
                    </x-primary-href>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="w-full bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Tanggal</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nomor Dokumen</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Unit</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bulan Pelaporan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Bulan Permintaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($orders as $order)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->input_date }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->document_number }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->unit_name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->report_month }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->request_month }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $order->status }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <x-primary-href :href="route('unit.edit', $order->id)" class="mb-2">
                                                {{ __('Edit') }}
                                            </x-primary-href>
                                            <form action="{{ route('unit.destroy', $order->id) }}" method="POST" class="form-delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Hapus</button>
                                            </form>
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
