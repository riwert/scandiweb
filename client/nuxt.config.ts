// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  app: {
    pageTransition: { name: 'page', mode: 'out-in' }
  },
  css: [
    '~/assets/scss/styles.scss',
  ],
  modules: ['@nuxtjs/tailwindcss'],
})
