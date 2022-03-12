require('./bootstrap');

import router from "./router";
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fab } from '@fortawesome/free-brands-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import HeaderComponent from "./components/Header";
import FooterComponent from "./components/Footer";

window.Vue = require('vue').default;

library.add(fas, far, fab);
Vue.component("fontawesome-icon", FontAwesomeIcon);
Vue.component('header-component', HeaderComponent);
Vue.component('footer-component', FooterComponent);

const app = new Vue({
  el: '#app',
  router,
});
