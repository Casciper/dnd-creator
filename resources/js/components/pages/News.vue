<template>
    <h1>News</h1>
    <div v-if="user">News for user {{ user.username }}</div>
    <div v-else>News</div>
</template>

<script>
export default {
    name: "News",
    data() {
        return {}
    },
    computed: {
        user() {
            return this.$store.state.user
        }
    },
}
</script>

<style scoped>

</style>
