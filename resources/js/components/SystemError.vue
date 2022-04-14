<template>
  <div id="system-error" class="wrapper">
    <div class="system-error-inner">
      <p class="title">System Error</p>
      <p class="text">{{ systemErrorMessage }}</p>
      <p class="error-message">{{ message }}</p>
      <p class="file-name">{{ file }}</p>
      <div class="btn-wrapper">
        <router-link class="btn btn-gray large" :to="{ name: 'home' }"
          >トップ画面へ</router-link
        >
        <router-link class="btn btn-gray large" :to="{ name: 'menu' }"
          >メニュー画面へ</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import { SYSTEM_ERROR_MESSAGE } from "../util.js";
export default {
  props: {
    /**
     * ファイル名
     */
    file: String,
    /**
     * エラーメッセージ
     */
    message: String,
  },
  data() {
    return {
      /**
       * システムエラーメッセージ
       */
      systemErrorMessage: SYSTEM_ERROR_MESSAGE,
    };
  },
};
</script>