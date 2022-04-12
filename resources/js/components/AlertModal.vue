<template>
  <transition appear>
    <div id="alert-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <button class="closeBtn" @click="$emit('close')">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-xmark']" />
          </button>
          <p class="message">{{ alertMessage }}</p>
          <div class="btn-wrapper">
            <button class="btn btn-orange" @click="$emit('close')">OK</button>
          </div>
        </div>
      </div>
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
export default {
  props: {
    alertMessage: String,
  },
};
</script>