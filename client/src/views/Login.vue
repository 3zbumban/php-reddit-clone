<template>
  <form action="submit">
    <!-- <label>username:</label> -->
    <input type="text" placeholder="username">
  </form>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  msg: String
})

const count = ref(0)
</script>

<style scoped>
a {
  color: #42b983;
}
</style>
