<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_code')->unique();
            $table->date('receipt_date');
            $table->tinyInteger('payment_type')->comment('1: Cash, 2: Non Cash, 3: Petty Cash, 4: Receivables');
            $table->tinyInteger('payment_status')->comment('1: Paid, 2: Unpaid, 3: Pending');
            $table->decimal('amount', 17, 2);
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('cascade');
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}
