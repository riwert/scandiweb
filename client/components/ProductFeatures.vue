<script setup lang="ts">
const props = defineProps({
  product: Object
})
</script>

<template>
  <div class="product__features">

    <p class="block py-2 font-normal typography-text-sm text-neutral-500">{{ product.sku }}</p>
    <p class="block py-2 font-bold typography-text-lg text-neutral-700">{{ product.name }}</p>
    <p class="block py-2 font-bold typography-text-lg text-neutral-700">${{ product.price }}</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.productType == 'dvd'">Size: {{ product.size }} MB</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.productType == 'book'">Weight: {{ product.weight }} kg</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.productType == 'furniture'">Dimensions: {{ product.height }}x{{ product.width }}x{{ product.length }} cm</p>

  </div>
</template>

<style lang="scss" scoped>
.product {

  &__features {
    text-align: center;
  }
}
</style>
