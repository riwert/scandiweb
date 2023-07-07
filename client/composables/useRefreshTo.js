export const useRefreshTo = async (destination) => {
  return navigateTo(destination, {
    replace: true
  })
}
