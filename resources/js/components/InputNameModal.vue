<template>
  <transition name="modal">
    <div id="input-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <div class="img-wrapper">
            <img :src="'./image/' + imageId + '.png'" alt="" />
          </div>
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
            @click="close(selectedPlaceName, imageId)"
          >
            OK
          </button>
        </div>
      </div>
    </div>
  </transition>
</template>
<script>
import { ANSWER_METHOD_SELECT, ANSWER_METHOD_WRITE } from "../util";
export default {
  props: {
    placeNames: [],
    imageId: Number,
    setPlaceName: Function,
    answerMethod: String,
    initialPlaceName: String,
    close: Function,
  },
  data() {
    return {
      methodSelect: ANSWER_METHOD_SELECT,
      methodWrite: ANSWER_METHOD_WRITE,
      selectedPlaceName: this.initialPlaceName,
    };
  },
  methods: {
    
  },
};
</script>