<template>
<!-- <h1>BROWSE THREADS</h1> -->
<div v-show="!loading" class="create-thread">
  <form @submit.prevent="createThread">
    <input v-model="newThread.name" type="text" placeholder="thread name..." @submit="">
    <input type="submit" value="create">
  </form>
</div>
<div class="thread-list" v-show="!loading">
  <div 
    v-for="thrad in threads" 
    class="thread-item" 
    @click="() => router.push({ name: 'Thread', params: { id: thrad.Uid }})">
    <div class="thread-item-title">
      <span>{{ thrad.Name }}</span>
    </div>
  </div>
</div>
<div v-if="threads.length === 0 && !loading">
  <h2>nothing here yet...</h2>
</div>
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import threadService from '../service/thread.service.js'
import { useRouter } from "vue-router"
import { useStore } from '../store.js';
import AuthError from '../service/AuthError.js';

const router = useRouter()
const count = ref(0)
const threads = ref(false)
const store = useStore()
const loading = ref(true)
const newThread = ref({
  name: "",
  userId: ""
})

const createThread = async () => {
  loading.value = true
  console.log('create thread')
  // console.log(newThread.value)
  newThread.value.userId = store.user.id || ""
  try {
    const created = await threadService.create(newThread.value)
    console.log(created)
    newThread.value.name = ""
    await updateContent()
  } catch (error) {
    if (error instanceof AuthError) {
      console.log(error.message)
      store.unAuthenticate()
      await router.push({ name: 'Login' })
    } else {
      console.log(error.message)
      alert(error.message)
      await updateContent()
    }
  }
}

const updateContent = async () => {
  loading.value = true
  try {
    const response = await threadService.getAll();
    threads.value = response.threads
    count.value = threads.length
  } catch (error) {
    count.value = 0
    threads.value = []
    console.log(error)
    alert(error.message)
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await updateContent()
})
</script>

<style scoped lang="scss">
.thread-list {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
  justify-content: flex-start;
  flex-wrap: wrap;
  // align-items: center;
}

.thread-item {
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: flex-start;
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 5px;
  border: solid black 1px;
  width: 100%;
  background-color: #f5f5f5;
  box-sizing: border-box;
  cursor: pointer;

  &:hover {
    background-color: #e5e5e5;
  }
}

.create-thread {
  margin-bottom: 10px;
  margin-top: 10px;
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
