import apiUrl from "./apiUrl";

const getAll = async () => {
  try {
    const response = await fetch(`${apiUrl}/thread`, {
      method: "GET",
      headers: {
        // "Content-Type": "application/json", // todo: wtf?
        // "Accept": "application/json",
        // "access-control-request-headers": "Content-Type"
      }
    });
    return await response.json();
  } catch (error) {
    throw error;
  }
}

const create = () => {
  try {
    
  } catch (error) {
    
  }
}

export default {
  getAll,
}