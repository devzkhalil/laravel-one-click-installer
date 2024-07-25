<?php

return [

    /**
     * INSTALLER CONFIGURATION
     * --------------------------------------
     * Configure your application installer
     * before deploying the installer.
     */
    
    'php' => [
        /**
         * MINIMUM PHP VERSION
         * --------------------------------------
         * Define the minimum PHP version required
         * for your application.
         */
        'min' => '8.3.0',

        /**
         * REQUIRED PHP EXTENSIONS
         * --------------------------------------
         * Define the PHP extensions required
         * for your application.
         */
        'extensions' => [
            'tokenizer',
            'json',
            'mbstring',
            'openssl',
            'dom',
            'libxml',
            'pdo',
            'phar',
            'xml',
            'xmlwriter',
            'curl',
            'gd',
            'pcntl',
            'posix',
            'fileinfo',
            'ftp',
        ],
    ],

    /**
     * INSTALLATION STEPS
     * --------------------------------------
     * Define all steps for the installer.
     * Comment out any step you don't need.
     * Do not change any word; altering the
     * steps can break the system.
     */
    'steps' => [
        // 'license_validation',
        'check_required_extensions',
        'basic_information_setup',
        'database_setup',
        'smtp_setup',
    ],

    /**
     * LICENSE INFORMATION
     * --------------------------------------
     * Provide your license validation API.
     */
    'license' => [
        'license_input_name' => 'license',
        'api' => null,
    ],

    /**
     * SYMLINK SUPPORT
     * --------------------------------------
     * If your migrations include the artisan
     * command `storage:link` or any symbolic
     * link operations, check if your hosting/system
     * supports creating symlinks.
     */
    'symlink' => true,

    /**
     * PERFORM MIGRATION?
     * --------------------------------------
     * Does your application run migrations
     * to set up your database?
     */
    'migration' => false,

    /**
     * SQL FILE NAME
     * --------------------------------------
     * If your application does not use
     * migrations to set up the database,
     * and you prefer using an SQL file,
     * define its name here.
     * 
     * Place the SQL file inside "database/sql/app.sql".
     * 
     * example: 'sql' => 'app.sql'
     */
    'sql' => null,

    /**
     * SMTP ENVIRONMENT VARIABLES
     * --------------------------------------
     * If you need to set up additional
     * environment variables during setup,
     * define them here.
     */
    'smtp' => [
        [
            'key' => 'MAIL_MAILER',
            'title' => 'SMTP Route'
        ],
        [
            'key' => 'MAIL_HOST',
            'title' => 'SMTP Mail Host'
        ],
        [
            'key' => 'MAIL_PORT',
            'title' => 'SMTP Mail Port'
        ],
        [
            'key' => 'MAIL_USERNAME',
            'title' => 'SMTP Mail Username'
        ],
        [
            'key' => 'MAIL_PASSWORD',
            'title' => 'SMTP Mail Password'
        ],
        [
            'key' => 'MAIL_ENCRYPTION',
            'title' => 'SMTP Encryption'
        ],
        [
            'key' => 'MAIL_FROM_ADDRESS',
            'title' => 'SMTP From Address'
        ],
        [
            'key' => 'MAIL_FROM_NAME',
            'title' => 'SMTP From Name'
        ],
    ],

    /**
     * COMPLETION REDIRECT
     * --------------------------------------
     * Define the URL to redirect to after
     * completing the installation.
     * 
     * example: '/home'
     */
    'redirect' => '/',

    /**
     * INSTALLER STATUS
     * --------------------------------------
     * Do not change these configurations.
     */
    'installed' => env('INSTALLER_INSTALLED', false),
];
