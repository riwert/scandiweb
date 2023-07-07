export default defineEventHandler((event) => {
  return sendRedirect(event, '/product/list', 307);
})


