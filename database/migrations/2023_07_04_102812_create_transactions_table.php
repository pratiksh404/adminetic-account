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
        Schema::create(config('account.table_prefix', 'account') . '_' . 'transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->double('amount');
            $table->text('particular');
            $table->text('remark')->nullable();
            $table->integer('type')->default(1);
            $table->integer('method')->default(1);
            $table->unsignedBigInteger('issued_by');
            $table->json('data')->nullable();
            $table->dateTime('issue_date')->nullable();
            $table->unsignedBigInteger('account_id')->nullable();

            // Verification
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->integer('status')->default(0);

            // Polymorphism 
            $table->unsignedBigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('account_id')->references('id')->on(config('account.table_prefix', 'account') . '_accounts')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'transactions');
    }
};
