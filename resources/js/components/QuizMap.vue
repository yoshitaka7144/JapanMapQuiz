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
        {{ classificationCheckedValues }}
        {{ audioChecked }}
        {{ timeLimitChecked }}
        {{ timeLimitSelectedValue }}
        {{ quizCountSelectedValue }}
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
      this.canStartGame = true;
    },
  },
};
</script>