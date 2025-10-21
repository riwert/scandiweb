<script setup>
const config = useRuntimeConfig()
const apiUrl = config.public.NUXT_API_URL
const getProduct = async (sku) => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/get?sku=${sku}`)
    if (error.value?.error) messages.error = error.value.error
    if (error.value?.data?.error) messages.error = error.value.data.error
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
    <header class="product__header bg-white">

      <h1 class="typography-headline-2 my-2 font-bold">Product</h1>

      <div class="product__actions my-2">
        <button type="button" @click="useNavTo('/product/new')" class="btn-secondary">ADD</button>
        <button type="button" @click="useNavTo('/product/list')" class="btn-secondary">LIST</button>
      </div>

    </header>
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
