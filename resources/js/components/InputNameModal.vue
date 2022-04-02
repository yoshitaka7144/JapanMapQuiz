<template>
  <transition name="modal">
    <div id="input-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
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
                class="input"
                v-model="selectedPlaceName"
                v-if="answerMethod === methodWrite"
              />
              <div class="select-wrapper" v-else>
                <select class="select" v-model="selectedPlaceName">
                  <option value="">選択してください。</option>
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
            <button
              class="btn btn-gray"
              @click="ok(selectedPlaceName, imageId)"
            >
              OK
            </button>
          </div>
          <div class="mode-confirm" v-else>
            <div class="confirm-text" v-if="kana">
              <div class="typing-text">
                <p>{{ roman }}</p>
                <p>{{ kana }}</p>
                <p>{{ correctPlaceName }}</p>
              </div>
            </div>
            <div class="confirm-text" v-else>
              <div class="inputed-text">
                <p>あなたの解答</p>
                <p>{{ initialPlaceName }}</p>
              </div>
              <div class="correct-text">
                <p>正解</p>
                <p>{{ correctPlaceName }}</p>
              </div>
            </div>
            <button class="btn btn-gray" @click="ok">OK</button>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import {
  ANSWER_METHOD_SELECT,
  ANSWER_METHOD_WRITE,
  FILL_MAP_MODAL_INPUT_MODE,
  FILL_MAP_MODAL_CONFIRM_MODE,
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
    };
  },
  methods: {},
};
</script>