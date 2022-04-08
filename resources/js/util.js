/**
 * apiステータス：成功
 */
export const OK = 200;
/**
 * apiステータス：データ作成
 */
export const CREATED = 201;
/**
 * apiステータス：UNPROCESSABLE
 */
export const UNPROCESSABLE_ENTITY = 422;
/**
 * apiステータス：システムエラー
 */
export const INTERNAL_SERVER_ERROR = 500;

/**
 * 設定画面：制限時間チェックボックス：初期選択値
 */
export const DEFAULT_TIME_LIMIT_CHECKED = false;
/**
 * 設定画面：制限時間セレクトボックス：初期選択値
 */
export const DEFAULT_TIME_LIMIT_VALUE = 60;
/**
 * 設定画面：問題数セレクトボックス：初期選択値
 */
export const DEFAULT_QUIZ_COUNT_VALUE = 10;
/**
 * 設定画面：音声チェックボックス：初期選択値
 */
export const DEFAULT_AUDIO_CHECKED = false;
/**
 * 設定画面：解答方法ラジオボタン：選択
 */
export const ANSWER_METHOD_SELECT = "select";
/**
 * 設定画面：解答方法ラジオボタン：記述
 */
export const ANSWER_METHOD_WRITE = "write";
/**
 * 設定画面：解答方法ラジオボタン：初期選択値
 */
export const DEFAULT_ANSWER_METHOD = ANSWER_METHOD_SELECT;
/**
 * 設定画面：選択肢タイプ：全都道府県
 */
export const CHOICE_TYPE_ALL = "all";
/**
 * 設定画面：選択肢タイプ：同地方区分
 */
export const CHOICE_TYPE_CLASSIFICATION = "classification";
/**
 * 設定画面：選択肢タイプ：初期選択値
 */
export const DEFAULT_CHOICE_TYPE = CHOICE_TYPE_ALL;
/**
* 設定画面：区分チェックエラーテキスト
*/
export const SETTING_CLASSIFICATION_ERROR_TEXT = "出題対象地方を1つ以上選択してください。";

/**
 * 地図埋め：日本語タイトル
 */
export const FILL_MAP_MENU_TITLE_JAPANESE = "地図埋め";
/**
 * 地図埋め：英語タイトル
 */
export const FILL_MAP_MENU_TITLE_ENGLISH = "Fill";
/**
 * 地図埋め：説明テキスト
 */
export const FILL_MAP_EXPLANATION_TEXT = "地図埋めの説明";
/**
 * 地図埋め：解答終了確認テキスト
 */
export const FILL_MAP_ANSWER_CONFIRMATION_TEXT = "終了してよろしいですか？";
/**
* 地図埋め：モーダルモード：入力
*/
export const FILL_MAP_MODAL_INPUT_MODE = "input";
/**
* 地図埋め：モーダルモード：確認
*/
export const FILL_MAP_MODAL_CONFIRM_MODE = "confirm";
/**
* 地図埋め：入力モーダル：選択肢デフォルト値
*/
export const FILL_MAP_INPUT_MODAL_SELECT_DEFAULT_VALUE = "未選択";
/**
* 地図埋め：入力モーダル：プレースホルダテキスト
*/
export const FILL_MAP_INPUT_MODAL_PLACEHOLDER_TEXT = "都道府県名を入力";
/**
* 地図埋め：viewBox初期値
*/
export const FILL_MAP_VIEW_BOX_DEFAULT = "0 0 550 550";
/**
* 地図埋め：viewBox:最大幅（最大高さ）
*/
export const FILL_MAP_VIEW_BOX_MAX_WIDTH = 550;
/**
* 地図埋め：viewBox:最小幅（最小高さ）
*/
export const FILL_MAP_VIEW_BOX_MIN_WIDTH = 100;
/**
* 地図埋め：viewBox:最大x座標
*/
export const FILL_MAP_VIEW_BOX_MAX_X = 500;
/**
* 地図埋め：viewBox:最小x座標
*/
export const FILL_MAP_VIEW_BOX_MIN_X = -400;
/**
* 地図埋め：viewBox:最大y座標
*/
export const FILL_MAP_VIEW_BOX_MAX_Y = 480;
/**
* 地図埋め：viewBox:最小y座標
*/
export const FILL_MAP_VIEW_BOX_MIN_Y = -100;

/**
 * 地図クイズ：日本語タイトル
 */
export const QUIZ_MAP_MENU_TITLE_JAPANESE = "地図クイズ";
/**
 * 地図クイズ：英語タイトル
 */
export const QUIZ_MAP_MENU_TITLE_ENGLISH = "Quiz";
/**
 * 地図クイズ：説明テキスト
 */
export const QUIZ_MAP_EXPLANATION_TEXT = "地図クイズの説明";
/**
 * 地図クイズ：選択肢初期値
 */
export const QUIZ_MAP_CHOICE_DEFAULT_VALUE = "#";
/**
* 地図クイズ：選択肢未選択時テキスト
*/
export const QUIZ_MAP_NOT_CHOICE_TEXT = "選択肢を選択してください。";
/**
* 地図クイズ：選択肢が同地方区分の場合の北海道の選択肢データ
*/
export const QUIZ_MAP_HOKKAIDOU_CHOICES = "北海道,岩手,熊本,神奈川";
/**
* 地図クイズ：正解時表示テキスト
*/
export const QUIZ_MAP_CORRECT_TEXT = "正解!!";
/**
* 地図クイズ：不正解時表示テキスト
*/
export const QUIZ_MAP_INCORRECT_TEXT = "不正解";
/**
* 地図クイズ：ヒント：名所
*/
export const QUIZ_MAP_HINT_TEXT_FAMOUS = "famous";
/**
* 地図クイズ：ヒント：食べ物
*/
export const QUIZ_MAP_HINT_TEXT_FOOD = "food";

/**
* 地図タイピング：日本語タイトル
*/
export const TYPING_MAP_MENU_TITLE_JAPANESE = "地図タイピング";
/**
 * 地図タイピング：英語タイトル
 */
export const TYPING_MAP_MENU_TITLE_ENGLISH = "Typing";
/**
 * 地図タイピング：説明テキスト
 */
export const TYPING_MAP_EXPLANATION_TEXT = "地図タイピングの説明";
/**
 * 地図タイピング：タイピングテキスト終了文字
 */
export const TYPING_MAP_TYPING_TEXT_END_CHAR = "$";

/**
 * 結果画面：結果評価テキスト:大変良い
 */
export const RESULT_EVALUATION_TEXT_EXCELLENT = "全問正解,おめでとう!!";
/**
* 結果画面：結果評価テキスト:良い
*/
export const RESULT_EVALUATION_TEXT_GREAT = "たいへん,よくできました!";
/**
* 結果画面：結果評価テキスト:普通
*/
export const RESULT_EVALUATION_TEXT_GOOD = "もうすこし,がんばろう!";
/**
* 結果画面：結果評価テキスト:悪い
*/
export const RESULT_EVALUATION_TEXT_POOR = "少しずつ,覚えよう!";
