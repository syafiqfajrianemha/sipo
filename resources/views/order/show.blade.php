<x-app-layout>
    <div id="flash-data" data-flashdata="{{ session('message') }}"></div>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pesanan LPLPO {{ $order->unit_name }} ({{ $order->report_month }} - {{ $order->request_month }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <x-primary-href :href="route('give.list', $order->id)" class="mb-3">
                        {{ __('Lihat Pemberian') }}
                    </x-primary-href>
                    @if ($attachment !== null)
                        <x-primary-href href="{{ asset('storage/' . $attachment->file_path) }}" class="mb-3" target="_blank">
                            {{ __('Lampiran') }}
                        </x-primary-href>
                        @if (Auth::user()->role === 'petugas-puskesmas')
                            @if ($order->status !== 'done')
                            <form action="{{ route('order.update.done', $order->id) }}" method="POST" class="form-delete mb-3">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">Diterima</button>
                            </form>
                            @endif
                        @endif
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="w-full bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">No</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Obat</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Satuan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Stok Awal</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Penerimaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Persediaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Pemakaian</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Sisa Stok</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Stok Optimum</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Permintaan</th>
                                    @if (Auth::user()->role === 'petugas-farmasi')
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Pemberian</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->orderItems as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->drug->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->unit }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->initial_stock }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->acceptance }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->inventory }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->usage }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->remaining_stock }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->optimum_stock }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $item->request_quantity }}</td>
                                        @if (Auth::user()->role === 'petugas-farmasi')
                                            @if (!$item->drug_distribution_exists)
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    <x-primary-href :href="route('give.drug', $item->id)">
                                                        {{ __('Tambah') }}
                                                    </x-primary-href>
                                                </td>
                                            @else
                                                <td class="px-6 py-4 text-sm text-red-500">Pemberian obat sudah dilakukan.</td>
                                            @endif
                                        @endif
                                    </tr>
                                @empty
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-red-800 text-center p-6" colspan="6">Belum Ada Data Satupun.</td>
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
