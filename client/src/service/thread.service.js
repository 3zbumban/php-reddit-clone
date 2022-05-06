import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

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
    return await response.json()
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
    return await response.json();
  } catch (e) {
    throw e
  }
}

export default {
  getAll,
  create
}