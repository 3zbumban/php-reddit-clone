import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const create = async (payload) => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "POST",
    headers: {
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    },
    body: JSON.stringify(payload)
  })

  if (!response.ok) {
    throw new Error("Error creating comment");
  }

  return await response.json()
}

const getAll = async () => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "GET",
    headers: {}
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }
  
  return await response.json();
}

export default {
  getAll,
  create
}