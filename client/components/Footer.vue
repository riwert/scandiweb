<script setup lang="ts">
import { SfButton, SfIconHome, SfIconMenu, SfIconAdd } from '@storefront-ui/vue'

const items = [
  {
    label: 'Home',
    info: 'Redirects to Products',
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
</script>

<template>
  <footer class="bottom-0 w-full left-0 fixed">
    <nav class="flex flex-row items-stretch w-full">
      <SfButton v-for="item in items" :key="item.label" variant="tertiary" :class="[
        'py-1 flex flex-col h-full w-full rounded-none bg-primary-700 text-white font-bold hover:text-white hover:bg-primary-800 active:text-white active:bg-primary-900',
        { 'text-white bg-primary-900': item.link === route.path || item.link+'/' === route.path },
      ]" @click="onClickHandler(item.link)">
        <template #prefix>
          <Component :is="item.icon" />
        </template>
        <span v-html="item.label"></span>
        <small v-if="item.info" v-html="item.info" class="text-xs text-white font-normal leading-none"></small>
      </SfButton>
    </nav>
  </footer>
</template>
