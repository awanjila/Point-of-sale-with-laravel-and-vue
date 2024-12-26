<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Business Information
            $table->string('business_name')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_address')->nullable();
            
            // Financial Settings
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->string('currency')->default('KES');
            
            // Till Number
            $table->string('till_number')->nullable();
            
            // Logo Path
            $table->string('logo_path')->nullable();
            
            // Receipt Customization
            $table->text('receipt_header')->nullable();
            $table->text('receipt_footer')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
