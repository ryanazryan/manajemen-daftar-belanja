<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ $barang->nama_barang }}</h3>

                    <div class="space-y-2">
                        <p><strong>Nama Orang:</strong> {{ $barang->nama_orang }}</p>
                        <p><strong>Kuantitas:</strong> {{ $barang->kuantitas }}</p>
                        <p><strong>Harga Per Satuan:</strong> Rp {{ number_format($barang->harga_per_satuan, 0, ',', '.') }}</p>
                        <p><strong>Harga Total:</strong> Rp {{ number_format($barang->harga_total, 0, ',', '.') }}</p>
                        <p><strong>Keterangan:</strong> {{ $barang->keterangan ?? '-' }}</p>

                        {{-- ====================================================== --}}
                        {{-- ============ TAMBAHKAN BLOK KODE INI ================= --}}
                        {{-- ====================================================== --}}
                        @if ($barang->tanggal)
                            <p><strong>Tanggal:</strong> {{ $barang->tanggal->translatedFormat('d F Y') }}</p>
                        @else
                            <p><strong>Tanggal:</strong> -</p>
                        @endif
                        {{-- ====================================================== --}}

                    </div>

                    <div class="mt-6">
                        <a href="{{ route('barang.index') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Kembali ke Daftar Barang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>