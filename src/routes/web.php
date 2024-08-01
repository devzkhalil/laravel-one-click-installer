<?php

use Illuminate\Support\Facades\Route;
use Devzkhalil\Installer\Controllers\InstallerController;

Route::prefix('install')->middleware(['web', 'install'])->controller(InstallerController::class)->group(function () {

    Route::get('/', 'begin')->name('installer.require');

    Route::get('/license-validation', 'licenseValidation')->name('installer.license-validation');
    Route::post('/license-validation', 'licenseValidationProcess')->name('installer.license-validation.process');
    Route::get('/required-extensions', 'requiredExtensions')->name('installer.check-required-extensions');
    Route::get('/basic-information', 'basicInformation')->name('installer.basic-information');
    Route::post('/basic-information', 'saveBasicInformation')->name('installer.basic-information.save');
    Route::get('/database', 'database')->name('installer.database');
    Route::post('/upload-database', 'saveDatabase')->name('installer.database.save');
    Route::get('/smtp', 'smtp')->name('installer.smtp');
    Route::post('/smtp', 'saveSmtp')->name('installer.smtp.save');

    Route::post('/next-step', 'fetchNextStep')->name('installer.next-step');
});
