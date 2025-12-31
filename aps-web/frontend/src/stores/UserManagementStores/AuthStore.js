import { defineStore } from 'pinia'
import { api } from 'boot/axios'
import axios from 'axios'
import { urlFinder } from 'src/lib/helpers'

export const useAuthStore = defineStore('AuthStore', {
    state: () => ({
        token: null,
        user: null,
    }),
    actions: {
        async getToken() {
            await axios.get(urlFinder(true) + 'sanctum/csrf-cookie')
        },
        async login(email, password, remember = false) {
            return await api.post('login', {
                email,
                password,
                remember,
            })
        },
        async getLoggedInUse() {
            const result = await api.get('user')
            this.user = result.data.data
            return result
        },
        async changePassword(old_password, new_password, confirm_password) {
            return api.post('change-password', {
                old_password,
                new_password,
                confirm_password,
            })
        },
        async logout() {
            return api.post('logout')
        },
        isAllowed(permissionKey) {
            if (this.user.id === 1) {
                return true
            } else {
                return this.user.permissions.includes(permissionKey)
            }
        },
    },
})
