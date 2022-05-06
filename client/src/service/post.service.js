import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const getAll = async (threadId) => {
  try {
    const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
      method: "GET",
      headers: {}
    });
    return await response.json();
  } catch (e) {
    throw e
  }
}

const getOne = async (postId) => {
  try {
    const response = await fetch(`${apiUrl}/post/${postId}`, {
      method: "GET",
      headers: {}
    });
    return await response.json();
  } catch (e) {
    throw e
  }
}

const vote = async (postId, userId, vote) => {
  try {
    const response = await fetch(`${apiUrl}/vote?postId=${postId}&userId=${userId}&vote=${vote}`, {
      method: "POST",
      headers: {
        "Access-Token": getToken(),
        "Access-Control-Request-Headers": "Access-Token"
      }
    });
    return await response.json();
  } catch (e) {
    throw e
  }
}

const create = async (payload) => {
  try {
    const response = await fetch(`${apiUrl}/post`, {
      method: "POST",
      headers: {
        "Access-Token": getToken(),
        "Access-Control-Request-Headers": "Access-Token"
      },
      body: JSON.stringify(payload)
    });
    return await response.json();
  } catch (e) {
    throw e
  }
}

export default {
  getAll,
  getOne,
  create,
  vote
}