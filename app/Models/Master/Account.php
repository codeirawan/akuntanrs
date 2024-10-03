<?php

namespace App\Models\Master;

use App\Models\Transaction\Payment;
use App\Models\Transaction\Receipt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts';

    // Relasi ke tabel receipt (penerimaan)
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    // Relasi ke tabel payment (pembayaran)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
