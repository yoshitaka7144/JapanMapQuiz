<template>
  <transition appear>
    <div id="confirmation-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <button class="closeBtn" @click="$emit('close')">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-xmark']" />
          </button>
          <p class="empty-message">
            未解答：<span>{{ emptyCount }}</span
            >問
          </p>
          <p class="confirmation-message">{{ confirmationMessage }}</p>
          <div class="btn-wrapper">
            <button class="btn btn-orange" @click="ok">OK</button>
            <button class="btn btn-gray" @click="$emit('close')">戻る</button>
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
import { FILL_MAP_ANSWER_CONFIRMATION_TEXT } from "../util";
export default {
  props: {
    emptyCount: Number,
    ok: Function,
  },
  data() {
    return {
      confirmationMessage: FILL_MAP_ANSWER_CONFIRMATION_TEXT,
    };
  },
};
</script>