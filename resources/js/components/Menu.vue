<template>
<div class="menu">
    <router-link :to="{name: 'home'}">Home</router-link>
    <router-link :to="{name: 'news'}">News</router-link>
    <router-link v-if="user.id === null" :to="{name: 'characters'}">Create character</router-link>
    <router-link v-else :to="{name: 'user-characters'}">Characters</router-link>
    <router-link v-if="user.id === null" :to="{name: 'login'}">Login</router-link>
    <div @click="logout" v-if="user.id !== null" class="menu-item">Logout</div>
</div>
</template>

<script>
export default {
    name: "Menu",
    data() {
        return {

        }
    },
    computed: {
        user() {
            return this.$store.state.user
        }
    },
    methods: {
        logout() {
            this.$store.dispatch('logout');
            this.$router.push({name: 'login'});
        },
    },
}
</script>

<style scoped>
.menu{
    display: flex;
    gap : 10px;
    margin-bottom: 20px;
}
</style>
