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
        Schema::create(config('account.table_prefix', 'account') . '_' . 'accounts', function (Blueprint $table) {
            $table->id();
            $table->string('no')->unique();
            $table->string('holder_name');
            $table->string('holder_email')->nullable();
            $table->string('holder_phone')->nullable();
            $table->boolean('active')->default(1);
            $table->text('description')->nullable();
            $table->integer('type')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'accounts');
    }
};
