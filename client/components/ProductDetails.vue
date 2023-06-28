<script setup>
const props = defineProps({
  product: Object
})
</script>

<template>
  <div class="product__features">

    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.sku">{{ product.sku }}</p>
    <p class="block py-2 font-medium typography-text-lg text-neutral-700" v-if="product.name">{{ product.name }}</p>
    <p class="block py-2 font-bold typography-text-lg text-neutral-700" v-if="product.price">${{ useTrimZeros(product.price) }}</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.size && product.productType == 'dvd'">Size: {{ useTrimZeros(product.size) }} MB</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.weight && product.productType == 'book'">Weight: {{ useTrimZeros(product.weight) }} kg</p>
    <p class="block py-2 font-normal typography-text-sm text-neutral-500" v-if="product.height && product.productType == 'furniture'">Dimensions: {{ useTrimZeros(product.height) }}x{{ useTrimZeros(product.width) }}x{{ useTrimZeros(product.length) }} cm</p>

  </div>
</template>

<style lang="scss" scoped>
.product {

  &__features {
    text-align: center;
  }
}
</style>
