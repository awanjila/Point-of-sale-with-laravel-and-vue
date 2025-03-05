<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('sale_no')->unique();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->foreignId('delivery_person_id')->nullable()->constrained('employees');
            $table->enum('sale_type', ['final', 'draft', 'quotation', 'proforma']);
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled']);
            $table->date('sale_date');
            $table->enum('payment_terms', ['immediate', '15_days', '30_days', '45_days']);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percentage'])->default('fixed');
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('shipping_charges', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->enum('payment_status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->enum('payment_method', ['cash', 'bank_transfer', 'cheque', 'mobile_money'])->nullable();
            $table->string('payment_reference')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
} 