export const useConfigStore = defineStore(
  'config',
  () => {

    const activeFooter = ref(false)

    const isFooterActive = computed(() => activeFooter.value)

    function setFooterActivity (value) {
      activeFooter.value = value
    }

    return {
      activeFooter,
      isFooterActive,
      setFooterActivity,
    }
  },
  {
    persist: true,
  },
)
