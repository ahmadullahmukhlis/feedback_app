<template>
    <q-btn
        :flat="!forPOS"
        :round="!forPOS"
        :loading="notificationStore.loading"
        icon="notifications"
        :outline="forPOS"
        size="small"
        :color="forPOS && 'primary'"
    >
        <q-tooltip>
            {{ $translate('Notifications') }}
        </q-tooltip>
        <q-badge
            floating
            color="red"
            v-if="notificationStore.notifications.length > 0"
        >
            {{
                notificationStore.notifications.length > 10
                    ? '+10'
                    : notificationStore.notifications.length
            }}
        </q-badge>
        <q-menu transition-show="scale" transition-hide="scale">
            <protected-component
                v-for="notification in notificationStore.notifications"
                :key="notification.id"
                :for-all="notification.permissions === 'for-all'"
                :permission-key="notification.permissions"
            >
                <q-list>
                    <q-item
                        clickable
                        v-close-popup
                        @click="handleClick(notification)"
                    >
                        <q-item-section avatar>
                            <q-avatar
                                size="md"
                                :icon="getIcons(notification.model)"
                                :color="findColor(notification.model)"
                                text-color="white"
                            />
                        </q-item-section>
                        <q-item-section>
                            <q-item-label>{{
                                notification.message
                            }}</q-item-label>
                            <q-item-label caption>{{
                                dayjs(notification.created_at).format(
                                    'MMMM DD, YYYY',
                                )
                            }}</q-item-label>
                        </q-item-section>
                    </q-item>
                </q-list>
            </protected-component>
        </q-menu>
    </q-btn>
</template>
<script>
import { defineComponent } from 'vue'
import { useNotificationsStore } from 'stores/notificationStore'
import dayjs from 'dayjs'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'

export default defineComponent({
    name: 'NotificationComponent',
    components: { ProtectedComponent },
    props: ['forPOS'],
    setup() {
        const notificationStore = useNotificationsStore()
        notificationStore.fetchNotifications()
        const generalStore = useGeneralStore()
        return {
            notificationStore,
            dayjs,
            generalStore,
        }
    },
    methods: {
        getIcons(model) {
            switch (model) {
                case 'BackupHistory':
                    return 'settings_backup_restore'
                case 'ProductStockAlert':
                    return 'notifications'
                case 'product-expiration':
                    return 'event_busy'
                case 'near-to-expire':
                    return 'calendar_month'
            }
        },
        findColor(model) {
            switch (model) {
                case 'BackupHistory':
                    return 'primary'
                case 'ProductStockAlert':
                case 'product-expiration':
                    return 'red'
                case 'near-to-expire':
                    return 'warning'
            }
        },
        async handleClick(notification) {
            switch (notification?.model) {
                case 'BackupHistory':
                    this.notificationStore.removeNotification(notification.id)
                    await this.$router.push({ path: '/configurations/backups' })
                    this.generalStore.setUpdateId(notification.subject_id)
                    break

                case 'ProductStockAlert':
                    this.notificationStore.removeNotification(notification.id)
                    await this.$router.push({
                        path:
                            '/product-management/products/' +
                            notification?.subject_id,
                    })
                    this.generalStore.setUpdateId(notification.subject_id)
                    break
                case 'product-expiration':
                    this.notificationStore.removeNotification(notification.id)
                    await this.$router.push({
                        path: '/reporting/product/' + notification?.subject_id,
                    })
                    this.generalStore.setUpdateId(notification.subject_id)
                    break
                case 'near-to-expire':
                    this.notificationStore.removeNotification(notification.id)
                    await this.$router.push({
                        path: '/reporting/product/near_to_expire',
                    })
                    this.generalStore.setUpdateId(notification.subject_id)
                    break
            }
        },
    },
})
</script>
