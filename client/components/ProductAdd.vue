<script setup>
const config = useRuntimeConfig()
const apiUrl = config.public.NUXT_API_URL
const addProduct = async () => {
  try {
    const { data: product, error } = await useFetch(`${apiUrl}/product/saveApi`, {
      method: 'POST',
      body: JSON.stringify(newProduct)
    })
    if (error.value?.error) messages.error = error.value.error
    if (error.value?.data?.error) messages.error = error.value.data.error
    if (error.value?.data?.errors) {
      const errors = error.value.data.errors
      Object.keys(errors).forEach((key) => {
        productErrors[key] = errors[key]
      })
    }
    if (error.value) throw new Error(error.value)
    return product
  } catch(e) {
    console.log(e)
  }
}

const newProduct = reactive({
  productType: ''
})

const productErrors = reactive({})

const messages = reactive({
  success: '',
  error: '',
})

const resetMessages = () => {
  messages.success = ''
  messages.error = ''
}

const resetIfNoErrors = () => {
  let allErrors = Object.entries(productErrors)
  allErrors = allErrors.filter((error) => error[1])
  if (!allErrors.length) {
    resetMessages()
  }
}
const resetErrors = (key = '') => {
  if (key) {
    productErrors[key] = ''
    resetIfNoErrors()
  } else {
    Object.keys(productErrors).forEach((key) => {
      productErrors[key] = ''
    })
  }
}

// fallback for testing when programmatically fields changed
const triggerChangeEventForFields = () => {
  const inputFields = document.querySelectorAll('#product_form input')

  for (let i=0; i<inputFields?.length; i++) {
    const inputEvent = new Event('input')
    inputFields[i]?.dispatchEvent(inputEvent)
  }

  const selectFields = document.querySelectorAll('#product_form select')
  for (let i=0; i<selectFields?.length; i++) {
    const changeEvent = new Event('change')
    selectFields[i]?.dispatchEvent(changeEvent)
  }
}

const handleSubmit = async () => {
  resetErrors()
  resetMessages()
  triggerChangeEventForFields()
  const product = await addProduct()
  if (!product || !product.value) return
  if ('success' in toRaw(product.value)) {
    useNavTo('/product/list')
  }
}
</script>

<template>
  <form id="product_form" class="product bg-gray-50" @submit.prevent="handleSubmit">
    <header class="product__header bg-white">
      <h1 class="typography-headline-2 my-2 font-bold">Product Add</h1>
      <div class="product__actions my-2">
        <button type="button" @click="useNavTo('/product/list')" class="btn-secondary">Cancel</button>
        <button type="submit" class="btn-primary">Save</button>
      </div>
      <div v-if="messages.success || messages.error" class="product__message my-2">
        <span v-text="messages.success" class="typography-text-sm font-medium text-positive-700"></span>
        <span v-text="messages.error" class="typography-text-sm font-medium text-negative-700"></span>
      </div>
    </header>
    <hr>
    <div class="product__container text-neutral-900">
      <div class="product__item bg-white max-w-5xl mx-auto w-full h-full border border-1 border-neutral-200 rounded-md hover:shadow-lg">

        <label class="product__label w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">SKU</span>
          <input type="text" id="sku" @input="resetErrors('sku')" v-model="newProduct.sku" class="product__input input" placeholder="SKU" required />
          <span v-if="productErrors.sku" v-text="productErrors.sku" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label class="product__label w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Name</span>
          <input type="text" id="name" @input="resetErrors('name')" v-model="newProduct.name" class="product__input input" placeholder="Name" required />
          <span v-if="productErrors.name" v-text="productErrors.name" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label class="product__label w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Price</span>
          <input type="number" min="0" step=".01" id="price" @input="resetErrors('price')" v-model="newProduct.price" class="product__input input" placeholder="Price in $" required />
          <span v-if="productErrors.price" v-text="productErrors.price" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label class="product__label w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Type switcher</span>
          <span class="relative flex flex-col rounded-md">
            <select id="productType" @change="resetErrors('productType')" v-model="newProduct.productType" class="product__select select" required>
              <option class="text-sm bg-neutral-300 bg-neutral-300 text-sm text-base" value="" selected disabled hidden>Choose product type</option>
              <option>DVD</option>
              <option>Book</option>
              <option>Furniture</option>
            </select>
            <svg xmlns="http://www.w3.org/2000/svg" class="inline-block fill-current w-6 h-6 absolute -translate-y-1 pointer-events-none top-1/3 right-4 transition easy-in-out duration-0.5 text-neutral-500" viewBox="0 0 24 24" data-testid="expand-more"><path d="M17 9.003a.998.998 0 0 0-1.41 0l-3.885 3.876L7.82 9.003a.998.998 0 0 0-1.41 1.411l4.588 4.588a1 1 0 0 0 1.414 0L17 10.414a.997.997 0 0 0 0-1.41Z"></path></svg>
          </span>
          <span v-if="productErrors.productType" v-text="productErrors.productType" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label v-if="newProduct.productType?.toLowerCase() == 'dvd'" class="w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Size</span>
          <input type="number" min="0" step=".01" id="size" @input="resetErrors('size')" v-model="newProduct.size" class="product__input input" placeholder="Size in MB" required />
          <span v-if="productErrors.size" v-text="productErrors.size" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label v-if="newProduct.productType?.toLowerCase() == 'book'" class="w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Weight</span>
          <input type="number" min="0" step=".01" id="weight" @input="resetErrors('weight')" v-model="newProduct.weight" class="product__input input" placeholder="Weight in kg" required />
          <span v-if="productErrors.weight" v-text="productErrors.weight" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label v-if="newProduct.productType?.toLowerCase() == 'furniture'" class="w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Height</span>
          <input type="number" min="0" step=".01" id="height" @input="resetErrors('height')" v-model="newProduct.height" class="product__input input" placeholder="Height in cm" required />
          <span v-if="productErrors.height" v-text="productErrors.height" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label v-if="newProduct.productType?.toLowerCase() == 'furniture'" class="w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Width</span>
          <input type="number" min="0" step=".01" id="width" @input="resetErrors('width')" v-model="newProduct.width" class="product__input input" placeholder="Width in cm" required />
          <span v-if="productErrors.width" v-text="productErrors.width" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <label v-if="newProduct.productType?.toLowerCase() == 'furniture'" class="w-full flex flex-col gap-0.5">
          <span class="typography-text-sm font-medium">Length</span>
          <input type="number" min="0" step=".01" id="length" @input="resetErrors('length')" v-model="newProduct.length" class="product__input input" placeholder="Length in cm" required />
          <span v-if="productErrors.length" v-text="productErrors.length" class="typography-text-sm text-negative-700 font-medium"></span>
        </label>

        <p v-if="newProduct.productType?.toLowerCase() == 'dvd'" class="text-sm text-neutral-500">Please, provide size in MB as decimal number.</p>
        <p v-if="newProduct.productType?.toLowerCase() == 'book'" class="text-sm text-neutral-500">Please, provide weight in kg as decimal number.</p>
        <p v-if="newProduct.productType?.toLowerCase() == 'furniture'" class="text-sm text-neutral-500">Please, provide dimensions in cm as decimal numbers to display all in HxWxL format.</p>

      </div>
    </div>
  </form>
</template>

<style lang="scss" scoped>
.product {
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
    justify-content: flex-start;
    align-items: center;
    flex-direction: column;
    flex-wrap: wrap;
    gap: 1rem;
  }

  &__item {
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    gap: 1rem;
    position: relative;
    padding: 1rem;
    margin: 1rem auto;
    text-align: left;
  }

  &__checkbox {
    position: absolute;
    top: 0.25rem;
    left: 0.25rem;
  }
}
</style>
