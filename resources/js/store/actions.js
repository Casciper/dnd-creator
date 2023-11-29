import axios from "axios";
import { store } from './store.js';

const setHeaders = () => {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.token}`
}

const checkUser = ({commit, dispatch}) => {

}

const logout = ({commit}) => {
    commit('changeAuthenticated')
    commit('changeToken', null)
    commit('setUserInfo', {
        id: null,
        username: null,
        password: null
    })
    console.log(store.state)
}

export default {
    checkUser,
    logout,
}