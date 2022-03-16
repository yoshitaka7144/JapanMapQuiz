<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizCountValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("quiz_count_values")->truncate();

        $values = [
            [
                "value" => 5,
            ],
            [
                "value" => 10,
            ],
            [
                "value" => 15,
            ],
            [
                "value" => 20,
            ],
            [
                "value" => 25,
            ],
            [
                "value" => 30,
            ],
            [
                "value" => 35,
            ],
            [
                "value" => 40,
            ],
            [
                "value" => 45,
            ],
            [
                "value" => 47,
            ],
        ];

        // 登録
        foreach ($values as $value) {
            \App\Models\QuizCountValue::create($value);
        }
    }
}
