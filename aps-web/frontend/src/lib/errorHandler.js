import { useQuasar } from 'quasar'

export const errorHandler = (error, setError, router) => {
    console.log(error)
    const $q = useQuasar()
    switch (error.response?.status) {
        case 422:
            const data = error.response.data?.errors
            const errors = {}
            for (const key in data) {
                if (Array.isArray(data[key])) {
                    errors[key] = data[key].join(' ')
                } else {
                    errors[key] = data[key]
                }
            }

            setError(errors)
            break
        case 401:
            console.log(router)
            router.push('/login')
            break
        case 403:
            window.location.href = '/#/forbidden'
            router.push('/forbidden')
            break
        default:
        /*router.push('/server-error')*/
    }
}
