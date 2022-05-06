import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const create = async (payload) => {
  try {
    const response = await fetch(`${apiUrl}/thread`, {
      method: "POST",
      headers: {
        "Access-Token": getToken(),
        "Access-Control-Request-Headers": "Access-Token"
      },
      body: JSON.stringify(payload)
    })

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

const getAll = async () => {
  try {
    const response = await fetch(`${apiUrl}/thread`, {
      method: "GET",
      headers: {}
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
  getAll,
  create
}