import apiUrl from "./apiUrl";

const getAll = async (threadId) => {
  try {
    const response = await fetch(`${apiUrl}/post?threadId=${threadId}`, {
      method: "GET",
      headers: {
        // "Content-Type": "application/json", // todo: wtf?
        // "Accept": "application/json",
        // "access-control-request-headers": "Content-Type"
      }
    });
    return await response.json();
  } catch (error) {
    
  }
}

export default {
  getAll,
}