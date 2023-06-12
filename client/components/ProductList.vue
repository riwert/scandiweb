<script setup lang="ts">
import { SfButton, SfCheckbox } from '@storefront-ui/vue'

const config = useRuntimeConfig()
const apiUrl = config.public.NUXT_API_URL
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
    if (error.value) {
      if (error.value.data && error.value.data.error) {
        messages.error = error.value.data.error
      }

      throw new Error(error.value)
    }
    return product
  } catch(e) {
    console.log(e)
  }
}

const messages = reactive({
  success: '',
  error: '',
})

const resetMessages = () => {
  messages.success = ''
  messages.error = ''
}

const handleSubmit = async () => {
  resetMessages()
  let deleteSkus = Object.entries(deleteCheckbox)
  deleteSkus = deleteSkus.filter((checkbox) => checkbox[1])
  deleteSkus = deleteSkus.map((checkbox) => checkbox[0])
  deleteSkus = deleteSkus.join(',')

  const deleted = await deleteProducts(deleteSkus)
  if (!deleted || !deleted.value) return
  // const deletedRaw = toRaw(deleted.value)
  messages.success = deleted.value.success
  products = await getProducts()
}
</script>

<template>
  <form class="products bg-gray-50" @submit.prevent="handleSubmit">
    <header class="products__header bg-white">
      <h1 class="typography-headline-2 my-2 font-bold">Product List</h1>
      <div class="products__actions my-2">
        <SfButton type="button" class="" @click="useNavTo('/product/new')">
          ADD
        </SfButton>
        <SfButton type="submit" class="">
          MASS DELETE
        </SfButton>
      </div>
      <div v-if="messages.success || messages.error" class="products__message my-2">
        <span v-text="messages.success" class="typography-text-sm font-medium text-green-500"></span>
        <span v-text="messages.error" class="typography-text-sm font-medium text-red-500"></span>
      </div>
    </header>
    <hr>
    <div class="products__container text-neutral-900">
      <div v-for="product in products" :key="product.id" class="products__item bg-white border border-1 border-neutral-200 rounded-md hover:shadow-lg w-[300px] p-4">

        <NuxtLink :to="'/product/get?sku='+product.sku" class="absolute inset-0 z-1" :aria-label="product.name+' for $'+product.price"></NuxtLink>

        <SfCheckbox type="checkbox" v-model="deleteCheckbox[product.sku]" :value="product.sku" title="MASS DELETE" class="products__checkbox delete-checkbox z-2" />

        <ProductDetails :product="product" />

      </div>
    </div>
  </form>
</template>

<style lang="scss" scoped>
.products {
  display: flex;
  flex-direction: column;
  min-height: 100vh;

  &__header {
    padding: 1rem;
    display: flex;
    flex-wrap: wrap;
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

  &__message {
    width: 100%;
    flex-shrink: 0;
    text-align: center;

    @media (min-width: 768px) {
      text-align: right;
    }
  }

  &__container {
    display: flex;
    justify-content: center;
    align-items: stretch;
    flex-direction: row;
    flex-wrap: wrap;
    gap: 1rem;
    padding: 1rem;
  }

  &__item {
    position: relative;
    text-align: center;
  }

  &__checkbox {
    position: absolute;
    top: 0.5rem;
    left: 0.5rem;
  }
}
</style>
