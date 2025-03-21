import axios, { type AxiosInstance } from "axios"

export default defineNuxtPlugin(nuxtApp => {
  const api = axios.create({
    baseURL: "http://localhost:8000/api",
  })
  api.interceptors.request.use(config => {
      console.log('request', config)
      const token = localStorage.getItem("auth_token")
      if (token) 
        config.headers["Authorization"] = `Bearer ${token}`
      // 
      return config;
    },
    Promise.reject
  )
  api.interceptors.response.use(response => response, err => {
    if (!!err.response && err.response.status === 401) {
      localStorage.removeItem("auth_token");
      navigateTo("/")
    }
    // 
    return Promise.reject(err)
  })

  nuxtApp.provide('axios', api)
})

declare module "#app" {
  interface NuxtApp {
    $axios: AxiosInstance
  }
}