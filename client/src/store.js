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
    async authenticate(user) {
      this.user.id = user.userUid
      this.user.name = user.username
      this.user.loggedIn = true
      const jwt = user.jwt
      console.log(jwt)
      localStorage.setItem('user', JSON.stringify(this.user))
      localStorage.setItem('jwt', jwt)
    },
    unAuthenticate() {
      this.user.id = ''
      this.user.name = ''
      this.user.loggedIn = false
      localStorage.removeItem('user')
      localStorage.removeItem('jwt')
    },
    async reAuthenticate() {
      const user = JSON.parse(localStorage.getItem('user'))
      const jwt = localStorage.getItem('jwt')
      
    }
  },
});