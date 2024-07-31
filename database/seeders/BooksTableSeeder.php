<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; // Fakerのネームスペースをインポート
use App\Models\Book; // Bookモデルのネームスペースをインポート

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ja_JP'); // Fakerファクトリを使用
        for($i = 0; $i < 10; $i++){
            Book::create([
                'item_name' => $faker->word(),
                'user_id' => $faker->numberBetween(1,2),
                'item_number' => $faker->numberBetween(1,999),
                'item_amount' => $faker->numberBetween(100,5000),
                'item_img' => $faker->image("./public/upload", 300, 300, 'cats', false),
                'published' => $faker->dateTime('now'),
                'created_at' => $faker->dateTime('now'),
                'updated_at' => $faker->dateTime('now'),
            ]);
        }
    }
}
