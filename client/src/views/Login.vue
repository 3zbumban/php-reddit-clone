<template>
  <div class="container" v-show="!loading">
    <h1>Login</h1>
    <form @submit.prevent="login" class="user-form">
      <!-- <label>username:</label> -->
      <input v-model="data.username" type="text" placeholder="username">
      <input v-model="data.password" type="password" placeholder="password">
      <!-- <input type="password" placeholder="repeat password"> -->
      <input type="submit" value="Signup">
    </form>
  </div>
    <div v-show="loading" class="container loading-screen">
      <div class="loader"></div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import userService from '../service/user.service';

const count = ref(0)
const loading = ref(false)
const data = ref({
  username: "",
  password: ""
})

const login = async () => {
  loading.value = true
  console.log("Logging in")
  const response = await userService.login(data.value)
  console.log(response)
  loading.value = false
}

</script>

<style scoped lang="scss">
</style>
