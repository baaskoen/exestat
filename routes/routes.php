<?php

use Illuminate\Support\Facades\Route;
use Kbaas\Exestat\Http\Controllers\ExestatController;
use Kbaas\Exestat\Http\Middleware\IgnoreExestat;

Route::group(['middleware' => IgnoreExestat::class], function () {
    Route::get('exestat', [ExestatController::class, 'index'])->name('exestat.index');
    Route::get('exestat/clear', [ExestatController::class, 'clear'])->name('exestat.clear');
    Route::get('exestat/{uuid}', [ExestatController::class, 'detail'])->name('exestat.detail');
});
