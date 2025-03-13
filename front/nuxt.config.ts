// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  compatibilityDate: "2024-11-01",
  devtools: { enabled: true },
  modules: ["vuetify-nuxt-module", "@vee-validate/nuxt"],
  router: {
    options: {
      
    }
  },
  vuetify: {
    moduleOptions: {
      /* module specific options */
    },
    vuetifyOptions: {
      /* vuetify options */
    },
  },
});