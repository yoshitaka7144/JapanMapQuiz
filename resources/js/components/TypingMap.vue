<template>
  <div id="typing-map">
    <div class="typing-map-inner wrapper">
      <SettingComponent
        v-if="!canStartGame"
        :selected-menu-title-ja="selectedMenuTitleJa"
        :selected-menu-title-en="selectedMenuTitleEn"
        :selected-menu-text="selectedMenuText"
        :setting-params="settingParams"
      />
      <div class="count-down" v-else-if="startCountDownFlag">
        <p>3</p>
        <p>2</p>
        <p>1</p>
      </div>
      <div class="game" v-else-if="!isFinished">
        <div v-if="timeLimitChecked" class="progress">
          <div
            class="progress-bar"
            :style="{ width: progress + '%', backgroundColor: progressColor }"
          ></div>
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
        <div class="text-wrapper">
          <p class="hint" v-if="canShowHint">{{ displayHintText }}</p>
          <p class="quiz" v-if="canShowDetails">{{ displayQuizText }}</p>
          <p class="kana" v-if="canShowDetails">{{ displayKanaText }}</p>
          <div class="typing">
            <span class="inputed">{{ displayTypingInputedText }}</span>
            <span class="remaining" v-if="canShowDetails">{{
              displayTypingRemainingText
            }}</span>
          </div>
        </div>
      </div>
      <div class="result" v-else>
        <div class="table-wrapper">
          <div class="table">
            <tr>
              <th>正解タイプ数</th>
              <td>{{ correctTypeCount }}</td>
            </tr>
            <tr>
              <th>ミスタイプ数</th>
              <td>{{ missTypeCount }}</td>
            </tr>
            <tr>
              <th>ミス問題</th>
              <td>
                <span
                  v-for="item in missQuizData"
                  :key="item.id"
                  @click="showMissQuiz(item)"
                  >{{ item.correctName }}</span
                >
              </td>
            </tr>
          </div>
          <div class="btn-wrapper">
            <router-link :to="{ name: 'menu' }" class="btn btn-gray">
              メニュー画面へ
            </router-link>
            <button class="btn btn-gray" @click="reset()">設定画面へ</button>
          </div>
        </div>
      </div>
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
      />
    </div>
  </div>
</template>

<script>
import {
  INTERNAL_SERVER_ERROR,
  TYPING_MAP_MENU_TITLE_JAPANESE,
  TYPING_MAP_MENU_TITLE_ENGLISH,
  TYPING_MAP_EXPLANATION_TEXT,
  TYPING_MAP_TYPING_TEXT_END_CHAR,
  SETTING_CLASSIFICATION_ERROR_TEXT,
  FILL_MAP_MODAL_CONFIRM_MODE,
} from "../util";
import { checkInputKey } from "../key.js";
import SettingComponent from "./Setting.vue";
import AlertModalComponent from "./AlertModal.vue";
import InputModalComponent from "./InputNameModal.vue";
export default {
  components: {
    SettingComponent,
    AlertModalComponent,
    InputModalComponent,
  },
  data() {
    return {
      selectedMenuTitleJa: TYPING_MAP_MENU_TITLE_JAPANESE,
      selectedMenuTitleEn: TYPING_MAP_MENU_TITLE_ENGLISH,
      selectedMenuText: TYPING_MAP_EXPLANATION_TEXT,
      canStartGame: false,
      startCountDownFlag: true,
      isTyping: false,
      classificationCheckedValues: [],
      audioChecked: Boolean,
      timeLimitChecked: Boolean,
      timeLimitSelectedValue: Number,
      quizCountSelectedValue: Number,
      maps: [],
      quizData: [],
      quizCountLimit: 0,
      currentQuizIndex: 0,
      currentQuizData: Object,
      currentTypingText: [],
      currentTypingTextIndex: 0,
      correctTypeCount: 0,
      missTypeCount: 0,
      missTypeKeyHash: {},
      displayQuizText: String,
      displayKanaText: String,
      displayHintText: String,
      displayTypingRemainingText: String,
      displayTypingInputedText: String,
      isFinished: false,
      showAlertModal: false,
      alertMessage: String,
      canShowHint: false,
      canShowDetails: false,
      oneQuizMissCount: 0,
      typeTime: 0,
      // 残り時間
      remainingTime: 0,
      // プログレスバー進捗率
      progress: 100,
      // プログレスバーの色スタイル
      progressColor: String,
      // 繰り返し制御用
      intervalId: "",
      timeOutId: "",
      showInputModal: false,
      modalMode: FILL_MAP_MODAL_CONFIRM_MODE,
      imageId: Number,
      kana: String,
      roman: String,
      correctPlaceName: String,
      okFunction: Function,
      missQuizData: [],
      tmpId: 0,
    };
  },
  mounted() {
    // keydownイベントに処理を設定
    window.addEventListener("keydown", this.keyAction);
  },
  beforeDestroy() {
    // keydownイベントに設定した処理を削除
    window.removeEventListener("keydown", this.keyAction);
  },
  methods: {
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
    },
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
    async loadQuizMaps() {
      const params = {
        classificationId: this.classificationCheckedValues,
      };
      const response = await axios
        .get("/api/maps", { params })
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.maps = response.data;
      }
    },
    startQuiz() {
      Promise.all([this.loadQuizMaps()]).then(() => {
        // 出題問題データ作成
        this.createQuizData();

        // クイズ画面表示
        this.canStartGame = true;

        setTimeout(() => {
          this.startCountDownFlag = false;
          this.isTyping = true;
          // タイピング時間計測開始
          this.typeTime = performance.now();
          if (this.timeLimitChecked) {
            // 制限時間タイマースタート
            this.limitTimerStart();
          }
        }, 3000);
      });
    },
    createQuizData() {
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
        quiz.hintText = this.maps[i].hint_text;

        this.quizData.push(quiz);
      }

      // 表示初期化
      this.initQuizText();
    },
    // プログレスバー色作成
    createProgressBarColor(progressPercentage) {
      // 残り時間減少で緑、黄、赤色へと変化していく
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
    limitTimerStart() {
      this.remainingTime = this.timeLimitSelectedValue * 1000;
      this.intervalId = setInterval(this.remainingTimeCountDown, 10, 10);
    },
    // 残り時間を減らす
    remainingTimeCountDown(n) {
      // nミリ秒減らす
      this.remainingTime -= n;
    },
    showResult() {
      if (this.timeLimitChecked) {
        clearInterval(this.intervalId);
      }
      // タイピング時間測定終了
      this.typeTime = performance.now() - this.typeTime;

      this.isTyping = false;
      this.isFinished = true;
    },
    closeInputModal() {
      this.showInputModal = false;
    },
    showMissQuiz(item) {
      this.imageId = item.id;
      this.kana = item.kana;
      this.correctPlaceName = item.correctName;
      this.roman = item.roman;
      this.okFunction = this.closeInputModal;
      this.showInputModal = true;
    },
    initQuizText() {
      this.currentQuizData = this.quizData[this.currentQuizIndex];
      this.currentTypingText = this.currentQuizData.typingText.split("");
      this.currentTypingText.push(TYPING_MAP_TYPING_TEXT_END_CHAR);
      this.currentTypingTextIndex = 0;
      this.displayQuizText = this.currentQuizData.name;
      this.displayKanaText = this.currentQuizData.kana;
      this.displayHintText = this.currentQuizData.hint;
      this.displayTypingRemainingText = this.currentQuizData.typingText;
      this.displayTypingInputedText = "";
      this.oneQuizMissCount = 0;
      this.canShowHint = false;
      this.canShowDetails = false;
    },
    // キータイプ処理
    keyAction(e) {
      if (this.isTyping) {
        // キーの処理をキャンセル
        e.preventDefault();

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
              this.displayTypingRemainingText = "";
              this.displayTypingInputedText = "";
              // 表示文字列
              for (
                let i = this.currentTypingTextIndex;
                i < this.currentTypingText.length - 1;
                i++
              ) {
                this.displayTypingRemainingText += this.currentTypingText[i];
              }
              // 入力済み表示文字列
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
              //this.audio.play();
            }

            // ミス回数カウント
            this.missTypeCount++;
            this.oneQuizMissCount++;
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
  },
  watch: {
    remainingTime(val) {
      if (val < 0) {
        // 結果表示
        this.showResult();
      } else {
        // 残り時間割合
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