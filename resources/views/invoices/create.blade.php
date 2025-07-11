<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('invoices.store') }}" target="_blank">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="customer_name" :value="__('Nama Pelanggan')" />
                            <x-text-input id="customer_name" class="block mt-1 w-full" type="text" name="customer_name" required />
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mb-2">Barang</h3>
                        <div id="items-container" class="space-y-3">
                            </div>

                        <button type="button" id="add-item-btn" class="mt-4 text-sm text-blue-600 hover:text-blue-800">+ Tambah Barang</button>
                        
                        <div class="mt-6 border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Pengiriman</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="shipping_service" :value="__('Jasa Pengiriman (JNT, JNE, dll)')" />
                                    <x-text-input id="shipping_service" class="block mt-1 w-full" type="text" name="shipping_service" placeholder="Contoh: JNT Express" />
                                </div>
                                <div>
                                    <x-input-label for="shipping_cost" :value="__('Biaya Pengiriman')" />
                                    <x-text-input id="shipping_cost" class="block mt-1 w-full" type="number" name="shipping_cost" placeholder="Rp 0" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Simpan & Cetak Invoice') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemIndex = 0;
            const container = document.getElementById('items-container');
            
            function createItemRow() {
                const index = itemIndex++;
                const itemRow = document.createElement('div');
                itemRow.classList.add('grid', 'grid-cols-12', 'gap-x-4', 'item-row');
                itemRow.innerHTML = `
                    <div class="col-span-5">
                        <x-text-input type="text" name="items[${index}][name]" class="w-full" placeholder="Nama Barang" required />
                    </div>
                    <div class="col-span-2">
                        <x-text-input type="number" name="items[${index}][quantity]" class="w-full" placeholder="Qty" min="1" required />
                    </div>
                    <div class="col-span-4">
                        <x-text-input type="number" name="items[${index}][price]" class="w-full" placeholder="Harga Satuan" min="0" required />
                    </div>
                    <div class="col-span-1 flex items-center">
                        <button type="button" class="remove-item-btn text-red-500 font-bold">&times;</button>
                    </div>
                `;
                container.appendChild(itemRow);
            }

            document.getElementById('add-item-btn').addEventListener('click', createItemRow);
            
            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-item-btn')) {
                    e.target.closest('.item-row').remove();
                }
            });

            createItemRow();
        });
    </script>
</x-app-layout>