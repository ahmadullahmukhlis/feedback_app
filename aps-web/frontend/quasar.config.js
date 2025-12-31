/* eslint-env node */

/*
 * This file runs in a Node context (it's NOT transpiled by Babel), so use only
 * the ES6 features that are supported by your Node version. node.green
 */

// Configuration for your app
// v2.quasar.dev

import { defineConfig } from '#q-app/wrappers'
import path from 'node:path'
import { fileURLToPath } from 'node:url'
import dotenv from 'dotenv'
import VueI18nPlugin from '@intlify/unplugin-vue-i18n/vite'

// Helper for ESM path resolution to maintain __dirname functionality
const __dirname = path.dirname(fileURLToPath(import.meta.url))

export default defineConfig(function (/* ctx */) {
    return {
        eslint: {
            // fix: true,
            // include: [],
            // exclude: [],
            // rawOptions: {},
            warnings: true,
            errors: true,
        },

        // v2.quasar.dev
        // preFetch: true,

        // app boot file (/src/boot)
        // --> boot files are part of "main.js"
        // v2.quasar.dev
        boot: [
            'i18n',
            'axios',
            'auth',
            'translate',
            'echo',
            'generalStore',
            'authStore',
            'print',
        ],

        // v2.quasar.dev#css
        css: ['app.scss', 'index.css'],

        // github.com
        extras: [
            // 'ionicons-v4',
            // 'mdi-v5',
            // 'fontawesome-v6',
            // 'eva-icons',
            // 'themify',
            // 'line-awesome',
            // 'roboto-font-latin-ext', // this or either 'roboto-font', NEVER both!

            'roboto-font', // optional, you are not bound to it
            'material-icons', // optional, you are not bound to it
        ],

        // Full list of options: v2.quasar.dev#build
        build: {
            env: dotenv.config().parsed,
            rtl: true,
            target: {
                browser: [
                    'es2019',
                    'edge88',
                    'firefox78',
                    'chrome87',
                    'safari13.1',
                ],
                node: 'node20',
            },

            vueRouterMode: 'hash', // available values: 'hash', 'history'
            // vueRouterBase,
            // vueDevtools,
            // vueOptionsAPI: false,

            // rebuildCache: true, // rebuilds Vite/linter/etc cache on startup

            // publicPath: '/',
            // analyze: true,
            // env: {},
            // rawDefine: {}
            // ignorePublicFolder: true,
            // minify: false,
            // polyfillModulePreload: true,
            // distDir

            // extendViteConf (viteConf) {},
            // viteVuePluginOptions: {},

            vitePlugins: [
                [
                    VueI18nPlugin,
                    {
                        // if you want to use Vue I18n Legacy API, you need to set `compositionOnly: false`
                        // compositionOnly: false,

                        // if you want to use named tokens in your Vue I18n messages, such as 'Hello {name}',
                        // you need to set `runtimeOnly: false`
                        // runtimeOnly: false,

                        // you need to set i18n resource including paths !
                        include: path.resolve(__dirname, './src/i18n/**'),
                    },
                ],
            ],
        },

        // Full list of options: v2.quasar.dev#devServer
        devServer: {
            // https: true
            open: true, // opens browser window automatically
        },

        // v2.quasar.dev#framework
        framework: {
            config: {},

            // iconSet: 'material-icons', // Quasar icon set
            // lang: 'en-US', // Quasar language pack

            // For special cases outside of where the auto-import strategy can have an impact
            // (like functional components as one of the examples),
            // you can manually specify Quasar components/directives to be available everywhere:
            //
            // components: [],
            // directives: [],

            // Quasar plugins
            plugins: ['Notify', 'Dialog', 'Loading', 'AppFullscreen'],
        },

        // animations: 'all', // --- includes all animations
        // v2.quasar.dev
        animations: [],

        // v2.quasar.dev#property-sourcefiles
        // sourceFiles: {
        //   rootComponent: 'src/App.vue',
        //   router: 'src/router/index',
        //   store: 'src/store/index',
        //   registerServiceWorker: 'src-pwa/register-service-worker',
        //   serviceWorker: 'src-pwa/custom-service-worker',
        //   pwaManifestFile: 'src-pwa/manifest.json',
        //   electronMain: 'src-electron/electron-main',
        //   electronPreload: 'src-electron/electron-preload'
        // },

        // v2.quasar.dev
        ssr: {
            // ssrPwaHtmlFilename: 'offline.html', // do NOT use index.html as name!
            // will mess up SSR

            // extendSSRWebserverConf (esbuildConf) {},
            // extendPackageJson (json) {},

            pwa: false,

            // manualStoreHydration: true,
            // manualPostHydrationTrigger: true,

            prodPort: 3000, // The default port that the production server should use
            // (gets superseded if process.env.PORT is specified at runtime)

            middlewares: [
                'render', // keep this as last one
            ],
        },

        // v2.quasar.dev
        pwa: {
            workboxMode: 'generateSW', // or 'injectManifest'
            injectPwaMetaTags: true,
            swFilename: 'sw.js',
            manifestFilename: 'manifest.json',
            useCredentialsForManifestTag: false,
            // useFilenameHashes: true,
            // extendGenerateSWOptions (cfg) {}
            // extendInjectManifestOptions (cfg) {},
            // extendManifestJson (json) {}
            // extendPWACustomSWConf (esbuildConf) {}
        },

        // Full list of options: v2.quasar.dev
        cordova: {
            // noIosLegacyBuildFlag: true, // uncomment only if you know what you are doing
        },

        // Full list of options: v2.quasar.dev
        capacitor: {
            hideSplashscreen: true,
        },

        // Full list of options: v2.quasar.dev
        electron: {
            // extendElectronMainConf (esbuildConf)
            // extendElectronPreloadConf (esbuildConf)

            // specify the debugging port to use for the Electron app when running in development mode
            inspectPort: 5858,

            bundler: 'packager', // 'packager' or 'builder'

            packager: {
                // github.com
                // OS X / Mac App Store
                // appBundleId: '',
                // appCategoryType: '',
                // osxSign: '',
                // protocol: 'myapp://path',
                // Windows only
                // win32metadata: { ... }
            },

            builder: {
                // www.electron.build

                appId: 'aem-quasar-frontend',
            },
        },

        // Full list of options: v2.quasar.dev
        bex: {
            contentScripts: ['my-content-script'],

            // extendBexScriptsConf (esbuildConf) {}
            // extendBexManifestJson (json) {}
        },
    }
})
