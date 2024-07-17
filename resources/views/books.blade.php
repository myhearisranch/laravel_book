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
    </div>
    @endsection
    
    