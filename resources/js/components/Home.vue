<template>
  <div id="home">
    <div class="home-inner wrapper">
      <router-link :to="{ name: 'menu' }" class="home-img">
        <p class="start-text">クリック or タップして下さい。</p>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
  },
};
</script>