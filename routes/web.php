<?php

// /app/Book.phpというモデルを参照するために利用
use App\Book;

//HTTPリクエストを扱うための様々なメソッドを参照できるようにする
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

//本の一覧を表示

//HTTPメソッド: get
//URL: '/'
//目的: このルートは、アプリケーションのルートURL（/）にアクセスしたときに、
//      welcome ビューを表示します。通常、welcome.blade.php はLaravelのデフォルトのウェルカムページです。

Route::get('/', function () {
    return view('welcome');
});

//本を追加

// HTTPメソッド: POST
// URL: /books
Route::post('/books', function(Request $request){
    
});

//本を削除する

// HTTPメソッド: DELETE
// URL: /book/{book}

// 目的: このルートは、本を削除するためのエンドポイントを定義します。
//       URLの {book} はプレースホルダーであり、削除したい特定の本のIDを含むパラメータを示しています。
//       Bookモデルのインスタンスをルートパラメータとして受け取り、そのインスタンスを使用して本を削除するためのロジックを実装します。

Route::delete('book/{book}', function(Book $book){
    
});
