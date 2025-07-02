<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tombol untuk membuat invoice baru --}}
            <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 mb-4">
                Buat Invoice Baru
            </a>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 uppercase text-xs leading-normal">
                                    <th class="py-3 px-4 text-left whitespace-nowrap">No. Invoice</th>
                                    <th class="py-3 px-4 text-left whitespace-nowrap">Nama Customer</th>
                                    <th class="py-3 px-4 text-left whitespace-nowrap">Tanggal</th>
                                    <th class="py-3 px-4 text-right whitespace-nowrap">Total</th>
                                    <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light divide-y divide-gray-200">
                                @forelse ($invoices as $invoice)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-4 whitespace-nowrap">{{ $invoice->invoice_number }}</td>
                                        <td class="py-4 px-4 whitespace-nowrap">{{ $invoice->customer_name }}</td>
                                        <td class="py-4 px-4 whitespace-nowrap">{{ $invoice->invoice_date->format('d M Y') }}</td>
                                        <td class="py-4 px-4 whitespace-nowrap text-right">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                        <td class="py-4 px-4 whitespace-nowrap text-center">
                                            <div class="flex items-center justify-center space-x-4">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Lihat</a>
                                                <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="text-green-600 hover:text-green-900 font-medium">Cetak</a>
                                                <a href="{{ route('invoices.download', $invoice) }}" class="text-blue-600 hover:text-blue-900 font-medium">Download</a>
                                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus invoice ini?');" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-gray-500">
                                            Tidak ada riwayat invoice.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $invoices->links() }}
                    </div>
            </div>
            </div>
        </div>
    </div>
</x-app-layout>