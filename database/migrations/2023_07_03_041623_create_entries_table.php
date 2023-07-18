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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->foreignId('ledger_id')->constrained()->cascadeOnDelete();
            $table->string('ledger_account');
            $table->foreignId('journal_id')->constrained()->cascadeOnDelete();
            $table->integer('account_type');
            $table->double('amount');
            $table->text('particular')->nullable();
            $table->unsignedBigInteger('issued_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            // Foreign 
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
