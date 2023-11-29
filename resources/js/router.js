import {createWebHistory, createRouter} from "vue-router";
import LoginForm from "./components/forms/login.vue";
import RegistrationForm from "./components/forms/registration.vue";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("./components/pages/Home.vue"),
    },
    {
        path: "/news",
        name: "news",
        component: () => import("./components/pages/News.vue"),
    },
    {
        path: "/create-character",
        name: "characters",
        component: () => import("./components/pages/CharactersUnAuth.vue"),
    },
    {
        path: "/characters",
        name: "user-characters",
        component: () => import("./components/pages/Characters.vue"),
    },
    {
        path: "/character/create",
        name: "character-create",
        component: () => import("./components/pages/CreateCharacter.vue"),
    },
    {
        path: "/character/:id/edit",
        name: "character-edit",
        component: () => import("./components/pages/EditCharacter.vue"),
    },
    {
        path: "/auth",
        name: "auth",
        component: () => import("./components/pages/Auth.vue"),
        children: [
            {
                path: "login",
                name: "login",
                components: {
                    form: LoginForm
                }
            },
            {
                path: "registration",
                name: "registration",
                components: {
                    form: RegistrationForm
                }
            }
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
