<template>
    <Menu/>
    <router-view/>
</template>

<script>
import Menu from "./Menu.vue";

export default {
    name: "App",
    components: {Menu},
    created() {
       this.$store.dispatch('getRaces')
    }
}
</script>

<style scoped>

</style>
