<template>
  <div id="footer">
    <div class="footer-inner wrapper">
      <p class="copyright">
        <fontawesome-icon class="icon" :icon="['fas', 'fa-copyright']" />
        {{ authorName }}
      </p>
    </div>
  </div>
</template>
<script>
import { AUTHOR_NAME } from "../util.js";
export default {
  data() {
    return {
      /**
       * 制作者名
       */
      authorName: AUTHOR_NAME,
    };
  },
};
</script>