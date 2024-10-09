<?php

namespace App\Models\Transaction;

use Carbon\Carbon;
use App\Models\Master\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'journal_entries';

    protected $fillable = [
        'voucher_code',
        'account_id',
        'journal_date',
        'debit',
        'credit',
        'note',
        'updated_by',
        'created_by',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

}
