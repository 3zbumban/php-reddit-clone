import apiUrl from "./apiUrl";

const login = (payload) => {
  try {
    const response = await fetch(`${apiBase}/auth/login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "access-control-request-headers": "Content-Type"
      },
      body: JSON.stringify(payload)
    })
    return await response.json()
  } catch (error) {
    throw error
  }
}

const signup = () => {
  try {
    
  } catch (error) {
    
  }
}

const refreshToken = () => {
  try {
    
  } catch (error) {
    
  }
}