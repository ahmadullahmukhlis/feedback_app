import { boot } from 'quasar/wrappers'
import { useGeneralStore } from 'stores/generalStore'

const generalStore = useGeneralStore()
export default boot(({ app }) => {
    app.config.globalProperties.$generalStore = generalStore
})
