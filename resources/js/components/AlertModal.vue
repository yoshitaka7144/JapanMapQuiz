<template>
  <transition name="modal">
    <div id="alert-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <button class="closeBtn" @click="$emit('close')">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-circle-xmark']" />
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
<script>
export default {
  props: {
    alertMessage: String,
  },
};
</script>