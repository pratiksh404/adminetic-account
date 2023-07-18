<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Info Management
    |--------------------------------------------------------------------------
    | 
    */
    'vat' => '123456789',

    /*
    |--------------------------------------------------------------------------
    | Flag Management
    |--------------------------------------------------------------------------
    | 
    */
    'income_flag' => 1,
    'expense_flag' => 0,
    'debit' => 0,
    'credit' => 1,

    /*
    |--------------------------------------------------------------------------
    | Configuration Management
    |--------------------------------------------------------------------------
    */
    'publish_migrations' => true,
    'migration_publish_path' => 'database/migrations/account',
    'table_prefix' => 'account',

    /*
    |--------------------------------------------------------------------------
    | Has Entry Model Tables
    |--------------------------------------------------------------------------
    */
    'entryable_tables' => [
        'payments'
    ]

];