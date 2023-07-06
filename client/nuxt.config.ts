// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  // ssr: true,
  // experimental: {
  //   payloadExtraction: false,
  // },
  nitro: {
    preset: 'vercel-edge',
    // prerender: {
    //   crawlLinks: true,
    // },
  },
  devtools: { enabled: true },
  runtimeConfig: {
    NODE_ENV: process.env.NODE_ENV,
    public: {
      NUXT_API_URL: process.env.NUXT_API_URL || '/api',
    },
  },
  // app: {
  //   pageTransition: { name: 'page', mode: 'out-in' },
  // },
  css: [
    '~/assets/scss/styles.scss',
  ],
  modules: [
    '@nuxtjs/tailwindcss',
    '@vite-pwa/nuxt',
    '@vueuse/nuxt',
    '@pinia/nuxt',
    '@pinia-plugin-persistedstate/nuxt',
  ],
  pinia: {
    autoImports: [
      // automatically imports `defineStore`
      'defineStore', // import { defineStore } from 'pinia'
      ['defineStore', 'definePiniaStore'], // import { defineStore as definePiniaStore } from 'pinia'
    ],
  },
  piniaPersistedstate: {
    cookieOptions: {
      sameSite: 'strict',
    },
    storage: 'cookies'
  },
  pwa: {
    registerType: 'autoUpdate',
    strategies: 'generateSW',
    manifest: false,
    workbox: {
      globPatterns: ['**/*.{js,css,jpg,png,svg,ico}'],
      navigateFallback: null,
    },
  },
  vite: {
    server: {
      hmr: {
        protocol: 'ws',
        host: 'localhost',
      },
    },
  },
})
