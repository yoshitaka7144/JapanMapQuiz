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
          <p class="title">
            <span class="title-ja">{{ fillMapTitle.ja }}</span>
          </p>
        </div>
        <div class="menu-item quiz" @click="selectMenu(quizMapTitle.en)">
          <div class="icon-wrapper">
            <fontawesome-icon
              class="icon"
              :icon="['fas', 'fa-circle-question']"
            />
          </div>
          <p class="title">
            <span class="title-ja">{{ quizMapTitle.ja }}</span>
          </p>
        </div>
        <div class="menu-item typing" @click="selectMenu(typingMapTitle.en)">
          <div class="icon-wrapper">
            <fontawesome-icon
              class="icon"
              :icon="['fas', 'fa-keyboard']"
            />
          </div>
          <p class="title">
            <span class="title-ja">{{ typingMapTitle.ja }}</span>
          </p>
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
      fillMapTitle: {
        ja: FILL_MAP_MENU_TITLE_JAPANESE,
        en: FILL_MAP_MENU_TITLE_ENGLISH,
      },
      quizMapTitle: {
        ja: QUIZ_MAP_MENU_TITLE_JAPANESE,
        en: QUIZ_MAP_MENU_TITLE_ENGLISH,
      },
      typingMapTitle: {
        ja: TYPING_MAP_MENU_TITLE_JAPANESE,
        en: TYPING_MAP_MENU_TITLE_ENGLISH,
      },
    };
  },
  methods: {
    selectMenu(menuName) {
      this.$router.push({
        name: menuName.toLowerCase(),
      });
    },
  },
};
</script>