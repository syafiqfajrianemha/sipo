<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Obat') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="post" action="{{ route('obat.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Obat*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="Masukkan nama obat" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="unit" :value="__('Satuan*')" />
                            <x-text-input id="unit" name="unit" type="text" class="mt-1 block w-full" :value="old('unit')" placeholder="Masukkan satuan obat (misalnya: tablet, botol)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Masukkan deskripsi obat">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div>
                            <x-input-label :value="__('Stok Berdasarkan Anggaran*')" />
                            @foreach($budgets as $budget)
                                <div class="mt-2">
                                    <x-input-label for="stocks_{{ $budget->id }}" :value="$budget->name" />
                                    <x-text-input id="stocks_{{ $budget->id }}" name="stocks[{{ $budget->id }}]" type="number" class="mt-1 block w-full" :value="old('stocks.' . $budget->id)" placeholder="Masukkan stok untuk anggaran {{ $budget->name }}" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('stocks.' . $budget->id)" />
                                </div>
                            @endforeach
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Tambah') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
