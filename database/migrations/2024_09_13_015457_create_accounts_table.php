<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->string('account_code')->unique();
            $table->enum('account_type', ['asset', 'liability', 'equity', 'income', 'expense']);
            $table->enum('dc_type', ['d', 'c'])->comment('d for debit, c for credit');
            $table->decimal('opening_balance', 17, 2)->default(0.00);
            $table->date('opening_balance_date');
            $table->boolean('is_active')->default(1);
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
