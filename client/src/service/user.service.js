import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const signup = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/signup`, {
    method: "POST",
    headers: {},
    body: JSON.stringify(payload)
  });

  const json = await response.json()
  if (!response.ok) {
    if (response.code === 401) throw new AuthError(response.error, 401);
    else throw new Error(json.error);
  }
  return json;
}

const login = async (payload) => {
  const response = await fetch(`${apiUrl}/auth/login`, {
    method: "POST",
    headers: {},
    body: JSON.stringify(payload)
  });

  const json = await response.json()
  if (!response.ok) {
    if (response.code === 401) throw new AuthError(response.error, 401);
    else throw new Error(json.error);
  }
  return json;
}

const refreshToken = async (userId) => {
  const response = await fetch(`${apiUrl}/auth/refresh?userId=${userId}`, {
    method: "POST",
    headers: {
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    }
  });

  const json = await response.json()
  if (!response.ok) {
    if (response.code === 401) throw new AuthError(response.error, 401);
    else throw new Error(json.error);
  }
  return json;
}

export default {
  signup,
  login,
  refreshToken
}