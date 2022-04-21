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
                "hint_famous" => "全都道府県の中で一番面積が大きい。",
                "hint_food" => "味噌ラーメン、ジンギスカン。",
            ],
            [
                "classification_id" => "2",
                "name" => "青森",
                "kana" => "あおもり",
                "typing_text" => "aomori",
                "hint_famous" => "ねぶた祭、弘前城、八甲田山。",
                "hint_food" => "りんごの収穫量が全国一位。",
            ],
            [
                "classification_id" => "2",
                "name" => "岩手",
                "kana" => "いわて",
                "typing_text" => "iwate",
                "hint_famous" => "全都道府県の中で二番目に面積が大きい。",
                "hint_food" => "わんこそば、じゃじゃ麺、冷麺。",
            ],
            [
                "classification_id" => "2",
                "name" => "秋田",
                "kana" => "あきた",
                "typing_text" => "akita",
                "hint_famous" => "なまはげ、乳頭温泉郷。",
                "hint_food" => "きりたんぽ、稲庭うどん。",
            ],
            [
                "classification_id" => "2",
                "name" => "宮城",
                "kana" => "みやぎ",
                "typing_text" => "miyagi",
                "hint_famous" => "松島、田代島。",
                "hint_food" => "牛タン、笹かまぼこ、ずんだ。",
            ],
            [
                "classification_id" => "2",
                "name" => "山形",
                "kana" => "やまがた",
                "typing_text" => "yamagata",
                "hint_famous" => "さくらんぼの収穫量が全国一位。",
                "hint_food" => "さくらんぼ、ぶどう、米沢牛。",
            ],
            [
                "classification_id" => "2",
                "name" => "福島",
                "kana" => "ふくしま",
                "typing_text" => "hukusima",
                "hint_famous" => "全都道府県の中で三番目に面積が大きい。",
                "hint_food" => "喜多方ラーメン、イカにんじん。",
            ],
            [
                "classification_id" => "3",
                "name" => "茨城",
                "kana" => "いばらき",
                "typing_text" => "ibaraki",
                "hint_famous" => "都道府県魅力度ランキング最下位。",
                "hint_food" => "あんこう鍋、水戸納豆。",
            ],
            [
                "classification_id" => "3",
                "name" => "栃木",
                "kana" => "とちぎ",
                "typing_text" => "totigi",
                "hint_famous" => "いちごの生産量全国一位。",
                "hint_food" => "宇都宮餃子、佐野ラーメン、とちおとめ。",
            ],
            [
                "classification_id" => "3",
                "name" => "群馬",
                "kana" => "ぐんま",
                "typing_text" => "gunma",
                "hint_famous" => "草津温泉、高崎だるま。",
                "hint_food" => "水沢うどん、ソースカツ丼。",
            ],
            [
                "classification_id" => "3",
                "name" => "埼玉",
                "kana" => "さいたま",
                "typing_text" => "saitama",
                "hint_famous" => "アイスクリーム出荷額全国一位。",
                "hint_food" => "ガリガリ君、冷汁うどん。",
            ],
            [
                "classification_id" => "3",
                "name" => "千葉",
                "kana" => "ちば",
                "typing_text" => "tiba",
                "hint_famous" => "ディズニーランド、鴨川シーワールド。",
                "hint_food" => "なめろう、落花生。",
            ],
            [
                "classification_id" => "3",
                "name" => "東京",
                "kana" => "とうきょう",
                "typing_text" => "toukyou",
                "hint_famous" => "全都道府県の中で一番人口が多い。",
                "hint_food" => "江戸前寿司、月島もんじゃ、深川めし。",
            ],
            [
                "classification_id" => "3",
                "name" => "神奈川",
                "kana" => "かながわ",
                "typing_text" => "kanagawa",
                "hint_famous" => "全都道府県の中で二番目に人口が多い。",
                "hint_food" => "よこすか海軍カレー、崎陽軒のシウマイ、しらす丼。",
            ],
            [
                "classification_id" => "4",
                "name" => "山梨",
                "kana" => "やまなし",
                "typing_text" => "yamanasi",
                "hint_famous" => "日本ワイン生産量全国一位。",
                "hint_food" => "ほうとう、桔梗信玄餅。",
            ],
            [
                "classification_id" => "4",
                "name" => "長野",
                "kana" => "ながの",
                "typing_text" => "nagano",
                "hint_famous" => "林業産出額が全国一位。",
                "hint_food" => "信州そば、おやき、野沢菜。",
            ],
            [
                "classification_id" => "4",
                "name" => "新潟",
                "kana" => "にいがた",
                "typing_text" => "niigata",
                "hint_famous" => "米の収穫量が全国一位。",
                "hint_food" => "へぎそば、笹団子。",
            ],
            [
                "classification_id" => "4",
                "name" => "富山",
                "kana" => "とやま",
                "typing_text" => "toyama",
                "hint_famous" => "黒部ダム、砺波チューリップ公園。",
                "hint_food" => "ます寿司、たら汁。",
            ],
            [
                "classification_id" => "4",
                "name" => "石川",
                "kana" => "いしかわ",
                "typing_text" => "isikawa",
                "hint_famous" => "兼六園、千里浜なぎさドライブウェイ。",
                "hint_food" => "金沢カレー、ハントンライス、能登丼。",
            ],
            [
                "classification_id" => "4",
                "name" => "福井",
                "kana" => "ふくい",
                "typing_text" => "hukui",
                "hint_famous" => "東尋坊、恐竜博物館、芝政ワールド。",
                "hint_food" => "越前おろしそば、越前ガニ、若狭牛。",
            ],
            [
                "classification_id" => "4",
                "name" => "静岡",
                "kana" => "しずおか",
                "typing_text" => "sizuoka",
                "hint_famous" => "富士サファリパーク、浜名湖、熱海温泉。",
                "hint_food" => "さわやかハンバーグ、富士宮やきそば、みしまコロッケ。",
            ],
            [
                "classification_id" => "4",
                "name" => "愛知",
                "kana" => "あいち",
                "typing_text" => "aiti",
                "hint_famous" => "名古屋城、大須観音、東山動植物園。",
                "hint_food" => "味噌煮込みうどん、手羽先、きしめん。",
            ],
            [
                "classification_id" => "4",
                "name" => "岐阜",
                "kana" => "ぎふ",
                "typing_text" => "gihu",
                "hint_famous" => "下呂温泉、花フェスタ記念公園、養老の滝。",
                "hint_food" => "飛騨牛、高山ラーメン、五平餅。",
            ],
            [
                "classification_id" => "4",
                "name" => "三重",
                "kana" => "みえ",
                "typing_text" => "mie",
                "hint_famous" => "鈴鹿サーキット、伊勢神宮、なばなの里。",
                "hint_food" => "伊勢えび、松阪牛、赤福。",
            ],
            [
                "classification_id" => "5",
                "name" => "滋賀",
                "kana" => "しが",
                "typing_text" => "siga",
                "hint_famous" => "琵琶湖、延暦寺、伊吹山。",
                "hint_food" => "近江牛、鴨鍋、伊吹そば。",
            ],
            [
                "classification_id" => "5",
                "name" => "京都",
                "kana" => "きょうと",
                "typing_text" => "kyouto",
                "hint_famous" => "清水寺、金閣寺、伏見稲荷大社。",
                "hint_food" => "八ツ橋、湯豆腐、サバ寿司。",
            ],
            [
                "classification_id" => "5",
                "name" => "大阪",
                "kana" => "おおさか",
                "typing_text" => "oosaka",
                "hint_famous" => "全都道府県の中で二番目に面積が小さい。",
                "hint_food" => "いか焼き、きんつば、たこ焼き。",
            ],
            [
                "classification_id" => "5",
                "name" => "兵庫",
                "kana" => "ひょうご",
                "typing_text" => "hyougo",
                "hint_famous" => "姫路城、六甲山、生田神社。",
                "hint_food" => "明石焼き、神戸牛、姫路おでん。",
            ],
            [
                "classification_id" => "5",
                "name" => "奈良",
                "kana" => "なら",
                "typing_text" => "nara",
                "hint_famous" => "法隆寺、吉野山、十津川温泉。",
                "hint_food" => "飛鳥鍋、天理ラーメン、柿の葉寿司。",
            ],
            [
                "classification_id" => "5",
                "name" => "和歌山",
                "kana" => "わかやま",
                "typing_text" => "wakayama",
                "hint_famous" => "アドベンチャーワールド、金剛峯寺。",
                "hint_food" => "みかんの収穫量が全国一位。",
            ],
            [
                "classification_id" => "6",
                "name" => "鳥取",
                "kana" => "とっとり",
                "typing_text" => "tottori",
                "hint_famous" => "全都道府県の中で一番人口が少ない。",
                "hint_food" => "とうふちくわ、モサエビ。",
            ],
            [
                "classification_id" => "6",
                "name" => "島根",
                "kana" => "しまね",
                "typing_text" => "simane",
                "hint_famous" => "出雲大社、玉造温泉、壇鏡の滝。",
                "hint_food" => "出雲そば、ぼてぼて茶、うずめ飯。",
            ],
            [
                "classification_id" => "6",
                "name" => "岡山",
                "kana" => "おかやま",
                "typing_text" => "okayama",
                "hint_famous" => "ＲＳＫバラ園、鷲羽山、池田動物園。",
                "hint_food" => "どどめせ、津山ホルモンうどん、デミカツ丼。",
            ],
            [
                "classification_id" => "6",
                "name" => "広島",
                "kana" => "ひろしま",
                "typing_text" => "hirosima",
                "hint_famous" => "嚴島神社、原爆ドーム、みろくの里。",
                "hint_food" => "尾道ラーメン、あなごめし、牡蠣。",
            ],
            [
                "classification_id" => "6",
                "name" => "山口",
                "kana" => "やまぐち",
                "typing_text" => "yamaguti",
                "hint_famous" => "秋吉台、錦帯橋、角島大橋。",
                "hint_food" => "ふぐ、ばりそば、みかん鍋。",
            ],
            [
                "classification_id" => "7",
                "name" => "香川",
                "kana" => "かがわ",
                "typing_text" => "kagawa",
                "hint_famous" => "全都道府県の中で一番面積が小さい。",
                "hint_food" => "讃岐うどん、たこ飯、伊吹いりこ。",
            ],
            [
                "classification_id" => "7",
                "name" => "愛媛",
                "kana" => "えひめ",
                "typing_text" => "ehime",
                "hint_famous" => "道後温泉、松山城、佐田岬。",
                "hint_food" => "ふかの湯ざらし、いもたき、宇和島鯛めし。",
            ],
            [
                "classification_id" => "7",
                "name" => "徳島",
                "kana" => "とくしま",
                "typing_text" => "tokusima",
                "hint_famous" => "鳴門海峡、阿波おどり、眉山。",
                "hint_food" => "すだち、たらいうどん、でこまわし。",
            ],
            [
                "classification_id" => "7",
                "name" => "高知",
                "kana" => "こうち",
                "typing_text" => "kouti",
                "hint_famous" => "桂浜、龍河洞、坂本龍馬像。",
                "hint_food" => "カツオのたたき、鍋焼きラーメン、土佐ジロー。",
            ],
            [
                "classification_id" => "8",
                "name" => "福岡",
                "kana" => "ふくおか",
                "typing_text" => "hukuoka",
                "hint_famous" => "能古島、海の中道海浜公園。",
                "hint_food" => "もつ鍋、水炊き、あまおう。",
            ],
            [
                "classification_id" => "8",
                "name" => "佐賀",
                "kana" => "さが",
                "typing_text" => "saga",
                "hint_famous" => "嬉野温泉、武雄温泉、呼子大橋。",
                "hint_food" => "呼子イカ、ごどうふ、伊万里牛。",
            ],
            [
                "classification_id" => "8",
                "name" => "長崎",
                "kana" => "ながさき",
                "typing_text" => "nagasaki",
                "hint_famous" => "ハウステンボス、軍艦島、九十九島。",
                "hint_food" => "佐世保バーガー、五島うどん、トルコライス。",
            ],
            [
                "classification_id" => "8",
                "name" => "熊本",
                "kana" => "くまもと",
                "typing_text" => "kumamoto",
                "hint_famous" => "白川水源、グリーンランド、黒川温泉。",
                "hint_food" => "からしれんこん、いきなり団子、だご汁。",
            ],
            [
                "classification_id" => "8",
                "name" => "大分",
                "kana" => "おおいた",
                "typing_text" => "ooita",
                "hint_famous" => "別府温泉、由布院温泉、血の池地獄。",
                "hint_food" => "とり天、豊後牛、琉球丼。",
            ],
            [
                "classification_id" => "8",
                "name" => "宮崎",
                "kana" => "みやざき",
                "typing_text" => "miyazaki",
                "hint_famous" => "鵜戸神宮、高千穂神社、日南海岸。",
                "hint_food" => "チキン南蛮、肉巻きおにぎり、日向夏。",
            ],
            [
                "classification_id" => "8",
                "name" => "鹿児島",
                "kana" => "かごしま",
                "typing_text" => "kagosima",
                "hint_famous" => "豚の飼育数が全国一位。",
                "hint_food" => "かんぱち漬け丼、しろくま、黒豚。",
            ],
            [
                "classification_id" => "8",
                "name" => "沖縄",
                "kana" => "おきなわ",
                "typing_text" => "okinawa",
                "hint_famous" => "西表島、ひめゆりの塔、与那国島。",
                "hint_food" => "タコライス、ゴーヤーチャンプルー、ラフテー。",
            ],
        ];

        // 登録
        foreach ($maps as $map) {
            \App\Models\Map::create($map);
        }
    }
}
