import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const signup = async (payload) => {
  try {
    const response = await fetch(`${apiUrl}/auth/signup`, {
      method: "POST",
      headers: {},
      body: JSON.stringify(payload)
    })
    return await response.json()
  } catch (e) {
    throw e
  }
}

const login = async (payload) => {
  try {
    const response = await fetch(`${apiUrl}/auth/login`, {
      method: "POST",
      headers: {},
      body: JSON.stringify(payload)
    })
    return await response.json()
  } catch (e) {
    throw e
  }
}

const refreshToken = async (userId) => {
  try {
    const response = await fetch(`${apiUrl}/auth/refresh?userId=${userId}`, {
      method: "POST",
      headers: {
        "Access-Token": getToken(),
        "Access-Control-Request-Headers": "Access-Token"
      }
    })
    return await response.json()
  } catch (e) {
    throw e
  }
}

export default {
  signup,
  login,
  refreshToken
}