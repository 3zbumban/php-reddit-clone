<template>
  <h1>NOT <span style="color: red;">R</span>EDDIT</h1>
  <router-view></router-view>
</template>

<script setup>

</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap');

html, body {
  height: 100vh;
  width: 100vw;
  margin: 0;
  font-family: 'Ubuntu Mono', monospace;
}

#app {
  margin: 0;
  height: 100vh;
  width: 100vw;
  display: flex;
  flex-direction: column;
  overflow: auto;
}

input {
  box-sizing: border-box;
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

