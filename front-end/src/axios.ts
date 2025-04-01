import axios from "axios"


const api = axios.create({
	withCredentials: false
})

api.defaults.baseURL = import.meta.env.VITE_API_URL

api.defaults.headers.common["Accept"] = "application/json"
if (localStorage.getItem("access_token")) {
	api.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem("access_token")}`
}

api.interceptors.response.use(
	response => {
		return response
	},
	error => {
		if (error.response?.status === 401) {
			console.log("erro 401")
			// Remove the token from local storage:
			localStorage.removeItem("access_token")
			// Reset the axios Authorization header:
			axios.defaults.headers.common["Authorization"] = "Bearer"
			// Redirect the user to the login page:
			window.location.href = "/login"
		}
		// console.log(error.response?.status == 423)
		if (error.response?.status == 423) {
			console.log("erro 423")
			window.location.href = "/service-unavailable"
		}

		return Promise.reject(error)
	}
)

export { api }
