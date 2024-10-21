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

    protected $casts = [
        'journal_date' => 'datetime',
        'debit' => 'float',
        'credit' => 'float',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public static function generateVoucherCode($type = 'JV')
    {
        // Get current year and month
        $currentDate = Carbon::now();
        $year = $currentDate->year;
        $month = $currentDate->format('m');  // Two-digit month

        // Get the latest journal entry for the given type and current year/month, including soft-deleted entries
        $latestJournalEntry = self::where('voucher_code', 'like', "$type-$year$month%")
            ->orderBy('voucher_code', 'desc')
            ->withTrashed() // Include soft-deleted entries
            ->first();

        // Determine the next increment number (XXX part)
        if ($latestJournalEntry) {
            // Extract the last 3 digits from the latest voucher_code and increment it
            $lastIncrement = (int) substr($latestJournalEntry->voucher_code, -3);
            $nextIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);  // Increment and pad to 3 digits
        } else {
            // Start with 001 if no previous entries exist for the current month
            $nextIncrement = '001';
        }

        // Generate voucher_code in the format TYPE-YYYYMM-XXX
        return $type . '-' . $year . $month . '-' . $nextIncrement;
    }

}
