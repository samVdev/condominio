import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  // uncomment these lines to containerize
  // server: { 
  //   host: '0.0.0.0',
  //   port: '80'
  //}, 
  
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
  define: {
    'process.env': {
      // comment this line to containerize
      VUE_APP_API_URL: "http://localhost:8000",
      // uncomment this line to containerize
      // VUE_APP_API_URL: "http://api.store.dev.com"
    }
  },
  test: {
    globals: true,
    environment: "jsdom",
  },
})
