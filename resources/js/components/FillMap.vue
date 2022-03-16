<template>
  <div id="fill-map">
    <div class="fill-map-inner wrapper">
      {{ classificationCheckedValues }}
      {{ timeLimitChecked }}
      {{ timeLimitValue }}
      {{ answerMethod }}
    </div>
  </div>
</template>

<script>
import {
  OK,
  CREATED,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
} from "../util";
export default {
  props: {
    classificationCheckedValues: "",
    timeLimitChecked: "",
    timeLimitValue: "",
    answerMethod: "",
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>