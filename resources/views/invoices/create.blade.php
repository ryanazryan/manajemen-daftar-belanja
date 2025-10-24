<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Invoice Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="customer_name" class="block font-medium text-sm text-gray-700">Nama Pelanggan</label>
                                <input type="text" name="customer_name" id="customer_name" class="block mt-1 w-full" required>
                            </div>
                            <div>
                                <label for="invoice_date" class="block font-medium text-sm text-gray-700">Tanggal Invoice</label>
                                <input type="date" name="invoice_date" id="invoice_date" class="block mt-1 w-full" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Items</h3>
                            <div id="items-container" class="mt-2 space-y-4">
                                </div>
                            <button type="button" id="add-item" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Tambah Item</button>
                        </div>

                        <hr class="my-6">

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <label for="discount" class="font-medium text-sm text-gray-700">Diskon (Opsional)</label>
                                <input type="number" name="discount" id="discount" class="block w-1/2 text-right" placeholder="0">
                            </div>

                            <div class="flex justify-between items-center">
                                <label for="shipping_service" class="font-medium text-sm text-gray-700">Jasa Pengiriman</label>
                                <input type="text" name="shipping_service" id="shipping_service" class="block w-1/2 text-right" placeholder="Contoh: JNT">
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <label for="shipping_cost" class="font-medium text-sm text-gray-700">Biaya Pengiriman</label>
                                <input type="number" name="shipping_cost" id="shipping_cost" class="block w-1/2 text-right" value="0" required>
                            </div>
                        </div>


                        <div class="mt-6 text-right">
                            <h3 class="text-xl font-bold">Total: <span id="total-amount">Rp 0</span></h3>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button type="submit" class="ml-4 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600">
                                Simpan Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const itemsContainer = document.getElementById('items-container');
            const addItemButton = document.getElementById('add-item');
            let itemIndex = 0;

            function addItemRow() {
                const itemHtml = `
                    <div class="item grid grid-cols-12 gap-4 items-center">
                        <div class="col-span-5">
                            <input type="text" name="items[${itemIndex}][item_name]" placeholder="Nama Item" class="block w-full" required>
                        </div>
                        <div class="col-span-2">
                            <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" class="quantity block w-full" value="1" min="1" required>
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="items[${itemIndex}][price]" placeholder="Harga" class="price block w-full" min="0" required>
                        </div>
                        <div class="col-span-2">
                            <button type="button" class="remove-item text-red-500 hover:text-red-700">Hapus</button>
                        </div>
                    </div>
                `;
                itemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                itemIndex++;
            }

            addItemButton.addEventListener('click', addItemRow);
            addItemRow();

            itemsContainer.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('.item').remove();
                    calculateTotal();
                }
            });

            function calculateTotal() {
                let subtotal = 0;
                document.querySelectorAll('.item').forEach(item => {
                    const quantity = parseFloat(item.querySelector('.quantity').value) || 0;
                    const price = parseFloat(item.querySelector('.price').value) || 0;
                    subtotal += quantity * price;
                });

                const shippingCost = parseFloat(document.getElementById('shipping_cost').value) || 0;
                const discount = parseFloat(document.getElementById('discount').value) || 0;

                const total = (subtotal - discount) + shippingCost;

                document.getElementById('total-amount').textContent = 'Rp ' + total.toLocaleString('id-ID');
            }

            document.querySelector('form').addEventListener('input', function(e) {
                if(e.target.matches('.quantity, .price, #shipping_cost, #discount')) {
                    calculateTotal();
                }
            });
            
            // Hitung total saat halaman pertama kali dimuat (jika ada nilai default)
            calculateTotal();
        });
    </script>
</x-app-layout>