<template>
    <router-view name="form"/>
    <router-link v-if="showLoginButton" :to="{name: 'login'}">Login</router-link>
    <router-link v-if="showRegistrationButton" :to="{name: 'registration'}">Registration</router-link>
</template>

<script>
export default {
    name: "Auth",
    data() {
        return {}
    },
    computed: {
        showLoginButton() {
            return this.$route.name !== 'login';
        },
        showRegistrationButton() {
            return this.$route.name !== 'registration';
        },
    },
}
</script>

<style>
form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 300px;
}
label {
    display: flex;
    flex-direction: column;
    width: 100%;
    margin-bottom: 10px;
}
</style>
