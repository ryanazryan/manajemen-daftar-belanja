<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Invoice: ') }} {{ $invoice->invoice_number }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- Tombol Aksi di Atas --}}
                    <div class="flex justify-end space-x-3 mb-6">
                        <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="inline-flex items-center px-4 py-2 mr-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Cetak
                        </a>
                        <a href="{{ route('invoices.download', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Download
                        </a>
                    </div>
                    
                    {{-- Header Invoice --}}
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <h3 class="text-lg font-bold">INVOICE</h3>
                            <p><strong>No:</strong> {{ $invoice->invoice_number }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-bold">Unit Usaha DWP FKIK ULM</h3>
                            <p class="text-sm">Jl. A. Yani Km. 36, Banjarbaru</p>
                            <p class="text-sm">081349506500</p>
                        </div>
                    </div>

                    {{-- Detail Customer --}}
                    <div class="mb-8">
                        <p class="font-bold">Kepada Yth:</p>
                        <p>{{ $invoice->customer_name }}</p>
                        <p><strong>Tanggal:</strong> {{ $invoice->invoice_date->format('d F Y') }}</p>
                    </div>

                    {{-- Tabel Item --}}
                    <div class="overflow-x-auto mt-3">
                        <table class="min-w-full border">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b text-left">Nama Barang</th>
                                    <th class="py-2 px-4 border-b text-center">Kuantitas</th>
                                    <th class="py-2 px-4 border-b text-right">Harga Satuan</th>
                                    <th class="py-2 px-4 border-b text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                <tr class="border-b">
                                    <td class="py-2 px-4">{{ $item->item_name }}</td>
                                    <td class="py-2 px-4 text-center">{{ $item->quantity }}</td>
                                    <td class="py-2 px-4 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="py-2 px-4 text-right">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="py-2 px-4 text-right font-bold">Total Keseluruhan</td>
                                    <td class="py-2 px-4 text-right font-bold">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>