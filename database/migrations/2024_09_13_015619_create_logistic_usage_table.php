<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogisticUsageTable extends Migration
{
    public function up()
    {
        Schema::create('logistic_usage', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logistic_item_id')->constrained('items');
            $table->integer('quantity');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('logistic_usage');
    }
}
