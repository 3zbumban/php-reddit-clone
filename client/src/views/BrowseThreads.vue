<template>
<h1>BROWSE THREADS</h1>
<div class="create-thread">
  <form @submit.prevent="createThread">
    <input v-model="newThread.name" type="text" placeholder="thread name..." @submit="">
    <input type="submit" value="create">
  </form>
</div>
<div v-show="!loading">
  <div class="thread-list">
      <div v-for="thrad in threads" class="thread-item">
        <div class="thread-item-title">
          <span @click="() => router.push({ name: 'Thread', params: { id: thrad.Id }})">{{ thrad.Name }}</span>
        </div>
    </div>
  </div>
</div>
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import threadService from '../service/thread.service.js'
import { useRouter } from "vue-router"

defineProps({
  msg: String
})


const router = useRouter()
const count = ref(0)
const threads = ref(false)
const loading = ref(true)
const newThread = ref({
  name:"",
  userId: ""
})

const createThread = async () => {
  console.log('create thread')
  console.log(newThread.value)
}

onMounted(async () => {
  loading.value = true
  const response = await threadService.getAll();
  count.value = threads.length
  threads.value = response.threads
  loading.value = false
})
</script>

<style scoped lang="scss">
.thread-list {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
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

span {
  font-size: 1.5rem;
  font-weight: bold;
  cursor: pointer;
  color: blue;
  &:hover {
    text-decoration: underline;
  }
}
</style>
