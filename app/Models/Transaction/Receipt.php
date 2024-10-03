<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'receipts';

    protected $fillable = [
        'receipt_code',
        'receipt_date',
        'payment_type',
        'payment_status',
        'account_id',
        'patient_id',
        'amount',
        'note',
        'created_by',
        'updated_by',
    ];

    public function medicines()
    {
        return $this->hasMany(ReceiptItem::class, 'receipt_id');
    }

    public function services()
    {
        return $this->hasMany(ReceiptService::class, 'receipt_id');
    }
}
