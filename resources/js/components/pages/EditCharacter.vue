<template>
<h1>Create your own character</h1>
    <form action="" @submit.prevent="submit">
        <label for="name">Name
            <input v-model="name" type="text" name="name" id="name">
            <span v-if="v$?.name?.$error" class="error" id="name_error">{{ this.errorRequired }}</span>
        </label>

        <label for="story">Story
            <input v-model="story" type="text" name="story" id="story">
            <span v-if="v$?.story?.$error" class="error" id="story_error">{{ this.errorRequired }}</span>
        </label>
        <button type="submit">Edit</button>
    </form>

</template>

<script>
import {useVuelidate} from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import dataJson from '../../data.json'

export default {
    name: "EditCharacter",
    data() {
        return {
            errorRequired: 'Это поле обязательно',
            name: '',
            story: ''
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            name: { required },
            story: { required }
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
    },
    mounted() {
        this.character = dataJson.characters.find(c => c.id === parseInt(this.$route.params.id))
        this.name = this.character.name
        this.story = this.character.story
    },
    methods: {
        submit() {
            this.v$.$touch()
            if (!this.v$.$error) {
                this.v$.$reset()
                let character = dataJson.characters.find(c => c.id === parseInt(this.$route.params.id))
                character.name = this.name
                character.story = this.story
                this.$router.push({name: 'user-characters'})
            }
        }
    }
}
</script>

<style scoped>
form{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    max-width: 400px;
    margin-bottom: 20px;
}
label{
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    width: 100%;
}
</style>
