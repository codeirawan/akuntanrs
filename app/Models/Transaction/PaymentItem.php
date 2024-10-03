<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_items';

    protected $fillable = [
        'payment_id',
        'item_id',
        'total_price',
        'item_code',
        'item_name',
        'item_qty',
        'item_unit',
        'unit_price',
        'total_price',
        'item_type',
    ];
}
