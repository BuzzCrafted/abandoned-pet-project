import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite';
import laravel from 'laravel-vite-plugin'
import { wordpressPlugin, wordpressThemeJson } from '@roots/vite-plugin';

const appUrl = process.env.APP_URL ?? 'https://abandonedpetproject.test';

export default defineConfig({
  base: '',
  plugins: [
    tailwindcss(),
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/editor.css',
        'resources/js/editor.js',
      ],
      refresh: true,
      assets: ['resources/images/**', 'resources/fonts/**'],
      // Use Valet TLS certs so the dev server matches the HTTPS WordPress site.
      detectTls: 'abandonedpetproject.test',
    }),

    wordpressPlugin({
      hmr: {
        // Enable/disable HMR (default: true)
        enabled: true,

        // Pattern to match editor entry points (default: /editor/)
        editorPattern: /editor/,

        // Name of the editor iframe element (default: 'editor-canvas')
        iframeName: "editor-canvas",
      },
    }),

    // Generate the theme.json file in the public/build/assets directory
    // based on the Tailwind config and the theme.json file from base theme folder
    wordpressThemeJson({
      partials: ["resources/views/blocks", "resources/styles"],
      disableTailwindColors: false,
      disableTailwindFonts: false,
      disableTailwindFontSizes: false,
      disableTailwindBorderRadius: false,
    }),
  ],
  resolve: {
    alias: {
      '@scripts': '/resources/js',
      '@styles': '/resources/css',
      '@fonts': '/resources/fonts',
      '@images': '/resources/images',
    },
  },
  server: {
    cors: {
      origin: appUrl,
    },
  },
})
