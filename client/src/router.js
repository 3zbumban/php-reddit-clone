import { createRouter, createWebHashHistory } from "vue-router";
import Login from "./views/Login.vue";
import Thread from "./views/Thread.vue";
import Signup from "./views/Signup.vue";
import BrowseThreads from "./views/BrowseThreads.vue";

const routes = [
  {
    path: "/",
    name: "Threads",
    component: BrowseThreads
  },
  {
    path: "/login",
    name: "Login",
    component: Login
  },
  {
    path: "/signup",
    name: "Signup",
    component: Signup
  },
  {
    path: "/thread/:id",
    name: "Thread",
    component: Thread
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

export default router;