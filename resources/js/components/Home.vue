<template>
  <div id="home">
    <div class="home-inner wrapper">
      <router-link :to="{ name: 'menu' }" class="home-img">
        <p class="start-text">{{ message }}</p>
      </router-link>
    </div>
  </div>
</template>

<script>
import { HOME_MESSAGE } from "../util.js";
export default {
  data() {
    return {
      /**
       * 表示メッセージ
       */
      message: HOME_MESSAGE,
    };
  },
};
</script>