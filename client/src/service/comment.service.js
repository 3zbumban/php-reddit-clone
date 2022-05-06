import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const comment = async (payload, userId, postId) => {
  try {
    const response = await fetch(`${apiUrl}/comment?postId=${postId}&userId=${userId}`, {
      method: "POST",
      headers: {
        "Access-Token": getToken(),
        "Access-Control-Request-Headers": "Access-Token"
      },
      body: JSON.stringify(payload)
    });
    return await response.json()
  } catch (e) {
    throw e
  }
}

export default {
  comment
}