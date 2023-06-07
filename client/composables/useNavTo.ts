export const useNavTo = (destination) => {
  const router = useRouter()
  return router.push(destination)
}
