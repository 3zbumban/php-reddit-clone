import apiUrl from "./apiUrl";

const comment = async (payload, userId, postId) => {
  const response = await fetch(`${apiUrl}/comment?postId=${postId}&userId=${userId}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json", // todo: wtf?
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
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