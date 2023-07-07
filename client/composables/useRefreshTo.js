export const useRefreshTo = (destination) => {
  const router = useRouter()
  return router.push('/').then(() => router.replace(destination))
}
