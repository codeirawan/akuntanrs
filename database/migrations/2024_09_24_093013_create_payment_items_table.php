<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->onDelete('cascade');
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_items');
    }
};
