import apiUrl from "./apiUrl";

const getAll = async (threadId) => {
  try {
    const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
      method: "GET",
      headers: {
        // "Content-Type": "application/json",
        // "Accept": "application/json",
        // "access-control-request-headers": "Content-Type"
      }
    });
    return await response.json();
  } catch (error) {
    
  }
}

// http://localhost:3030/post/dfd72475-fa80-4377-8981-0a54bb320853

const getOne = async (postId) => {
  try {
    const response = await fetch(`${apiUrl}/post/${postId}`, {
      method: "GET",
      headers: {
        // "Content-Type": "application/json",
        // "Accept": "application/json",
        // "access-control-request-headers": "Content-Type"
      }
    });
    return await response.json();
  } catch (error) {
    throw error;
  }
}

const vote = async (postId, userId, vote) => {
  const response = await fetch(`${apiUrl}/vote?postId=${postId}&userId=${userId}&vote=${vote}`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
    }
  });
  return await response.json();
}

const create = async (payload) => {
  const response = await fetch(`${apiUrl}/post`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json", // todo: wtf?
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
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