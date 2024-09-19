<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code');
            $table->enum('category', ['pharmacy', 'logistic', 'general']);
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->date('date');
            $table->date('paid_at');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
