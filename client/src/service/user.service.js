import apiUrl from "./apiUrl";

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
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

const refreshToken = async (payload, userId) => {
  const response = await fetch(`${apiUrl}/auth/refresh?userId=${userId}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

export default {
  signup,
  login,
  refreshToken
}