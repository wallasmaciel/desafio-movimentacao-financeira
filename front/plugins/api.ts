import axios from "axios"

export default defineNuxtPlugin(nuxtApp => {
  const api = axios.create({
    baseURL: "https://viacep.com.br/ws",
  })
  return {
    provide: {
      api,
    }
  }
})