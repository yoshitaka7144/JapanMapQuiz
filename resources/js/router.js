import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./components/Home";
import Menu from "./components/Menu";
import FillMap from "./components/FillMap";
import QuizMap from "./components/QuizMap";
import TypingMap from "./components/TypingMap";
import NotFound from "./components/NotFound";
import SystemError from "./components/SystemError";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes: [
    {
      path: "/",
      name: "home",
      component: Home
    },
    {
      path: "/menu",
      name: "menu",
      component: Menu
    },
    {
      path: "/fill",
      name: "fill",
      component: FillMap,
      props: true,
    },
    {
      path: "/quiz",
      name: "quiz",
      component: QuizMap,
      props: true,
    },
    {
      path: "/typing",
      name: "typing",
      component: TypingMap,
      props: true,
    },
    {
      path: "/system-error",
      name: "system-error",
      component: SystemError,
      props: true,
    },
    {
      path: "*",
      name: "not-found",
      component: NotFound
    },
  ]
});

export default router