<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pemberian
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
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Nama Obat</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Satuan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Stok Awal</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Penerimaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Persediaan</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Pemakaian</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Sisa Stok</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Stok Optimum</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Permintaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->drug->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->unit }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->initial_stock }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->acceptance }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->inventory }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->usage }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->remaining_stock }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $orderItem->optimum_stock }}</td>
                                    <td class="px-6 py-4 text-sm text-blue-500">{{ $orderItem->request_quantity }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <form method="POST" action="{{ route('drug.give.store', $orderItem->id) }}" class="space-y-6">
                            @csrf

                            <table class="min-w-full bg-white border border-gray-200">
                                <thead>
                                    <tr class="w-full bg-gray-100 border-b">
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Anggaran</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Stok</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Pemberian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($budgets as $budget)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $budget->budget->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $budget->stock }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <x-text-input name="budgets[{{ $budget->id }}]" type="number" min="0" class="w-full" />
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                            </div>
                        </form>
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
