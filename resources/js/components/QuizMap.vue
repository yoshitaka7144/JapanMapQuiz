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
      <div class="game" v-else-if="!resultFlag">
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
        <div class="hint">
          <button
            v-if="!canShowHint"
            @click="canShowHint = true"
            class="btn btn-gray"
          >
            ヒント表示
          </button>
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
        <button class="btn btn-gray" @click="judgeQuiz()">
          <span v-if="nextFlag && lastFlag">結果へ</span>
          <span v-else-if="nextFlag && !lastFlag">次へ</span>
          <span v-else>解答する</span>
        </button>
      </div>
      <div class="result" v-else>
        <div class="table-wrapper">
          <div class="table">
            <tr>
              <th>問題数</th>
              <td>{{ quizCountLimit }}</td>
            </tr>
            <tr>
              <th>正解数</th>
              <td>{{ correctCount }}</td>
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
} from "../util";
import SettingComponent from "./Setting.vue";
import AlertModalComponent from "./AlertModal.vue";
export default {
  components: {
    SettingComponent,
    AlertModalComponent,
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
      maps: [],
      choices: [],
      quizData: [],
      correctCount: 0,
      incorrectCount: 0,
      quizCountLimit: 0,
      currentQuizIndex: 0,
      selectedChoiceValue: QUIZ_MAP_CHOICE_DEFAULT_VALUE,
      nextFlag: false,
      lastFlag: false,
      resultFlag: false,
      showAlertModal: false,
      alertMessage: String,
      canShowHint: false,
    };
  },
  methods: {
    reset() {
      this.canStartGame = false;
      this.maps = [];
      this.choices = [];
      this.quizData = [];
      this.correctCount = 0;
      this.incorrectCount = 0;
      this.quizCountLimit = 0;
      this.currentQuizIndex = 0;
      this.selectedChoiceValue = QUIZ_MAP_CHOICE_DEFAULT_VALUE;
      this.nextFlag = false;
      this.lastFlag = false;
      this.resultFlag = false;
      this.showAlertModal = false;
      this.canShowHint = false;
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
    async loadQuizChoices() {
      const response = await axios
        .get("/api/maps/names")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.choices = response.data;
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
        while (j !== 4) {
          const r = Math.floor(Math.random() * this.choices.length);
          const name = this.choices[r].name;
          if (name !== quiz.name && array.indexOf(name) === -1) {
            array.push(name);
            j++;
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
    judgeQuiz() {
      if (this.selectedChoiceValue === QUIZ_MAP_CHOICE_DEFAULT_VALUE) {
        this.alertMessage = QUIZ_MAP_NOT_CHOICE_TEXT;
        this.showAlertModal = true;
      } else if (this.nextFlag && this.lastFlag) {
        // 結果画面表示
        this.resultFlag = true;
      } else if (this.nextFlag && !this.lastFlag) {
        // 次の問題表示
        this.currentQuizIndex++;
        this.nextFlag = false;
        this.canShowHint = false;

        // 選択肢をデフォルト値に
        this.selectedChoiceValue = QUIZ_MAP_CHOICE_DEFAULT_VALUE;
      } else {
        // 正解判定
        const correctValue = this.quizData[this.currentQuizIndex].name;
        if (this.selectedChoiceValue === correctValue) {
          // 正解
          this.correctCount++;
        } else {
          // 不正解
          this.incorrectCount++;
        }

        // 次へボタン表示
        this.nextFlag = true;
        if (this.currentQuizIndex + 1 === this.quizCountLimit) {
          // 結果へボタン表示
          this.lastFlag = true;
        }
      }
    },
  },
};
</script>