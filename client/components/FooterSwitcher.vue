<script setup>
import { SfIconVuestorefront } from '@storefront-ui/vue'

const props = defineProps(['withFooter'])
const emit = defineEmits(['click'])

// const activeFooter = localStorage?.getItem('activeFooter') || props.withFooter

const toggleFooter = () => {
  // localStorage?.setItem('activeFooter', activeFooter)
  emit('click', !props.withFooter)
}
</script>

<template>
  <div class="footer-switcher" :class="{'footer-switcher--is-on': props.withFooter}">
    <button @click="toggleFooter" class="btn-secondary bg-white" :title="(props.withFooter) ? 'Hide footer' : 'Show footer'">
      <Component :is="SfIconVuestorefront" class="icon" :class="(props.withFooter) ? 'icon--hide' : 'icon--show'" />
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
