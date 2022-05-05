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
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import threadService from '../service/thread.service.js'
import { useRouter } from "vue-router"
import { useStore } from '../store.js';

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
  newThread.value.userId = store.state.user.id
  const created = await threadService.create(newThread.value)
  console.log(created)
  updateContent()
}

const updateContent = async () => {
  loading.value = true
  const response = await threadService.getAll();
  count.value = threads.length
  threads.value = response.threads
  loading.value = false
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

// .loading-screen {
//   display: flex;
//   flex-direction: column;
//   justify-content: center;
//   align-items: center;
//   // height: 100vh;
//   // width: 100vw;
//   height: 100%;
//   width: 100%;
// }

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
