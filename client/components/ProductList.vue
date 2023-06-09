<script setup lang="ts">
import { SfButton, SfCheckbox, SfLink } from '@storefront-ui/vue'

const apiUrl = 'http://localhost/scandiweb/api'
const getProducts = async () => {
  try {
    const { data: products, error } = await useFetch(`${apiUrl}/product/list`)
    if (error.value) throw new Error(error.value)
    return products
  } catch(e) {
    console.log(e)
  }
}
let products = await getProducts()

const deleteCheckbox = reactive({})

const deleteProducts = async (toDelete) => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/massDelete?skus=${toDelete}`, {
      method: 'DELETE',
      body: JSON.stringify({"skus": toDelete})
    })
    if (error.value) throw new Error(error.value)
    return product
  } catch(e) {
    console.log(e)
  }
}

const handleSubmit = async () => {
  let deleteSkus = Object.entries(deleteCheckbox)
  deleteSkus = deleteSkus.filter((checkbox) => checkbox[1])
  deleteSkus = deleteSkus.map((checkbox) => checkbox[0])
  deleteSkus = deleteSkus.join(',')

  const deleted = await deleteProducts(deleteSkus)
  if (deleted) {
    console.log(toRaw(deleted.value))
    products = await getProducts()
  }
}
</script>

<template>
  <form class="products" @submit.prevent="handleSubmit">
    <div class="products__header">
      <h1 class="typography-headline-2 my-2 font-bold">Product List</h1>
      <div class="products__actions my-2">
        <SfButton type="button" class="" @click="useNavTo('/product/new')">
          ADD
        </SfButton>
        <SfButton type="submit" class="">
          MASS DELETE
        </SfButton>
      </div>
    </div>
    <hr>
    <div class="products__container">
      <div v-for="product in products" :key="product.id" class="products__item">
        <div class="border border-neutral-200 rounded-md hover:shadow-lg w-[300px] h-full">
          <div class="relative p-4 border-t border-neutral-200">

            <NuxtLink :to="'/product/get?sku='+product.sku" class="absolute inset-0 z-1"></NuxtLink>

            <SfCheckbox type="checkbox" v-model="deleteCheckbox[product.sku]" :value="product.sku" title="MASS DELETE" class="products__checkbox delete-checkbox z-2" />

            <ProductFeatures :product="product" />

          </div>
        </div>
        
      </div>
    </div>
  </form>
</template>

<style lang="scss" scoped>
.products {

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
    justify-content: center;
    flex-wrap: wrap;
  }

  &__item {
    position: relative;
    margin: 1rem;
    text-align: center;
  }

  &__checkbox {
    position: absolute;
    top: 0.25rem;
    left: 0.25rem;
  }
}
</style>
