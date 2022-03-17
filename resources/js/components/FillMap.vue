<template>
  <div id="fill-map">
    <div class="fill-map-inner wrapper">
      <SettingComponent
        v-if="!canStartGame"
        :selected-menu-title-ja="selectedMenuTitleJa"
        :selected-menu-title-en="selectedMenuTitleEn"
        :selected-menu-text="selectedMenuText"
        :setting-params="settingParams"
      />
      <div class="game" v-else>
        {{ classificationCheckedValues }}
        {{ answerMethod }}
        {{ timeLimitChecked }}
        {{ timeLimitSelectedValue }}
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
  FILL_MAP_MENU_TITLE_JAPANESE,
  FILL_MAP_MENU_TITLE_ENGLISH,
  FILL_MAP_EXPLANATION_TEXT,
} from "../util";
import SettingComponent from "./Setting.vue";
export default {
  components: {
    SettingComponent,
  },
  data() {
    return {
      selectedMenuTitleJa: FILL_MAP_MENU_TITLE_JAPANESE,
      selectedMenuTitleEn: FILL_MAP_MENU_TITLE_ENGLISH,
      selectedMenuText: FILL_MAP_EXPLANATION_TEXT,
      canStartGame: false,
      classificationCheckedValues: [],
      answerMethod: String,
      timeLimitChecked: Boolean,
      timeLimitSelectedValue: Number,
    };
  },
  mounted() {},
  methods: {
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.answerMethod = params.answerMethod;
      this.timeLimitChecked = params.timeLimitChecked;
      this.timeLimitSelectedValue = params.timeLimitSelectedValue;
      this.canStartGame = true;
    },
  },
};
</script>