<template>
  <div class="container">
    <h1>Signup</h1>
    <form @submit.prevent="signup" class="user-form">
      <input v-model="data.username" type="text" placeholder="username">
      <input v-model="data.password" type="password" placeholder="password">
      <input v-model="data.passwordRepeat" type="password" placeholder="repeat password">
      <input type="submit" value="Signup">
    </form>
    <div v-show="loading" class="loading-screen">
      <div class="loader"></div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import userService from "../service/user.service.js"
import { useStore } from '../store.js';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter()
const loading = ref(false)
const data = ref({
  username: "",
  password: "",
  passwordRepeat: ""
})

const signup = async () => {
  loading.value = true
  if (data.value.password !== data.value.passwordRepeat || data.value.password.trim() === "" || data.value.username.trim() === "") {
    alert("something went wrong - please check your data again")
    return
  } else {
    console.log("Signing up")
    const response = await userService.signup({
      username: data.value.username,
      password: data.value.password
    })
    console.log(response)
    store.authenticate(response.userUid, response.username, response.jwt)
  }
  loading.value = false
  await router.push({ name: 'Threads' })
}

</script>

<style scoped>
a {
  color: #42b983;
}
</style>
