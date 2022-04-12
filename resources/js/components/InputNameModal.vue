<template>
  <transition appear>
    <div id="input-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <button class="closeBtn" @click="$emit('close')">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-xmark']" />
          </button>
          <div class="img-wrapper">
            <svg
              class="svg-default"
              :class="{
                correct:
                  mode === modeConfirm && initialPlaceName === correctPlaceName,
                incorrect:
                  mode === modeConfirm && initialPlaceName !== correctPlaceName,
              }"
            >
              <use
                :xlink:href="'./image/map/' + imageId + '.svg#' + imageId"
              ></use>
            </svg>
          </div>
          <div class="mode-input" v-if="mode === modeInput">
            <div class="input-place-name">
              <input
                type="text"
                autocomplete="false"
                :placeholder="placeholderText"
                v-model="selectedPlaceName"
                v-if="answerMethod === methodWrite"
              />
              <div class="select-wrapper" v-else>
                <select class="select" v-model="selectedPlaceName">
                  <option value="">{{ selectDefaultValue }}</option>
                  <option
                    v-for="item in placeNames"
                    :key="item.name"
                    :value="item.name"
                  >
                    {{ item.name }}
                  </option>
                </select>
              </div>
            </div>
            <div class="btn-wrapper">
              <button
                class="btn btn-orange"
                @click="ok(selectedPlaceName, imageId)"
              >
                OK
              </button>
            </div>
          </div>
          <div class="mode-confirm" v-else>
            <div class="confirm" v-if="kana">
              <div class="typing">
                <p class="roman">{{ roman }}</p>
                <p class="kana">{{ kana }}</p>
                <p class="name">{{ correctPlaceName }}</p>
              </div>
            </div>
            <div class="confirm" v-else>
              <div class="answer">
                <p class="title">あなたの解答</p>
                <p class="text">
                  <span :class="{ incorrect: !isCorrected }">{{
                    initialPlaceName
                  }}</span>
                </p>
              </div>
              <div class="correct">
                <p class="title">正解</p>
                <p class="text">
                  <span>{{ correctPlaceName }}</span>
                </p>
              </div>
            </div>
            <div class="btn-wrapper">
              <button class="btn btn-orange" @click="ok">OK</button>
            </div>
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
import {
  ANSWER_METHOD_SELECT,
  ANSWER_METHOD_WRITE,
  FILL_MAP_MODAL_INPUT_MODE,
  FILL_MAP_MODAL_CONFIRM_MODE,
  FILL_MAP_INPUT_MODAL_SELECT_DEFAULT_VALUE,
  FILL_MAP_INPUT_MODAL_PLACEHOLDER_TEXT,
} from "../util";
export default {
  props: {
    placeNames: [],
    imageId: Number,
    setPlaceName: Function,
    answerMethod: String,
    initialPlaceName: String,
    correctPlaceName: String,
    kana: String,
    roman: String,
    mode: String,
    ok: Function,
  },
  data() {
    return {
      methodSelect: ANSWER_METHOD_SELECT,
      methodWrite: ANSWER_METHOD_WRITE,
      selectedPlaceName: this.initialPlaceName,
      modeInput: FILL_MAP_MODAL_INPUT_MODE,
      modeConfirm: FILL_MAP_MODAL_CONFIRM_MODE,
      selectDefaultValue: FILL_MAP_INPUT_MODAL_SELECT_DEFAULT_VALUE,
      placeholderText: FILL_MAP_INPUT_MODAL_PLACEHOLDER_TEXT,
    };
  },
  computed: {
    isCorrected() {
      return this.initialPlaceName === this.correctPlaceName;
    },
  },
  methods: {},
};
</script>