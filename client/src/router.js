import { createRouter, createWebHashHistory } from "vue-router";
import Login from "./views/Login.vue";
import Thread from "./views/Thread.vue";
import Signup from "./views/Signup.vue";
import BrowseThreads from "./views/BrowseThreads.vue";
import Post from "./views/Post.vue";

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
  {
    path: "/post/:id",
    name: "Post",
    component: Post
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes
});

export default router;