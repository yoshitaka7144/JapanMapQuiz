<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClassificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("classifications")->truncate();

        $classifications = [
            [
                "name" => "北海道",
            ],
            [
                "name" => "東北　",
            ],
            [
                "name" => "関東　",
            ],
            [
                "name" => "中部　",
            ],
            [
                "name" => "近畿　",
            ],
            [
                "name" => "中国　",
            ],
            [
                "name" => "四国　",
            ],
            [
                "name" => "九州　",
            ],
        ];

        // 登録
        foreach ($classifications as $classification) {
            \App\Models\Classification::create($classification);
        }
    }
}
