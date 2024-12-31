<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // I go through the official documentation to national portal if VAT invoices
            // this app supports only the main features not diving deep into nuanses
            // because the main purpose of this app is to give a general idea of ​​how 
            // vat invoice mechanism works
            //1. general
            $table->string('number')->unique();
            $table->date('creation_date')->required();
            $table->date('action_date')->required();
            $table->string('type')->required();
            $table->string('parent_invoice')->nullable();


            $table->string('status')->required();
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('total_wo_vat', 10, 2)->default(0);
            $table->decimal('total_vat', 10, 2)->default(0);

            // 2 invoice sender fields
            $table->foreignId('sender_company')
            ->required()
            ->constrained('companies', 'id', 'sender_company_id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('author')
            ->required()
            ->constrained('users', 'id', 'author_user_id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            // 3 invoice recipient fields 
            $table->foreignId('recipient_company')
            ->required()
            ->constrained('companies', 'id', 'recipient_company_id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreignId('signatory')
            ->nullable()
            ->constrained('users', 'id', 'signatory_user_id')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            // 3 not supported
            // 5 shipment terms
            $table->string('contract_number');
            $table->date('contract_date');
            $table->json('delivery_documents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
