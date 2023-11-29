<template>
<h1>Create your own character</h1>
    <form action="" @submit.prevent="submit">
        <div v-if="part === 1">
            ---------------------------------
            <label for="stats">BIO</label>
            ---------------------------------
            <label for="name">Name
                <input v-model="name" type="text" name="name" id="name">
                <span v-if="v$?.name?.$error" class="error" id="name_error">{{ this.errorRequired }}</span>
            </label>

            <label for="story">Story
                <input v-model="story" type="text" name="story" id="story">
                <span v-if="v$?.story?.$error" class="error" id="story_error">{{ this.errorRequired }}</span>
            </label>


            <label for="race">Race
                <select v-model="race" name="race" id="race">
                    <option v-for="race in races" :key="race.id" :value="race.code">{{ race.name }}</option>
                </select>
                <span v-if="v$?.race?.$error" class="error" id="race_error">{{ this.errorRequired }}</span>
            </label>

            <label for="gender">Gender
                <select v-model="gender" name="gender" id="gender">
                    <option v-for="gender in genders" :key="gender" :value="gender">{{ gender }}</option>
                </select>
                <span v-if="v$?.gender?.$error" class="error" id="gender_error">{{ this.errorRequired }}</span>
            </label>

            <label for="class">Class
                <select v-model="chClass" name="class" id="class">
                    <option v-for="chClass in classes" :key="chClass" :value="chClass">{{ chClass }}</option>
                </select>
                <span v-if="v$?.class?.$error" class="error" id="class_error">{{ this.errorRequired }}</span>
            </label>
        </div>
        <div v-if="part === 2">
            ---------------------------------
            <label for="stats">Stats</label>
            ---------------------------------
            <label for="stats.strength">
                Strength
                <input v-model="stats.strength" type="number" name="stats.strength" id="stats.strength">
                <span v-if="v$?.stats?.strength?.$error" class="error" id="stats.strength_error">{{ this.errorRequired }}</span>
            </label>

            <label for="stats.dexterity">
                Dexterity
                <input v-model="stats.dexterity" type="number" name="stats.dexterity" id="stats.dexterity">
                <span v-if="v$?.stats?.dexterity?.$error" class="error" id="stats.dexterity_error">{{ this.errorRequired }}</span>
            </label>

            <label for="stats.constitution">
                Constitution
                <input v-model="stats.constitution" type="number" name="stats.constitution" id="stats.constitution">
                <span v-if="v$?.stats?.constitution?.$error" class="error" id="stats.constitution_error">{{ this.errorRequired }}</span>
            </label>

            <label for="stats.intelligence">
                Intelligence
                <input v-model="stats.intelligence" type="number" name="stats.intelligence" id="stats.intelligence">
                <span v-if="v$?.stats?.intelligence?.$error" class="error" id="stats.intelligence_error">{{ this.errorRequired }}</span>
            </label>

            <label for="stats.wisdom">
                Wisdom
                <input v-model="stats.wisdom" type="number" name="stats.wisdom" id="stats.wisdom">
                <span v-if="v$?.stats?.wisdom?.$error" class="error" id="stats.wisdom_error">{{ this.errorRequired }}</span>
            </label>

            <label for="stats.charisma">
                Charisma
                <input v-model="stats.charisma" type="number" name="stats.charisma" id="stats.charisma">
                <span v-if="v$?.stats?.charisma?.$error" class="error" id="stats.charisma_error">{{ this.errorRequired }}</span>
            </label>
        </div>

        <button @click="part--" type="button">Prev</button>
        <button @click="part++" type="button">Next</button>
        <button type="submit">Create</button>
    </form>

</template>

<script>
import {useVuelidate} from '@vuelidate/core'
import {required} from '@vuelidate/validators'
import dataJson from '../../data.json'
export default {
    name: "CreateCharacter",
    data() {
        return {
            errorRequired: 'Это поле обязательно',
            name: '',
            story: '',
            race: '',
            gender: '',
            genders: '',
            chClass: '',
            classes: '',
            stats: {
                strength: 10,
                dexterity: 10,
                constitution: 10,
                intelligence: 10,
                wisdom: 10,
                charisma: 10
            },
            part: 1,
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            name: { required },
            story: { required },
            race: { required },
            gender: { required },
            chClass: { required },
            stats: {
                strength: { required },
                dexterity: { required },
                constitution: { required },
                intelligence: { required },
                wisdom: { required },
                charisma: { required }
            }
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        races() {
            return dataJson.races
        },
    },
    methods: {
        submit() {
            this.v$.$touch()
            if (!this.v$.$error) {
                this.v$.$reset()
                dataJson.characters.push({id: dataJson.characters.length + 1, image: '123', name: this.name, parent_id: this.user.id, story: this.story})
                this.$router.push({name: 'user-characters'})
            }
        }
    },
    watch:{
        part() {
            if (this.part < 1) {
                this.part = 1
            }
            if (this.part > 3) {
                this.part = 3
            }
        },
        race(newRace, oldRace) {
            if (newRace) {
                this.genders = dataJson.races.find(r => r.code === newRace).gender
                this.classes = dataJson.races.find(r => r.code === newRace).class
            }

        },
        'stats.strength': function () {
            if (this.stats.strength < 0) {
                this.stats.strength = 0
            }
        },
        'stats.dexterity': function () {
            if (this.stats.dexterity < 0) {
                this.stats.dexterity = 0
            }
        },
        'stats.constitution': function () {
            if (this.stats.constitution < 0) {
                this.stats.constitution = 0
            }
        },
        'stats.intelligence': function () {
            if (this.stats.intelligence < 0) {
                this.stats.intelligence = 0
            }
        },
        'stats.wisdom': function () {
            if (this.stats.wisdom < 0) {
                this.stats.wisdom = 0
            }
        },
        'stats.charisma': function () {
            if (this.stats.charisma < 0) {
                this.stats.charisma = 0
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
