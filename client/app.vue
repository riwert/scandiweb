<script setup lang="ts">
useServerSeoMeta({
  charset: 'utf-8',
  viewport: 'width=device-width, initial-scale=1',
})

useHead({
  htmlAttrs: {
    lang: 'en',
  },
  title: 'Scandiweb Products',
  meta: [
    { name: 'description', content: 'Mid-senior & Senior Web Developer test assignment in Scandiweb' },
    { name: 'author', content: 'revert@revert.pl' },
    { name: 'theme-color', content: '#dd4746' },
  ],
  link: [
    { rel: 'manifest', href: '/manifest.json' },
    { rel: 'apple-touch-icon', href: '/favicon/apple-touch-icon.png', sizes: '180x180' },
    { rel: 'icon', href: '/favicon/favicon.ico' },
    { rel: 'icon', href: '/favicon/favicon-32x32.png', sizes: '32x32', type: 'image/png' },
    { rel: 'icon', href: '/favicon/favicon-16x16.png', sizes: '16x16', type: 'image/png' },
  ],
  noscript: [
    {
      children: 'JavaScript is required.',
      body: true
    }
  ],
})
</script>

<template>
  <div class="app">
    <NuxtLoadingIndicator />

    <NuxtPage />

    <Footer />
  </div>
</template>

<style lang="scss">
.page-enter-active {
  transition: all 0.15s;
}

.page-leave-active {
  transition: all 0.05s;
}

.page-enter-from,
.page-leave-to {
  opacity: 0;
  filter: blur(0.5rem);
}

.page-enter-to,
.page-leave-from {
  opacity: 1;
  filter: none;
}

// Fix for W3C validation
.nuxt-loading-indicator {
  background-size: auto auto;
}
</style>
