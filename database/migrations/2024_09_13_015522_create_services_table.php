<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_code')->unique();
            $table->string('service_name');
            $table->decimal('price', 17, 2);
            $table->text('description')->nullable();
            $table->tinyInteger('service_type')->comment('1: consultation, 2: surgery, 3: diagnostic, 4: inpatient, 5: outpatient');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('services');
    }
}
