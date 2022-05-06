import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const create = async (payload) => {
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
}

const getAll = async () => {
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
}

export default {
  getAll,
  create
}