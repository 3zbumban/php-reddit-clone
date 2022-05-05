<template>
  <div class="container" v-show="!loading">
    <h1>Login</h1>
    <form @submit.prevent="login" class="user-form">
      <!-- <label>username:</label> -->
      <input v-model="data.username" type="text" placeholder="username">
      <input v-model="data.password" type="password" placeholder="password">
      <!-- <input type="password" placeholder="repeat password"> -->
      <input type="submit" value="Login">
    </form>
  </div>
    <div v-show="loading" class="container loading-screen">
      <div class="loader"></div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import userService from '../service/user.service.js';
import { useStore } from "../store.js";
import { useRouter } from "vue-router";

const router = useRouter()
const store = useStore()
const loading = ref(false)
const data = ref({
  username: "",
  password: ""
})

const login = async () => {
  loading.value = true
  try {
    console.log("Logging in")
    const response = await userService.login(data.value)
    console.log(response)
    store.authenticate(response.userUid, response.username, response.jwt)
    await router.push({ name: 'Threads' })
  } catch (error) {
    alert(error.error)
  }
  loading.value = false
}

</script>

<style scoped lang="scss">
</style>
