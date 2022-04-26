<template>
<h1>BROWSE THREADS</h1>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import threadService from '../service/thread.service.js'

defineProps({
  msg: String
})

const count = ref(0)

onMounted(async () => {
  const threads = await threadService.getAll();
  console.log(threads);
})
</script>

<style scoped>
a {
  color: #42b983;
}
</style>
