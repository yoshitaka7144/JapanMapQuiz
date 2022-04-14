<template>
  <div id="typing-map">
    <LoadingComponent v-if="isLoadingApi" />
    <div class="typing-map-inner wrapper">
      <transition appear mode="out-in">
        <SettingComponent
          v-if="!canStartGame"
          :selected-menu-title-ja="selectedMenuTitleJa"
          :selected-menu-title-en="selectedMenuTitleEn"
          :setting-params="settingParams"
        />
        <div class="count-down" v-else-if="startCountDownFlag">
          <p>3</p>
          <p>2</p>
          <p>1</p>
        </div>
        <div class="game" v-else-if="!isFinished" key="game">
          <div class="info-table-wrapper">
            <table class="table">
              <tr>
                <th>タイプ数</th>
              </tr>
              <tr>
                <td class="correct">{{ correctTypeCount }}</td>
              </tr>
              <tr>
                <th>ミス数</th>
              </tr>
              <tr>
                <td class="miss">{{ missTypeCount }}</td>
              </tr>
            </table>
          </div>
          <div class="img-wrapper">
            <svg class="svg-default">
              <use
                :xlink:href="
                  './image/map/' +
                  quizData[currentQuizIndex].id +
                  '.svg#' +
                  quizData[currentQuizIndex].id
                "
              ></use>
            </svg>
          </div>
          <div v-if="timeLimitChecked" class="progress-wrapper">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-clock']" />
            <div class="progress">
              <div
                class="progress-bar"
                :style="{
                  width: progress + '%',
                  backgroundColor: progressColor,
                }"
              ></div>
            </div>
          </div>
          <div class="hint-wrapper">
            <p class="hint" :class="{ hidden: !canShowHint }">
              <fontawesome-icon class="icon" :icon="['far', 'fa-lightbulb']" />
              {{ displayHintText }}
            </p>
          </div>
          <div class="text-wrapper">
            <p class="pre-text" v-if="!typeKey">{{ preText }}</p>
            <div class="typing">
              <span class="inputed">{{ displayTypingInputedText }}</span>
              <span class="remaining" :class="{ hidden: !canShowDetails }">{{
                displayTypingRemainingText
              }}</span>
            </div>
            <p class="kana" :class="{ hidden: !canShowDetails }">
              {{ displayKanaText }}
            </p>
            <p class="quiz" :class="{ hidden: !canShowDetails }">
              {{ displayQuizText }}
            </p>
          </div>
        </div>
        <div class="result" v-else key="result">
          <table class="table">
            <tr>
              <th>クリア数 / 問題数</th>
              <td>{{ currentQuizIndex }} / {{ quizCountLimit }}</td>
            </tr>
            <tr>
              <th>正解タイプ数</th>
              <td class="correct">{{ correctTypeCount }}</td>
            </tr>
            <tr>
              <th>ミスタイプ数</th>
              <td class="miss">{{ missTypeCount }}</td>
            </tr>
            <tr>
              <th>WPM</th>
              <td>{{ wpm }}</td>
            </tr>
            <tr>
              <th>ミス問題</th>
              <td>
                <div class="incorrect-item-wrapper">
                  <span
                    v-for="item in missQuizData"
                    :key="item.id"
                    @click="showMissQuiz(item)"
                    >{{ item.correctName }}</span
                  >
                </div>
              </td>
            </tr>
          </table>
          <div class="evaluation-wrapper">
            <div class="circle">
              <div class="circle-inner">
                <p class="evaluation-text">
                  {{ evaluationText.split(",")[0] }}<br />{{
                    evaluationText.split(",")[1]
                  }}
                </p>
              </div>
            </div>
            <div class="btn-wrapper">
              <router-link :to="{ name: 'menu' }" class="btn btn-gray">
                メニューへ
              </router-link>
              <button class="btn btn-gray" @click="reset()">設定画面へ</button>
            </div>
          </div>
        </div>
      </transition>
      <AlertModalComponent
        v-if="showAlertModal"
        :alertMessage="alertMessage"
        @close="showAlertModal = false"
      />
      <InputModalComponent
        v-if="showInputModal"
        :imageId="imageId"
        :kana="kana"
        :roman="roman"
        :correctPlaceName="correctPlaceName"
        :mode="modalMode"
        :ok="okFunction"
        @close="showInputModal = false"
      />
    </div>
  </div>
</template>
<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.3s;
}

.v-enter,
.v-leave-to {
  opacity: 0;
}
</style>
<script>
import {
  INTERNAL_SERVER_ERROR,
  TYPING_MAP_MENU_TITLE_JAPANESE,
  TYPING_MAP_MENU_TITLE_ENGLISH,
  TYPING_MAP_TYPING_TEXT_END_CHAR,
  SETTING_CLASSIFICATION_ERROR_TEXT,
  FILL_MAP_MODAL_CONFIRM_MODE,
  RESULT_EVALUATION_TEXT_EXCELLENT,
  RESULT_EVALUATION_TEXT_GREAT,
  RESULT_EVALUATION_TEXT_GOOD,
  RESULT_EVALUATION_TEXT_POOR,
  TYPING_MAP_TYPING_PRE_TEXT,
} from "../util";
import { checkInputKey } from "../key.js";
import LoadingComponent from "./Loading.vue";
import SettingComponent from "./Setting.vue";
import AlertModalComponent from "./AlertModal.vue";
import InputModalComponent from "./InputNameModal.vue";
export default {
  components: {
    LoadingComponent,
    SettingComponent,
    AlertModalComponent,
    InputModalComponent,
  },
  data() {
    return {
      /**
       * 日本語メニュータイトル
       */
      selectedMenuTitleJa: TYPING_MAP_MENU_TITLE_JAPANESE,
      /**
       * 英語メニュータイトル
       */
      selectedMenuTitleEn: TYPING_MAP_MENU_TITLE_ENGLISH,
      /**
       * ゲーム開始フラグ
       */
      canStartGame: false,
      /**
       * カウントダウン表示フラグ
       */
      startCountDownFlag: true,
      /**
       * タイピング判定フラグ
       */
      isTyping: false,
      /**
       * 設定問題対象地方区分id
       */
      classificationCheckedValues: [],
      /**
       * 設定音声有無
       */
      audioChecked: Boolean,
      /**
       * 設定制限時間有無
       */
      timeLimitChecked: Boolean,
      /**
       * 設定制限時間値
       */
      timeLimitSelectedValue: Number,
      /**
       * 設定問題数
       */
      quizCountSelectedValue: Number,
      /**
       * 地図データ
       */
      maps: [],
      /**
       * 問題データ
       */
      quizData: [],
      /**
       * 問題数
       */
      quizCountLimit: 0,
      /**
       * 現在の問題インデックス
       */
      currentQuizIndex: 0,
      /**
       * 現在のクイズデータ
       */
      currentQuizData: Object,
      /**
       * 現在のタイピング文字配列
       */
      currentTypingText: [],
      /**
       * 現在のタイピング文字配列インデックス
       */
      currentTypingTextIndex: 0,
      /**
       * 正解タイプ数
       */
      correctTypeCount: 0,
      /**
       * ミスタイプ数
       */
      missTypeCount: 0,
      /**
       * ミスキーオブジェクト
       */
      missTypeKeyHash: {},
      /**
       * 表示用地図名テキスト
       */
      displayQuizText: String,
      /**
       * 表示用かなテキスト
       */
      displayKanaText: String,
      /**
       * 表示用ヒントテキスト
       */
      displayHintText: String,
      /**
       * 表示用未入力タイピングテキスト
       */
      displayTypingRemainingText: String,
      /**
       * 表示用入力済みタイピングテキスト
       */
      displayTypingInputedText: String,
      /**
       * ゲーム終了フラグ
       */
      isFinished: false,
      /**
       * 警告モーダル表示フラグ
       */
      showAlertModal: false,
      /**
       * 警告メッセージ
       */
      alertMessage: String,
      /**
       * ヒント表示フラグ
       */
      canShowHint: false,
      /**
       * 詳細表示フラグ
       */
      canShowDetails: false,
      /**
       * 1問題当たりのミスカウント
       */
      oneQuizMissCount: 0,
      /**
       * タイピングの経過時間
       */
      typeTime: 0,
      /**
       * 残り時間
       */
      remainingTime: 0,
      /**
       * プログレスバー進捗率
       */
      progress: 100,
      /**
       * プログレスバーの色スタイル
       */
      progressColor: String,
      /**
       * 繰り返し制御用
       */
      intervalId: "",
      /**
       * 入力モーダル表示フラグ
       */
      showInputModal: false,
      /**
       * モーダルモード
       */
      modalMode: FILL_MAP_MODAL_CONFIRM_MODE,
      /**
       * 確認モーダル用地図画像id
       */
      imageId: Number,
      /**
       * 確認モーダル用かな
       */
      kana: String,
      /**
       * 確認モーダル用ローマ字
       */
      roman: String,
      /**
       * 確認モーダル用正解地図名
       */
      correctPlaceName: String,
      /**
       * 確認モーダル用ok処理
       */
      okFunction: Function,
      /**
       * ミス問題データリスト
       */
      missQuizData: [],
      /**
       * ミス問題追加判定用id
       */
      tmpId: 0,
      /**
       * wpm
       */
      wpm: Number,
      /**
       * タイピング準備表示テキスト
       */
      preText: TYPING_MAP_TYPING_PRE_TEXT,
      /**
       * 1度でもタイプしたか判定
       */
      typeKey: false,
      /**
       * タイプミス音データ
       */
      missAudio: new Audio("./audio/miss.mp3"),
      /**
       * apiローディング状態
       */
      isLoadingApi: false,
    };
  },
  mounted() {
    // keydownイベントにキー判定処理を設定
    window.addEventListener("keydown", this.judgeKey);
  },
  beforeDestroy() {
    // keydownイベントに設定した処理を削除
    window.removeEventListener("keydown", this.judgeKey);
  },
  computed: {
    /**
     * 評価テキストを返す
     * @returns {String} 評価テキスト
     */
    evaluationText() {
      const total = this.quizCountLimit;
      const finishedQuizCount = this.currentQuizIndex;
      const missQuizCount = this.missQuizData.length;
      const correctQuizCount = finishedQuizCount - missQuizCount;
      const missTypeCount = this.missTypeCount;
      const percentage =
        Math.floor((correctQuizCount / total) * 100) - missTypeCount;
      if (percentage === 100) {
        return RESULT_EVALUATION_TEXT_EXCELLENT;
      } else if (percentage >= 70) {
        return RESULT_EVALUATION_TEXT_GREAT;
      } else if (percentage >= 40) {
        return RESULT_EVALUATION_TEXT_GOOD;
      } else {
        return RESULT_EVALUATION_TEXT_POOR;
      }
    },
  },
  methods: {
    /**
     * リセット処理
     */
    reset() {
      this.quizData = [];
      this.canStartGame = false;
      this.startCountDownFlag = true;
      this.isTyping = false;
      this.quizCountLimit = 0;
      this.currentQuizIndex = 0;
      this.correctTypeCount = 0;
      this.missTypeCount = 0;
      this.missTypeKeyHash = {};
      this.isFinished = false;
      this.showAlertModal = false;
      this.canShowHint = false;
      this.canShowDetails = false;
      this.tmpId = 0;
      this.missQuizData = [];
      this.typeKey = false;
    },
    /**
     * 設定パラメータセット
     * @param {Object} params 設定パラメータオブジェクト
     */
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.audioChecked = params.audioChecked;
      this.timeLimitChecked = params.timeLimitChecked;
      this.timeLimitSelectedValue = params.timeLimitSelectedValue;
      this.quizCountSelectedValue = params.quizCountSelectedValue;

      // 地方区分エラーチェック
      if (this.classificationCheckedValues.length === 0) {
        this.alertMessage = SETTING_CLASSIFICATION_ERROR_TEXT;
        this.showAlertModal = true;
        return;
      }

      // 問題開始
      this.startQuiz();
    },
    /**
     * 問題地図データ取得
     */
    async loadQuizMaps() {
      const params = {
        classificationId: this.classificationCheckedValues,
      };
      const response = await axios
        .get("/api/maps", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({
          name: "system-error",
          params: {
            file: response.data.file,
            message: response.data.message,
          },
        });
      } else {
        this.maps = response.data;
      }
    },
    /**
     * ゲーム開始
     */
    startQuiz() {
      // ローディング表示
      this.isLoadingApi = true;

      Promise.all([this.loadQuizMaps()]).then(() => {
        // 出題問題データ作成
        this.createQuizData();

        // クイズ画面表示
        this.canStartGame = true;

        // ローディング非表示
        this.isLoadingApi = false;

        // 3秒後（カウントダウンの為）に実行
        setTimeout(() => {
          // カウントダウン画面非表示
          this.startCountDownFlag = false;

          // タイピング判定
          this.isTyping = true;

          // タイピング時間計測開始
          this.typeTime = performance.now();

          // 制限時間有りの場合、制限時間タイマースタート
          if (this.timeLimitChecked) {
            this.limitTimerStart();
          }
        }, 3000);
      });
    },
    /**
     * 問題データ作成
     */
    createQuizData() {
      // 問題数
      this.quizCountLimit =
        this.maps.length <= this.quizCountSelectedValue
          ? this.maps.length
          : this.quizCountSelectedValue;

      for (let i = 0; i < this.quizCountLimit; i++) {
        let quiz = {
          id: Number,
          name: String,
          kana: String,
          typingText: String,
          hintText: String,
        };

        quiz.id = this.maps[i].id;
        quiz.name = this.maps[i].name;
        quiz.kana = this.maps[i].kana;
        quiz.typingText = this.maps[i].typing_text;

        // ヒントテキストを2パターンランダムに設定
        if (Math.floor(Math.random() * 10) % 2 === 0) {
          quiz.hintText = this.maps[i].hint_famous;
        } else {
          quiz.hintText = this.maps[i].hint_food;
        }

        this.quizData.push(quiz);
      }

      // 表示初期化
      this.initQuizText();
    },
    /**
     * プログレスバー色作成
     * @param {Number} progressPercentage 進捗パーセンテージ
     */
    createProgressBarColor(progressPercentage) {
      // 緑、黄、赤色へと変化
      const rInitVal = 0;
      const gInitVal = 230;
      const bInitVal = 100;
      const r =
        (100 - progressPercentage) * 5 > 255
          ? 255
          : (100 - progressPercentage) * 5;
      const g =
        progressPercentage < 50
          ? gInitVal - (50 - progressPercentage) * 4
          : gInitVal;
      const b = bInitVal - (100 - progressPercentage);
      this.progressColor = "rgb(" + r + ", " + g + ", " + b + ")";
    },
    /**
     * 制限時間タイマースタート
     */
    limitTimerStart() {
      // 秒をミリ秒へ
      this.remainingTime = this.timeLimitSelectedValue * 1000;

      // 10ミリ秒ごとに10ミリ秒減らす
      this.intervalId = setInterval(this.remainingTimeCountDown, 10, 10);
    },
    /**
     * 残り時間を減らす
     * @param {Number} n 減らすミリ秒
     */
    remainingTimeCountDown(n) {
      this.remainingTime -= n;
    },
    /**
     * 結果表示
     */
    showResult() {
      // 制限時間有りの場合、繰り返し処理停止
      if (this.timeLimitChecked) {
        clearInterval(this.intervalId);
      }

      // タイピング時間測定終了
      this.typeTime = performance.now() - this.typeTime;

      // wpm算出
      this.wpm = Math.floor(
        (this.correctTypeCount / this.typeTime) * 1000 * 60
      );

      // タイピング判定終了
      this.isTyping = false;

      // ゲーム終了、結果表示
      this.isFinished = true;
    },
    /**
     * モーダルを閉じる
     */
    closeInputModal() {
      this.showInputModal = false;
    },
    /**
     * ミス問題表示
     * @param {Object} item ミス問題オブジェクト
     */
    showMissQuiz(item) {
      // 各データをセット
      this.imageId = item.id;
      this.kana = item.kana;
      this.correctPlaceName = item.correctName;
      this.roman = item.roman;
      this.okFunction = this.closeInputModal;

      // 確認モーダルを表示
      this.showInputModal = true;
    },
    /**
     * 問題初期表示処理
     */
    initQuizText() {
      // 現在の問題データ
      this.currentQuizData = this.quizData[this.currentQuizIndex];
      this.currentTypingText = this.currentQuizData.typingText.split("");
      this.currentTypingText.push(TYPING_MAP_TYPING_TEXT_END_CHAR);
      this.currentTypingTextIndex = 0;

      // 表示テキスト更新
      this.displayQuizText = this.currentQuizData.name;
      this.displayKanaText = this.currentQuizData.kana;
      this.displayHintText = this.currentQuizData.hintText;
      this.displayTypingRemainingText = this.currentQuizData.typingText;
      this.displayTypingInputedText = "";

      // 1問題当たりの設定初期化
      this.oneQuizMissCount = 0;
      this.canShowHint = false;
      this.canShowDetails = false;
      this.typeKey = false;
    },
    /**
     * キータイプ判定処理
     * @param {Event} e キーダウンイベント
     */
    judgeKey(e) {
      // タイピング判定が有りの時のみ
      if (this.isTyping) {
        // キーのデフォルト処理をキャンセル
        e.preventDefault();

        // タイプ判定
        this.typeKey = true;

        switch (
          checkInputKey(
            e.code,
            this.currentTypingText,
            this.currentTypingTextIndex
          )
        ) {
          case 1:
          case 2:
            // 正解のタイプ時

            // タイプ数カウント
            this.correctTypeCount++;

            // 次のタイピング文字へ進める
            this.currentTypingTextIndex++;
            if (
              this.currentTypingText[this.currentTypingTextIndex] ===
              TYPING_MAP_TYPING_TEXT_END_CHAR
            ) {
              // 設定された最終文字に達したとき
              this.currentQuizIndex++;
              if (this.currentQuizIndex === this.quizCountLimit) {
                // 結果表示
                this.showResult();
              } else {
                // 次の問題を表示
                this.initQuizText();
              }
            } else {
              // 未入力表示文字列更新
              this.displayTypingRemainingText = "";
              for (
                let i = this.currentTypingTextIndex;
                i < this.currentTypingText.length - 1;
                i++
              ) {
                this.displayTypingRemainingText += this.currentTypingText[i];
              }

              // 入力済み表示文字列更新
              this.displayTypingInputedText = "";
              for (let i = 0; i < this.currentTypingTextIndex; i++) {
                this.displayTypingInputedText += this.currentTypingText[i];
              }
            }
            break;
          case 0:
          case 3:
            //タイプミス時
            // ミス音声再生
            if (this.audioChecked) {
              this.playSound(this.missAudio);
            }

            // ミスタイプ回数カウント
            this.missTypeCount++;

            // 1問題当たりのミスカウント
            this.oneQuizMissCount++;

            // 1問題当たりミス回数に応じて、ヒント表示 or 詳細表示
            if (this.oneQuizMissCount === 1) {
              this.canShowHint = true;
            } else if (this.oneQuizMissCount === 2) {
              this.canShowDetails = true;
            }

            // ミスタイプキーカウント
            const missTypeKey =
              this.currentTypingText[this.currentTypingTextIndex];
            if (this.missTypeKeyHash[missTypeKey]) {
              this.missTypeKeyHash[missTypeKey]++;
            } else {
              this.missTypeKeyHash[missTypeKey] = 1;
            }

            // ミス問題保持
            if (this.tmpId !== this.quizData[this.currentQuizIndex].id) {
              const missData = {
                id: this.quizData[this.currentQuizIndex].id,
                correctName: this.quizData[this.currentQuizIndex].name,
                kana: this.quizData[this.currentQuizIndex].kana,
                roman: this.quizData[this.currentQuizIndex].typingText,
              };
              this.missQuizData.push(missData);
              this.tmpId = this.quizData[this.currentQuizIndex].id;
            }

            break;
          default:
            break;
        }
      }
    },
    /**
     * 音声再生
     * @param {Audio} audio 音声データ
     */
    playSound(audio) {
      // 再生位置を先頭に
      audio.currentTime = 0;

      // 音声再生
      audio.play();
    },
  },
  watch: {
    // 残り時間
    remainingTime(val) {
      if (val <= 0) {
        // 0秒以下の場合、結果表示
        this.showResult();
      } else {
        // 残り時間割合算出
        this.progress =
          Math.floor(
            (this.remainingTime / (this.timeLimitSelectedValue * 1000)) *
              100 *
              10
          ) / 10;

        // プログレスバー色作成
        this.createProgressBarColor(this.progress);
      }
    },
  },
};
</script>