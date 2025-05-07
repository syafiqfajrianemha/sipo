<x-guest-layout>
    <form method="POST" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PATCH')

        <div>
            <x-input-label for="name" :value="__('Nama*')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ !old('name') ? $user->name : old('name') }}" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" :value="__('Email*')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ !old('email') ? $user->email : old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="role" :value="__('Role*')" />
            <x-select-option id="role" class="block mt-1 w-full" name="role" required>
                <option selected disabled>Choose Role</option>
                <option value="admin" @if ($user->role == "admin") selected @endif>Admin</option>
                <option value="petugas-puskesmas" @if ($user->role == "petugas-puskesmas") selected @endif>Petugas Pelayanan Kesehatan</option>
                <option value="petugas-farmasi" @if ($user->role == "petugas-farmasi") selected @endif>Petugas Farmasi</option>
            </x-select-option>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="unit_id" :value="__('Unit')" />
            <x-select-option id="unit_id" class="block mt-1 w-full" name="unit_id">
                <option selected disabled>Pilih Unit</option>
                @foreach ($units as $unit)
                    <option value="{{ $unit->id }}" @if ($user->unit_id == $unit->id) selected @endif>{{ $unit->name }}</option>
                @endforeach
            </x-select-option>
            <x-input-error :messages="$errors->get('unit_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Edit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
