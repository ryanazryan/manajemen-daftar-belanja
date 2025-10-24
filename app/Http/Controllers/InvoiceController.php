<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::latest()->paginate(10);
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'invoice_date'     => 'required|date',
            'shipping_service' => 'nullable|string|max:255',
            'shipping_cost'    => 'nullable|numeric|min:0',
            'discount'         => 'nullable|numeric|min:0',
            'items'            => 'required|array|min:1',
            'items.*.item_name'  => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price'    => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['price'];
        }

        $shippingCost = $request->shipping_cost ?? 0;
        $discount = $request->discount ?? 0;
        $totalAmount = ($subtotal - $discount) + $shippingCost;

        $invoice = Invoice::create([
            'invoice_number'   => 'INV-' . time(),
            'customer_name'    => $request->customer_name,
            'invoice_date'     => $request->invoice_date,
            'shipping_service' => $request->shipping_service,
            'shipping_cost'    => $shippingCost,
            'discount'         => $discount,
            'total_amount'     => $totalAmount,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create([
                'item_name' => $item['item_name'],
                'quantity'  => $item['quantity'],
                'price'     => $item['price'],
                'total'     => $item['quantity'] * $item['price'],
            ]);
        }
        
        return redirect()->route('invoices.index')->with('success', 'Invoice baru berhasil dibuat!');
    }
    
    public function show(Invoice $invoice)
    {
         return view('invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        
        $customerNameSlug = Str::slug($invoice->customer_name, '_');
        $fileName = 'invoice_' . $customerNameSlug . '.pdf';

        return $pdf->stream($fileName);
    }

    public function download(Invoice $invoice)
    {
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));

        $customerNameSlug = Str::slug($invoice->customer_name, '_');
        $fileName = 'invoice_' . $customerNameSlug . '.pdf';

        return $pdf->download($fileName);
    }
    
    public function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }
}