import apiUrl from "./apiUrl";
import getToken from "./getToken";

const comment = async (payload, userId, postId) => {
  const response = await fetch(`${apiUrl}/comment?postId=${postId}&userId=${userId}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
      "access-token": getToken()
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