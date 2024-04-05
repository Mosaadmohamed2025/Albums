<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[\App\Http\Controllers\AlbumController::class , 'index']);

Route::resource('Albums' , \App\Http\Controllers\AlbumController::class);

Route::post('product-images/{id}' , [\App\Http\Controllers\AlbumController::class , 'addAlbumImages'])->name('album.add.images');
Route::delete('product-images-delete/{id}' , [\App\Http\Controllers\AlbumController::class , 'deleteAlbumImages'])->name('album.images.delete');

Route::get('move/{id}' , [\App\Http\Controllers\AlbumController::class , 'move'])->name('move');
Route::post('move-images' , [\App\Http\Controllers\AlbumController::class , 'moveImagesToAlbum'])->name('move.images');
