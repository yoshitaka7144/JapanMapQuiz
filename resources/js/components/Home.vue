<template>
  <div id="home">
    <router-link :to="{ name: 'menu' }"> クリック </router-link>
    <button @click="aaa">test</button>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
  methods: {
    async aaa() {
      // api用パラメータ
      const params = {
        classificationId: [2],
      };
      // api呼び出し
      const response = await axios
        .get("/api/maps/names", { params })
        .catch((error) => error.response || error);

      console.log(response);
    },
  },
};
</script>