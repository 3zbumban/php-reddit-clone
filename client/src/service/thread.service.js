import apiUrl from "./apiUrl";

const create = async (payload) => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "POST",
    headers: {
      // "Content-Type": "application/json",
      // "access-control-request-headers": "Content-Type"
    },
    body: JSON.stringify(payload)
  })
  return await response.json()
}

const getAll = async () => {
  const response = await fetch(`${apiUrl}/thread`, {
    method: "GET",
    headers: {
      // "Content-Type": "application/json", // todo: wtf?
      // "Accept": "application/json",
      // "access-control-request-headers": "Content-Type"
    }
  });
  return await response.json();
}

export default {
  getAll,
  create
}