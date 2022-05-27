<template>
<div class="thread-view">
  <h1 v-if="posts">
    /{{ thread.Name}}
  </h1>
  <div v-show="!loading" class="create-post">
    <form @submit.prevent="createPost">
      <input v-model="newPost.title" type="text" placeholder="post title..." @submit="">
      <textarea v-model="newPost.text" rows="5" cols="60" name="text" placeholder="text..."></textarea>
      <input type="submit" value="create">
    </form>
  </div>
<div class="post-list" v-if="posts.length > 0">
  <div v-show="!loading" v-for="post in posts" class="post">
      <div class="post-title" @click="() => router.push({ name: 'Post', params: { id : post.post.Uid }})">
        {{ post.post.Title }}
      </div>
      <div class="post-text">
        {{ post.post.Text }}
      </div>
      <div class="post-createdAt">
        {{ formatDistance(addHours(parseISO(post.post.Createdat), 2), new Date(), { addSuffix: true }) }}
      </div>
      <div class="post-username">
        {{ post.username }}
      </div>
      <div class="votes">
        <div class="voting">
          <span>👍{{ post.votes.up }}</span>
          <span>👎{{ post.votes.down }}</span>
        </div>
        <div class="voting">
          voting:{{ post.votes.voting }}
        </div>
      </div>
  </div>
</div>
<div v-if="posts && !loading">
  <h2>nothing here yet...</h2>
</div>
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</div>

</template>

<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, useRoute } from "vue-router"
import postService from '../service/post.service.js'
import { parseISO, formatDistance, addHours } from "date-fns"
import { useStore } from "../store.js"
import AuthError from '../service/AuthError.js';

const router = useRouter()
const store = useStore()
const route = useRoute()
const posts = ref(false)
const thread = ref(false)
const loading = ref(true)
const newPost = ref({
  title: "",
  text: "",
  threadId: ""
})

const createPost = async () => {
  loading.value = true
  console.log('create post')
  // console.log(newPost.value)
  // console.log(route.params.id)
  try {
    const response = await postService.create({
      title: newPost.value.title,
      text: newPost.value.text,
      threadUid: route.params.id,
      userUid: store.user.id // todo:
    })
    newPost.value.title = ""
    newPost.value.text = ""
    console.log(response)
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
  console.log('update content')
  loading.value = true
  try {
    const response = await postService.getAll(route.params.id);
    console.log(response)
    posts.value = response.posts
    posts.value.sort((a, b) => {
      return parseISO(b.post.Createdat) - parseISO(a.post.Createdat)
    })
    thread.value = response.thread
  } catch (error) {
    console.log(error)
    posts.value = false
    alert(error.message)
    if (error.message === "Failed to fetch") {
      await router.push({ name: 'Threads' })
    }
  } finally {
    loading.value = false
  }
}

onMounted(async () => {
  await updateContent()
})

</script>

<style scoped lang="scss">
a {
  color: #42b983;
}

.votes {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.voting {
  display: flex;
  flex-direction: row;
  align-items: baseline;
}
.create-post {
  form {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    input, textarea {
      width: 100%;
      margin-bottom: 10px;
      box-sizing: border-box;
    }
  }
}

.post-list {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  margin-top: 5px;
}

.thread-view {
  min-width: 60%;
  // margin: 3rem;
  margin: 1rem 8rem 0 8rem;

}

.post {
  user-select: none;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  border-radius: 5px;
  border: solid black 1px;
  margin-bottom: 5px;
  padding: 5px;
  width: 100%;
  box-sizing: border-box;
  
  // width: max-content;

  .post-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 5px;

    &:hover {
      cursor: pointer;
      text-decoration: underline;
    }
  }

  .post-text {
    border: dashed black 1px;
    padding: 5px;
  }
}
</style>
