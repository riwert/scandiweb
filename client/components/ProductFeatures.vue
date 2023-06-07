<script setup lang="ts">
const props = defineProps({
  product: Object
})
</script>

<template>
  <div class="product__features">

    <p class="block py-2 font-normal leading-5 typography-text-sm text-neutral-700">{{ product.sku }}</p>
    <p class="block py-2 font-medium typography-text-base text-neutral-700">{{ product.name }}</p>
    <p class="block py-2 font-bold typography-text-lg">${{ product.price }}</p>
    <p class="block py-2 font-normal leading-5 typography-text-sm text-neutral-700" v-if="product.productType == 'dvd'">Size: {{ product.size }} MB</p>
    <p class="block py-2 font-normal leading-5 typography-text-sm text-neutral-700" v-if="product.productType == 'book'">Weight: {{ product.weight }} kg</p>
    <p class="block py-2 font-normal leading-5 typography-text-sm text-neutral-700" v-if="product.productType == 'furniture'">Dimensions: {{ product.height }}x{{ product.width }}x{{ product.length }}</p>

  </div>
</template>

<style lang="scss" scoped>
.product {

  &__features {
    text-align: center;
  }
}
</style>
