import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const getAll = async (threadId) => {
  try {
    const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
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

const getOne = async (postId) => {
  try {
    const response = await fetch(`${apiUrl}/post/${postId}`, {
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

const vote = async (postId, userId, vote) => {
  try {
    const response = await fetch(`${apiUrl}/vote?postId=${postId}&userId=${userId}&vote=${vote}`, {
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
  getOne,
  create,
  vote
}