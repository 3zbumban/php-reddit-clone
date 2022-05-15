<template>
  <div class="header">
    <h1 class="logo" @click="() => router.push({ name: 'Threads'})">NOT <span style="color: red;">R</span>EDDIT</h1>
    <div class="header-end">
      <h2 v-if="!store.user.loggedIn" class="link" @click="() => router.push({ name: 'Login'})">Login</h2>
      <h2 v-if="!store.user.loggedIn" class="link" @click="() => router.push({ name: 'Signup'})">Signup</h2>
      <h2 v-if="store.user.loggedIn" class="link" @click="logout">Logout</h2>
      <h2 v-if="store.user.loggedIn" class="username">{{ store.user.name }}</h2>
    </div>
    <!-- <span class="link" @click="() => router.push({ name: 'Threads'})">Browse Threads</span> -->
    <!-- <span class="link" @click="() => router.push({ name: 'Threads'})">2</span> -->
    <!-- <span class="link" @click="() => router.push({ name: 'Threads'})">3</span> -->
    <!-- <span class="link" @click="() => router.push({ name: 'Threads'})">4</span> -->
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter, useRoute } from "vue-router"
import { useStore } from '../store.js'

const router = useRouter()
const route = useRoute()
const count = ref(0)
const store = useStore()

const logout = () => {
  store.unAuthenticate()
  router.push({ name: 'Threads'})
}
</script>

<style scoped lang="scss">

.logo {
  padding: 5px;
  border-radius: 5px;
  
  &:hover {
    background-color: #99e4c2;
    text-decoration: underline;
    cursor: pointer;
  }
}
.header {
  display: flex;
  flex-direction: row;
  background-color: bisque;
  // justify-content: center;
  justify-content: space-between;
  align-items: baseline;
  width: 100%;
  user-select: none;
  h1 {
    // justify-self: flex-start;
    margin-left: 10px;
    margin-right: 10px;
  }

  .header-end {
    display: flex;
    flex-direction: row;
    // justify-content: flex-end;
    align-items: baseline;

    .link {
      margin-right: 10px;
        padding: 5px;
        border-radius: 5px;
      &:hover {
        background-color: #42b983;
        text-decoration: underline;
        cursor: pointer;
      }
    }

    .username {
      margin-right: 10px;
        padding: 5px;
        border-radius: 5px;
      &:hover {
        // background-color: #42b983;
        text-decoration: underline;
        // cursor: pointer;
      }
    }
    // justify-self: flex-end;
    // margin-right: 10px;
    // margin-left: 10px;
    // margin-top: 10px;
    // margin-bottom: 10px;
    // padding: 10px;
    // border: solid black 1px;
    // border-radius: 5px;
    // background-color: bisque;
    // width: max-content;
  }

  h1 {
    &:first-child {
      &:hover {
        cursor: pointer;
      }
    }
  }
  
  span {
    &:hover {
      text-decoration: underline;
    }
  }

  // .link {
  //   margin-left: 3rem;
  //   cursor: pointer;
  //   color: blue;
  // }
}
</style>
