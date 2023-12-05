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

            <label v-if="biography.race && this.getRaceData(biography.race).data.race_types !== null" for="race">Sub race
                <select v-model="biography.subRace" name="sub_race" id="sub_race">
                    <option v-for="subRace in this.getRaceData(biography.race).data.race_types" :key="subRace.id" :value="subRace.code">{{ subRace.name }}</option>
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
            <div v-if="biography.race && biography.subRace && getSubRaceData(biography.race, biography.subRace) !== null">choosen data:<br>
                <span>race: {{ getSubRaceData(biography.race, biography.subRace).name }}</span><br>
                <span>race stats:</span><br>
                <ul>
                    <li v-for="(value, key) in getSubRaceData(biography.race, biography.subRace).stats" :key="key">
                        {{ key }}: {{ value }}
                    </li>
                </ul>
                <span>gender: {{ biography.gender }}</span><br>
                <span>class: {{ biography.chClass }}</span><br>
                <span>origin: {{ biography.origin }}</span><br>
                <span>name: {{ biography.name }}</span><br>
            </div>
            <div v-else>
                <span>race: {{ getRaceData(biography.race).name }}</span><br>
                <span>race stats:</span><br>
                <ul>
                    <li v-for="(value, key) in getRaceData(biography.race).data.stats" :key="key">
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
                Strength {{ biography.stats.strength.modifier }}
                <input v-model="biography.stats.strength.value" type="number" name="stats.strength" id="stats.strength">
                <ul>
                    <li v-for="(value, key) in biography.stats.strength.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.strength.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
            </label>

            <label for="stats.dexterity">
                Dexterity {{ biography.stats.dexterity.modifier }}
                <input v-model="biography.stats.dexterity.value" type="number" name="stats.dexterity"
                       id="stats.dexterity">
                <ul>
                    <li v-for="(value, key) in biography.stats.dexterity.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.dexterity.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
            </label>

            <label for="stats.constitution">
                Constitution {{ biography.stats.constitution.modifier }}
                <input v-model="biography.stats.constitution.value" type="number" name="stats.constitution"
                       id="stats.constitution">
                <ul>
                    <li v-for="(value, key) in biography.stats.constitution.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.constitution.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
            </label>

            <label for="stats.intelligence">
                Intelligence {{ biography.stats.intelligence.modifier }}
                <input v-model="biography.stats.intelligence.value" type="number" name="stats.intelligence"
                       id="stats.intelligence">
                <ul>
                    <li v-for="(value, key) in biography.stats.intelligence.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.intelligence.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
            </label>

            <label for="stats.wisdom">
                Wisdom {{ biography.stats.wisdom.modifier }}
                <input v-model="biography.stats.wisdom.value" type="number" name="stats.wisdom" id="stats.wisdom">
                <ul>
                    <li v-for="(value, key) in biography.stats.wisdom.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.wisdom.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
            </label>

            <label for="stats.charisma">
                Charisma {{ biography.stats.charisma.modifier }}
                <input v-model="biography.stats.charisma.value" type="number" name="stats.charisma" id="stats.charisma">
                <ul>
                    <li v-for="(value, key) in biography.stats.charisma.skills" :key="key">
                        <input type="checkbox" :value="key" v-model="biography.stats.charisma.skills[key].isOwns">
                        {{ key }}: {{ value.isOwns ? value.value + ownsBonus : value.value }}
                    </li>
                </ul>
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
import calculateModifier from '../../scripts/calculateModifier.js';
import axios from "axios";

export default {
    name: "CreateCharacter",
    data() {
        return {
            part: 1,
            character: {},
            genders: '',
            classes: '',
            ownsBonus: 2,
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
        calculateModifier,
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
                const characterStats = this.biography.stats;

                let raceStats = this.getRaceData(this.character.race).data.stats;
                if (biography.race && biography.subRace && this.getSubRaceData(biography.race, biography.subRace)) {
                    raceStats = this.getSubRaceData(biography.race, biography.subRace).stats
                } else {
                    raceStats = this.getRaceData(this.character.race).data.stats
                }

                for (const key in raceStats) {
                    if (key in characterStats) {
                        if(parseInt(raceStats[key]) > 0){
                            characterStats[key].value += parseInt(raceStats[key]);
                        }
                    }
                }
                this.character.stats = characterStats;
                setTimeout(() => {
                    for (let stat in this.character.stats) {
                        for (let skill in this.character.stats[stat].skills) {
                            if (this.character.stats[stat].skills[skill].isOwns === true) {
                                this.character.stats[stat].skills[skill].value += this.ownsBonus;
                            }
                        }
                    }

                    console.log(this.character)

                    /*axios.post('/api/add-character', this.character)
                        .then(() => {
                            console.log('success')
                            this.$store.dispatch('getCharacters')
                            this.$router.push({name: 'user-characters'})
                        })*/
                }, 300)
                this.part = 3;
            }
        },
        limitStatValue(stat) {
            this.biography.stats[stat].modifier = calculateModifier(this.biography.stats[stat].value);
            this.biography.stats[stat].value = this.biography.stats[stat].value < 2 ? 2 : this.biography.stats[stat].value > 20 ? 20 : this.biography.stats[stat].value;
        },
        updateSkills(stat, newModifier) {
            for (const key in this.biography.stats[stat].skills) {
                this.biography.stats[stat].skills[key].value = newModifier;
            }
        },
        handleCheckboxChange(stat, skill) {
            if (this.biography.stats[stat].skills[skill].isOwns) {
                this.biography.stats[stat].skills[skill].value += this.ownsBonus;
            } else {
                this.biography.stats[stat].skills[skill].value -= this.ownsBonus;
            }
        },
        getRaceData(race) {
            return this.$store.state.races.find(r => r.code === race)
        },
        getSubRaceData(race, subRace) {
            const currentRace = this.getRaceData(race)
            if (!currentRace.data.race_types) {
                return null
            }
            return this.getRaceData(race).data.race_types.find(r => r.code === subRace)
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
        'biography.stats.strength.value': function () {
            this.limitStatValue('strength');
        },
        'biography.stats.dexterity.value': function () {
            this.limitStatValue('dexterity');
        },
        'biography.stats.constitution.value': function () {
            this.limitStatValue('constitution');
        },
        'biography.stats.intelligence.value': function () {
            this.limitStatValue('intelligence');
        },
        'biography.stats.wisdom.value': function () {
            this.limitStatValue('wisdom');
        },
        'biography.stats.charisma.value': function () {
            this.limitStatValue('charisma');
        },
        'biography.stats.charisma.modifier': function (newModifier) {
            this.updateSkills('charisma', newModifier);
        },
        'biography.stats.strength.modifier': function (newModifier) {
            this.updateSkills('strength', newModifier);
        },
        'biography.stats.dexterity.modifier': function (newModifier) {
            this.updateSkills('dexterity', newModifier);
        },
        'biography.stats.constitution.modifier': function (newModifier) {
            this.updateSkills('constitution', newModifier);
        },
        'biography.stats.intelligence.modifier': function (newModifier) {
            this.updateSkills('intelligence', newModifier);
        },
        'biography.stats.wisdom.modifier': function (newModifier) {
            this.updateSkills('wisdom', newModifier);
        },
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
