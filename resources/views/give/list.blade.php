<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Pemberian {{ $order->unit_name }} ({{ $order->report_month }} - {{ $order->request_month }})
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
                                    @foreach ($budgets as $budget)
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">{{ $budget }}</th>
                                    @endforeach
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($groupedDistributions as $distribution)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $distribution['drug_name'] }}</td>
                                        @foreach ($budgets as $budget)
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $distribution['budgets'][$budget] ?? 0 }}</td>
                                        @endforeach
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $distribution['total_quantity'] }}</td>
                                    </tr>
                                @empty
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="text-red-800 text-center p-6" colspan="{{ count($budgets) + 2 }}">Pemberian obat belum dilakukan.</td>
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
