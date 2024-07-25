<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator; 

//この記述がないとClass "Book" not foundというエラーが発生
use App\Models\Book;

//本の一覧表示
Route::get('/', function () {
    
    //Book::orderBy('created_at', 'asc'): books テーブルのレコードを created_at カラムで昇順に並べ替えるクエリを作成。
    //get(): 並べかえた結果を全て取得する
    $books = Book::orderBy('created_at', 'asc') ->get();
    
    //view('books', ['books' => $books]): resources/views/books.blade.php というビューを返すように Laravel に指示
    //このビューにbooksという変数を渡す
    return view('books',[
        'books' => $books
        ]);
    
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//本を登録
Route::post('/books', function(Request $request){
   //バリデーション
   //Validator::makeメソッドを使用してバリデーションルールを定義
   //$request->all(): 送信されたすべてのデータを配列として取得
   $validator = Validator::make($request->all(), [
       
        //カラム名  => ルール
        'item_name'   => 'required|min:3|max:255',
        'item_number' => 'required|min:1|max:3',
        'item_amount' => 'required|max:6',
        'published'   => 'required',
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
    
    //  +request: 
    //     Symfony\Component\HttpFoundation
    //     \
    //     InputBag {#44 ▼
    //         #parameters: array:5 [▼
    //           "_token" => "Dxj3t0z3j8w56wjgbMUS2hQdklrJghIuxlFBt3oF"
    //           "item_name" => "hoge"
    //           "item_amount" => "1"
    //           "item_number" => "1"
    //           "published" => "2024-07-03"
    //         ]
    //       }
    
    
    $books -> item_name = $request->item_name;
    $books -> item_number = $request->item_number;
    $books -> item_amount = $request->item_amount;
    $books -> published = $request->published;
    $books -> save();
    return redirect('/');
});

//本を削除

//DELETEリクエストを処理するルートを定義。
///book/{book}の{book}は、ルートパラメータを示す。
//このパラメータは削除する特定のBookモデルのIDに対応。

//function(Book $book): {book}がURLで指定されたとき、そのIDに対応するBookオブジェクトがコントローラ内で直接利用可能
Route::delete('/book/{book}', function(Book $book) {
    
    //Bookモデルインスタンスのdeleteメソッドを呼び出して、そのデータベースエントリを削除
    $book->delete();
    return redirect('/');
});

//本の更新画面

//Route::post: HTTP POSTリクエストに対してルート定義する。通常、フォームの送信やデータの作成・更新操作に使用されます。
//'/booksedit/{books}': ルートのURLパス/booksedit/の後に本のIDを受け取るプレースホルダー {books} が含まれる
//URLパスから取得した books のIDに基づいて Book モデルのインスタンスを受け取ります。LaravelはこのIDを使って、
//自動的にデータベースから該当するレコードを取得し、$books という変数に格納

Route::get('/booksedit/{books}', function(Book $books) {
   //{books}: id値を取得 => Book $books id値のレコードを取得
   //このデータはビュー内で$booktという変数としてアクセスできる
   //書き方: return view('読み込むビューの指定', [ビューに渡す値])
   //ビューに渡す値: ビュー側で使用する変数名=>値
   return view('booksedit', ['book' => $books]);
});

//本の更新処理

//Route::post: HTTP POSTリクエストに対してルートを定義。通常、フォームの送信やデータの作成・更新操作に使用される。
//'/books/update': ルートのURLパスです。このパスに対してPOSTリクエストが送信されると、このルートがマッチします。
//function(Request $request): ルートがマッチしたときに実行される。送信されたデータにアクセスできます。

Route::post('/books/update', function(Request $request){
   //バリデーション
   
    //Validator::make: バリデーションを作成。$request->all() はリクエストの全データを取得し、第二引数にはバリデーションルールを指定します。
    // 各フィールドのバリデーションルール:
    // 'id': 必須フィールド。
    // 'item_name': 必須フィールド、最小文字数3、最大文字数255。
    // 'item_number': 必須フィールド、最小文字数1、最大文字数3。
    // 'item_amount': 必須フィールド、最大文字数6。
    // 'published': 必須フィールド。
   $validator = Validator::make($request->all(),[
       
       'id'          => 'required',
       'item_name'   => 'required|min:3|max:255',
       'item_number' => 'required|min:1|max:3',
       'item_amount' => 'required|max:6',
       'published'   => 'required',
       
       ]);
    //バリデーションエラー
    
    // $validator->fails(): バリデーションが失敗した場合に true を返します。
    // redirect('/'): ルート '/' にリダイレクトします。
    // withInput(): フォーム入力をセッションに保存し、リダイレクト後に再入力を簡単にします。
    // withErrors($validator): バリデーションエラーをセッションに保存します。

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->WithErrors($validator);
    }
    
    //データ更新
    
    //リクエストから取得したIDでデータベースからデータを取得する
    $books = Book::find($request->id);
    
    //リクエストから送信されたデータを使ってフィールドを更新します。
    $books->item_name   = $request->item_name;
    $books->item_number = $request->item_number;
    $books->item_amount = $request->item_amount;
    $books->published   = $request->published;
    
    //更新したデータをデータベースに保存
    $books->save();
    
    //ホームページにredirect
    return redirect('/');
});

//ログイン機能の主なルーティングはauth.phpに記述されている
require __DIR__.'/auth.php';
