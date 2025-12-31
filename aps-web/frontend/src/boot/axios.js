import axios from 'axios'
import { urlFinder } from 'src/lib/helpers'
import { boot } from 'quasar/wrappers'

const api = axios.create({
    baseURL: urlFinder(),
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
})
api.interceptors.request.use(req => {
    const token = localStorage.getItem('token')
    if (typeof token !== 'undefined') {
        req.headers.Authorization = `Bearer ${localStorage.getItem('token')}`
        req.headers.lang = `${localStorage.getItem('lang')}`
    }
    return req
})

export default boot(({ app }) => {
    app.config.globalProperties.$api = api
})

export { api }
