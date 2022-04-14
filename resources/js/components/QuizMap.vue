<template>
  <div id="quiz-map">
    <LoadingComponent v-if="isLoadingApi" />
    <div class="quiz-map-inner wrapper">
      <transition appear mode="out-in">
        <SettingComponent
          v-if="!canStartGame"
          :selected-menu-title-ja="selectedMenuTitleJa"
          :selected-menu-title-en="selectedMenuTitleEn"
          :setting-params="settingParams"
        />
        <div class="game" v-else-if="!isFinished" key="game">
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
          <div class="hint-wrapper">
            <p class="title">
              <fontawesome-icon
                class="icon"
                :icon="['far', 'fa-lightbulb']"
              />ヒント
            </p>
            <div class="btn-wrapper" v-if="!canShowHint">
              <button
                @click="
                  canShowHint = true;
                  hintTextType = typeFamous;
                "
                class="btn btn-green circle"
              >
                <fontawesome-icon
                  class="icon"
                  :icon="['fas', 'fa-location-dot']"
                />
              </button>
              <button
                @click="
                  canShowHint = true;
                  hintTextType = typeFood;
                "
                class="btn btn-orange circle"
              >
                <fontawesome-icon class="icon" :icon="['fas', 'fa-utensils']" />
              </button>
            </div>
            <p
              v-else
              class="hint-text"
              :class="{
                famous: hintTextType === typeFamous,
                food: hintTextType === typeFood,
              }"
            >
              {{ quizData[currentQuizIndex].hintText[hintTextType] }}
            </p>
          </div>
          <div class="choices">
            <div
              class="item"
              v-for="(choice, index) in quizData[currentQuizIndex].choices"
              :key="choice"
            >
              <input
                type="radio"
                :id="index"
                :value="choice"
                v-model="selectedChoiceValue"
              />
              <label
                :for="index"
                :class="[
                  quizData[currentQuizIndex].name === choice
                    ? 'correct'
                    : 'incorrect',
                  nextFlag ? 'judge' : '',
                ]"
                >{{ choice }}</label
              >
            </div>
          </div>
          <p class="judge-text" :class="{ correct: isCorrected }">
            {{ judgeText }}
          </p>
          <div class="btn-wrapper">
            <button
              class="btn"
              :class="{ 'btn-blue': !nextFlag, 'btn-green': nextFlag }"
              @click="judgeQuiz()"
            >
              <span v-if="nextFlag && lastFlag">結果へ</span>
              <span v-else-if="nextFlag && !lastFlag">次へ</span>
              <span v-else>解答する</span>
            </button>
          </div>
        </div>
        <div class="result" v-else key="result">
          <table class="table">
            <tr>
              <th>問題数</th>
              <td>
                {{ quizCountLimit }}
              </td>
            </tr>
            <tr>
              <th>正解数</th>
              <td>
                <span class="correct">{{ correctCount }}</span>
              </td>
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
        :initialPlaceName="initialPlaceName"
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
  QUIZ_MAP_MENU_TITLE_JAPANESE,
  QUIZ_MAP_MENU_TITLE_ENGLISH,
  QUIZ_MAP_CHOICE_DEFAULT_VALUE,
  QUIZ_MAP_NOT_CHOICE_TEXT,
  SETTING_CLASSIFICATION_ERROR_TEXT,
  CHOICE_TYPE_ALL,
  QUIZ_MAP_HOKKAIDOU_CHOICES,
  FILL_MAP_MODAL_CONFIRM_MODE,
  RESULT_EVALUATION_TEXT_EXCELLENT,
  RESULT_EVALUATION_TEXT_GREAT,
  RESULT_EVALUATION_TEXT_GOOD,
  RESULT_EVALUATION_TEXT_POOR,
  QUIZ_MAP_CORRECT_TEXT,
  QUIZ_MAP_INCORRECT_TEXT,
  QUIZ_MAP_HINT_TEXT_FAMOUS,
  QUIZ_MAP_HINT_TEXT_FOOD,
} from "../util";
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
      selectedMenuTitleJa: QUIZ_MAP_MENU_TITLE_JAPANESE,
      /**
       * 英語メニュータイトル
       */
      selectedMenuTitleEn: QUIZ_MAP_MENU_TITLE_ENGLISH,
      /**
       * ゲーム開始フラグ
       */
      canStartGame: false,
      /**
       * 設定問題対象地方区分id
       */
      classificationCheckedValues: [],
      /**
       * 設定音声有無
       */
      audioChecked: Boolean,
      /**
       * 設定問題数
       */
      quizCountSelectedValue: Number,
      /**
       * 設定選択肢タイプ
       */
      choiceType: String,
      /**
       * 地図データ
       */
      maps: [],
      /**
       * 選択肢データ
       */
      choices: {},
      /**
       * クイズデータ
       */
      quizData: [],
      /**
       * 正解数
       */
      correctCount: 0,
      /**
       * 不正解数
       */
      incorrectCount: 0,
      /**
       * 出題クイズ数
       */
      quizCountLimit: 0,
      /**
       * 現在のクイズインデックス
       */
      currentQuizIndex: 0,
      /**
       * 選択した選択肢
       */
      selectedChoiceValue: QUIZ_MAP_CHOICE_DEFAULT_VALUE,
      /**
       * 次の問題フラグ
       */
      nextFlag: false,
      /**
       * 最終問題フラグ
       */
      lastFlag: false,
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
       * 入力モーダル表示フラグ
       */
      showInputModal: false,
      /**
       * モーダルモード
       */
      modalMode: FILL_MAP_MODAL_CONFIRM_MODE,
      /**
       * 地図画像id
       */
      imageId: Number,
      /**
       * 選択地図名
       */
      initialPlaceName: String,
      /**
       * 正解地図名
       */
      correctPlaceName: String,
      /**
       * ok処理
       */
      okFunction: Function,
      /**
       * ミスクイズデータ
       */
      missQuizData: [],
      /**
       * 判定テキスト
       */
      judgeText: "",
      /**
       * 問題正解判定
       */
      isCorrected: false,
      /**
       * ヒントタイプ
       */
      hintTextType: String,
      /**
       * ヒントタイプ：名所
       */
      typeFamous: QUIZ_MAP_HINT_TEXT_FAMOUS,
      /**
       * ヒントタイプ：食べ物
       */
      typeFood: QUIZ_MAP_HINT_TEXT_FOOD,
      /**
       * クイズ正解音
       */
      correctAudio: new Audio("./audio/correct.mp3"),
      /**
       * クイズ不正解音
       */
      incorrectAudio: new Audio("./audio/incorrect.mp3"),
      /**
       * apiローディング状態
       */
      isLoadingApi: false,
    };
  },
  computed: {
    /**
     * 評価テキスト取得
     * @returns {String} 評価テキスト
     */
    evaluationText() {
      const total = this.quizCountLimit;
      const percentage = Math.floor((this.correctCount / total) * 100);
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
      this.canStartGame = false;
      this.maps = [];
      this.choices = {};
      this.quizData = [];
      this.correctCount = 0;
      this.incorrectCount = 0;
      this.quizCountLimit = 0;
      this.currentQuizIndex = 0;
      this.selectedChoiceValue = QUIZ_MAP_CHOICE_DEFAULT_VALUE;
      this.nextFlag = false;
      this.lastFlag = false;
      this.isFinished = false;
      this.showAlertModal = false;
      this.canShowHint = false;
      this.missQuizData = [];
      this.judgeText = "";
    },
    /**
     * 設定パラメータセット
     * @param {Object} params 設定パラメータオブジェクト
     */
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.audioChecked = params.audioChecked;
      this.quizCountSelectedValue = params.quizCountSelectedValue;
      this.choiceType = params.choiceType;

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
     * クイズ対象地図データ取得
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
     * クイズ選択肢データ取得
     */
    async loadQuizChoices() {
      const response = await axios
        .get("/api/maps/names")
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
        if (this.choiceType === CHOICE_TYPE_ALL) {
          // 選択肢タイプ：全都道府県
          this.choices = response.data;
        } else {
          // 選択肢タイプ：同地方区分
          response.data.forEach((item) => {
            const name = item.name;
            const classificationId = item.classification_id;
            if (classificationId === 1) {
              // 北海道のみ同地方区分の県がない為、固定の選択肢
              this.choices[classificationId] =
                QUIZ_MAP_HOKKAIDOU_CHOICES.split(",");
            } else {
              if (this.choices[classificationId]) {
                this.choices[classificationId].push(name);
              } else {
                this.choices[classificationId] = [name];
              }
            }
          });
        }
      }
    },
    /**
     * 配列内容をシャッフル
     * @param {Array} array シャッフル対象の配列
     */
    shuffle(array) {
      let n = array.length;
      let tmp;
      let i;

      while (n) {
        i = Math.floor(Math.random() * n--);
        tmp = array[n];
        array[n] = array[i];
        array[i] = tmp;
      }

      return array;
    },
    /**
     * クイズデータ作成
     */
    createQuizData() {
      // クイズ問題数
      this.quizCountLimit =
        this.maps.length <= this.quizCountSelectedValue
          ? this.maps.length
          : this.quizCountSelectedValue;

      for (let i = 0; i < this.quizCountLimit; i++) {
        let quiz = {
          id: Number,
          name: String,
          hintText: {},
          choices: [],
        };
        quiz.id = this.maps[i].id;
        quiz.name = this.maps[i].name;
        quiz.hintText[QUIZ_MAP_HINT_TEXT_FAMOUS] = this.maps[i].hint_famous;
        quiz.hintText[QUIZ_MAP_HINT_TEXT_FOOD] = this.maps[i].hint_food;

        let j = 1;
        let array = [];
        array.push(quiz.name);

        // 選択肢データ作成
        if (this.choiceType === CHOICE_TYPE_ALL) {
          // 選択肢タイプ：全都道府県の場合
          while (j !== 4) {
            const r = Math.floor(Math.random() * this.choices.length);
            const name = this.choices[r].name;
            if (name !== quiz.name && array.indexOf(name) === -1) {
              array.push(name);
              j++;
            }
          }
        } else {
          // 選択肢タイプ：同地方区分の場合
          const classificationId = this.maps[i].classification_id;
          while (j !== 4) {
            const r = Math.floor(
              Math.random() * this.choices[classificationId].length
            );
            const name = this.choices[classificationId][r];
            if (name !== quiz.name && array.indexOf(name) === -1) {
              array.push(name);
              j++;
            }
          }
        }

        quiz.choices = this.shuffle(array);
        this.quizData.push(quiz);
      }
    },
    /**
     * ゲーム開始
     */
    startQuiz() {
      // ローディング表示
      this.isLoadingApi = true;
      Promise.all([this.loadQuizMaps(), this.loadQuizChoices()]).then(() => {
        // 問題データ作成
        this.createQuizData();

        // クイズ画面表示
        this.canStartGame = true;

        // ローディング非表示
        this.isLoadingApi = false;
      });
    },
    /**
     * 結果表示
     */
    showResult() {
      this.isFinished = true;
    },
    /**
     * クイズ判定処理
     */
    judgeQuiz() {
      if (this.selectedChoiceValue === QUIZ_MAP_CHOICE_DEFAULT_VALUE) {
        // 未選択の場合
        // 警告モーダル表示
        this.alertMessage = QUIZ_MAP_NOT_CHOICE_TEXT;
        this.showAlertModal = true;
      } else if (this.nextFlag && this.lastFlag) {
        // 最終問題解答後の場合
        // 結果画面表示
        this.showResult();
      } else if (this.nextFlag && !this.lastFlag) {
        // 解答後、次の問題がある場合
        // 次の問題表示
        this.currentQuizIndex++;
        this.nextFlag = false;

        // ヒント非表示
        this.canShowHint = false;

        // 選択肢をデフォルト値に
        this.selectedChoiceValue = QUIZ_MAP_CHOICE_DEFAULT_VALUE;

        // 判定テキストを空に
        this.judgeText = "";
      } else {
        // 解答後の判定
        const correctValue = this.quizData[this.currentQuizIndex].name;
        if (this.selectedChoiceValue === correctValue) {
          // 正解処理
          this.correctCount++;
          this.judgeText = QUIZ_MAP_CORRECT_TEXT;
          this.isCorrected = true;
          if (this.audioChecked) {
            this.playSound(this.correctAudio);
          }
        } else {
          // 不正解処理
          this.incorrectCount++;
          this.judgeText = QUIZ_MAP_INCORRECT_TEXT;
          this.isCorrected = false;
          const missData = {
            id: this.quizData[this.currentQuizIndex].id,
            correctName: correctValue,
            selectedName: this.selectedChoiceValue,
          };
          this.missQuizData.push(missData);
          if (this.audioChecked) {
            this.playSound(this.incorrectAudio);
          }
        }

        // 次へボタン表示
        this.nextFlag = true;

        // 最終問題解答後の場合、結果へボタン表示
        if (this.currentQuizIndex + 1 === this.quizCountLimit) {
          this.lastFlag = true;
        }
      }
    },
    /**
     * 入力モーダルを閉じる
     */
    closeInputModal() {
      this.showInputModal = false;
    },
    /**
     * ミスクイズ情報表示
     * @param {Object} item ミスクイズデータオブジェクト
     */
    showMissQuiz(item) {
      // 各データセット
      this.imageId = item.id;
      this.initialPlaceName = item.selectedName;
      this.correctPlaceName = item.correctName;
      this.okFunction = this.closeInputModal;

      // モーダル表示
      this.showInputModal = true;
    },
    /**
     * 音声再生
     * @param {Audio} audio 音声データ
     */
    playSound(audio) {
      // 再生位置を先頭へ
      audio.currentTime = 0;

      // 音声再生
      audio.play();
    },
  },
};
</script>