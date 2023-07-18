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
        Schema::create(config('account.table_prefix', 'account') . '_' . 'entries', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->unsignedBigInteger('ledger_id');
            $table->string('ledger_account');
            $table->unsignedBigInteger('journal_id');
            $table->integer('account_type');
            $table->double('amount');
            $table->text('particular')->nullable();
            $table->unsignedBigInteger('issued_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->json('data')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->timestamps();

            // Foreign 
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('ledger_id')->references('id')->on(config('account.table_prefix', 'account') . '_ledgers')->onDelete('cascade');
            $table->foreign('journal_id')->references('id')->on(config('account.table_prefix', 'account') . '_journals')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on(config('account.table_prefix', 'account') . '_transactions')->onDelete('SET NULL');
            // Polymorphic Relation
            $table->unsignedBigInteger('entryable_id')->nullable();
            $table->string('entryable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'entries');
    }
};
