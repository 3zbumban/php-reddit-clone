import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const create = async (payload) => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

const getAll = async () => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "GET",
    headers: {
      // "Content-Type": "application/json",
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
    }
  });
  return await response.json();
}

export default {
  getAll,
  create
}