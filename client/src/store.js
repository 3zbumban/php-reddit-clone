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
    authenticate(id, name) {
      this.user.id = id
      this.user.name = name
      this.user.loggedIn = true
    },
    unAuthenticate() {
      this.user.id = ''
      this.user.name = ''
      this.user.loggedIn = false
    },
    async reAuthenticate() {

    }
  },
});