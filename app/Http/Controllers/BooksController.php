<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Bookモデルを使えるようにする
// use App\Book;　Class "App\Book" not foundというエラーが発生
//Laravel 7以前の書き方であり、現在のバージョンでは use App\Models\Book と指定する必要がある。
use App\Models\Book;


//バリデーションエラーを使えるようにする
use Validator;

//認証モデルを使用する
use Auth;

use App\Http\Controllers\Controller;

class BooksController extends Controller
{
    
    //コンストラクタ(このクラスが呼ばれたら最初に処理をする)
    //この記述があると、Call to undefined method App\Http\Controllers\BooksController::middleware()というエラーが発生
    // public function __construct()
    
    // {
    //     $this->middleware('auth');
    // }
    
    
    //本の一覧表示
    //本の登録や更新のようにパラメータを受け取らないので$requestはいらない
    //(Request $request):Laravelでは、Request オブジェクトを使ってクライアントから送信されたデータ
    //（フォームデータ、クエリパラメータ、ヘッダーなど）を取得することができる。
    
    public function index(){
        $books = Book::where('user_id',Auth::user()->id)->orderBy('created_at', 'asc')->paginate(3);
        return view('books',[
           'books'=>$books 
        ]);
    }
    
    //編集画面
    
    //変数が$booksだと本の情報を受け取れていない
    
    // public function edit(Book $books){
    //     dd($books);
    //     return view('booksedit',[
    //       'book' => $books 
    //     ]);
    // }
    
    public function edit($book_id){
        $books=Book::where('user_id',Auth::user()->id)->find($book_id);
        return view('booksedit', [
            'book' => $books
        ]);
    }
    
    
    //更新
    public function update(Request $request){
    
        //バリデーション
        $validator = Validator::make($request->all(),[
            'item_name'   => 'required|min:3|max:255',
            'item_number' => 'required|min:1|max:3',
            'item_amount' => 'required|max:6',
        ]);
        
        //バリデーションエラー
        if($validator->fails()){
            return redirect('/')
              ->withInput()
              ->withErrors($validator);
        }
        
    // 　#parameters: array:6 [▼
    //       "item_name" => "hoge"
    //       "item_number" => "1"
    //       "item_amount" => "10"
    //       "published" => "2024/7/23"
    //       "id" => null
    //       "_token" => "OtCMH0zAnxoxFiFZjMILwbFyNC57wAyYWAh1QIfg"
    //     ]
    
    //原因: id=>null
    
    //解決方法: 
    //編集画面を表示する時点で、そもそもidを渡せていなかった
    //ルートパラメータ名とコントローラメソッドのパラメータ名を一致させる必要があります
    
    //ルーティング:
    //Route::get('booksedit/{book}', [BooksController::class, 'edit']);
    
    //コントローラ:
    //  public function edit(Book $book){
    //     return view('booksedit', [
    //         'book' => $book
    //     ]);
    // }
        
        //データ更新
        $books = Book::find($request->id);
        $books->item_name = $request->item_name;
        $books->item_number = $request->item_number;
        $books->item_amount = $request->item_amount;
        $books->published = $request->published;
        $books->save();
        return redirect('/');
    }
    
    //登録
    public function store(Request $request){
        //バリデーション
        $validator = Validator::make($request->all(),[
            'item_name'=>'required|min:3|max:255',
            'item_number'=>'required|min:1|max:3',
            'item_amount'=>'required|max:6',
            'published'=>'required',
        ]);
        
        //バリデーションエラー
        if($validator->fails()){
            dd($validator);
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        $file = $request->file('item_img');
        if(!empty($file)){
            $filename=$file->getClientOriginalName();
            $move = $file->move('./upload/',$filename);
        }else{
            $filename="";
        }
        
        //登録処理
        $books = new Book;
        $books->user_id = Auth::user()->id;
        $books->item_name = $request->item_name;
        $books->item_number=$request->item_number;
        $books->item_amount=$request->item_amount;
        $books->item_img = $filename;
        $books->published=$request->published;
        $books->save();
        
        return redirect('/')->with('message', '本登録が完了しました');
    }
    
    //削除
    public function destroy(Book $book){
        $book->delete();
        return redirect('/');
    }
}
