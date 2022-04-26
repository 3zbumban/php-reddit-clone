<template>
<h1>POSTS</h1>
<!-- <div class="create-thread">
  <form @submit.prevent="createThread">
    <input v-model="newThread.name" type="text" placeholder="thread name..." @submit="">
    <input type="submit" value="create">
  </form>
</div> -->
<div v-show="!loading">
  <!-- <div class="thread-list">
      <div v-for="thrad in threads" class="thread-item">
        <div class="thread-item-title">
          <span @click="() => router.push({ name: 'Thread', params: { id: thrad.Id }})">{{ thrad.Name }}</span>
        </div>
    </div>
  </div> -->
</div>
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, useRoute } from "vue-router"
import postService from '../service/post.service.js'

const router = useRouter()
const posts = ref(false)
const loading = ref(true)
const route = useRoute()

onMounted(async () => {
  loading.value = true
  const response = await postService.getAll(route.params.id);
  console.log(response)
  loading.value = false
  // count.value = threads.length
  // posts.value = response.threads
})

</script>

<style scoped>
a {
  color: #42b983;
}
</style>
