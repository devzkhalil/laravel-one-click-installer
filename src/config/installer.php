<?php

return [

    /**
     * INSTALLER CONFIGURATION
     * --------------------------------------
     * Configure you application installer
     * before you deploy the installer.
     * 
     */

    'php' => [
        /**
         * MINIMUM PHP VERSION
         * --------------------------------------
         * Define the minimum php version 
         * required for you application
         * 
         */

        'min' => '8.3.0',

        /**
         * REQUIRED PHP EXTENSIONS
         * --------------------------------------
         * Define here which extensions are
         * required for your application.
         * 
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
     * HERE IS THE ALL STEPS FOR INSTALLER
     * --------------------------------------
     * If you don't any one just comment out this step
     * Please don't change single word, 
     * if it then system will be break
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
     * Give your license validation api 
     */

    'license' => [
        'api' => null,
    ],

    /**
     * CHECK FOR SYMLINK
     * --------------------------------------
     * If your migration contains the artisan
     * command of storage:link , or any 
     * symbolic link operation, then you 
     * might need to check if your hosting/system
     * service supports creating symlinks
     * 
     */

    'symlink' => true,

    /**
     * PERFORM MIGRATION?
     * --------------------------------------
     * Does you application runs migration 
     * to setup your database?
     * 
     */

    'migration' => false,

    /**
     * SQL FILE NAME
     * --------------------------------------
     * If your application does not like
     * migration to setup db, and you want
     * to use .sql file to upload to DB
     * to setup, define its name here.
     * 
     * It should be placed inside "database/sql/app.sql"
     * directory.
     * 
     * example: 'sql' => 'app.sql'
     * 
     */

    'sql' => null,

    /**
     * SMTP ENV DATA
     * --------------------------------------
     * If you want to setup some more 
     * env attribute during setup time,
     * place them bellow here.
     * 
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
     * COMPLETE INSTALLATION REDIRECT
     * --------------------------------------
     * Redirect after completing the 
     * installation.
     * Provide url here.
     * 
     * example: /home
     */

    'redirect' => '/',

    /**
     * INSTALLER CONFIGURATION 
     * --------------------------------------
     * Do not change these configs.
     */

    'installed' => env('INSTALLER_INSTALLED', false),
];
