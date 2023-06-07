<script setup lang="ts">
const apiUrl = 'http://localhost/scandiweb/api'
const getProducts = async () => {
  try {
    const { data: products, error } = await useFetch(`${apiUrl}/product`)
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
      <h1>Product List</h1>
      <div class="products__actions">
        <button type="button" @click="useNavTo('/product/new')">
          ADD
        </button>
        <button type="submit">
          MASS DELETE
        </button>
      </div>
    </div>
    <hr>
    <div class="products__container">
      <div v-for="product in products" :key="product.id" class="products__item">
        <input type="checkbox" v-model="deleteCheckbox[product.sku]" :value="product.sku" title="MASS DELETE" class="products__checkbox delete-checkbox" />
        <p>{{ product.sku }}</p>
        <p>{{ product.name }}</p>
        <p>${{ product.price }}</p>
        <p v-if="product.productType == 'dvd'">Size: {{ product.size }} MB</p>
        <p v-if="product.productType == 'book'">Weight: {{ product.size }} kg</p>
        <p v-if="product.productType == 'furniture'">Dimensions: {{ product.height }}x{{ product.width }}x{{ product.length }} cm</p>
      </div>
    </div>
  </form>
</template>

<style lang="scss" scoped>
.products {

  &__header {
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
    padding: 1rem;
    margin: 1rem;
    border: 1px solid #ccc;
    text-align: center;
  }

  &__checkbox {
    position: absolute;
    top: 0.25rem;
    left: 0.25rem;
  }
}
</style>
