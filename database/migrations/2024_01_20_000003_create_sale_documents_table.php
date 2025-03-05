<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('sale_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->string('document_path');
            $table->string('document_name');
            $table->string('document_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_documents');
    }
} 