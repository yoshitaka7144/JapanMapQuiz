<template>
  <div id="quiz-map">
    <div class="quiz-map-inner wrapper">
      {{ classificationCheckedValues }}
      {{ timeLimitChecked }}
      {{ timeLimitValue }}
      {{ quizCountValue }}
      {{ audioChecked }}
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
    quizCountValue: "",
    audioChecked: "",
  },
  data() {
    return {};
  },
  mounted() {},
  methods: {},
};
</script>