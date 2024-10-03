<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payments';

    protected $fillable = [
        'payment_code',
        'payment_date',
        'payment_type',
        'payment_status',
        'amount',
        'account_id',
        'doctor_id',
        'receipt_id',
        'supplier_id',
        'note',
        'created_by',
        'updated_by',
    ];

    public function items()
    {
        return $this->hasMany(PaymentItem::class, 'payment_id');
    }

}
