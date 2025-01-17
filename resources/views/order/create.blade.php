<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Permintaan Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('order.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="document_number" :value="__('Dokumen*')" />
                            <x-text-input id="document_number" name="document_number" type="text" class="mt-1 block w-full" :value="old('document_number')" placeholder="Masukkan nomor dokumen" required />
                            <x-input-error class="mt-2" :messages="$errors->get('document_number')" />
                        </div>

                        <div>
                            <x-input-label for="unit_name" :value="__('Nama Unit*')" />
                            <x-text-input id="unit_name" name="unit_name" type="text" class="mt-1 block w-full" value="{{ $unitName }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('unit_name')" />
                        </div>

                        <div>
                            <x-input-label for="input_date" :value="__('Tanggal Input*')" />
                            <x-text-input id="input_date" name="input_date" type="date" class="mt-1 block w-full" value="{{ $currentDate }}" readonly />
                            <x-input-error class="mt-2" :messages="$errors->get('input_date')" />
                        </div>

                        <div>
                            <x-input-label for="report_month" :value="__('Bulan Pelaporan*')" />
                            <x-select-option id="report_month" class="block mt-1 w-full" name="report_month" :value="old('report_month')" required>
                                <option selected disabled>Pilih Bulan Pelaporan</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('report_month')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="request_month" :value="__('Bulan Permintaan*')" />
                            <x-select-option id="request_month" class="block mt-1 w-full" name="request_month" :value="old('request_month')" required>
                                <option selected disabled>Pilih Bulan Permintaan</option>
                                <option value="Januari">Januari</option>
                                <option value="Februari">Februari</option>
                                <option value="Maret">Maret</option>
                                <option value="April">April</option>
                                <option value="Mei">Mei</option>
                                <option value="Juni">Juni</option>
                                <option value="Juli">Juli</option>
                                <option value="Agustus">Agustus</option>
                                <option value="September">September</option>
                                <option value="Oktober">Oktober</option>
                                <option value="November">November</option>
                                <option value="Desember">Desember</option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('request_month')" class="mt-2" />
                        </div>

                        <div id="drugs-container">
                            <div>
                                <button type="button" id="add-drug" class="mb-2 text-blue-600 hover:underline">Tambah 1 Permintaan Obat</button>
                            </div>

                            <div class="drug-row flex gap-4 items-center">
                                <div class="flex-1">
                                    <x-input-label for="drug_id[]" :value="__('Nama Obat*')" />
                                    <select id="drug_id[]" name="items[][drug_id]" class="block mt-1 w-full drug-select" required>
                                        <option value="" disabled selected>Pilih Obat</option>
                                        @foreach ($drugs as $drug)
                                            <option value="{{ $drug->id }}">{{ $drug->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('drug_id')" />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="unit[]" :value="__('Satuan')" />
                                    <x-text-input id="unit[]" name="items[][unit]" type="text" class="mt-1 block w-full" value="" readonly />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="initial_stock[]" :value="__('Stok Awal')" />
                                    <x-text-input id="initial_stock[]" name="items[][initial_stock]" type="number" class="mt-1 block w-full" min="0" />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="acceptance[]" :value="__('Penerimaan')" />
                                    <x-text-input id="acceptance[]" name="items[][acceptance]" type="number" class="mt-1 block w-full" min="0" />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="inventory[]" :value="__('Persediaan')" />
                                    <x-text-input id="inventory[]" name="items[][inventory]" type="number" class="mt-1 block w-full" min="0" />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="pemakaian[]" :value="__('Pemakaian*')" />
                                    <x-text-input id="pemakaian[]" name="items[][usage]" type="number" class="mt-1 block w-full" min=0 />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="remaining_stock[]" :value="__('Sisa Stok')" />
                                    <x-text-input id="remaining_stock[]" name="items[][remaining_stock]" type="number" class="mt-1 block w-full" min=0 />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="optimum_stock[]" :value="__('Stok Optimum')" />
                                    <x-text-input id="optimum_stock[]" name="items[][optimum_stock]" type="number" class="mt-1 block w-full" min=0 />
                                </div>

                                <div class="flex-1">
                                    <x-input-label for="permintaan[]" :value="__('Permintaan*')" />
                                    <x-text-input id="permintaan[]" name="items[][request_quantity]" type="number" class="mt-1 block w-full" min="0" />
                                </div>

                                <button type="button" class="remove-drug-row text-red-500">Hapus</button>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Permintaan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const drugsContainer = document.getElementById('drugs-container');

            function updateRowIndexes() {
                drugsContainer.querySelectorAll('.drug-row').forEach((row, index) => {
                    row.querySelectorAll('input, select').forEach(input => {
                        const name = input.getAttribute('name');
                        if (name) {
                            input.setAttribute('name', name.replace(/items\[\d*\]/, `items[${index}]`));
                        }
                    });
                });
            }

            drugsContainer.addEventListener('change', function (e) {
                if (e.target.classList.contains('drug-select')) {
                    const drugId = e.target.value;
                    const parentRow = e.target.closest('.drug-row');
                    const unitInput = parentRow.querySelector('input[name$="[unit]"]');

                    if (drugId) {
                        fetch(`/get-drug/${drugId}`)
                            .then(response => response.json())
                            .then(data => {
                                unitInput.value = data.unit || '';
                            })
                            .catch(error => console.error('Error fetching drug data:', error));
                    }
                }
            });

            document.getElementById('add-drug').addEventListener('click', () => {
                const newRow = drugsContainer.querySelector('.drug-row').cloneNode(true);
                newRow.querySelectorAll('input, select').forEach(input => {
                    if (input.type === 'text' || input.type === 'number') input.value = '';
                });
                drugsContainer.appendChild(newRow);
                updateRowIndexes();
            });

            drugsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-drug-row')) {
                    e.target.closest('.drug-row').remove();
                    updateRowIndexes();
                }
            });

            updateRowIndexes();
        });
    </script>
</x-app-layout>
