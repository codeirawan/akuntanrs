<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nik');
            $table->date('dob');
            $table->tinyInteger('gender')->comment('0: Female, 1: Male');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('insurance_name')->nullable();
            $table->string('insurance_no')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
