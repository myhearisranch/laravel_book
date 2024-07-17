<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

//Schemaファザードを使用できるようにする
//これにより、マイグレーションやスキーマビルダ操作を簡単に行える
use Illuminate\Support\Facades\Schema;

//URLファザードを使用できるようにする
//これにより、アプリケーション内でURLを生成する際にHTTPSプロトコルを強制させる
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //デフォルトの文字列長を191に設定しています。
        //これにより、インデックス長の制限内に収まるようになります。
        Schema::defaultStringLength(191);
        
        //アプリケーションが生成するすべてのURLにHTTPSプロトコルを強制します。
        URL::forceScheme('https');
        //
    }
}
