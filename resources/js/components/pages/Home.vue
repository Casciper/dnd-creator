<template>
    <h1>Home</h1>
    <div v-if="user">Welcome for user {{ user.username }}</div>
    <div v-else>Home</div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {}
    },
    computed: {
        user() {
            return this.$store.state.user
        }
    }
}
</script>

<style scoped>

</style>
