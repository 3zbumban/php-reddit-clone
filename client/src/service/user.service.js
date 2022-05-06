import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const signup = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/signup`, {
    method: "POST",
    headers: {},
    body: JSON.stringify(payload)
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }
  
  return await response.json()
}

const login = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/login`, {
    method: "POST",
    headers: {},
    body: JSON.stringify(payload)
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }

  return await response.json()
}

const refreshToken = async (userId) => {
  const response = await fetch(`${apiUrl}/auth/refresh?userId=${userId}`, {
    method: "POST",
    headers: {
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    }
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }

  return await response.json()
}

export default {
  signup,
  login,
  refreshToken
}