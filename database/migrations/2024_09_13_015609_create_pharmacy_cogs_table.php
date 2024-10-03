<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmacyCogsTable extends Migration
{
    public function up()
    {
        Schema::create('pharmacy_cogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_item_id')->constrained('items');
            $table->decimal('cost', 17, 2);
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pharmacy_cogs');
    }
}
