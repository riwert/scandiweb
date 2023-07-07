export const useRefreshTo = async (destination) => {
  const router = useRouter()
  return router.replace(destination)
}
