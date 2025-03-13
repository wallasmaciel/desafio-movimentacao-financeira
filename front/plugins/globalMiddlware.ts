export default defineNuxtPlugin(() => {
    addRouteMiddleware('auth', (to, from) => {
      if (import.meta.client) {
        const auth = window.localStorage.getItem("auth_token");
        if (auth && to.fullPath.trim() === "/") return navigateTo("/movements");
        if (!auth && to.fullPath.trim() !== "/") return navigateTo("/");
      }
    }, {
        global: true,
    })
})