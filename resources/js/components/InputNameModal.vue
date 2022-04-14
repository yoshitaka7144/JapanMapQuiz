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
    /**
     * セレクトボックス用地図名
     */
    placeNames: [],
    /**
     * 地図画像id
     */
    imageId: Number,
    /**
     * 解答方法
     */
    answerMethod: String,
    /**
     * 入力or選択地図名
     */
    initialPlaceName: String,
    /**
     * 正解地図名
     */
    correctPlaceName: String,
    /**
     * 地図名（かな）
     */
    kana: String,
    /**
     * 地図名（ローマ字）
     */
    roman: String,
    /**
     * モーダルモード
     */
    mode: String,
    /**
     * ok処理
     */
    ok: Function,
  },
  data() {
    return {
      /**
       * 解答タイプ：選択
       */
      methodSelect: ANSWER_METHOD_SELECT,
      /**
       * 解答タイプ：記述
       */
      methodWrite: ANSWER_METHOD_WRITE,
      /**
       * 選択地図名
       */
      selectedPlaceName: this.initialPlaceName,
      /**
       * 入力モーダルモード
       */
      modeInput: FILL_MAP_MODAL_INPUT_MODE,
      /**
       * 確認モーダルモード
       */
      modeConfirm: FILL_MAP_MODAL_CONFIRM_MODE,
      /**
       * 地図名初期選択値
       */
      selectDefaultValue: FILL_MAP_INPUT_MODAL_SELECT_DEFAULT_VALUE,
      /**
       * inputプレースホルダテキスト
       */
      placeholderText: FILL_MAP_INPUT_MODAL_PLACEHOLDER_TEXT,
    };
  },
  computed: {
    /**
     * 入力地図名正解判定
     */
    isCorrected() {
      return this.initialPlaceName === this.correctPlaceName;
    },
  },
};
</script>