<template>
  <transition appear>
    <div id="manual-modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <button class="closeBtn" @click="$emit('close')">
            <fontawesome-icon class="icon" :icon="['fas', 'fa-circle-xmark']" />
          </button>
          <div class="tab-wrapper">
            <input type="radio" id="input" value="input" v-model="tabName" />
            <label for="input">入力</label>
            <input type="radio" id="move" value="move" v-model="tabName" />
            <label for="move">移動</label>
            <input type="radio" id="zoom" value="zoom" v-model="tabName" />
            <label for="zoom">ズーム</label>
          </div>
          <p class="text" v-if="tabName === 'input'">
            入力対象の都道府県をクリック（タップ）すると入力用のウィンドウが開きます。テキストを入力または選択し、OKボタンをクリック（タップ）すると入力が完了します。
          </p>
          <p class="text" v-if="tabName === 'move'">
            地図上をドラッグすることで表示位置を移動させることが出来ます。
          </p>
          <p class="text" v-if="tabName === 'zoom'">
            地図上でマウスホイールを上下させることで地図の拡大と縮小が出来ます。スマートフォンの場合は地図上でピンチイン、ピンチアウトで拡大と縮小が出来ます。
          </p>
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
  transition: opacity 0.5s;
}

.v-enter,
.v-leave-to {
  opacity: 0;
}
</style>
<script>
export default {
  data() {
    return {
      tabName: "input",
    };
  },
};
</script>