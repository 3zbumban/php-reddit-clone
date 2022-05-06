import { defineStore } from 'pinia'
import useService from "./service/user.service.js"

export const useStore = defineStore('main', {
  state: () => ({
    user: {
      id: '',
      name: '',
      loggedIn: false,
    },
  }),
  actions: {
    authenticate(useUid, username, jwt) {
      this.user.id = useUid
      this.user.name = username
      this.user.loggedIn = true
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
      // const jwt = localStorage.getItem('jwt')
      try {
        const response = await useService.refreshToken(user.id)
        console.log(response)
        this.authenticate(response.userUid, response.username, response.jwt)
      } catch (e) {
        console.log("not authenticated")
      }
    }
  },
});