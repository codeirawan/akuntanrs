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
            $table->string('account_code')->unique();
            $table->string('account_name');
            $table->string('sub_account_name');
            $table->tinyInteger('account_type')->comment('1 = liquid asset, 2 = fixed asset, 3 = liability, 4 = equity, 5 = income, 6 = expense, 7 = other');
            $table->boolean('is_debit')->default(0);
            $table->boolean('is_credit')->default(0);
            $table->boolean('bs_flag')->default(0)->comment('balance sheet');
            $table->boolean('pl_flag')->default(0)->comment('profit loss');
            $table->decimal('opening_balance', 17, 2)->default(0.00);
            $table->date('opening_balance_date')->nullable();
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
