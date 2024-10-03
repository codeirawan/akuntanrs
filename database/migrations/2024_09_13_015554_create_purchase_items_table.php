<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('item_id')->constrained('items');
            $table->string('unit');
            $table->decimal('price', 17, 2);
            $table->decimal('quantity', 17, 2);
            $table->decimal('amount', 17, 2);
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_items');
    }
}
