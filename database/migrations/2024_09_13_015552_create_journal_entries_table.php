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
            $table->string('voucher');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('unit_id')->constrained('units');
            $table->date('date');
            $table->decimal('debit', 15, 2);
            $table->decimal('credit', 15, 2);
            $table->text('description');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('journal_entries');
    }
}
