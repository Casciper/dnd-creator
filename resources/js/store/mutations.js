const changeToken = (state, data) => {
    state.token = data
}

const changeAuthenticated = (state) => {
    state.isAuthenticated = !state.isAuthenticated
}

const setUserInfo = (state, data) => {
    state.user.id = data.id;
    state.user.username = data.username;
    state.user.password = data.password;
}

const setRaces = (state, data) => {
    state.races = data
}

const setOrigins = (state, data) => {
    state.origins = data
}

const setCharacters = (state, data) => {
    state.user.characters = data
}

export default {
    changeToken,
    changeAuthenticated,
    setUserInfo,
    setRaces,
    setOrigins,
    setCharacters
}
