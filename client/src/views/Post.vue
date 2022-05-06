<template>
<!-- <h1>POST</h1> -->
<div class="post-view" v-if="post">
  <div class="post">
    <div class="post-title">
      {{ post.post.Title }}
    </div>
    <div class="post-text">
      {{ post.post.Text }}
    </div>
    <div class="meta">
      <span class="createdat">
        {{ formatDistance(addHours(parseISO(post.post.Createdat), 2), new Date(), { addSuffix: true }) }}
      </span>
      <span class="votes" @click="vote('up')">👍{{ post.votes.up }}</span>
      <span class="votes" @click="vote('down')">👎{{ post.votes.down }}</span>
      <span class="voting">voting: {{ post.votes.voting }}</span>
    </div>
  </div>
  <div class="comments">
    <div class="comments-text">comments:</div>
    <div v-for="comment in post.comments" class="comment">
      <div class="meta">
        <div class="meta-username">{{ comment.user.username }}</div>
        <div class="meta-createdat">{{ formatDistance(addHours(parseISO(comment.createdAt.date), 2), new Date(), { addSuffix: true }) }}</div>
      </div>
      <div class="comment-text">{{ comment.text }}</div>
    </div>
  </div>
  <div class="create-comment">
    <form @submit.prevent="createComment">
      <input v-model="newComment.text" type="text" placeholder="comment..." :disabled="loading">
      <input type="submit" value="comment" :disabled="loading">
    </form>
  </div>
</div>
<div v-show="loading" class="loading-screen">
  <div class="loader"></div>
</div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import postService from '../service/post.service';
import { useRouter, useRoute } from "vue-router"
import { parseISO, formatDistance, addHours } from "date-fns"
import { de } from "date-fns/locale"
import { useStore } from "../store.js";
import commentService from '../service/comment.service';

const router = useRouter()
const route = useRoute()
const post = ref(false)
const store = useStore()
const loading = ref(true)
const newComment = ref({
  text: "",
  postId: "",
  userId: ""
})

const createComment = async () => {
  loading.value = true
  console.log('create comment')
  // console.log(newComment.value)

  try {
    const response = await commentService.comment({
        text: newComment.value.text,
      },
      store.user.id, 
      route.params.id
    ) 
    console.log(response)
  } catch (error) {
    alert(error.message)
  }
  await updateContent()
}

const vote = async (t) => {
  console.log('vote => ' + t)
  // todo auth
  // todo already voted
  loading.value = true
  try {
    const response = await postService.vote(route.params.id, store.user.id, t)  // todo
    console.log(response)
  } catch (error) {
    alert(error.message)  
  }
  await updateContent()
}

const updateContent = async () => {
  loading.value = true
  const response = await postService.getOne(route.params.id);
  // console.log(route.params.id)
  console.log(response)
  post.value = response
  loading.value = false
}

onMounted(async () => {
  await updateContent()
})
</script>

<style scoped lang="scss">
a {
  color: #42b983;
}

.post {
  display: flex;
  flex-direction: column;
  border: solid black 1px;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
  width: 100%;
  /* justify-content: center; */
  /* align-items: center; */
}

.comment-text {
  border: dashed black 1px;
  padding: 5px;
}

.create-comment {
  width: 100%;
  margin-bottom: 10px;
  form {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    align-items: center;
    input {
      width: 100%;
      // margin-top: 10px;
    }

    input[type="text"] {
      width: 100%;
      margin-bottom: 10px;
    }
  }
  border-radius: 5px;
  border: solid black 1px;
  padding: 5px;
  margin-top: 10px;
}

.comments {
  width: 100%;

  .comments-text {
    font-weight: bold;
    margin-bottom: 3px;
  }
}
.post-view {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  min-width: 60%;
  margin-top: 10px;
}

.comment {
  display: flex;
  flex-direction: column;
  border: solid black 1px;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
  width: 100%;
  background-color: bisque;
  box-sizing: border-box;
}

.post-title {
  font-size: 1.5rem;
  font-weight: bold;
}

.meta-createdat {
  margin-right: 10px;
  font-size: 0.8rem;
}
.meta {
  user-select: none;
  display: flex;
  flex-direction: row;
  justify-content: flex-start;
  align-items: baseline;
  span {
    margin-right: 10px;
  }

  .votes {
    padding: 3px;
    border-radius: 5px;
    background-color: antiquewhite;
    &:hover {
      background-color: #42b983;
      cursor: pointer;
    }
  }

  .voting {
    padding: 3px;
    border-radius: 5px;
    background-color: antiquewhite;
  }

  .createdat {
    margin-right: 5rem;
  }
}

.post-text {
  border: dashed black 1px;
  margin: 5px;
  padding: 5px;
}

.createdat {
  font-size: 0.8rem;
  font-style: italic;
  margin-bottom: 5px;
}
</style>
