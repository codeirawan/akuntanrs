<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'receipt_services';

    protected $fillable = [
        'receipt_id',
        'service_id',
        'unit_id',
        'doctor_id',
        'price',
    ];
}
