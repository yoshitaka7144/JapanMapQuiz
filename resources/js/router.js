import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./components/Home";
import Menu from "./components/Menu";
import FillMap from "./components/FillMap";
import QuizMap from "./components/QuizMap";
import TypingMap from "./components/TypingMap";
import NotFound from "./components/NotFound";
// import SystemError from "./components/SystemError";

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
      path: "/fill-map",
      name: "fill-map",
      component: FillMap
    },
    {
      path: "/quiz-map",
      name: "quiz-map",
      component: QuizMap
    },
    {
      path: "/typing-map",
      name: "typing-map",
      component: TypingMap
    },
    {
      path: "*",
      name: "not-found",
      component: NotFound
    },
  ]
});

export default router