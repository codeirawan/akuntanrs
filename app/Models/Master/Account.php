<?php

namespace App\Models\Master;

use App\Models\Transaction\JournalEntry;
use App\Models\Transaction\Payment;
use App\Models\Transaction\Receipt;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'accounts';

    // Specify which attributes can be mass assigned
    protected $fillable = [
        'account_name',
        'account_code',
        'sub_account_name',
        'account_type',
        'opening_balance',
        'opening_balance_date',
        'is_credit',
        'is_debit',
        'bs_flag',
        'pl_flag',
        'pl_flag',
        'is_active',
        'updated_by',
        'created_by',
    ];

    public function journals()
    {
        return $this->hasMany(JournalEntry::class);
    }

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
