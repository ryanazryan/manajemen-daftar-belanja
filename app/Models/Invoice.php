<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'customer_name',
        'invoice_date',
        'total_amount',
    ];

    protected $casts = [
        'invoice_date' => 'date',
    ];
    
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

}