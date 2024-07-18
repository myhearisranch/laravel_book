<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 

Route::get('/', function () {
    return view('books');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/books', function(Request $request){
   //バリデーション
   //Validator::makeメソッドを使用してバリデーションルールを定義
   //$request->all(): 送信されたすべてのデータを配列として取得
   $validator = Validator::make($request->all(), [
       
        //カラム名  => ルール
        'item_name' => 'required|max:255',   
    ]);
    
    //バリデーションエラー(バリデーションが失敗した場合の処理)
    if($validator -> fails()) {
        return redirect('/')
            //withInput(): ユーザーが入力したデータをセッションにフラッシュし、次のリクエストで再表示できるようにする
            -> withInput()
            //withErrors($validator): バリデーションエラーメッセージをセッションにフラッシュする。。
            //これにより、ビューでエラーメッセージを表示する。
            //バリデーションエラー内容を$error変数に渡している
            -> withErrors($validator);
    }
    
    //本の登録処理
    $books = new Book;
    $books -> item_name = $request->item_name;
    $books -> item_number = '1';
    $books -> item_amount = '1000';
    $books -> published = '2017-03-07 00:00:00';
    $books -> save();
    return redirect('/');
});


//ログイン機能の主なルーティングはauth.phpに記述されている
require __DIR__.'/auth.php';
