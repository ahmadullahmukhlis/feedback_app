<template>
    <slot v-if="show" />
</template>
<script>
import { defineComponent } from 'vue'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { useRouter } from 'vue-router'

export default defineComponent({
    name: 'ProtectedComponent',
    props: {
        onlyAdmin: {
            type: Boolean,
            default: false,
        },
        isPage: {
            type: Boolean,
            default: false,
        },
        forAll: {
            type: Boolean,
            default: false,
        },
        permissionKey: {
            type: String,
            default: '',
        },
    },
    setup() {
        const authStore = useAuthStore()
        const router = useRouter()
        return {
            authStore,
            user: authStore.user,
            router,
        }
    },
    data() {
        return {
            show: false,
        }
    },
    methods: {
        notAllowedPage() {
            if (this.isPage) {
                this.router.push({ path: '/forbidden' })
            } else {
                this.show = false
            }
        },
    },
    mounted() {
        if (this.isPage) {
            try {
                this.authStore.getLoggedInUse()
            } catch (e) {
                errorHandler(e, '', this.router)
            }
        }
        if (this.forAll) {
            this.show = true
        } else {
            if (this.onlyAdmin) {
                if (this.user.id === 1) {
                    this.show = true
                } else {
                    this.notAllowedPage()
                }
            } else {
                if (this.user.id === 1) {
                    this.show = true
                } else {
                    if (this.user.permissions.includes(this.permissionKey)) {
                        this.show = true
                    } else {
                        this.notAllowedPage()
                    }
                }
            }
        }
    },
})
</script>
