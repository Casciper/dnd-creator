<template>
    <h1>Create your own character</h1>
    <form action="" @submit.prevent="submit">
        <div v-if="part === 1">
            ---------------------------------
            <label for="stats">BIO</label>
            ---------------------------------
            <label for="name">Name
                <input v-model="biography.name" type="text" name="name" id="name">
            </label>

            <label for="class">Origin
                <select v-model="biography.origin" name="class" id="class">
                    <option v-for="origin in origins" :key="origin.id" :value="origin.code">{{ origin.name }}</option>
                </select>
            </label>

            <label for="story">Worldview
                <input v-model="biography.worldview" type="text" name="story" id="story">
            </label>

            <label for="story">Growth
                <input v-model="biography.growth" type="text" name="story" id="story">
            </label>

            <label for="story">Weight
                <input v-model="biography.weight" type="text" name="story" id="story">
            </label>

            <label for="story">Age
                <input v-model="biography.age" type="text" name="story" id="story">
            </label>

            <label for="story">Eyes
                <input v-model="biography.eyes" type="text" name="story" id="story">
            </label>

            <label for="story">Skin
                <input v-model="biography.skin" type="text" name="story" id="story">
            </label>

            <label for="story">Hair
                <input v-model="biography.hair" type="text" name="story" id="story">
            </label>

            <label for="race">Race
                <select v-model="biography.race" name="race" id="race">
                    <option v-for="race in races" :key="race.id" :value="race.code">{{ race.name }}</option>
                </select>
            </label>

            <label for="gender">Gender
                <select v-model="biography.gender" name="gender" id="gender">
                    <option v-for="gender in genders" :key="gender.id" :value="gender.code">{{ gender.name }}</option>
                </select>
            </label>

            <label for="class">Class
                <select v-model="biography.chClass" name="class" id="class">
                    <option v-for="chClass in classes" :key="chClass.id" :value="chClass.code">{{
                            chClass.name
                        }}
                    </option>
                </select>
            </label>

            <label for="story">Story
                <textarea v-model="biography.story" type="text" name="story" id="story"></textarea>
            </label>

            <label for="story">Allies and organizations
                <textarea v-model="biography.alliesAndOrganizations" type="text" name="story" id="story"></textarea>
            </label>

            <label for="story">Character traits
                <input v-model="biography.characterTraits" type="text" name="story" id="story">
            </label>

            <label for="story">Ideals
                <input v-model="biography.ideals" type="text" name="story" id="story">
            </label>

            <label for="story">Attachments
                <input v-model="biography.attachments" type="text" name="story" id="story">
            </label>

            <label for="story">Weaknesses
                <input v-model="biography.weaknesses" type="text" name="story" id="story">
            </label>
        </div>

        <div v-if="part === 2" id="part-2">
            ---------------------------------
            <label for="stats">Stats</label>
            <div>choosen data:<br>
                <span>race: {{ this.getRaceData(biography.race).name }}</span><br>
                <span>race stats:</span><br>
                <ul>
                    <li v-for="(value, key) in this.getRaceData(biography.race).data.stats" :key="key">
                        {{ key }}: {{ value }}
                    </li>
                </ul>
                <span>gender: {{ biography.gender }}</span><br>
                <span>class: {{ biography.chClass }}</span><br>
                <span>origin: {{ biography.origin }}</span><br>
                <span>name: {{ biography.name }}</span><br>
            </div>

            <b>Complete to fill your stats by default after saving all features form race, gender and class will be
                added to your character</b><br>

            ---------------------------------
            <label for="stats.strength">
                Strength
                <input v-model="biography.stats.strength" type="number" name="stats.strength" id="stats.strength">
            </label>

            <label for="stats.dexterity">
                Dexterity
                <input v-model="biography.stats.dexterity" type="number" name="stats.dexterity" id="stats.dexterity">
            </label>

            <label for="stats.constitution">
                Constitution
                <input v-model="biography.stats.constitution" type="number" name="stats.constitution"
                       id="stats.constitution">
            </label>

            <label for="stats.intelligence">
                Intelligence
                <input v-model="biography.stats.intelligence" type="number" name="stats.intelligence"
                       id="stats.intelligence">
            </label>

            <label for="stats.wisdom">
                Wisdom
                <input v-model="biography.stats.wisdom" type="number" name="stats.wisdom" id="stats.wisdom">
            </label>

            <label for="stats.charisma">
                Charisma
                <input v-model="biography.stats.charisma" type="number" name="stats.charisma" id="stats.charisma">
            </label>
        </div>

        <button v-if="part > 1" @click="part--" type="button">Prev</button>
        <button v-if="part < 3" @click="nextStage" type="button">Next</button>
        <button v-if="part === 3" type="submit">Create</button>
    </form>

</template>

<script>
import {getCharacterData} from '../../scripts/characterData.js';
import biography from '../../scripts/biography.js';

export default {
    name: "CreateCharacter",
    data() {
        return {
            part: 1,
            character: {},
            genders: '',
            classes: '',
            biography: biography
        }
    },
    computed: {
        user() {
            return this.$store.state.user
        },
        races() {
            return this.$store.state.races
        },
        origins() {
            return this.$store.state.origins
        }
    },
    methods: {
        nextStage() {
            if (this.part === 1) {
                this.character = {
                    ...this.character,
                    ...getCharacterData(this.biography, this.user)
                };
                this.part = 2;
                return;
            }

            if (this.part === 2) {
                this.character.stats = this.biography.stats;
                this.part = 3;
            }
        },
        limitStatValue(stat) {
            this.biography.stats[stat] = this.biography.stats[stat] < 2 ? 2 : this.biography.stats[stat] > 20 ? 20 : this.biography.stats[stat];
        },
        getRaceData(race) {
            console.log()
            return this.$store.state.races.find(r => r.code === race)
        }
    },
    watch: {
        part() {
            if (this.part < 1) {
                this.part = 1
            }
            if (this.part > 3) {
                this.part = 3
            }
        },
        'biography.race': function (newRace, oldRace) {
            if (newRace) {
                this.genders = this.$store.state.races.find(r => r.code === newRace).genders
                this.classes = this.$store.state.races.find(r => r.code === newRace).ch_classes
            }
        },
        'biography.stats.strength': function () {
            this.limitStatValue('strength');
        },
        'biography.stats.dexterity': function () {
            this.limitStatValue('dexterity');
        },
        'biography.stats.constitution': function () {
            this.limitStatValue('constitution');
        },
        'biography.stats.intelligence': function () {
            this.limitStatValue('intelligence');
        },
        'biography.stats.wisdom': function () {
            this.limitStatValue('wisdom');
        },
        'biography.stats.charisma': function () {
            this.limitStatValue('charisma');
        }
    }
}
</script>

<style scoped>
form {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    max-width: 400px;
    margin-bottom: 20px;
}

label {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: flex-start;
    width: 100%;
}
</style>
