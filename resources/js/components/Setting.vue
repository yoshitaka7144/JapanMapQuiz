<template>
  <div class="setting">
    <div class="setting-inner" v-if="completesApiLoading">
      <p class="title">
        <span
          class="title-ja"
          :class="{
            fill: selectedMenuTitleEn === fillMapMenuTitleEn,
            quiz: selectedMenuTitleEn === quizMapMenuTitleEn,
            typing: selectedMenuTitleEn === typingMapMenuTitleEn,
          }"
          >{{ selectedMenuTitleJa }}</span
        >
      </p>
      <div class="setting-wrapper">
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
        <button class="btn large btn-orange" @click="settingParams(params)">
          <fontawesome-icon class="icon" :icon="['fas', 'fa-play']" />
          スタート
        </button>
        <router-link :to="{ name: 'menu' }" class="btn large btn-gray">
          <fontawesome-icon class="icon" :icon="['fas', 'fa-reply']" />
          戻る
        </router-link>
      </div>
    </div>
    <LoadingComponent v-else />
  </div>
</template>
<script>
import LoadingComponent from "./Loading.vue";
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
  components: {
    LoadingComponent,
  },
  props: {
    /**
     * 日本語メニュータイトル
     */
    selectedMenuTitleJa: String,
    /**
     * 英語メニュータイトル
     */
    selectedMenuTitleEn: String,
    /**
     * 設定情報セット処理
     */
    settingParams: Function,
  },
  data() {
    return {
      /**
       * 設定パラメータ
       */
      params: {
        /**
         * 地方区分id
         */
        classificationCheckedValues: [1, 2, 3, 4, 5, 6, 7, 8],
        /**
         * 解答方法
         */
        answerMethod: DEFAULT_ANSWER_METHOD,
        /**
         * 音声有無
         */
        audioChecked: DEFAULT_AUDIO_CHECKED,
        /**
         * 制限時間有無
         */
        timeLimitChecked: DEFAULT_TIME_LIMIT_CHECKED,
        /**
         * 制限時間値
         */
        timeLimitSelectedValue: DEFAULT_TIME_LIMIT_VALUE,
        /**
         * 問題数
         */
        quizCountSelectedValue: DEFAULT_QUIZ_COUNT_VALUE,
        /**
         * 選択肢タイプ
         */
        choiceType: DEFAULT_CHOICE_TYPE,
      },
      /**
       * 地方区分名リスト
       */
      classifications: Array,
      /**
       * 制限時間値リスト
       */
      timeLimitValues: Array,
      /**
       * 問題数リスト
       */
      quizCountValues: Array,
      /**
       * 地図埋め英語タイトル
       */
      fillMapMenuTitleEn: FILL_MAP_MENU_TITLE_ENGLISH,
      /**
       * 地図クイズ英語タイトル
       */
      quizMapMenuTitleEn: QUIZ_MAP_MENU_TITLE_ENGLISH,
      /**
       * 地図タイピング英語タイトル
       */
      typingMapMenuTitleEn: TYPING_MAP_MENU_TITLE_ENGLISH,
      /**
       * 解答方法：選択
       */
      answerMethodSelectValue: ANSWER_METHOD_SELECT,
      /**
       * 解答方法：記述
       */
      answerMethodWriteValue: ANSWER_METHOD_WRITE,
      /**
       * 選択肢タイプ：全都道府県
       */
      choiceTypeAll: CHOICE_TYPE_ALL,
      /**
       * 選択肢タイプ：同地方区分
       */
      choiceTypeClassification: CHOICE_TYPE_CLASSIFICATION,
      /**
       * api読み込み処理完了フラグ
       */
      completesApiLoading: false,
    };
  },
  created() {
    if (this.selectedMenuTitleEn === TYPING_MAP_MENU_TITLE_ENGLISH) {
      // 地図タイピングの場合
      Promise.all([
        this.loadTimeLimitValues(),
        this.loadQuizCountValues(),
        this.loadClassifications(),
      ]).then(() => {
        this.completesApiLoading = true;
      });
    } else if (this.selectedMenuTitleEn === QUIZ_MAP_MENU_TITLE_ENGLISH) {
      // 地図クイズの場合
      Promise.all([
        this.loadQuizCountValues(),
        this.loadClassifications(),
      ]).then(() => {
        this.completesApiLoading = true;
      });
    } else {
      // 地図埋めの場合
      Promise.all([this.loadClassifications()]).then(() => {
        this.completesApiLoading = true;
      });
    }
  },
  methods: {
    /**
     * 地方区分名リスト取得
     */
    async loadClassifications() {
      const response = await axios
        .get("/api/classifications")
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
        this.classifications = response.data;
      }
    },
    /**
     * 制限時間リスト取得
     */
    async loadTimeLimitValues() {
      const response = await axios
        .get("/api/time_limit_values")
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
        this.timeLimitValues = response.data;
      }
    },
    /**
     * 問題数リスト取得
     */
    async loadQuizCountValues() {
      const response = await axios
        .get("/api/quiz_count_values")
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
        this.quizCountValues = response.data;
      }
    },
  },
};
</script>