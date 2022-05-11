import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

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

    const json = await response.json()
    if (!response.ok) {
      if (response.status === 401) throw new AuthError(response.error, 401);
      else throw new Error(json.error);
    }
    return json;
  } catch (e) {
    throw e
  }
}

export default {
  comment
}