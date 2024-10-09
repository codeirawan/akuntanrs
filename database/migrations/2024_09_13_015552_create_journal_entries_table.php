<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJournalEntriesTable extends Migration
{
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_code');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');
            $table->date('journal_date');
            $table->decimal('debit', 17, 2)->default(0);
            $table->decimal('credit', 17, 2)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['account_id', 'journal_date', 'voucher_code'], 'unique_journal_entry');
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
