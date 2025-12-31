import { defineStore } from 'pinia/dist/pinia'
import { api } from 'boot/axios'

export const useNotificationsStore = defineStore('NotificationStore', {
    state: () => ({
        loading: true,
        notifications: [],
    }),
    actions: {
        async fetchNotifications() {
            this.loading = true
            try {
                const result = await api.get('notifications')
                this.notifications = result.data
            } catch (err) {
            } finally {
                this.loading = false
            }
        },
        setNotifications(notifications) {
            this.notifications = notifications
        },
        async removeNotification(id) {
            this.loading = true
            try {
                await api.delete('notifications/' + id)
                await this.fetchNotifications()
            } catch (err) {
            } finally {
                this.loading = false
            }
        },
    },
})
