<?php

use Illuminate\Support\Facades\Route;


Route::prefix('laraeditor')->name('laraeditor.')->namespace('LaraEditor\App\Http\Controllers')->group(function(){
	Route::post('editor/asset/store', 'AssetController@store')->name('editor.asset.store');
	
	Route::get('editor/{model}/{editable}', 'EditorController@editor')->name('editor.model.editor');
	Route::post('editor/{model}/{editable}', 'EditorController@store')->name('editor.model.store');
	
	Route::get('editor/{model}/{editable}/templates', 'EditorController@templates')->name('editor.model.templates');
	Route::get('editor/templates', 'EditorController@templates')->name('editor.templates');

	Route::get('media/{media}', 'MediaController@show')->name('media.show');
	Route::post('media', ['MediaController@store'])->name('media.store');
	Route::delete('media', ['MediaController@removeTemp'])->name('media.temp.delete');
	Route::delete('media/{media}', ['MediaController@destroy'])->name('media.destroy');
});
