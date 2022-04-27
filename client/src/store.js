import { defineStore } from 'pinia'

export const useStore = defineStore('main', {
  state: () => ({
    user: {
      id: '',
      name: '',
      loggedIn: false,
    },
  }),
  actions: {
    increment() {
      this.counter++
    },
    randomizeCounter() {
      this.counter = Math.round(100 * Math.random())
    },
  },
});