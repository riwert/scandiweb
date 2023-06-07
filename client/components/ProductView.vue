<script setup lang="ts">
import { SfButton } from '@storefront-ui/vue'

const apiUrl = 'http://localhost/scandiweb/api'
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
console.log(route.query.sku)

const product = await getProduct(route.query.sku)
</script>

<template>
  <div class="product">
    <div class="product__header">

      <h1 class="typography-headline-2 my-2 font-bold">Product</h1>

      <div class="product__actions my-2">
        <SfButton type="button" class="" @click="useNavTo('/product/new')">
          ADD
        </SfButton>
        <SfButton type="button" class="" @click="useNavTo('/')">
          LIST
        </SfButton>
      </div>

    </div>
    <hr>
    <div class="product__container">
      <div class="product__item">
        <div class="border border-neutral-200 rounded-md hover:shadow-lg w-full h-full">
          <div class="p-4 border-t border-neutral-200">

            <ProductFeatures :product="product" />

          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped>
.product {

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
  }

  &__item {
    position: relative;
    margin: 1rem;
    width: 100%;
    text-align: center;
  }
}
</style>
