<script setup lang="ts">
import { SfButton, SfIconHome, SfIconMenu, SfIconAdd } from '@storefront-ui/vue'

const items = [
  {
    label: 'Home',
    info: 'Product List',
    icon: SfIconHome,
    link: '/',
  },
  {
    label: 'Products',
    info: 'Product List',
    icon: SfIconMenu,
    link: '/product/list',
  },
  {
    label: 'Add',
    info: 'New Product',
    icon: SfIconAdd,
    link: '/product/new',
  },
]

const route = useRoute()

const onClickHandler = (itemLink: string) => {
  useNavTo(itemLink)
}

const footerNavRef = ref(null)

const updateFooterHeight = () => {
  const footerHeight = footerNavRef?.value?.offsetHeight
  document.documentElement.style.setProperty('--footer-height', `${footerHeight}px`);
}

onMounted(() => {
  updateFooterHeight()
  window.addEventListener('resize', updateFooterHeight)
})

onUnmounted(() => {
  window.removeEventListener('resize', updateFooterHeight)
})
</script>

<template>
  <footer class="footer">
    <hr>
    <div class="text-center p-4">
      &copy; 2023 <a href="https://revert.pl" title="" target="_blank" rel="noopener">Revert.pl</a>
    </div>
    <nav ref="footerNavRef" class="fixed bottom-0 w-full left-0 flex flex-row items-stretch">
      <SfButton v-for="item in items" :key="item.label" variant="tertiary" :class="[
        'py-1 flex flex-col h-full w-full rounded-none bg-primary-700 text-white font-bold hover:text-white hover:bg-primary-800 active:text-white active:bg-primary-900',
        { 'text-white bg-primary-900': item.link === route.path || item.link+'/' === route.path },
      ]" @click="onClickHandler(item.link)">
        <template #prefix>
          <Component :is="item.icon" />
        </template>
        <span v-html="item.label"></span>
        <small v-if="item.info" v-html="item.info" class="text-sm text-white font-normal leading-none"></small>
      </SfButton>
    </nav>
  </footer>
</template>

<style lang="scss">
.footer {
  padding-bottom: var(--footer-height, 7rem);
}
</style>
