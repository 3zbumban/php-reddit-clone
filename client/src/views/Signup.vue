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

const loading = ref(false)
const data = ref({
  username: "",
  password: "",
  passwordRepeat: ""
})

const signup = async () => {
  loading.value = true
  console.log(data.value.password)
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
  }
  loading.value = false  
}

</script>

<style scoped>
a {
  color: #42b983;
}
</style>
