<script setup>
const config = useRuntimeConfig()
const apiUrl = config.public.NUXT_API_URL

const getProducts = async () => {
  try {
    const { data: products, error } = await useFetch(`${apiUrl}/product/list`)
    if (error.value) throw new Error(error.value)
    return products
  } catch(e) {
    console.log(e)
    return
  }
}

const fetchedProducts = await getProducts()
const productList = ref(toRaw(fetchedProducts.value) || [])

const deleteCheckbox = ref([])

const deleteProducts = async (toDelete) => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/massDelete?skus=${toDelete}`, {
      method: 'DELETE',
      body: JSON.stringify({"skus": toDelete})
    })
    if (error.value) {
      if (error.value.data?.error) {
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

// fallback for testing when programmatically checked checkboxes
const getCheckedCheckboxes = () => {
  const checkboxes = document.getElementsByClassName('checkbox')

  let checkedCheckboxes = []
  for (let i=0; i<checkboxes?.length; i++) {
    if (checkboxes[i].checked) checkedCheckboxes.push(checkboxes[i].value)
  }

  return checkedCheckboxes
}

const handleSubmit = async () => {
  resetMessages()

  let deleteSkus = deleteCheckbox.value.join(',')

  // fallback
  if (!deleteSkus.length) {
    deleteSkus = getCheckedCheckboxes()
    deleteSkus = deleteSkus.join(',')
  }

  const deleted = await deleteProducts(deleteSkus)
  if (!deleted || !deleted.value) return

  messages.success = deleted.value.success

  productList.value = productList.value.filter((product) => !deleteSkus.includes(product.sku))
  const reFetchedProducts = await getProducts()
  productList.value = toRaw(reFetchedProducts.value) || []
  deleteCheckbox.value = []
  deleteSkus = ''

  // refresh for ssr clear dom to pass the test
  refreshNuxtData()
  reloadNuxtApp({
    force: true
  })
  // navigateTo('/products', {
  //   reload: true
  // })
}

const props = defineProps({
  title: String
})
</script>

<template>
  <form class="products bg-gray-50" @submit.prevent="handleSubmit">
    <header class="products__header bg-white">
      <h1 class="typography-headline-2 my-2 font-bold" v-text="title"></h1>
      <div class="products__actions my-2">
        <button type="button" @click="useNavTo('/product/new')" class="btn-secondary">ADD</button>
        <button type="submit" class="btn-primary">MASS DELETE</button>
      </div>
      <div v-if="messages.success || messages.error" class="products__message my-2">
        <span v-text="messages.success" class="typography-text-sm font-medium text-positive-700"></span>
        <span v-text="messages.error" class="typography-text-sm font-medium text-negative-700"></span>
      </div>
    </header>
    <hr>
    <div class="products__container text-neutral-900">
      <div v-for="product in productList" :key="product.sku" class="products__item bg-white border border-1 border-neutral-200 rounded-md hover:shadow-lg w-[300px] p-4">

        <NuxtLink :to="'/product/get?sku='+product.sku" class="absolute inset-0 z-1" :aria-label="product.name+' for $'+product.price"></NuxtLink>

        <input type="checkbox" v-model="deleteCheckbox" :value="product.sku" title="Select for MASS DELETE" class="products__checkbox delete-checkbox checkbox z-2" />

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
