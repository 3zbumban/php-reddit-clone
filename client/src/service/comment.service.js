import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";
import AuthError from "./AuthError.js";

const comment = async (payload, userId, postId) => {
  const response = await fetch(`${apiUrl}/comment?postId=${postId}&userId=${userId}`, {
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
  return await response.json()
}

export default {
  comment
}