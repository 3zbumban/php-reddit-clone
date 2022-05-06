import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const signup = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/signup`, {
    method: "POST",
    headers: {},
    body: JSON.stringify(payload)
  });

  if (!response.ok) {
    throw new Error("Error signing up");
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
    throw new Error("Error logging in");
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
    if (response.code === 401) throw new AuthError(response.error, 401)
    throw new Error("Error refreshing");
  }

  return await response.json()
}

export default {
  signup,
  login,
  refreshToken
}