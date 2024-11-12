<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Tambah Barang Baru') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Masukkan detail barang yang ingin ditambahkan.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('barang.store') }}" class="mt-6 space-y-6">
                            @csrf

                            <!-- Nama Barang -->
                            <div>
                                <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                                <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full" :value="old('nama_barang')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                            </div>

                            <!-- Nama Orang -->
                            <div>
                                <x-input-label for="nama_orang" :value="__('Nama Orang')" />
                                <x-text-input id="nama_orang" name="nama_orang" type="text" class="mt-1 block w-full" :value="old('nama_orang')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('nama_orang')" />
                            </div>

                            <!-- Kuantitas -->
                            <div>
                                <x-input-label for="kuantitas" :value="__('Kuantitas')" />
                                <x-text-input id="kuantitas" name="kuantitas" type="number" class="mt-1 block w-full" :value="old('kuantitas')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('kuantitas')" />
                            </div>

                            <!-- Harga Per Satuan -->
                            <div>
                                <x-input-label for="harga_per_satuan" :value="__('Harga Per Satuan (Rp)')" />
                                <x-text-input id="harga_per_satuan" name="harga_per_satuan" type="text" class="mt-1 block w-full" :value="old('harga_per_satuan')" placeholder="Rp 0" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga_per_satuan')" />
                            </div>

                            <!-- Keterangan -->
                            <div>
                                <x-input-label for="keterangan" :value="__('Keterangan')" />
                                <textarea id="keterangan" name="keterangan" rows="3" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('keterangan') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('keterangan')" />
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>

                                @if (session('status') === 'barang-created')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
