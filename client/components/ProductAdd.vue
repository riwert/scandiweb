<script setup lang="ts">
const apiUrl = 'http://localhost/scandiweb/api'
const addProduct = async () => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/saveApi`, {
      method: 'POST',
      body: JSON.stringify(newProduct)
    })
    if (error.value) throw new Error(error.value)
    return product
  } catch(e) {
    console.log(e)
  }
}

const newProduct = reactive({
  sku: '',
  name: '',
  price: '',
  productType: '',
  size: '',
  weight: '',
  height: '',
  width: '',
  lenght: '',
})

const handleSubmit = async () => {
  console.log(toRaw(newProduct.value))
  const product = await addProduct()
  if (!product) {
    console.log(product)
    return
  }
  if ('success' in toRaw(product.value)) {
    useNavTo('/')
  }
}
</script>

<template>
  <form id="product_form" class="product" @submit.prevent="handleSubmit">
    <div class="product__header">
      <h1>Product Add</h1>
      <div class="product__actions">
        <button type="button" @click="useNavTo('/')">
          Cancel
        </button>
        <button type="submit">
          Save
        </button>
      </div>
    </div>
    <hr>
    <div class="product__container">

        <input type="text" id="sku" v-model="newProduct.sku" class="product__input" placeholder="SKU" />
        <input type="text" id="name" v-model="newProduct.name" class="product__input" placeholder="Name" />
        <input type="number" min="0" step=".01" id="price" v-model="newProduct.price" class="product__input" placeholder="Price" />
        <select v-model="newProduct.productType">
          <option value="" disabled>Choose product type</option>
          <option value="dvd">DVD</option>
          <option value="book">Book</option>
          <option value="furniture">Furniture</option>
        </select>
        <div v-if="newProduct.productType == 'dvd'">
          <input type="number" min="0" step=".01" id="size" v-model="newProduct.size" class="product__input" placeholder="Size" />
        </div>
        <div v-if="newProduct.productType == 'book'">
          <input type="number" min="0" step=".01" id="weight" v-model="newProduct.weight" class="product__input" placeholder="Weight" />
        </div>
        <div v-if="newProduct.productType == 'furniture'">
          <input type="number" min="0" step=".01" id="height" v-model="newProduct.height" class="product__input" placeholder="Height" />
          <input type="number" min="0" step=".01" id="width" v-model="newProduct.width" class="product__input" placeholder="Width" />
          <input type="number" min="0" step=".01" id="lenght" v-model="newProduct.lenght" class="product__input" placeholder="Lenght" />
        </div>

    </div>
  </form>
</template>

<style lang="scss" scoped>
.product {

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
    flex-direction: column;
    flex-wrap: wrap;
    gap: 1rem;
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
