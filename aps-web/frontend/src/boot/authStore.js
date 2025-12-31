import { boot } from 'quasar/wrappers'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'

const authStore = useAuthStore()
export default boot(({ app }) => {
    app.config.globalProperties.$authStore = authStore
})
