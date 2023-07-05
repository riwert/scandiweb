export const useCustomStorage = (key, ref) => {

  onBeforeMount(() => {
    const value = localStorage?.getItem(key)
    if (value) ref.value = JSON.parse(value)
  })

  watch (ref, () => {
    localStorage?.setItem(key, JSON.stringify(ref.value))
  })

  return ref.value
}
