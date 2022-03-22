<template>
  <transition name="modal">
    <div id="alert-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <p class="message">{{ alertMessage }}</p>
          <button @click="$emit('close')">OK</button>
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