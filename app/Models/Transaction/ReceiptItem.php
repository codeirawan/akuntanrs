<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'receipt_items';

    protected $fillable = [
        'receipt_id',
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
