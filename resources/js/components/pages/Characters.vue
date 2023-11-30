<template>
    <h1>Characters</h1>
    <div style="margin-bottom: 20px;">
        List of your characters, <router-link :to="{ name: 'character-create' }">Create new</router-link>
    </div>
    <div>
        <table>
            <thead>
            <tr v-if="characters !== ''">
                <th>ID</th>
                <th>Character name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="character in characters" :key="character.id">
                <td>{{ character.id }}</td>
                <td>{{ character.name }}</td>
                <td><router-link :to="{ name: 'character-edit', params: {id: character.id}}">Edit</router-link> <button @click="remove(character.id)">Remove</button></td>
            </tr>
            <tr>Characters not found for you, <router-link :to="{ name: 'character-create' }">Create new</router-link></tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import dataJson from "../../data.json";
export default {
    name: "Characters",
    data() {
        return {
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        characters() {
            return this.$store.state.user.characters
        }
    },
    mounted() {
        this.$store.dispatch('getCharacters')
    },
    methods: {
        remove(id) {
            this.characters = this.characters.filter(c => c.id !== id)
            if (this.characters.length === 0) {
                this.characters = ''
            }
        }
    }
}
</script>

<style scoped>

</style>
