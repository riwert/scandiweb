<script setup lang="ts">

</script>

<template>
  <div class="app">
    <NuxtLoadingIndicator />

    <NuxtPage />
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
