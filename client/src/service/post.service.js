import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const getAll = async (threadId) => {
  const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
    method: "GET",
    headers: {}
  });
  return await response.json();
}

const getOne = async (postId) => {
  const response = await fetch(`${apiUrl}/post/${postId}`, {
    method: "GET",
    headers: {}
  });
  return await response.json();
}

const vote = async (postId, userId, vote) => {
  const response = await fetch(`${apiUrl}/vote?postId=${postId}&userId=${userId}&vote=${vote}`, {
    method: "POST",
    headers: {
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    }
  });
  return await response.json();
}

const create = async (payload) => {
  const response = await fetch(`${apiUrl}/post`, {
    method: "POST",
    headers: {
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    },
    body: JSON.stringify(payload)
  });
  return await response.json();
}

export default {
  getAll,
  getOne,
  create,
  vote
}