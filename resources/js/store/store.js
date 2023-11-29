import { createStore } from "vuex";
import mutations from "./mutations";
import actions from "./actions";

export const store = createStore({
    state () {
        return {
            isAuthenticated: false,
            isLoading: false,
            user: {
                id: 1,
                username: "Casciper",
                password: "0504asdasd",
            },
            token: null,
        }
    },
    mutations,
    actions
})
