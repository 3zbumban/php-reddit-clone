<template>
  <header-component></header-component>
  <router-view></router-view>
  <!-- <div v-show="loading" class="loading-screen">
    <div class="loader"></div>
  </div> -->
</template>

<script setup>
import { onMounted, ref } from "vue";
import HeaderComponent from "./components/Header.vue";
import { useStore } from "./store.js";

const store = useStore();
const loading = ref(false);

onMounted(async () => {
  loading.value = true;
  await store.reAuthenticate();
  console.log("mounted");
  loading.value = false;
});

</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Oswald:wght@200&display=swap');

.container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
}
.user-form {
  margin-top: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;

  input {
    margin-bottom: 10px;
  }
}

html, body {
  height: 100vh;
  width: 100vw;
  margin: 0;
  font-family: 'Ubuntu Mono', monospace;
}

.loading-screen {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  // height: 100vh;
  // width: 100vw;
  height: 100%;
  width: 100%;
}

.meta-username {
  margin-right: 10px;
  // todo: overrides
  font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
  font-family: 'Oswald', sans-serif;
}

#app {
  margin: 0;
  height: 100vh;
  width: 100vw;
  display: flex;
  flex-direction: column;
  overflow: auto;
  justify-content: flex-start;
  align-items: center;
}

input {
  box-sizing: border-box;
  font-size: 1.5rem;
}

.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

