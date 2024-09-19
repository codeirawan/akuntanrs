<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierTable extends Migration
{
    public function up()
    {
        Schema::create('cashier', function (Blueprint $table) {
            $table->id();
            $table->string('voucher');
            $table->date('date');
            $table->foreignId('account_id')->constrained('accounts');
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('service_id')->nullable()->constrained('services');
            $table->foreignId('patient_id')->nullable()->constrained('patients');
            $table->string('unregistered_patient')->nullable();
            $table->enum('service_type', [1, 2, 3])->comment('1: Rawat Inap, 2: Rawat Jalan, 3: Pembelian Obat');
            $table->enum('transaction_type', [1, 2, 3, 4])->comment('1: Cash, 2: Non Cash, 3: Petty Cash, 4: Receivables');
            $table->decimal('amount', 15, 2);
            $table->enum('payment_status', [1, 2, 3])->comment('1: Paid, 2: Unpaid, 3: Pending');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashier');
    }
}
