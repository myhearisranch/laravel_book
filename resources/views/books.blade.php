<!-- resources/views/books.blade.php -->

<!-- ベーステンプレート親を読み込む　-->
<!-- .は/に変換され、layouts.app -> layouts/app.blade.phpを読み込むという意味 -->
@extends('layouts.app')


@section('content')
    <!-- Bootstrapの定形コード -->
    <div class="card-body">
        <div class="cart-title">
          本のタイトル
        </div>
  
        <!-- バリデーションエラーの表示に使用 -->
        <!--記述したファイルを読み込む-->
        <!--common/errors.blade.phpを読み込む-->
        
        @include('common.errors')
        <!-- バリデーションエラーの表示に使用 -->
        
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message')}}
            </div>
        @endif
        
        <!-- 本のタイトル -->
        <form action="{{ route('books.store') }}" method="POST" class="form-horizotal">
            @csrf
            
            <div class="form-row">
                <div class="form-grooup col-md-6">
                    <label for="book" class="col-sm-3 control-label">Book</label>
                    <input type="text" name="item_name" class="form-control">
                </div>
           
            
                <div class="form-group col-md-6">
                    <label for="amount" class="col-sm-3 control-label">金額</label> 
                    <input type="text" name="item_amount" class="form-control">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="number" class="col-sm-3 control-label">数</label>
                    <input type ="text" name="item_number" class="form-control">
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label for="published" class="col-sm-3 control-label">公開日</label>
                <input type="date" name="published" class="form-control">
            </div>
            
            
            <!-- 本 登録ボタン -->
            <div class="form-row">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div> 
            </div>
            
        </form>
        
        <!-- 現在の本 -->
        @if (count($books) > 0)
            <div class ="card-body">
                <div class="card-body">
                    <table class="table table-striped task-table">
                        <!-- テーブルヘッダー -->
                        <thead>
                            <th>本一覧</th>
                            <th>&nbsp;</th>　　
                        </thead>
                        <!-- テーブル本体 -->
                        <tbody>
                            @foreach ($books as $book)
                                <tr>
                                    <!-- 本タイトル -->
                                    <td class="table-text">
                                        <!-- $book->item_name: 各本のタイトルを取得して表示 -->
                                        <div>{{ $book->item_name}}</div>
                                    </td>
                                    
                                    
                                    <!-- 本:編集ボタン -->
                                    <td>
                                      　<form action="{{ url('booksedit/'.$book->id) }}" method="GET">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                更新
                                            </button>
                                        </form>
                                    </td>
                                    
                                    <!-- 本:削除ボタン -->
                                    <td>
                                        <form action="{{url('book/'.$book->id) }}" method="POST">
                                            @csrf
                                            
                                            {{--<!--@method DELETE : フォームのHTTPメソッドを上書きしてDELETEリクエストを送信するために使用される -->--}}
                                            {{--<!-- 上のコメントアウトがあるとUndefined constant "method_field"というエラーが発生 -->--}}
                                            {{-- 原因: HTML コメント <!-- --> はHTMLとして扱われ、Bladeテンプレートエンジンが正しくコメントアウトとして処理しないことがある --}}
                                            {{--　｛-- -- ｝を使うことで、Bladeテンプレートエンジンで正しくコメントとして認識される --}}
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-danger">
                                                削除
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    
    <div class="row">
        <div class="col-md-4 offset-md-4">
            {{$books->links()}}
        </div>
    </div>
         @endif
    @endsection
    
    