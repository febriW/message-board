import axios, { type AxiosInstance } from "axios"
import { type Plugin } from "vue"

declare module '@vue/runtime-core' {
  interface ComponentCustomProperties {
     $axios: AxiosInstance
  }
}

const axiosInstance: AxiosInstance = axios.create({
  baseURL: "http://localhost:8000/api/",
  headers: {
    'Access-Control-Allow-Origin': '*',
    'Content-Type': 'application/json',
  },
  timeout: 5000
})

axiosInstance.interceptors.response.use(
  (response: any) => response,
  (error: any) => {
    return Promise.reject(error)
  }
)

export default axiosInstance