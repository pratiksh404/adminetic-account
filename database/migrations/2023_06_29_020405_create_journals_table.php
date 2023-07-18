<?php

use Adminetic\Account\Models\Admin\Journal;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('account.table_prefix', 'account') . '_' . 'journals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fiscal_id');
            $table->dateTime('issued_date');
            $table->integer('status')->default(Journal::PENDING);
            $table->string('bill_no');
            $table->json('data')->nullable();
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();

            // Foreign
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('SET NULL');
            $table->foreign('fiscal_id')->references('id')->on(config('account.table_prefix', 'account') . '_fiscals')->onDelete('cascade');

            // Polymorphic Relation
            $table->unsignedBigInteger('journalable_id')->nullable();
            $table->string('journalable_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'journals');
    }
};
