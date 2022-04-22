# 都道府県クイズ
![top_pc](https://user-images.githubusercontent.com/18690548/164740941-f37f63e9-20b9-4b25-a019-0e26a725576a.png)

# 概要
* 都道府県クイズアプリケーションです。
* 地図埋め、地図クイズ、地図タイピングの3つのゲームが遊べます。
* PC、スマートフォンからの実行に対応しています。（地図タイピングのみキーボード入力必須です。）

# 公開URL
* https://mapquiz.mikanbako.jp

# 目的
* Vue.jsの勉強
* PC、スマホ対応のゲーム作成
* Laravelの勉強
* デザインの練習

# 使用言語
* JavaScript
* PHP
* HTML
* CSS
* MySQL

# フレームワーク
* Laravel@9.4.1
* Vue@2.6.12

# ライブラリ、プラグイン等
* vue-router@3.5.2
* vue-fontawesome@2.0.6

# 開発環境
* Windows10
* XAMPP
* Visual Studio Code
* git(SourceTree使用)

# 機能一覧
* ホーム画面
* メニュー画面
* 地図埋め
  * 設定画面
  * ゲーム画面
  * 結果画面
* 地図クイズ
  * 設定画面
  * ゲーム画面
  * 結果画面
* 地図タイピング
  * 設定画面
  * ゲーム画面
  * 結果画面
* Not Found画面
* System Error画面

# URL一覧
| URL                    | 内容               |
| :--------------------- | :----------------- |
| /                      | ホーム画面         |
| /menu                  | メニュー画面       |
| /fill                  | 地図埋め           |
| /quiz                  | 地図クイズ         |
| /typing                | 地図タイピング     |
| /system-error          | System Error画面   |
| 該当URL無し            | Not Found画面      |
| /api/maps              | 地図マスタ取得     |
| /api/maps/names        | 地図名一覧取得     |
| /api/classifications   | 地方区分マスタ取得 |
| /api/time_limit_values | 制限時間マスタ取得 |
| /api/quiz_count_values | 問題数マスタ取得   |

# テーブル定義書
<a
              href="https://docs.google.com/spreadsheets/d/1qRK8z6oY5cymp37oBqunSILltPq86BsIJAynrMcVS6Y/edit?usp=sharing"
              target="_blank" rel="noopener noreferrer">テーブル定義書（Googleスプレッドシート）</a>

# テスト
<a
              href="https://docs.google.com/spreadsheets/d/1_f9O1hEy-_z9cG_5BvSrkim2qVf7ld9cbZcCsbbD1CE/edit?usp=sharing"
              target="_blank" rel="noopener noreferrer">テスト（Googleスプレッドシート）</a>
* テスト環境
* PC
  * OS：Windows10
  * ブラウザ：Chrome 100.0.4896.127
* スマートフォン
  * OS：Android 11
  * ブラウザ：Chrome 100.0.4896.88

# 機能紹介
## ホーム画面
![top_pc](https://user-images.githubusercontent.com/18690548/164746507-b249146e-4f7d-4682-b2de-53d77e977965.png)

ホーム画像、ヘッダーが表示されます。画像をクリックするとメニュー画面が表示されます。
## メニュー画面
![menu_pc](https://user-images.githubusercontent.com/18690548/164746674-9965c30e-84b4-4d90-a24a-09f143a0ae71.png)

地図埋め、地図クイズ、地図タイピングの3つのメニューが表示されます。メニューをクリックすると各ゲームの設定画面が表示されます。

## 地図埋め
### 設定画面
![fill_setting_pc](https://user-images.githubusercontent.com/18690548/164747209-2349d538-9351-43ef-b060-59cf78d36c6a.png)

①出題対象地方  
解答する対象の地方を選択できます。1つ以上の選択が必須です。

②解答タイプ  
* 選択：都道府県名を選択肢から選択
* 記述：都道府県名を自分で入力

③スタートボタン  
ゲームを開始します。出題対象地方が1つ以上選択されていない場合、警告のモーダルウィンドウが表示されます。

④戻るボタン  
メニュー画面へ戻ります。

### ゲーム画面
![fill_game_pc](https://user-images.githubusercontent.com/18690548/164748666-e962fc4e-269a-412f-90b7-ad86de4f23ad.png)

①対象外数  
解答対象ではない都道府県の数。（上の画像では北海道と関東地方が対象外です。）

②未入力数  
解答対象の都道府県の未入力数。

③入力済み数  
解答対象の都道府県の既に解答を入力 or 選択している数。

④拡大縮小スライダー  
スライダー操作で地図の拡大縮小ができます。プラスボタンとマイナスボタンで一定間隔で拡大縮小できます。

⑤地図上での操作  
* 都道府県をクリックすると入力用のモーダルウィンドウが表示されます。
* 任意の方向へドラッグすると地図が移動します。
* マウスホイールを上下すると地図が拡大縮小します。
* （スマートフォン）ピンチアウト、ピンチイン操作で地図が拡大縮小します。

⑥都道府県名入力  
地図をクリックすると県名入力用のモーダルウィンドウが表示されます。設定画面の解答タイプで設定した方法で県名を入力し、OKボタンをクリックすることで解答が確定します。
![fill_game_input](https://user-images.githubusercontent.com/18690548/164749505-4e3872d1-9509-4969-80e4-5f41711b2cd5.gif)

⑦解答終了ボタン  
結果画面が表示されます。未入力があると終了確認のモーダルウィンドウが表示されます。

⑧操作方法ボタン  
操作方法を説明するモーダルウィンドウが表示されます。

### 結果画面
![fill_result_pc](https://user-images.githubusercontent.com/18690548/164749730-00ec2c09-4bc1-4d39-8bdd-1f839afab43b.png)

①正解数  
正解の解答の数。

②不正解数  
不正解の解答の数。

③評価  
正答率に応じて評価のテキストが表示されます。

④地図  
解答の正解 or 不正解毎に色分けされて表示されます。対象の都道府県をクリックすると自分の解答や正解等の詳細が確認できます。
![fill_result_confirm](https://user-images.githubusercontent.com/18690548/164750038-c649585d-f6a9-4b41-ba69-48032073536a.gif)

⑤メニューへボタン  
メニュー画面へ戻ります。

⑥設定画面へボタン  
設定画面へ戻ります。

## 地図クイズ
### 設定画面
![quiz_setting_pc](https://user-images.githubusercontent.com/18690548/164750568-723492b5-4bec-4a66-bd48-174037214233.png)

①出題対象地方  
クイズが出題される対象の地方を選択できます。1つ以上の選択が必須です。

②選択肢タイプ  
選択肢の内容を選択します。
* 全都道府県：全都道府県からランダムに選択肢を作成
* 同地方区分：正解と同じ地方区分からランダムに選択肢を作成

③音声有無  
クイズ正解 or 不正解時の効果音の有無を設定できます。

④問題数  
出題されるクイズの数を設定できます。

⑤スタートボタン  
ゲームを開始します。出題対象地方が1つ以上選択されていない場合、警告のモーダルウィンドウが表示されます。

⑥戻るボタン  
メニュー画面へ戻ります。

### ゲーム画面
![quiz_game_pc](https://user-images.githubusercontent.com/18690548/164751280-bc40596b-8a8e-4aaa-902f-bf868683f6bb.png)

①地図  
クイズ対象の地図が表示されます。

②ヒント  
ボタンをクリックするとヒントが表示されます。
* 緑色ボタン：土地や名所に関するヒント表示
* 橙色ボタン：食べ物に関するヒント表示

③選択肢  
設定画面で選ばれた選択肢タイプの選択肢が表示されます。クリックすると選択状態になります。

④解答するボタン、次へボタン、結果へボタン  
解答するボタンをクリックすると判定が行われ、正解 or 不正解のテキストが表示されます。次の問題がある場合は次へボタンが表示され、最終問題の場合は結果へボタンが表示されます。選択肢が選択されていない場合は警告のモーダルウィンドウが表示されます。
![quiz_game_demo](https://user-images.githubusercontent.com/18690548/164752414-01eb397a-7ab8-415d-8f1a-adc0f389e939.gif)

### 結果画面
![quiz_result_pc](https://user-images.githubusercontent.com/18690548/164752877-0dbca62e-cfbd-4e6b-8d97-f87b6bf3c1cb.png)

①問題数  
出題された問題数が表示されます。

②正解数  
クイズに正解した数が表示されます。

③ミス問題  
クイズが不正解だった問題が表示されます。クリックするとモーダルウィンドウが表示され、自分の解答と正解が確認できます。

④評価  
正答率に応じて評価のテキストが表示されます。

⑤メニューへボタン  
メニュー画面へ戻ります。

⑥設定画面へボタン  
設定画面へ戻ります。

## 地図タイピング
### 設定画面
![typing_setting_pc](https://user-images.githubusercontent.com/18690548/164753581-7e5333cf-09ad-4195-b725-f0f7f1db94f7.png)

①出題対象地方  
問題が出題される対象の地方を選択できます。1つ以上の選択が必須です。

②音声有無  
タイプミス時の効果音のON/OFFを設定できます。

③問題数  
出題される問題数を設定できます。

④時間制限（秒）  
タイピングの時間制限のON/OFFを設定できます。ONにするとセレクトボックスが表示され秒数を選択できます。

⑤スタートボタン  
ゲームを開始します。出題対象地方が1つ以上選択されていない場合、警告のモーダルウィンドウが表示されます。

⑥戻るボタン  
メニュー画面へ戻ります。

### ゲーム画面
![typing_game_pc](https://user-images.githubusercontent.com/18690548/164754182-7191131b-3d02-4118-8378-ee0d1b1de4a4.png)

①地図  
問題の地図が表示されます。

②タイプ数  
正しくタイピングできた数が表示されます。

③ミス数  
間違ったタイピングをした数が表示されます。

④残り時間  
設定画面で時間制限をONにした場合に表示されます。残り時間の割合に応じて色が緑、黄、赤へと変化していきます。残り時間がなくなると結果画面が表示されます。

⑤ヒント  
1回タイプミスすると表示されます。土地や名所に関するヒント or 食べ物に関するヒントがランダムに表示されます。

⑥テキスト表示エリア  
2回タイプミスすると全てのテキストが表示されます。
* タイピングテキスト：入力済みテキストはオレンジ色で表示されます。
* かなテキスト：問題のかな表記の県名が表示されます。
* 県名テキスト：問題の漢字の県名が表示されます。

![typing_game_demo](https://user-images.githubusercontent.com/18690548/164754834-cabb6b7c-3a40-40b4-aae8-8eefd73657bb.gif)

※タイピング判定処理  
キー入力判定アルゴリズムは<a
              href="https://crieit.net/posts/dc0eb0f0a74f6e15e362e1f384d28f0d#%E6%9F%94%E8%BB%9F%E3%81%AA%E5%85%A5%E5%8A%9B%E6%96%B9%E6%B3%95%E3%81%AB%E5%AF%BE%E5%BF%9C%E3%81%99%E3%82%8B%E3%82%A2%E3%83%AB%E3%82%B4%E3%83%AA%E3%82%BA%E3%83%A0"
              target="_blank" rel="noopener noreferrer">柔軟な入力方法に対応したタイピングゲームの作り方</a>で紹介されているものを参考、改変させていただきました。

### 結果画面
![typing_result_pc](https://user-images.githubusercontent.com/18690548/164755073-662307e3-75a0-4595-9535-7687a6b1cabe.png)

①クリア数/問題数  
タイピングが完了した問題数と出題された問題数が表示されます。

②正解タイプ数  
正しくタイピングできた数が表示されます。

③ミスタイプ数  
間違ったタイピングをした数が表示されます。

④WPM  
1分間当たりの正しくタイピングできた数が表示されます。

⑤ミスキーTOP3  
ミスした回数が多い順に3つ表示されます。

⑥ミス問題  
タイプミスした問題が表示されます。クリックするとモーダルウィンドウが表示され、解答を確認できます。
![typing_result_confirm](https://user-images.githubusercontent.com/18690548/164755467-42d79363-c0e5-45d4-bcd0-b2884e516a30.gif)

⑦評価  
クリア数、ミスタイプ数に応じて評価のテキストが表示されます。

⑧メニューへボタン  
メニュー画面へ戻ります。

⑨設定画面へボタン  
設定画面へ戻ります。

## Not Found画面
![not_found_pc](https://user-images.githubusercontent.com/18690548/164755886-7e6630c0-75a0-4fa6-9707-8346134710c9.png)

該当するURLが存在しない場合に表示される画面です。

①トップ画面へボタン  
ホーム画面へ遷移します。

②メニュー画面へボタン  
メニュー画面へ遷移します。

## System Error画面
![system_error_pc](https://user-images.githubusercontent.com/18690548/164755920-9dfcbfea-e8c9-4af5-abd1-86c3949adb6a.png)

システムエラーが発生している場合に表示される画面です。主にApi関連の処理のエラーを想定しています。

①エラー内容  
エラーメッセージが表示されます。

②対象ファイル名  
エラーレスポンスにファイル名のメッセージがあれば表示されます。

③トップ画面へボタン  
ホーム画面へ遷移します。

④メニュー画面へボタン  
メニュー画面へ遷移します。

# リンク
* <a class="link-box" href="https://crieit.net/posts/dc0eb0f0a74f6e15e362e1f384d28f0d" target="_blank" rel="noopener noreferrer">柔軟な入力方法に対応したタイピングゲームの作り方</a>：キー入力判定アルゴリズムを参考、改変させていただきました。
* <a href="https://github.com/yoshitaka7144" target="_blank" rel="noopener noreferrer">Githubアカウント</a>
* <a href="https://portfolio.mikanbako.jp" target="_blank" rel="noopener noreferrer">ポートフォリオ</a>