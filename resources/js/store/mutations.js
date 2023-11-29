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

export default {
    changeToken,
    changeAuthenticated,
    setUserInfo
}
