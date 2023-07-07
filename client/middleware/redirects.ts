export default defineNuxtRouteMiddleware((to) => {
  if (to.path === '/') return '/product/list'
  if (to.path === '/products') return '/product/list'
})
