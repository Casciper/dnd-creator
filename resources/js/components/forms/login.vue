<template>
    <form @submit.prevent="submit()">
        log
        <label for="username">
            <span>Username</span>
            <input v-model="username" name="username" id="username" type="text" @input="this.userNotFound = false">
            <span v-if="v$?.username?.$error" class="error" id="username_error">{{ this.errorRequired }}</span>
        </label>
        <label for="password">
            <span>Password</span>
            <input v-model="password" name="password" id="password" @input="this.userNotFound = false" type="password">
            <span v-if="v$?.password?.$error" class="error" id="password_error">{{ this.errorRequired }}</span>
        </label>
        <span v-if="userNotFound">User not found</span>
        <button type="submit">Submit</button>
    </form>

</template>

<script>
import { useVuelidate } from '@vuelidate/core'
import { required } from '@vuelidate/validators'
import dataJson from '../../data.json'
export default {
    name: "login",
    data() {
        return {
            errorRequired: 'Это поле обязательно',
            username: '',
            password: '',
            userNotFound: false
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            username: { required },
            password: { required }
        }
    },
    created() {
        console.log(this.$store.state)
    },
    methods: {
        submit() {
            this.v$.$touch()
            if (!this.v$.$error) {
                this.v$.$reset()
                let user = dataJson.users.find(u => u.username === this.username && u.password === this.password)
                if (user) {
                    this.$store.commit('setUserInfo', user)
                    this.$store.commit('changeAuthenticated')
                    this.$router.push({name: 'home'})
                    console.log(this.$store.state)
                } else {
                    this.userNotFound = true
                }
            }
        }
    }
}
</script>
