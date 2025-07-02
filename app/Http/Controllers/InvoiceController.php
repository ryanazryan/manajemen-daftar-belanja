<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
            'customer_name' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $totalAmount = 0;
        foreach ($request->items as $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }

        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . time(),
            'customer_name' => $request->customer_name,
            'invoice_date' => Carbon::now(),
            'total_amount' => $totalAmount,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create([
                'item_name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['quantity'] * $item['price'],
            ]);
        }
        
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        $fileName = 'Invoice-' . $invoice->invoice_number . '.pdf';

        return $pdf->stream($fileName);
    }
    
    public function show(Invoice $invoice)
    {
         return view('invoices.show', compact('invoice'));
    }

    public function print(Invoice $invoice)
    {
        $pdf = PDF::loadView('invoices.pdf', compact('invoice'));
        $fileName = 'Invoice-' . $invoice->invoice_number . '.pdf';
        return $pdf->stream($fileName);
    }
    
    public function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus.');
    }
}