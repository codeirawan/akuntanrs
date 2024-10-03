<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBankTable extends Migration
{
    public function up()
    {
        Schema::create('cash_bank', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('unit_id')->constrained('units');
            $table->enum('type', ['receipt', 'payment']);
            $table->date('date');
            $table->decimal('amount', 17, 2);
            $table->text('description')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_bank');
    }
}
