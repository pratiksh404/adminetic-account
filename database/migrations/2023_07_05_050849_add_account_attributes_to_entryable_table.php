<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (count(config('account.entryable_tables', [])) > 0) {
            foreach (config('account.entryable_tables') as $entryable_table) {
                Schema::table($entryable_table, function (Blueprint $table) {
                    $table->string('ledger_account')->nullable();
                    $table->text('remark')->nullable();
                    $table->integer('method')->default(1);
                    $table->json('data')->nullable();
                    $table->dateTime('issue_date')->nullable();
                    $table->unsignedBigInteger('account_id')->nullable();

                    // Verification
                    $table->unsignedBigInteger('verified_by')->nullable();
                    $table->integer('status')->default(0);
                    // Foreign
                    $table->foreign('verified_by')->references('id')->on('users')->onDelete('SET NULL');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (count(config('account.entryable_tables', [])) > 0) {
            foreach (config('account.entryable_tables') as $entryable_table) {
                Schema::table($entryable_table, function (Blueprint $table) {
                    $table->dropForeign(['verified_by']);
                    $table->dropColumn([
                        'ledger_account', 'remark', 'method', 'data', 'issue_date', 'account_id', 'verified_by', 'status'
                    ]);
                });
            }
        }
    }
};
