<template>
  <div id="menu">
    <div class="menu-inner wrapper">
      <div class="menu-select" v-if="selectedMenuTitleJa === ''">
        <div
          v-for="menu in menus"
          :key="menu.text"
          class="menu-item"
          :class="menu.title.en"
          @click="selectMenu(menu)"
        >
          <p class="title">
            <span class="title-en">{{ menu.title.en }}</span>
            <span class="title-ja">{{ menu.title.ja }}</span>
          </p>
        </div>
      </div>
      <div class="setting" v-if="selectedMenuTitleJa !== ''">
        <div class="btn-back-wrapper">
          <button class="btn btn-gray" @click="clear()">戻る</button>
        </div>
        <p class="title">
          <span class="title-en">{{ selectedMenuTitleEn }}</span>
          <span class="title-ja">{{ selectedMenuTitleJa }}</span>
        </p>
        <p class="explanation-text">{{ selectedMenuText }}</p>
        <div class="setting-target-area">
          <label
            v-for="classification in classifications"
            :key="classification.id"
            :for="classification.id"
            >{{ classification.name
            }}<input
              :id="classification.id"
              type="checkbox"
              v-model="classificationCheckedValues"
              :value="classification.id"
          /></label>
        </div>
        <div class="setting-time-limit">
          <input
            type="checkbox"
            id="time-limit"
            class="checkbox"
            v-model="timeLimitChecked"
          />
          <label for="time-limit">時間制限（秒）</label>
          <div class="select-wrapper">
            <select class="select" v-model="timeLimitSelectedValue">
              <option
                v-for="timeLimitValue in timeLimitValues"
                :key="timeLimitValue.id"
                :value="timeLimitValue.value"
              >
                {{ timeLimitValue.value }}
              </option>
            </select>
          </div>
        </div>
        <div class="setting-audio" v-if="selectedMenuTitleEn !== 'fill'">
          <input
            type="checkbox"
            id="audio"
            class="checkbox"
            v-model="audioChecked"
          />
          <label for="audio">音声有無</label>
        </div>
        <div class="setting-quiz-count" v-if="selectedMenuTitleEn !== 'fill'">
          <label for="">問題数</label>
          <div class="select-wrapper">
            <select class="select" v-model="quizCountSelectedValue">
              <option
                v-for="quizCountValue in quizCountValues"
                :key="quizCountValue.id"
                :value="quizCountValue.value"
              >
                {{ quizCountValue.value }}
              </option>
            </select>
          </div>
        </div>
        <div
          class="setting-answer-method"
          v-if="selectedMenuTitleEn === 'fill'"
        >
          <input
            type="radio"
            id="answer-select"
            value="select"
            v-model="answerMethod"
          />
          <label for="answer-select">選択</label>
          <input
            type="radio"
            id="answer-write"
            value="write"
            v-model="answerMethod"
          />
          <label for="answer-write">記述</label>
        </div>
        <div class="btn-start-wrapper">
          <button class="btn btn-gray" @click="start(selectedMenuTitleEn)">
            スタート
          </button>
        </div>
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
  DEFAULT_TIME_LIMIT_VALUE,
  DEFAULT_QUIZ_COUNT_VALUE,
} from "../util";
export default {
  data() {
    return {
      classificationCheckedValues: [],
      selectedMenuTitleJa: "",
      selectedMenuTitleEn: "",
      selectedMenuText: "",
      menus: [
        {
          text: "地図埋めの説明説明説明説明説明説明説明説明説明説明説明",
          title: {
            ja: "地図埋め",
            en: "fill",
          },
        },
        {
          text: "地図クイズの説明説明説明説明説明説明説明説明説明説明説明",
          title: {
            ja: "地図クイズ",
            en: "quiz",
          },
        },
        {
          text: "地図タイピングの説明説明説明説明説明説明説明説明説明説明説明",
          title: {
            ja: "地図タイピング",
            en: "typing",
          },
        },
      ],
      classifications: "",
      answerMethod: "select",
      audioChecked: false,
      timeLimitValues: "",
      timeLimitChecked: false,
      timeLimitSelectedValue: DEFAULT_TIME_LIMIT_VALUE,
      quizCountValues: "",
      quizCountSelectedValue: DEFAULT_QUIZ_COUNT_VALUE,
    };
  },
  mounted() {
    this.getClassifications();
    this.getTimeLimitValues();
    this.getQuizCountValues();
  },
  methods: {
    clear() {
      this.classificationCheckedValues = [];
      this.selectedMenuTitleJa = "";
      this.selectedMenuTitleEn = "";
      this.selectedMenuText = "";
      this.answerMethod = "select";
      this.audioChecked = false;
      this.timeLimitChecked = false;
      this.timeLimitSelectedValue = DEFAULT_TIME_LIMIT_VALUE;
      this.quizCountSelectedValue = DEFAULT_QUIZ_COUNT_VALUE;
    },
    selectMenu(menu) {
      this.selectedMenuTitleJa = menu.title.ja;
      this.selectedMenuTitleEn = menu.title.en;
      this.selectedMenuText = menu.text;
    },
    start(selectedMenuTitleEn) {
      if (selectedMenuTitleEn === "fill") {
        this.$router.push({
          name: selectedMenuTitleEn,
          params: {
            classificationCheckedValues: this.classificationCheckedValues,
            timeLimitChecked: this.timeLimitChecked,
            timeLimitValue: this.timeLimitSelectedValue,
            answerMethod: this.answerMethod,
          },
        });
      } else {
        this.$router.push({
          name: selectedMenuTitleEn,
          params: {
            classificationCheckedValues: this.classificationCheckedValues,
            timeLimitChecked: this.timeLimitChecked,
            timeLimitValue: this.timeLimitSelectedValue,
            quizCountValue: this.quizCountSelectedValue,
            audioChecked: this.audioChecked,
          },
        });
      }
    },
    async getClassifications() {
      const response = await axios
        .get("/api/classifications")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.classifications = response.data;
      }
    },
    async getTimeLimitValues() {
      const response = await axios
        .get("/api/time_limit_values")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.timeLimitValues = response.data;
      }
    },
    async getQuizCountValues() {
      const response = await axios
        .get("/api/quiz_count_values")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.quizCountValues = response.data;
      }
    },
  },
};
</script>