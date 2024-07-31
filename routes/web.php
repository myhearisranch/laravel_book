<?php

use App\Http\Controllers\BooksController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 
use App\Models\Book;

// 本の一覧表示
//Route::get('/', 'BooksController@index'); : この書き方だとTarget class [BooksController] does not exist.
//Laravel 8以前の書き方で、Laravel 8以降ではコントローラーのフル名前空間を使用する必要がある
Route::get('/', [BooksController::class, 'index']);

// ダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/', [BooksController::class, 'index'])->name('books.index');
    Route::get('booksedit/{book}', [BooksController::class, 'edit'])->name('books.edit');
    Route::post('book/update', [BooksController::class, 'update'])->name('books.update');
    Route::post('book/store', [BooksController::class, 'store'])->name('books.store');
    Route::delete('book/{book}', [BooksController::class, 'destroy'])->name('books.destroy');
});

// ログイン機能の主なルーティングはauth.phpに記述されている
require __DIR__.'/auth.php';