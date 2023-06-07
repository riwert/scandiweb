<script setup lang="ts">
import { SfSelect, SfInput, SfButton } from '@storefront-ui/vue'

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
  length: '',
})

const handleSubmit = async () => {
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
      <h1 class="typography-headline-2 my-2 font-bold">Product Add</h1>
      <div class="product__actions my-2">
        <SfButton type="button" @click="useNavTo('/')">
          Cancel
        </SfButton>
        <SfButton type="submit">
          Save
        </SfButton>
      </div>
    </div>
    <hr>
    <div class="product__container p-4 flex gap-4 flex-wrap text-neutral-900">

      <label class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">SKU</span>
        <SfInput type="text" id="sku" v-model="newProduct.sku" class="product__input" placeholder="SKU" required />
      </label>

      <label class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Name</span>
        <SfInput type="text" id="name" v-model="newProduct.name" class="product__input" placeholder="Name" required />
      </label>

      <label class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Price</span>
        <SfInput type="number" min="0" step=".01" id="price" v-model="newProduct.price" class="product__input" placeholder="Price" required />
      </label>

      <label class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Product type</span>
        <SfSelect v-model="newProduct.productType" placeholder="Choose product type" required>
          <option value="dvd">DVD</option>
          <option value="book">Book</option>
          <option value="furniture">Furniture</option>
        </SfSelect>
      </label>

      <label v-if="newProduct.productType == 'dvd'" class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Size</span>
        <SfInput type="number" min="0" step=".01" id="size" v-model="newProduct.size" class="product__input" placeholder="Size" required />
      </label>

      <label v-if="newProduct.productType == 'book'" class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Weight</span>
        <SfInput type="number" min="0" step=".01" id="weight" v-model="newProduct.weight" class="product__input" placeholder="Weight" required />
      </label>

      <label v-if="newProduct.productType == 'furniture'" class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Height</span>
        <SfInput type="number" min="0" step=".01" id="height" v-model="newProduct.height" class="product__input" placeholder="Height" required />
      </label>

      <label v-if="newProduct.productType == 'furniture'" class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Width</span>
        <SfInput type="number" min="0" step=".01" id="width" v-model="newProduct.width" class="product__input" placeholder="Width" required />
      </label>

      <label v-if="newProduct.productType == 'furniture'" class="w-full flex flex-col gap-0.5">
        <span class="typography-text-sm font-medium">Lenght</span>
        <SfInput type="number" min="0" step=".01" id="lenght" v-model="newProduct.length" class="product__input" placeholder="Lenght" required />
        <!-- id with typo lenght instead length to match with spec for testing -->
      </label>

      <p v-if="newProduct.productType == 'dvd'">Please, provide size in MB</p>
      <p v-if="newProduct.productType == 'book'">Please, provide weight in kg</p>
      <p v-if="newProduct.productType == 'furniture'">Please, provide dimensions in HxWxL format</p>

    </div>
  </form>
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
