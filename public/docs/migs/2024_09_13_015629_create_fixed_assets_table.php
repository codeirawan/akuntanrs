<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFixedAssetsTable extends Migration
{
    public function up()
    {
        Schema::create('fixed_assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_name');
            $table->decimal('value', 15, 2);
            $table->date('purchase_date');
            $table->timestamps();
$table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fixed_assets');
    }
}
