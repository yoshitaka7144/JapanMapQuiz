<template>
  <div id="menu">
    <div class="menu-inner wrapper">
      <router-link :to="{ name: 'fill-map' }"> 地図埋め </router-link>
      <router-link :to="{ name: 'quiz-map' }"> 地図クイズ </router-link>
      <router-link :to="{ name: 'typing-map' }"> 地図タイピング </router-link>
    </div>
  </div>
</template>

<script>
export default {};
</script>