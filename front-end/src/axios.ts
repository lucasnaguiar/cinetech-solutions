import axios from "axios";

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: false,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json"
  }
});

// Adiciona o token se existir
if (localStorage.getItem("access_token")) {
  api.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem("access_token")}`;
}

api.interceptors.response.use(
  response => response,
  error => {
    if (error.response?.status === 401) {
      localStorage.removeItem("access_token");
      delete api.defaults.headers.common["Authorization"];
      window.location.href = "admin/login";
    }
    if (error.response?.status === 423) {
      window.location.href = "/service-unavailable";
    }
    return Promise.reject(error);
  }
);

export { api };