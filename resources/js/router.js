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
      // ホーム画面
      path: "/",
      name: "home",
      component: Home
    },
    {
      // メニュー画面
      path: "/menu",
      name: "menu",
      component: Menu
    },
    {
      // 地図埋め画面
      path: "/fill",
      name: "fill",
      component: FillMap,
      props: true,
    },
    {
      // 地図クイズ画面
      path: "/quiz",
      name: "quiz",
      component: QuizMap,
      props: true,
    },
    {
      // 地図タイピング画面
      path: "/typing",
      name: "typing",
      component: TypingMap,
      props: true,
    },
    {
      // システムエラー画面
      path: "/system-error",
      name: "system-error",
      component: SystemError,
      props: true,
    },
    {
      // NotFound画面
      path: "*",
      name: "not-found",
      component: NotFound
    },
  ]
});

export default router