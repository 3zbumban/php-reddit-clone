import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const signup = async (payload) => {
  try {
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
    });

    const json = await response.json()
    if (!response.ok) {
      if (response.code === 401) throw new AuthError(response.error, 401);
      else throw new Error(json.error);
    }
    return json;
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
    });

    const json = await response.json()
    if (!response.ok) {
      if (response.code === 401) throw new AuthError(response.error, 401);
      else throw new Error(json.error);
    }
    return json;
  } catch (e) {
    throw e
  }
}

export default {
  signup,
  login,
  refreshToken
}