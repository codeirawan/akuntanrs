<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticPurchasesTable extends Migration
{
    public function up()
    {
        Schema::create('logistic_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained('suppliers');
            $table->decimal('total', 15, 2);
            $table->timestamps();
$table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logistic_purchases');
    }
}
