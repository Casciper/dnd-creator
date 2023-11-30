import { createStore } from "vuex";
import mutations from "./mutations";
import actions from "./actions";

export const store = createStore({
    state () {
        return {
            isAuthenticated: false,
            isLoading: false,
            user: {
                id: null,
                username: null,
                password: null,
                characters: null
            },
            races: null,
            origins: null,
            token: null,
        }
    },
    mutations,
    actions
})
