<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // テーブルのクリア
        DB::table("maps")->truncate();

        $maps = [
            [
                "classification_id" => "1",
                "name" => "北海道",
                "kana" => "ほっかいどう",
                "typing_text" => "hokkaidou",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "青森",
                "kana" => "あおもり",
                "typing_text" => "aomori",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "岩手",
                "kana" => "いわて",
                "typing_text" => "iwate",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "秋田",
                "kana" => "あきた",
                "typing_text" => "akita",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "宮城",
                "kana" => "みやぎ",
                "typing_text" => "miyagi",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "山形",
                "kana" => "やまがた",
                "typing_text" => "yamagata",
                "hint_text" => "",
            ],
            [
                "classification_id" => "2",
                "name" => "福島",
                "kana" => "ふくしま",
                "typing_text" => "hukusima",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "茨城",
                "kana" => "いばらき",
                "typing_text" => "ibaraki",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "栃木",
                "kana" => "とちぎ",
                "typing_text" => "totigi",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "群馬",
                "kana" => "ぐんま",
                "typing_text" => "gunma",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "埼玉",
                "kana" => "さいたま",
                "typing_text" => "saitama",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "千葉",
                "kana" => "ちば",
                "typing_text" => "tiba",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "東京",
                "kana" => "とうきょう",
                "typing_text" => "toukyou",
                "hint_text" => "",
            ],
            [
                "classification_id" => "3",
                "name" => "神奈川",
                "kana" => "かながわ",
                "typing_text" => "kanagawa",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "山梨",
                "kana" => "やまなし",
                "typing_text" => "yamanasi",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "長野",
                "kana" => "ながの",
                "typing_text" => "nagano",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "新潟",
                "kana" => "にいがた",
                "typing_text" => "niigata",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "富山",
                "kana" => "とやま",
                "typing_text" => "toyama",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "石川",
                "kana" => "いしかわ",
                "typing_text" => "isikawa",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "福井",
                "kana" => "ふくい",
                "typing_text" => "hukui",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "静岡",
                "kana" => "しずおか",
                "typing_text" => "sizuoka",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "愛知",
                "kana" => "あいち",
                "typing_text" => "aiti",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "岐阜",
                "kana" => "ぎふ",
                "typing_text" => "gihu",
                "hint_text" => "",
            ],
            [
                "classification_id" => "4",
                "name" => "三重",
                "kana" => "みえ",
                "typing_text" => "mie",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "滋賀",
                "kana" => "しが",
                "typing_text" => "siga",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "京都",
                "kana" => "きょうと",
                "typing_text" => "kyouto",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "大阪",
                "kana" => "おおさか",
                "typing_text" => "oosaka",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "兵庫",
                "kana" => "ひょうご",
                "typing_text" => "hyougo",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "奈良",
                "kana" => "なら",
                "typing_text" => "nara",
                "hint_text" => "",
            ],
            [
                "classification_id" => "5",
                "name" => "和歌山",
                "kana" => "わかやま",
                "typing_text" => "wakayama",
                "hint_text" => "",
            ],
            [
                "classification_id" => "6",
                "name" => "鳥取",
                "kana" => "とっとり",
                "typing_text" => "tottori",
                "hint_text" => "",
            ],
            [
                "classification_id" => "6",
                "name" => "島根",
                "kana" => "しまね",
                "typing_text" => "simane",
                "hint_text" => "",
            ],
            [
                "classification_id" => "6",
                "name" => "岡山",
                "kana" => "おかやま",
                "typing_text" => "okayama",
                "hint_text" => "",
            ],
            [
                "classification_id" => "6",
                "name" => "広島",
                "kana" => "ひろしま",
                "typing_text" => "hirosima",
                "hint_text" => "",
            ],
            [
                "classification_id" => "6",
                "name" => "山口",
                "kana" => "やまぐち",
                "typing_text" => "yamaguti",
                "hint_text" => "",
            ],
            [
                "classification_id" => "7",
                "name" => "香川",
                "kana" => "かがわ",
                "typing_text" => "kagawa",
                "hint_text" => "",
            ],
            [
                "classification_id" => "7",
                "name" => "愛媛",
                "kana" => "えひめ",
                "typing_text" => "ehime",
                "hint_text" => "",
            ],
            [
                "classification_id" => "7",
                "name" => "徳島",
                "kana" => "とくしま",
                "typing_text" => "tokusima",
                "hint_text" => "",
            ],
            [
                "classification_id" => "7",
                "name" => "高知",
                "kana" => "こうち",
                "typing_text" => "kouti",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "福岡",
                "kana" => "ふくおか",
                "typing_text" => "hukuoka",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "佐賀",
                "kana" => "さが",
                "typing_text" => "saga",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "長崎",
                "kana" => "ながさき",
                "typing_text" => "nagasaki",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "熊本",
                "kana" => "くまもと",
                "typing_text" => "kumamoto",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "大分",
                "kana" => "おおいた",
                "typing_text" => "ooita",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "宮崎",
                "kana" => "みやざき",
                "typing_text" => "miyazaki",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "鹿児島",
                "kana" => "かごしま",
                "typing_text" => "kagosima",
                "hint_text" => "",
            ],
            [
                "classification_id" => "8",
                "name" => "沖縄",
                "kana" => "おきなわ",
                "typing_text" => "okinawa",
                "hint_text" => "",
            ],
        ];

        // 登録
        foreach ($maps as $map) {
            \App\Models\Map::create($map);
        }
    }
}
