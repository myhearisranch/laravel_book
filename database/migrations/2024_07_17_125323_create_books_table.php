<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     
    //新しいテーブル/カラム/インデックスをデータベースに追加するために使用する
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            
            //登録したユーザーのIDを入れるカラムを追加
            $table->bigInteger('user_id');
            
            
            $table->timestamps();
            $table->integer('item_number');
            $table->string('item_name');
            $table->integer('item_amount');
            $table->datetime('published');
            $table->string('item_img');
        });
    }

    /**
     * Reverse the migrations.
     */
     
    //up()メソッドで作成したテーブルを削除する
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
