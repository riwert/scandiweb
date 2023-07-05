<script setup>
import { SfIconVuestorefront } from '@storefront-ui/vue'
import { useConfigStore } from '../stores/config'

const config = useConfigStore()
const { isFooterActive } = toRefs(config)

const toggleFooter = () => {
  config.setFooterActivity(!config.isFooterActive)
}
</script>

<template>
  <div :data-with-footer="isFooterActive" class="footer-switcher" :class="{'footer-switcher--is-on': isFooterActive}">
    <button @click="toggleFooter" class="btn-secondary bg-white" :title="(isFooterActive) ? 'Hide footer' : 'Show footer'">
      <Component :is="SfIconVuestorefront" class="icon" :class="(isFooterActive) ? 'icon--hide' : 'icon--show'" />
    </button>
  </div>
</template>

<style lang="scss">
.footer-switcher {
  position: fixed;
  z-index: 100;
  right: 1rem;
  bottom: 1rem;

  &--is-on {
    bottom: 7rem;
  }

  .icon--show {
    transform: rotate(180deg);
  }
}
</style>
