<script setup lang="ts">
import { SfButton } from '@storefront-ui/vue'

const config = useRuntimeConfig()
const apiUrl = config.public.NUXT_API_URL
const getProduct = async (sku) => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/get?sku=${sku}`)
    if (error.value) throw new Error(error.value)
    return product
  } catch (e) {
    console.log(e)
  }
}

const route = useRoute()
const product = (route.query.sku) ? await getProduct(route.query.sku) : ''
</script>

<template>
  <div class="product bg-gray-50">
    <div class="product__header bg-white">

      <h1 class="typography-headline-2 my-2 font-bold">Product</h1>

      <div class="product__actions my-2">
        <SfButton type="button" class="" @click="useNavTo('/product/new')">
          ADD
        </SfButton>
        <SfButton type="button" class="" @click="useNavTo('/product/list')">
          LIST
        </SfButton>
      </div>

    </div>
    <hr>
    <div class="product__container text-neutral-900">
      <div class="product__item max-w-5xl mx-auto bg-white border border-1 border-neutral-200 rounded-md hover:shadow-lg w-full h-full">

        <ProductDetails :product="product" />

      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.product {
  display: flex;
  flex-direction: column;
  min-height: 100vh;

  &__header {
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    @media (min-width: 768px) {
      justify-content: space-between;
      flex-direction: row;
    }
  }

  &__actions {
    display: flex;
    gap: 1rem;
  }

  &__container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
  }

  &__item {
    position: relative;
    padding: 1rem;
    margin: 1rem;
    text-align: center;
  }
}
</style>
