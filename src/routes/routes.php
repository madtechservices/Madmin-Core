<?php

use Madtechservices\MadminCore\app\Http\Controllers\ChangeAccountController;
use Madtechservices\MadminCore\app\Http\Controllers\ChangeLangController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\AccountsCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\ActivitiesCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\FilesCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\RolesCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\SettingsCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\UsersCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\Cruds\PostsCrudController;
use Madtechservices\MadminCore\app\Http\Controllers\FilesController;
use Madtechservices\MadminCore\app\Http\Controllers\MagicLinkController;
use Madtechservices\MadminCore\app\Http\Middlewares\DisableDebugbarMiddleware;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => [
        'web',
        DisableDebugbarMiddleware::class,
    ],
], function () {
    Route::get('change-lang/{lang}', [ChangeLangController::class, 'changeLang'])->name('change-lang');
    Route::get('/file/{file:uuid}', FilesController::class)->name('madmin-core.file');
    Route::get('/file/{file:uuid}/download', [FilesController::class, 'download'])->name('madmin-core.file-download');
    Route::get('/thumbnail/{file:uuid}/{width?}/{height?}', [FilesController::class, 'thumbnail'])->name('madmin-core.thumbnail');
});

if (config('madmin-core.config.magic_link_login')) {
    Route::group([
        'prefix' => config('backpack.base.route_prefix', 'admin').'/login',
        'middleware' => [
            'web',
            'guest',
        ],
        'as' => 'magic-link.',
    ], function () {
        Route::get('magic', [MagicLinkController::class, 'getLogin'])->name('get');
        Route::post('magic', [MagicLinkController::class, 'postLogin'])->name('post');
        Route::get('magic/verify/{token}', [MagicLinkController::class, 'verifyLogin'])
            ->middleware(['signed'])
            ->name('verify');
    });
}

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'as' => 'admin.',
], function () {
    Route::crud('post', PostsCrudController::class);
    Route::crud('user', UsersCrudController::class);
    Route::crud('account', AccountsCrudController::class);
    Route::crud('activity', ActivitiesCrudController::class);
    Route::crud('role', RolesCrudController::class);
    Route::crud('filemanager', FilesCrudController::class);
    

    Route::get('change-account/{id}', [ChangeAccountController::class, 'changeAccount'])->name('change-account');

    Route::get('/users/{user}/verify', [UsersCrudController::class, 'verifyUser'])->name('verify');
    Route::get('settings', [SettingsCrudController::class, 'index'])->name('settings');
    Route::post('settings', [SettingsCrudController::class, 'save']);
});
