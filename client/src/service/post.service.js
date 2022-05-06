import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const getAll = async (threadId) => {
  const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
    method: "GET",
    headers: {}
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }
  
  return await response.json();
}

const getOne = async (postId) => {
  const response = await fetch(`${apiUrl}/post/${postId}`, {
    method: "GET",
    headers: {}
  });

  if (!response.ok) {
    throw new Error("Error creating comment");
  }

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

  if (!response.ok) {
    if (response.code === 401) throw new AuthError(response.error, 401);
    else throw new Error("Error voting");
  }
  
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

  if (!response.ok) {
    if (response.code === 401) throw new AuthError(response.error, 401);
    else throw new Error("Error voting");
  }
  
  return await response.json();
}

export default {
  getAll,
  getOne,
  create,
  vote
}