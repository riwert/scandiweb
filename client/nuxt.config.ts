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
  runtimeConfig: {
    NODE_ENV: process.env.NODE_ENV,
    public: {
      NUXT_API_URL: process.env.NUXT_API_URL || '/api',
    },
  },
})
