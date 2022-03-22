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
* 設定：区分チェックエラーテキスト
*/
export const SETTING_CLASSIFICATION_ERROR_TEXT = "地方区分を最低1つ選択してください。";