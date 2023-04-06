import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import type { RouteRecordRaw as ROUTE } from "vue-router";
import App from "./App.vue";
import index from "./components/index.vue";
import newUser from "./components/newUser.vue";
import login from "./components/login.vue";
import "./assets/reset.css";
import 'bootstrap/dist/css/bootstrap.css';
import "bootstrap/dist/js/bootstrap.js";

const routes: ROUTE[] = [
    { path: "/", name: "index", component: index },
    { path: "/newUser", name: "newUser", component: newUser },
    { path: "/login", name: "login", component: login }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes
});

const app = createApp(App);

app.use(router);

app.mount("#app");






