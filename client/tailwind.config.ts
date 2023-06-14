import type { Config } from 'tailwindcss'
import { tailwindConfig } from '@storefront-ui/vue/tailwind-config'
import sfTypography from '@storefront-ui/typography';
import { SFUICommentOptions } from '@storefront-ui/vue'

export default <Config>{
  presets: [tailwindConfig],
  plugins: [sfTypography],
  content: [
    './**/*.vue',
    './node_modules/@storefront-ui/vue/**/*.{js,mjs}'
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fdf0ef',
          100: '#f9dcdc',
          200: '#f4b6b5',
          300: '#ee9190',
          400: '#e56b6b',
          500: '#dd4746',
          600: '#d63e3d',
          700: '#e04f4f',
          800: '#c42f2e',
          900: '#aa2928',
        }
      },
    },
  },
  sfui: {
    enabled: false
  } as SFUICommentOptions
}
