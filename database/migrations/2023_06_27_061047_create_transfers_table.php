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
        Schema::create(config('account.table_prefix', 'account') . '_' . 'transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_from');
            $table->unsignedBigInteger('account_to');
            $table->double('amount');
            $table->text('remark')->nullable();
            $table->text('particular')->nullable();
            $table->unsignedBigInteger('issued_by');
            $table->timestamps();

            // Foreign
            $table->foreign('issued_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('account_from')->references('id')->on(config('account.table_prefix', 'account') . '_accounts')->onDelete('cascade');
            $table->foreign('account_to')->references('id')->on(config('account.table_prefix', 'account') . '_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'transfers');
    }
};
