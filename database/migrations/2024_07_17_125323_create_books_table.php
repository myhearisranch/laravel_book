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
            $table->timestamps();
            $table->integer('item_number');
            $table->integer('item_amount');
            $table->datetime('published');
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
