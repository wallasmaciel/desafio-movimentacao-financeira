import axios, { type AxiosInstance } from "axios"

export default defineNuxtPlugin(nuxtApp => {
  const api = axios.create({
    baseURL: "http://localhost:8000/api",
  })
  api.interceptors.request.use(config => {
      const token = localStorage.getItem("auth_token")
      if (token) 
        config.headers["Authorization"] = `Bearer ${token}`
      // 
      return config;
    },
    Promise.reject
  )

  nuxtApp.provide('axios', api)
})

declare module "#app" {
  interface NuxtApp {
    $axios: AxiosInstance
  }
}