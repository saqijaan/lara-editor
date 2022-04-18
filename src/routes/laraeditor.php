<?php

use Illuminate\Support\Facades\Route;
use LaraEditor\App\Http\Controllers\AssetController;

Route::prefix('laraeditor')->name('laraeditor.')->namespace('LaraEditor\App\Http\Controllers')->group(function(){
	Route::post('editor/asset/store', [AssetController::class,'store'])->name('asset.store');
});
