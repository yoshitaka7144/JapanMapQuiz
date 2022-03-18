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
      <div class="game" v-else>
        {{ quizData[currentQuizIndex].id }}
        {{ quizData[currentQuizIndex].name }}
        {{ quizData[currentQuizIndex].hintText }}
        {{ quizData[currentQuizIndex].choices }}
        <button @click="currentQuizIndex++;">test</button>
      </div>
    </div>
  </div>
</template>

<script>
import {
  OK,
  CREATED,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
  QUIZ_MAP_MENU_TITLE_JAPANESE,
  QUIZ_MAP_MENU_TITLE_ENGLISH,
  QUIZ_MAP_EXPLANATION_TEXT,
} from "../util";
import SettingComponent from "./Setting.vue";
export default {
  components: {
    SettingComponent,
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
      currentQuizIndex: 0,
    };
  },
  mounted() {},
  methods: {
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.audioChecked = params.audioChecked;
      this.timeLimitChecked = params.timeLimitChecked;
      this.timeLimitSelectedValue = params.timeLimitSelectedValue;
      this.quizCountSelectedValue = params.quizCountSelectedValue;

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
      const quizCount =
        this.maps.length <= this.quizCountSelectedValue
          ? this.maps.length
          : this.quizCountSelectedValue;

      for (let i = 0; i < quizCount; i++) {
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
  },
};
</script>