<template>
    <Menu/>
    <router-view/>
</template>

<script>
import Menu from "./Menu.vue";

export default {
    name: "App",
    components: {Menu}
}
</script>

<style scoped>

</style>
