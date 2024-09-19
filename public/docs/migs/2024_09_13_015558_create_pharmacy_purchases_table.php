<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacyPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('pharmacy_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_code');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->date('paid_at');
            $table->foreignId('updated_by')->constrained('accounts');
            $table->foreignId('created_by')->constrained('accounts');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pharmacy_purchases');
    }
}
