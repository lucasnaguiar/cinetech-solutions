import axios from "axios"

const api = axios.create({
	withCredentials: false
})

api.defaults.baseURL = import.meta.env.VITE_API_URL

api.defaults.headers.common["Accept"] = "application/json"

export { api }