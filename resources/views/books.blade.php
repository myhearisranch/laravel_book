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
        
        <!-- 本登録フォーム -->
        <form action="{{ url('books')}}" method="POST" class="form-horizotal">
            @csrf
            
            <!-- 本のタイトル -->
            <div class="form-group">
                <div class="col-sm-6">
                    <input type="text" name="item_name" class="form-control">
                </div>
            </div>
            
            <!-- 本 登録ボタン -->
            <div class="form-group">
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
                                    
                                    <!-- 本:削除ボタン -->
                                    <td>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
         @endif
    @endsection
    
    