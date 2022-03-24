<template>
  <div id="fill-map">
    <div class="fill-map-inner wrapper">
      <SettingComponent
        v-if="!canStartGame"
        :selected-menu-title-ja="selectedMenuTitleJa"
        :selected-menu-title-en="selectedMenuTitleEn"
        :selected-menu-text="selectedMenuText"
        :setting-params="settingParams"
      />
      <div class="game" v-else>
        <button
          class="btn btn-gray"
          @click="
            showInputNameModal = true;
            imageId = 1;
          "
        >
          {{ inputedNames[1] }}
        </button>
        <button
          class="btn btn-gray"
          @click="
            showInputNameModal = true;
            imageId = 2;
          "
        >
          {{ inputedNames[2] }}
        </button>
        <button
          class="btn btn-gray"
          @click="
            showInputNameModal = true;
            imageId = 3;
          "
        >
          {{ inputedNames[3] }}
        </button>
      </div>
      <AlertModalComponent
        v-if="showAlertModal"
        :alertMessage="alertMessage"
        @close="showAlertModal = false"
      />
      <InputModalComponent
        v-if="showInputNameModal"
        :placeNames="placeNames"
        :imageId="imageId"
        :answerMethod="answerMethod"
        :initialPlaceName="inputedNames[imageId]"
        :close="setPlaceName"
      />
    </div>
  </div>
</template>

<script>
import {
  INTERNAL_SERVER_ERROR,
  FILL_MAP_MENU_TITLE_JAPANESE,
  FILL_MAP_MENU_TITLE_ENGLISH,
  FILL_MAP_EXPLANATION_TEXT,
  SETTING_CLASSIFICATION_ERROR_TEXT,
} from "../util";
import SettingComponent from "./Setting.vue";
import InputModalComponent from "./InputNameModal.vue";
import AlertModalComponent from "./AlertModal.vue";
export default {
  components: {
    SettingComponent,
    AlertModalComponent,
    InputModalComponent,
  },
  data() {
    return {
      selectedMenuTitleJa: FILL_MAP_MENU_TITLE_JAPANESE,
      selectedMenuTitleEn: FILL_MAP_MENU_TITLE_ENGLISH,
      selectedMenuText: FILL_MAP_EXPLANATION_TEXT,
      canStartGame: false,
      classificationCheckedValues: [],
      answerMethod: String,
      timeLimitChecked: Boolean,
      timeLimitSelectedValue: Number,
      maps: [],
      placeNames: [],
      inputedNames: [],
      showInputNameModal: false,
      showAlertModal: false,
      alertMessage: String,
      imageId: Number,
    };
  },
  mounted() {},
  methods: {
    reset() {
      for (let i = 0; i < 47; i++) {
        this.inputedNames[i] = "";
      }
    },
    settingParams(params) {
      this.classificationCheckedValues = params.classificationCheckedValues;
      this.answerMethod = params.answerMethod;
      this.timeLimitChecked = params.timeLimitChecked;
      this.timeLimitSelectedValue = params.timeLimitSelectedValue;

      // 地方区分エラーチェック
      if (this.classificationCheckedValues.length === 0) {
        this.alertMessage = SETTING_CLASSIFICATION_ERROR_TEXT;
        this.showAlertModal = true;
        return;
      }

      // 開始
      this.reset();
      this.startGame();
    },
    async loadQuizMaps() {
      const response = await axios
        .get("/api/maps")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.maps = response.data;
      }
    },
    async loadPlaceNames() {
      const response = await axios
        .get("/api/maps/names")
        .catch((error) => error.response || error);

      if (response.status === INTERNAL_SERVER_ERROR) {
        this.$router.push({ name: "systemError" });
      } else {
        this.placeNames = response.data;
      }
    },
    startGame() {
      Promise.all([this.loadQuizMaps(), this.loadPlaceNames()]).then(() => {
        this.canStartGame = true;
      });
    },
    setPlaceName(name, id) {
      this.inputedNames[id] = name;
      this.showInputNameModal = false;
    },
  },
};
</script>