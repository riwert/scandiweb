# Produx

Vanilla PHP OOP API + Nuxt.js v3 client with PWA.

App demo: [produx.vercel.app](https://produx.vercel.app)

## 1. SWAPI - PHP REST API - [/api](api)

- [X] Vanilla PHP (without any framework)
- [X] Composer packages (autoload, phpdotenv)
- [X] OOP approach
- [X] PDO for SQL
- [X] MySQL database [import SQL from produx.sql file](api/database/produx.sql)
- [X] ENV config [set new .env based on .env.example](api/.env.example)
- [X] mod_rewrite [set in .htaccess correct ``RewriteBase /API_DIR``](api/.htaccess)

## 2. Produx - Nuxt.js client - [/client](client)

- [X] Nuxt v3
  - [X] Vue v3
  - [X] Vue Router
  - [X] Vue Meta
  - [X] TS support
  - [X] Composition API with simple syntax & auto imports
  - [X] SPA / SSR / SSR + Hydration/ SSG as rendering options
  - [X] Vite and Nitro
- [X] Pinia as a store for sharing a global state with persistence
- [X] Tailwind CSS v3
- [X] Storefront UI v2
- [X] PWA installable with service worker (workbox) [check manifest.json](client/public/manifest.json)
- [X] ENV config [set new .env based on .env.example](client/.env.example)

## Ad.1 SWAPI screenshot

[!['SWAPI example'](api/swapi-screenshot.png)](api/swapi-screenshot.png "See SWAPI example screenshot")

## Ad.2 Produx screenshot

[!['Produx example'](client/produx-screenshot.jpg)](client/produx-screenshot.jpg "See Produx example screenshot")
