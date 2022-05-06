import apiUrl from "./apiUrl.js";
import getToken from "./getToken.js";

const comment = async (payload, userId, postId) => {
  const response = await fetch(`${apiUrl}/comment?postId=${postId}&userId=${userId}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
      "Access-Token": getToken(),
      "Access-Control-Request-Headers": "Access-Token"
    },
    // {
    //   "text": "hi im a comment"
    // }
    body: JSON.stringify(payload)
  });
  return await response.json();
}

export default {
  comment
}