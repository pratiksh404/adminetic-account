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
        Schema::create(config('account.table_prefix', 'account') . '_' . 'ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->double('opening_balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('account.table_prefix', 'account') . '_' . 'ledgers');
    }
};
