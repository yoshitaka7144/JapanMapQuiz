<template>
  <div id="quiz-map">
    <div class="quiz-map-inner wrapper">
      <SettingComponent
        v-if="!canStartGame"
        :selected-menu-title-ja="selectedMenuTitleJa"
        :selected-menu-title-en="selectedMenuTitleEn"
        :selected-menu-text="selectedMenuText"
        :setting-params="settingParams"
      />
      <div class="game" v-else-if="!isFinished">
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
          <div class="btn-wrapper" v-if="!canShowHint">
            <button @click="canShowHint = true" class="btn btn-orange">
              <fontawesome-icon class="icon" :icon="['far', 'fa-lightbulb']" />
              ヒント
            </button>
          </div>
          <p v-else class="hint-text">
            {{ quizData[currentQuizIndex].hintText }}
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
      <div class="result" v-else>
        <div class="table-wrapper">
          <table class="table">
            <tr>
              <th><span class="correct">正解</span> / 問題数</th>
              <td>
                <span class="correct">{{ correctCount }}</span> /
                {{ quizCountLimit }}
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
          <div class="evaluation-circle-wrapper">
            <div class="circle">
              <div class="circle-inner">
                <p class="evaluation-text">
                  {{ evaluationText.split(",")[0] }}<br />{{
                    evaluationText.split(",")[1]
                  }}
                </p>
              </div>
            </div>
          </div>
        </div>
        <div class="btn-wrapper">
          <router-link :to="{ name: 'menu' }" class="btn btn-gray">
            メニューへ
          </router-link>
          <button class="btn btn-gray" @click="reset()">設定画面へ</button>
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
        :initialPlaceName="initialPlaceName"
        :correctPlaceName="correctPlaceName"
        :mode="modalMode"
        :ok="okFunction"
        @close="showInputModal = false"
      />
    </div>
  </div>
</template>

<script>
import {
  INTERNAL_SERVER_ERROR,
  QUIZ_MAP_MENU_TITLE_JAPANESE,
  QUIZ_MAP_MENU_TITLE_ENGLISH,
  QUIZ_MAP_EXPLANATION_TEXT,
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
} from "../util";
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
      selectedMenuTitleJa: QUIZ_MAP_MENU_TITLE_JAPANESE,
      selectedMenuTitleEn: QUIZ_MAP_MENU_TITLE_ENGLISH,
      selectedMenuText: QUIZ_MAP_EXPLANATION_TEXT,
      canStartGame: false,
      classificationCheckedValues: [],
      audioChecked: Boolean,
      timeLimitChecked: Boolean,
      timeLimitSelectedValue: Number,
      quizCountSelectedValue: Number,
      choiceType: String,
      maps: [],
      choices: {},
      quizData: [],
      correctCount: 0,
      incorrectCount: 0,
      quizCountLimit: 0,
      currentQuizIndex: 0,
      selectedChoiceValue: QUIZ_MAP_CHOICE_DEFAULT_VALUE,
      nextFlag: false,
      lastFlag: false,
      isFinished: false,
      showAlertModal: false,
      alertMessage: String,
      canShowHint: false,
      showInputModal: false,
      modalMode: FILL_MAP_MODAL_CONFIRM_MODE,
      imageId: Number,
      initialPlaceName: String,
      correctPlaceName: String,
      okFunction: Function,
      missQuizData: [],
      judgeText: "",
      isCorrected: false,
    };
  },
  computed: {
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
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.audioChecked = params.audioChecked;
      this.timeLimitChecked = params.timeLimitChecked;
      this.timeLimitSelectedValue = params.timeLimitSelectedValue;
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
    async loadQuizChoices() {
      const response = await axios
        .get("/api/maps/names")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        if (this.choiceType === CHOICE_TYPE_ALL) {
          this.choices = response.data;
        } else {
          response.data.forEach((item) => {
            const name = item.name;
            const classificationId = item.classification_id;
            if (classificationId === 1) {
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
    createQuizData() {
      this.quizCountLimit =
        this.maps.length <= this.quizCountSelectedValue
          ? this.maps.length
          : this.quizCountSelectedValue;

      for (let i = 0; i < this.quizCountLimit; i++) {
        let quiz = {
          id: Number,
          name: String,
          hintText: String,
          choices: [],
        };
        quiz.id = this.maps[i].id;
        quiz.name = this.maps[i].name;
        quiz.hintText = this.maps[i].hint_text;

        let j = 1;
        let array = [];
        array.push(quiz.name);

        if (this.choiceType === CHOICE_TYPE_ALL) {
          while (j !== 4) {
            const r = Math.floor(Math.random() * this.choices.length);
            const name = this.choices[r].name;
            if (name !== quiz.name && array.indexOf(name) === -1) {
              array.push(name);
              j++;
            }
          }
        } else {
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
    startQuiz() {
      Promise.all([this.loadQuizMaps(), this.loadQuizChoices()]).then(() => {
        // 問題、選択肢データ作成
        this.createQuizData();

        // クイズ画面表示
        this.canStartGame = true;
      });
    },
    showResult() {
      this.isFinished = true;
    },
    judgeQuiz() {
      if (this.selectedChoiceValue === QUIZ_MAP_CHOICE_DEFAULT_VALUE) {
        this.alertMessage = QUIZ_MAP_NOT_CHOICE_TEXT;
        this.showAlertModal = true;
      } else if (this.nextFlag && this.lastFlag) {
        // 結果画面表示
        this.showResult();
      } else if (this.nextFlag && !this.lastFlag) {
        // 次の問題表示
        this.currentQuizIndex++;
        this.nextFlag = false;
        this.canShowHint = false;

        // 選択肢をデフォルト値に
        this.selectedChoiceValue = QUIZ_MAP_CHOICE_DEFAULT_VALUE;
        this.judgeText = "";
      } else {
        // 正解判定
        const correctValue = this.quizData[this.currentQuizIndex].name;
        if (this.selectedChoiceValue === correctValue) {
          // 正解
          this.correctCount++;
          this.judgeText = QUIZ_MAP_CORRECT_TEXT;
          this.isCorrected = true;
        } else {
          // 不正解
          this.incorrectCount++;
          this.judgeText = QUIZ_MAP_INCORRECT_TEXT;
          this.isCorrected = false;
          const missData = {
            id: this.quizData[this.currentQuizIndex].id,
            correctName: correctValue,
            selectedName: this.selectedChoiceValue,
          };
          this.missQuizData.push(missData);
        }

        // 次へボタン表示
        this.nextFlag = true;
        if (this.currentQuizIndex + 1 === this.quizCountLimit) {
          // 結果へボタン表示
          this.lastFlag = true;
        }
      }
    },
    closeInputModal() {
      this.showInputModal = false;
    },
    showMissQuiz(item) {
      this.imageId = item.id;
      this.initialPlaceName = item.selectedName;
      this.correctPlaceName = item.correctName;
      this.okFunction = this.closeInputModal;
      this.showInputModal = true;
    },
  },
};
</script>