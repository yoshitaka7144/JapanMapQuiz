<template>
  <div id="menu">
    <div class="menu-inner wrapper">
      <div class="menu-item menu-fill-map">
        <router-link class="menu-link" :to="{ name: 'fill-map' }">
          <p class="title">
            <span class="title-en">Fill</span>
            <span class="title-ja">地図埋め</span>
          </p>
        </router-link>
      </div>
      <div class="menu-item menu-quiz-map">
        <router-link class="menu-link" :to="{ name: 'quiz-map' }">
          <p class="title">
            <span class="title-en">Quiz</span>
            <span class="title-ja">地図クイズ</span>
          </p>
        </router-link>
      </div>
      <div class="menu-item menu-typing-map">
        <router-link class="menu-link" :to="{ name: 'typing-map' }">
          <p class="title">
            <span class="title-en">Typing</span>
            <span class="title-ja">地図タイピング</span>
          </p>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>