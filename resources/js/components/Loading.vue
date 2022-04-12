<template>
  <transition appear>
    <div class="loading">
      <span class="loading01"><span></span></span>
    </div>
  </transition>
</template>
<style>
.v-enter-active,
.v-leave-active {
  transition: opacity 0.3s;
}

.v-enter,
.v-leave-to {
  opacity: 0;
}
</style>
<script>
export default {};
</script>