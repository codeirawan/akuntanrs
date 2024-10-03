<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierTable extends Migration
{
    public function up()
    {
        Schema::create('cashiers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher')->unique(); // Ensuring voucher is unique
            $table->date('date');
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade'); // Cascade on delete
            $table->foreignId('unit_id')->constrained('units')->onDelete('cascade'); // Cascade on delete
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('set null'); // Set null on delete
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null'); // Set null on delete
            $table->string('unregistered_patient')->nullable();
            $table->enum('service_type', [1, 2, 3])->comment('1: Rawat Inap, 2: Rawat Jalan, 3: Pembelian Obat');
            $table->enum('transaction_type', [1, 2, 3, 4])->comment('1: Cash, 2: Non Cash, 3: Petty Cash, 4: Receivables');
            $table->decimal('amount', 17, 2);
            $table->enum('payment_status', [1, 2, 3])->comment('1: Paid, 2: Unpaid, 3: Pending');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // Cascade on delete
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // Set null on delete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cashiers');
    }
}
