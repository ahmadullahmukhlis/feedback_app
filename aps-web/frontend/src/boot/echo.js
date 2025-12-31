import { boot } from 'quasar/wrappers'
import Echo from 'laravel-echo'
import Pusher from 'pusher-js'
export default boot(({ app }) => {
    const useCurrentRoute = process.env.USE_CURRENT_HOST
    let host = ''
    if (typeof useCurrentRoute !== 'undefined') {
        host = window.location.hostname
    } else {
        host = import.meta.env.VITE_REVERB_HOST
    }

    app.config.globalProperties.Pusher = Pusher
    app.config.globalProperties.$echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: host,
        wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
        wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
        forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
        enabledTransports: ['ws', 'wss'],
    })
})
