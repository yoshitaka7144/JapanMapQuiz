<template>
  <div id="not-found" class="wrapper">
    <div class="not-found-inner">
      <p class="title">Not Found</p>
      <p class="text">{{ notFoundText }}</p>
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
import { NOT_FOUND_MESSAGE } from "../util.js";
export default {
  data() {
    return {
      notFoundText: NOT_FOUND_MESSAGE,
    };
  },
};
</script>