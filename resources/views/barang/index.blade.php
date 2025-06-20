<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                        <div class="p-4 bg-indigo-100 border border-indigo-200 rounded-lg shadow-sm">
                            <h3 class="font-bold text-lg text-indigo-800">
                                Total Kuantitas Barang
                            </h3>
                            <p class="text-3xl font-extrabold text-indigo-900 mt-1">
                                {{ number_format($totalKuantitas ?? 0) }}
                            </p>
                        </div>

                        <div class="p-4 bg-green-100 border border-green-200 rounded-lg shadow-sm">
                            <h3 class="font-bold text-lg text-green-800">
                                Total Harga Keseluruhan
                            </h3>
                            <p class="text-3xl font-extrabold text-green-900 mt-1">
                                {{ 'Rp ' . number_format($grandTotalHarga ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                    <a href="{{ route('barang.create') }}">
                        <x-primary-button
                            class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Tambah Barang
                        </x-primary-button>
                    </a>

                    <a href="{{ route('barang.export') }}">
                        <x-primary-button class="bg-green-600 hover:bg-green-700">
                            Export ke Excel
                        </x-primary-button>
                    </a>

                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                <th class="py-4 px-4 text-center whitespace-nowrap">No</th>
                                <th class="py-4 px-4 text-left whitespace-nowrap">Nama Barang</th>
                                <th class="py-4 px-4 text-left whitespace-nowrap">Nama Orang</th>
                                <th class="py-4 px-4 text-center whitespace-nowrap">Kuantitas</th>
                                <th class="py-4 px-4 text-center whitespace-nowrap">Harga Per Satuan</th>
                                <th class="py-4 px-4 text-center whitespace-nowrap">Harga Total</th>
                                <th class="py-4 px-4 text-left whitespace-nowrap">Tanggal</th>
                                <th class="py-4 px-4 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm font-light divide-y divide-gray-200">
                            @forelse ($barangs as $barang)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-4 px-4 text-center">{{ $barangs->firstItem() + $loop->index }}
                                    </td>
                                    <td class="py-4 px-4 text-left whitespace-nowrap">{{ $barang->nama_barang }}
                                    </td>
                                    <td class="py-4 px-4 text-left whitespace-nowrap">{{ $barang->nama_orang }}</td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">{{ $barang->kuantitas }}
                                    </td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        {{ 'Rp ' . number_format($barang->harga_per_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-center whitespace-nowrap">
                                        {{ 'Rp ' . number_format($barang->harga_total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-left whitespace-nowrap">
                                        {{ $barang->tanggal ? $barang->tanggal->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="{{ route('barang.show', $barang->id) }}"
                                                class="p-2 bg-green-500 text-black rounded hover:bg-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>

                                            <a href="{{ route('barang.edit', $barang->id) }}"
                                                class="p-2 bg-yellow-500 text-black rounded hover:bg-yellow-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>

                                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-500 text-black rounded hover:bg-red-600">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="py-4 px-4 text-center text-gray-500">
                                        Tidak ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $barangs->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
