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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->double('amount');
            $table->text('particular');
            $table->text('remark')->nullable();
            $table->integer('type')->default(1);
            $table->integer('method')->default(1);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('data')->nullable();
            $table->dateTime('issue_date')->nullable();
            $table->foreignId('account_id')->nullable()->constrained()->nullOnDelete();

            // Verification
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->integer('status')->default(0);

            // Polymorphism 
            $table->unsignedBigInteger('transactionable_id')->nullable();
            $table->string('transactionable_type')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
