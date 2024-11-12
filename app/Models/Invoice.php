<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id', 'subtotal', 'discount', 'tax', 'total_amount', 'payment_method', 'discount_percentage', 'tax_percentage'];


    public function user()
    {
        return $this->belongsTo(related: User::class);
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}

