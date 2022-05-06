import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const signup = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/signup`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

const login = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/login`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
      // "Access-Token": getToken()
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

const refreshToken = async (userId) => {
  const response = await fetch(`${apiUrl}/auth/refresh?userId=${userId}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    }
  })
  return await response.json()
}

export default {
  signup,
  login,
  refreshToken
}