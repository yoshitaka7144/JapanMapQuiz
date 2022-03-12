<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("users")->truncate();

        $users = [
            [
                "name" => "admin",
                "password" => Hash::make("aaaa"),
                "role" => 2
            ],
            [
                "name" => "test",
                "password" => Hash::make("bbbb"),
            ],
        ];

        // 登録
        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
