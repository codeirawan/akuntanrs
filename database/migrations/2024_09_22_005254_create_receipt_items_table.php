<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptItemsTable extends Migration
{
    public function up()
    {
        Schema::create('receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('receipt_id')->constrained('receipts')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_unit')->nullable();
            $table->decimal('item_qty', 17, 2)->nullable();
            $table->decimal('unit_price', 17, 2)->nullable();
            $table->decimal('total_price', 17, 2)->nullable();
            $table->tinyInteger('item_type')->nullable()->comment('1: pharmacy, 2: logistic, 3: general');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipt_items');
    }
}
