<template>
  <div id="header">
    <div class="header-inner wrapper">
      <router-link class="logo" :to="{ name: 'home' }"></router-link>
      <nav id="pc-nav">
        <ul class="menu-list">
          <li>
            <a
              href="https://portfolio.mikanbako.jp/works-japan-map-quiz"
              target="_blank"
              rel="noopener"
              >作品紹介</a
            >
          </li>
          <li>
            <a
              href="https://portfolio.mikanbako.jp/"
              target="_blank"
              rel="noopener"
              >ポートフォリオ</a
            >
          </li>
          <li>
            <a
              href="https://github.com/yoshitaka7144/JapanMapQuiz"
              target="_blank"
              rel="noopener"
              >Github
            </a>
          </li>
        </ul>
      </nav>
      <nav id="sp-nav">
        <input type="checkbox" id="hamburger-menu" v-model="isOpened" />
        <label for="hamburger-menu" id="hamburger-menu-icon">
          <span></span>
          <span></span>
          <span></span>
        </label>
        <ul class="menu-list">
          <li @click="isOpened = false">
            <a
              href="https://portfolio.mikanbako.jp/works-japan-map-quiz"
              target="_blank"
              rel="noopener"
              >作品紹介</a
            >
          </li>
          <li @click="isOpened = false">
            <a
              href="https://portfolio.mikanbako.jp/"
              target="_blank"
              rel="noopener"
              >ポートフォリオ</a
            >
          </li>
          <li @click="isOpened = false">
            <a
              href="https://github.com/yoshitaka7144/JapanMapQuiz"
              target="_blank"
              rel="noopener"
              >Github
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      /**
       * spメニュー開閉状態
       */
      isOpened: false,
    };
  },
  mounted() {
    // clickイベントに処理設定
    window.addEventListener("click", this.closeSpNavMenu);
  },
  beforeDestroy() {
    // clickイベントの処理設定を削除
    window.removeEventListener("click", this.closeSpNavMenu);
  },
  methods: {
    /**
     * ナビメニューを閉じる
     * @param {Event} e
     */
    closeSpNavMenu(e) {
      // メニュー外をクリック時にメニューを閉じる
      if (!this.$el.querySelector("#sp-nav").contains(e.target)) {
        this.isOpened = false;
      }
    },
  },
};
</script>