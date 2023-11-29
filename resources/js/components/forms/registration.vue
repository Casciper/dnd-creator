<template>
    <form action="" @submit.prevent="submit">
        reg
        <label for="username">
            <span>Username</span>
            <input v-model="username" name="username" id="username" type="text">
            <span v-if="v$?.username?.$error" class="error" id="username_error">{{ this.errorRequired }}</span>
        </label>
        <label for="password">
            <span>Password</span>
            <input v-model="password" name="password" id="password" type="password">
            <span v-if="v$?.password?.$error" class="error" id="password_error">{{ this.errorRequired }}</span>
        </label>

        <label for="password">
            <span>Confirm password</span>
            <input v-model="confirm_password" name="confirm_password" id="confirm_password" type="password">
            <span v-if="v$?.confirm_password?.$error || confirm_password_error" class="error" id="confirm_password_required_error">
                {{ this.confirm_password_error ?? this.errorRequired }}
            </span>
        </label>
        <button type="submit">Submit</button>
    </form>
</template>

<script>
import {useVuelidate} from "@vuelidate/core";
import {required} from "@vuelidate/validators";
import dataJson from "../../data.json";

export default {
    name: "registration",
    data() {
        return {
            errorRequired: 'Это поле обязательно',
            confirm_password_error: null,
            username: '',
            password: '',
            confirm_password: '',
        }
    },
    setup() {
        return { v$: useVuelidate() }
    },
    validations() {
        return {
            username: { required },
            password: { required },
            confirm_password: { required }
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
                console.log(dataJson.users.length)
                console.log(dataJson.users)
                if (this.password === this.confirm_password) {
                    const id = dataJson.users.length + 1
                    dataJson.users.push({id: id, username: this.username, password: this.password})
                    this.$store.commit('setUserInfo', {id: id, username: this.username, password: this.password})
                    this.$store.commit('changeAuthenticated')
                    this.$router.push({name: 'home'})
                    console.log(this.$store.state)
                } else {
                    this.confirm_password_error = 'Пароли не совпадают'
                }
            } else {
                console.log(this.v$.$errors)
            }
        }
    }
}
</script>

<style scoped>

</style>
