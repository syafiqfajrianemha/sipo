<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="post" action="{{ route('obat.update', $drug->id) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" :value="__('Nama Obat*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="!old('name') ? $drug->name : old('name')"
                                placeholder="Masukkan nama obat" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Satuan*')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full"
                                :value="!old('unit') ? $drug->unit : old('unit')"
                                placeholder="Masukkan satuan (misal: tablet, botol)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                placeholder="Masukkan deskripsi">{{ !old('description') ? $drug->description : old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <h3 class="font-semibold text-lg text-gray-800 leading-tight">Stok Berdasarkan Anggaran</h3>
                            @foreach ($budgets as $budget)
                                <div class="mt-4">
                                    <x-input-label for="stocks[{{ $budget->id }}]"
                                        :value="__('Stok ' . $budget->name . '*')" />
                                    <x-text-input id="stocks[{{ $budget->id }}]"
                                        name="stocks[{{ $budget->id }}]" type="number" class="mt-1 block w-full"
                                        :value="old('stocks.' . $budget->id) ?? $drug->budgets->find($budget->id)?->pivot->stock"
                                        placeholder="Masukkan stok untuk {{ $budget->name }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('stocks.' . $budget->id)" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <x-primary-button>{{ __('Edit') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
