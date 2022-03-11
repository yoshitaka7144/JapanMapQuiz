import Vue from "vue";
import VueRouter from "vue-router";
// import Index from "./components/Index";
// import Login from "./components/Login";
// import Edit from "./components/Edit";
// import SystemError from "./components/SystemError";
// import NotFound from "./components/NotFound";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  routes: [
    // {
    //   path: "/",
    //   name: "index",
    //   component: Index
    // },
    // {
    //   path: "/login",
    //   name: "login",
    //   component: Login,
    //   beforeEnter(to, from, next) {
    //     if (store.getters["auth/isLogin"]) {
    //       next("/");
    //     } else {
    //       next();
    //     }
    //   }
    // },
    // {
    //   path: "/question",
    //   name: "question",
    //   component: Question,
    //   beforeEnter(to, from, next) {
    //     if (store.getters["auth/isLogin"]) {
    //       next();
    //     } else {
    //       next("/");
    //     }
    //   }
    // },
    // {
    //   path: "/500",
    //   name: "systemError",
    //   component: SystemError
    // },
    // {
    //   path: "*",
    //   name: "notFound",
    //   component: NotFound
    // },
  ]
});

export default router