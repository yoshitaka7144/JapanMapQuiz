<template>
  <div id="menu">
    <div class="menu-inner wrapper">
      <div class="menu-select">
        <div class="menu-item fill" @click="selectMenu(fillMapTitle.en)">
          <div class="icon-wrapper">
            <fontawesome-icon
              class="icon"
              :icon="['fas', 'fa-map-location-dot']"
            />
          </div>
          <div class="title-background-image"></div>
        </div>
        <div class="menu-item quiz" @click="selectMenu(quizMapTitle.en)">
          <div class="icon-wrapper">
            <fontawesome-icon
              class="icon"
              :icon="['fas', 'fa-circle-question']"
            />
          </div>
          <div class="title-background-image"></div>
        </div>
        <div class="menu-item typing" @click="selectMenu(typingMapTitle.en)">
          <div class="icon-wrapper">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-keyboard']" />
          </div>
          <div class="title-background-image"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  FILL_MAP_MENU_TITLE_JAPANESE,
  FILL_MAP_MENU_TITLE_ENGLISH,
  QUIZ_MAP_MENU_TITLE_JAPANESE,
  QUIZ_MAP_MENU_TITLE_ENGLISH,
  TYPING_MAP_MENU_TITLE_JAPANESE,
  TYPING_MAP_MENU_TITLE_ENGLISH,
} from "../util";
export default {
  data() {
    return {
      /**
       * 地図埋めメニュータイトル
       */
      fillMapTitle: {
        ja: FILL_MAP_MENU_TITLE_JAPANESE,
        en: FILL_MAP_MENU_TITLE_ENGLISH,
      },
      /**
       * 地図クイズメニュータイトル
       */
      quizMapTitle: {
        ja: QUIZ_MAP_MENU_TITLE_JAPANESE,
        en: QUIZ_MAP_MENU_TITLE_ENGLISH,
      },
      /**
       * 地図タイピングメニュータイトル
       */
      typingMapTitle: {
        ja: TYPING_MAP_MENU_TITLE_JAPANESE,
        en: TYPING_MAP_MENU_TITLE_ENGLISH,
      },
    };
  },
  methods: {
    /**
     * 選択したゲームを開く
     * @param {String} menuName メニュー名
     */
    selectMenu(menuName) {
      this.$router.push({
        name: menuName.toLowerCase(),
      });
    },
  },
};
</script>