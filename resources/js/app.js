require('./bootstrap');

import router from "./router";
import App from "./components/App.vue";
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

window.Vue = require('vue').default;

library.add(fas, far, fab);
Vue.component("fontawesome-icon", FontAwesomeIcon);

const app = new Vue({
  el: '#app',
  router,
  components: {
    App
  },
  template: "<App />"
});
