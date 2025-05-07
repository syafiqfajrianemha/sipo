<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="post" action="{{ route('unit.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="category" :value="__('Kategori Unit*')" />
                            <x-select-option id="category" class="block mt-1 w-full" name="category" :value="old('category')" required>
                                <option selected disabled>Pilih Kategori Unit</option>
                                <option value="puskesmas">Puskesmas</option>
                                <option value="kantor-pusat">Kantor Pusat</option>
                                <option value="rumah-sakit">Rumah Sakit</option>
                            </x-select-option>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Nama Unit*')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" placeholder="Masukkan nama unit" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Alamat*')" />
                            <textarea id="address" name="address" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Masukkan alamat" required>{{ old('address') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Nomor Telp*')" />
                            <x-text-input id="phone" name="phone" type="number" class="mt-1 block w-full" :value="old('phone')" placeholder="Masukkan nomor telp" required />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <div>
                            <x-input-label for="postal_code" :value="__('Kode Pos*')" />
                            <x-text-input id="postal_code" name="postal_code" type="number" class="mt-1 block w-full" :value="old('postal_code')" placeholder="Masukkan kode pos" required />
                            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
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
