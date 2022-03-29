<template>
  <transition name="modal">
    <div id="confirmation-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <p class="empty-message">
            未解答：<span>{{ emptyCount }}</span
            >問
          </p>
          <p class="confirmation-message">{{ confirmationMessage }}</p>
          <div class="btn-wrapper">
            <button class="btn btn-gray" @click="$emit('ok')">OK</button>
            <button class="btn btn-gray" @click="$emit('close')">戻る</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import { FILL_MAP_ANSWER_CONFIRMATION_TEXT } from "../util";
export default {
  props: {
    emptyCount: Number,
  },
  data() {
    return {
      confirmationMessage: FILL_MAP_ANSWER_CONFIRMATION_TEXT,
    };
  },
};
</script>