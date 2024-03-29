import axios from "axios";
import { store } from './store.js';

const setHeaders = () => {
    axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.token}`
}
const getRaces = ({commit, dispatch}) => {
    return axios
        .get('/api/get-race')
        .then(response => {
            if (response.data) {
                commit('setRaces', response.data.race)
                commit('setOrigins', response.data.origins)
            }
        })
        .catch(error => {
            console.error(error);
        });
}

const getCharacters = ({commit, dispatch}) => {
    return axios
        .post('/api/get-characters', {user_id: store.state.user.id})
        .then(response => {
            if (response.data) {
                commit('setCharacters', response.data)
            }
        })
        .catch(error => {
            console.error(error);
        });
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
    getRaces,
    getCharacters
}
