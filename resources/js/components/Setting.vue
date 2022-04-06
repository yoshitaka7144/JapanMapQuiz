<template>
  <div class="setting" v-if="completesApiLoading">
    <p class="title">
      <span class="title-ja">{{ selectedMenuTitleJa }}</span>
    </p>
    <div class="setting-inner">
      <div class="setting-target-area">
        <p class="sub-title">出題対象地方</p>
        <div
          class="checkbox-wrapper"
          v-for="classification in classifications"
          :key="classification.id"
        >
          <input
            :id="classification.id"
            type="checkbox"
            v-model="params.classificationCheckedValues"
            :value="classification.id"
          />
          <label :for="classification.id">{{ classification.name }}</label>
        </div>
      </div>
      <div
        class="setting-choice-type"
        v-if="selectedMenuTitleEn === quizMapMenuTitleEn"
      >
        <p class="sub-title">選択肢タイプ</p>
        <div class="radio-wrapper">
          <input
            type="radio"
            id="choice-type-all"
            :value="choiceTypeAll"
            v-model="params.choiceType"
          />
          <label for="choice-type-all">全都道府県</label>
          <input
            type="radio"
            id="choice-type-classification"
            :value="choiceTypeClassification"
            v-model="params.choiceType"
          />
          <label for="choice-type-classification">同地方区分</label>
        </div>
      </div>
      <div
        class="setting-common"
        v-if="selectedMenuTitleEn !== fillMapMenuTitleEn"
      >
        <div class="setting-audio">
          <input
            type="checkbox"
            id="audio"
            class="checkbox"
            v-model="params.audioChecked"
          />
          <label for="audio">音声有無</label>
        </div>
        <div class="setting-quiz-count">
          <label>問題数</label>
          <div class="select-wrapper">
            <select class="select" v-model="params.quizCountSelectedValue">
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
          class="setting-time-limit"
          v-if="selectedMenuTitleEn === typingMapMenuTitleEn"
        >
          <input
            type="checkbox"
            id="time-limit"
            class="checkbox"
            v-model="params.timeLimitChecked"
          />
          <label for="time-limit">時間制限(秒)</label>
          <div class="select-wrapper">
            <select class="select" v-model="params.timeLimitSelectedValue">
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
      </div>
      <div
        class="setting-answer-method"
        v-if="selectedMenuTitleEn === fillMapMenuTitleEn"
      >
        <p class="sub-title">解答タイプ</p>
        <div class="radio-wrapper">
          <input
            type="radio"
            id="answer-select"
            :value="answerMethodSelectValue"
            v-model="params.answerMethod"
          />
          <label for="answer-select">選択</label>
          <input
            type="radio"
            id="answer-write"
            :value="answerMethodWriteValue"
            v-model="params.answerMethod"
          />
          <label for="answer-write">記述</label>
        </div>
      </div>
    </div>
    <div class="btn-start-wrapper">
      <button class="btn large btn-blue" @click="settingParams(params)">
        <fontawesome-icon class="icon" :icon="['fas', 'fa-play']" />
        スタート
      </button>
      <router-link :to="{ name: 'menu' }" class="btn large btn-gray">
        <fontawesome-icon class="icon" :icon="['fas', 'fa-reply']" />
        戻る
      </router-link>
    </div>
  </div>
</template>
<script>
import {
  INTERNAL_SERVER_ERROR,
  DEFAULT_TIME_LIMIT_VALUE,
  DEFAULT_QUIZ_COUNT_VALUE,
  FILL_MAP_MENU_TITLE_ENGLISH,
  QUIZ_MAP_MENU_TITLE_ENGLISH,
  TYPING_MAP_MENU_TITLE_ENGLISH,
  ANSWER_METHOD_SELECT,
  ANSWER_METHOD_WRITE,
  DEFAULT_ANSWER_METHOD,
  DEFAULT_TIME_LIMIT_CHECKED,
  DEFAULT_AUDIO_CHECKED,
  CHOICE_TYPE_ALL,
  CHOICE_TYPE_CLASSIFICATION,
  DEFAULT_CHOICE_TYPE,
} from "../util";
export default {
  props: {
    selectedMenuTitleJa: String,
    selectedMenuTitleEn: String,
    selectedMenuText: String,
    settingParams: Function,
  },
  data() {
    return {
      params: {
        classificationCheckedValues: [1, 2, 3, 4, 5, 6, 7, 8],
        answerMethod: DEFAULT_ANSWER_METHOD,
        audioChecked: DEFAULT_AUDIO_CHECKED,
        timeLimitChecked: DEFAULT_TIME_LIMIT_CHECKED,
        timeLimitSelectedValue: DEFAULT_TIME_LIMIT_VALUE,
        quizCountSelectedValue: DEFAULT_QUIZ_COUNT_VALUE,
        choiceType: DEFAULT_CHOICE_TYPE,
      },
      classifications: Array,
      timeLimitValues: Array,
      quizCountValues: Array,
      fillMapMenuTitleEn: FILL_MAP_MENU_TITLE_ENGLISH,
      quizMapMenuTitleEn: QUIZ_MAP_MENU_TITLE_ENGLISH,
      typingMapMenuTitleEn: TYPING_MAP_MENU_TITLE_ENGLISH,
      answerMethodSelectValue: ANSWER_METHOD_SELECT,
      answerMethodWriteValue: ANSWER_METHOD_WRITE,
      choiceTypeAll: CHOICE_TYPE_ALL,
      choiceTypeClassification: CHOICE_TYPE_CLASSIFICATION,
      completesApiLoading: false,
    };
  },
  created() {
    if (this.selectedMenuTitleEn === TYPING_MAP_MENU_TITLE_ENGLISH) {
      Promise.all([
        this.loadTimeLimitValues(),
        this.loadQuizCountValues(),
        this.loadClassifications(),
      ]).then(() => {
        this.completesApiLoading = true;
      });
    } else if (this.selectedMenuTitleEn === QUIZ_MAP_MENU_TITLE_ENGLISH) {
      Promise.all([
        this.loadQuizCountValues(),
        this.loadClassifications(),
      ]).then(() => {
        this.completesApiLoading = true;
      });
    } else {
      Promise.all([this.loadClassifications()]).then(() => {
        this.completesApiLoading = true;
      });
    }
  },
  methods: {
    async loadClassifications() {
      const response = await axios
        .get("/api/classifications")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.classifications = response.data;
      }
    },
    async loadTimeLimitValues() {
      const response = await axios
        .get("/api/time_limit_values")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.timeLimitValues = response.data;
      }
    },
    async loadQuizCountValues() {
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