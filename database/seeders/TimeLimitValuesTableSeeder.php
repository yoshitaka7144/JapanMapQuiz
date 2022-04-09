<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeLimitValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("time_limit_values")->truncate();

        $values = [
            [
                "value" => 30,
            ],
            [
                "value" => 60,
            ],
            [
                "value" => 120,
            ],
            [
                "value" => 180,
            ],
            [
                "value" => 240,
            ],
            [
                "value" => 300,
            ],
            [
                "value" => 600,
            ],
            [
                "value" => 900,
            ],
        ];

        // 登録
        foreach ($values as $value) {
            \App\Models\TimeLimitValue::create($value);
        }
    }
}
