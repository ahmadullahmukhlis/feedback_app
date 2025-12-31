<template>
    <q-layout
        view="lHh LpR fFf"
        :dir="languageStore.direction"
        :class="languageStore.direction === 'rtl' ? 'text-right' : 'text-left'"
    >
        <div v-if="isLoading" class="h-screen flex items-center justify-center">
            <q-spinner color="primary" size="3rem" />
        </div>
        <span v-else>
            <q-intersection transition="scale" transition-duration="200">
                <q-header
                    v-if="!$route.meta?.disable_layout"
                    elevated
                    class="bg-gradient-to-t to-blue-400 from-blue-600"
                >
                    <q-toolbar class="flex items-center">
                        <q-btn
                            flat
                            dense
                            round
                            icon="menu"
                            aria-label="Menu"
                            @click="toggleLeftDrawer"
                        />

                        <q-toolbar-title>
                            {{
                                languageStore.translate(generalStore.page_title)
                            }}
                        </q-toolbar-title>
                        <notification-component />
                        <language-selector-component />

                        <q-btn size="small" flat round icon="person">
                            <q-tooltip>
                                {{ $translate('Profile') }}
                            </q-tooltip>
                            <q-menu
                                transition-show="scale"
                                transition-hide="scale"
                            >
                                <q-list>
<!--                                    <router-link to="/profile">-->
<!--                                        <q-item-->
<!--                                            clickable-->
<!--                                            v-close-popup-->
<!--                                            @click="onItemClick"-->
<!--                                        >-->
<!--                                            <q-item-section avatar>-->
<!--                                                <q-avatar-->
<!--                                                    size="lg"-->
<!--                                                    icon="person"-->
<!--                                                    color="primary"-->
<!--                                                    text-color="white"-->
<!--                                                />-->
<!--                                            </q-item-section>-->
<!--                                            <q-item-section>-->
<!--                                                <q-item-label>{{-->
<!--                                                    $translate('Profile')-->
<!--                                                }}</q-item-label>-->
<!--                                            </q-item-section>-->
<!--                                        </q-item>-->
<!--                                    </router-link>-->
                                    <q-item
                                        clickable
                                        v-close-popup
                                        @click="changePassword(true)"
                                    >
                                        <q-item-section avatar>
                                            <q-avatar
                                                size="lg"
                                                icon="lock"
                                                color="primary"
                                                text-color="white"
                                            />
                                        </q-item-section>
                                        <q-item-section>
                                            <q-item-label>
                                                {{
                                                    $translate(
                                                        'Change password',
                                                    )
                                                }}
                                            </q-item-label>
                                        </q-item-section>
                                    </q-item>
                                    <q-item
                                        clickable
                                        v-close-popup
                                        @click="logout"
                                    >
                                        <q-item-section avatar>
                                            <q-avatar
                                                size="lg"
                                                icon="logout"
                                                color="primary"
                                                text-color="white"
                                            />
                                        </q-item-section>
                                        <q-item-section>
                                            <q-item-label>{{
                                                $translate('Logout')
                                            }}</q-item-label>
                                        </q-item-section>
                                    </q-item>
                                </q-list>
                            </q-menu>
                        </q-btn>
                    </q-toolbar>
                </q-header>
                <q-drawer
                    v-model="drawer"
                    v-if="!$route.meta?.disable_layout"
                    show-if-above
                    :width="250"
                    :side="languageStore.direction === 'rtl' ? 'right' : 'left'"
                >
                    <q-scroll-area
                        style="
                            height: calc(100% - 150px);
                            margin-top: 150px;
                            border-right: 1px solid #ddd;
                        "
                    >
                        <SideBarLinks />
                    </q-scroll-area>

                    <q-img
                        class="absolute-top"
                        src="~assets/material.png"
                        style="height: 150px"
                    >
                        <div
                            class="absolute top-2 !p-0 !z-50 !right-2 bg-transparent"
                        >
                            <q-icon
                                class="cursor-pointer"
                                name="logout"
                                size="large"
                                @click="logout"
                            />
                        </div>
                        <div class="absolute-bottom bg-transparent">
                            <q-avatar size="56px" class="q-mb-sm">
                                <q-img
                                    :src="
                                        authStore.user.image ||
                                        '~assets/material.png'
                                    "
                                />
                            </q-avatar>
                            <div class="text-weight-bold">
                                {{
                                    authStore.user.first_name +
                                    ' ' +
                                    authStore.user.last_name
                                }}
                            </div>
                            <div class="text-xs">
                                @{{ authStore.user.email }}
                            </div>
                        </div>
                    </q-img>
                </q-drawer>
                <div>
                    <q-page-container>
                        <div
                            v-if="$route?.meta?.breadcrumb?.length > 0"
                            class="bg-white p-3 shadow z-50 border"
                        >
                            <q-breadcrumbs>
                                <q-breadcrumbs-el icon="home" to="/" />
                                <q-breadcrumbs-el
                                    v-for="data in $route.meta.breadcrumb"
                                    :key="data.link"
                                    :to="data.link"
                                    :label="$translate(data.text)"
                                />
                            </q-breadcrumbs>
                        </div>
                        <q-scroll-area
                            :class="
                                !$route.meta?.disable_layout
                                    ? 'h-[93vh]'
                                    : 'h-[100vh]'
                            "
                            :thumb-style="{
                                right: '4px',
                                borderRadius: '5px',
                                width: '5px',
                                opacity: 0.75,
                            }"
                        >
                            <router-view />
                        </q-scroll-area>
                    </q-page-container>
                </div>
            </q-intersection>
        </span>
    </q-layout>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { errorHandler } from 'src/lib/errorHandler'
import { useQuasar } from 'quasar'
import ChangePasswordComponent from 'components/ChangePasswordComponent.vue'
import { useGeneralStore } from 'stores/generalStore'
import SideBarLinks from 'components/SideBarLinks.vue'
import LanguageSelectorComponent from 'components/LanguageSelectorComponent.vue'
import { useLanguageStore } from 'stores/languageStore'
import NotificationComponent from 'components/NotificationComponent.vue'
import { useNotificationsStore } from 'stores/notificationStore'

export default defineComponent({
    name: 'MainLayout',
    components: {
        NotificationComponent,
        LanguageSelectorComponent,
        SideBarLinks,
    },
    data() {
        return {
            isLoading: true,
        }
    },
    setup() {
        const authStore = useAuthStore()
        const generalStore = useGeneralStore()
        const drawer = ref(false)
        const router = useRouter()
        const q = useQuasar()
        const languageStore = useLanguageStore()
        const notificationsStore = useNotificationsStore()
        q.lang.rtl = false
        return {
            drawer,
            toggleLeftDrawer() {
                drawer.value = !drawer.value
            },
            router,
            q,
            authStore,
            generalStore,
            languageStore,
            notificationsStore,
        }
    },
    async mounted() {
        this.$echo
            .private('applicationChannel')
            .listen('UserUpdatedEvent', e => {
                this.authStore.getLoggedInUse()
                if (
                    !e.result?.is_active &&
                    e.result?.user_id === this.authStore.user.id
                ) {
                    this.logoutFunction(e.result.message)
                }
            })
            .listen('NotificationPushedEvent', () => {
                this.$q.notify({
                    message: this.$translate('You have a new notification'),
                    color: 'info',
                    position: 'bottom-left',
                })
                this.notificationsStore.fetchNotifications()
            })
            .listen('LanguageWordUpdateEvent', message => {
                this.languageStore.getLanguageDictionary()
            })
            .listen('NotifyEvent', message => {
                this.$q.notify({
                    message: this.$translate(message?.message),
                    color: message?.color ?? 'green',
                    position: 'bottom-left',
                })
                this.notificationsStore.fetchNotifications()
            })
            .subscribe()

        const language = localStorage.getItem('lang')
        const dir = localStorage.getItem('dir')
        this.languageStore.setLanguage(language ?? 'eng', dir ?? 'ltr')
        try {
            const data = await this.authStore.getLoggedInUse()
            const user = data.data.data
            if (user.change_password) {
                this.changePassword(false)
            }
            if (!user.is_active) {
                await this.logoutFunction('Your account is disabled', 'red')
            }
            this.isLoading = false
        } catch (e) {
            errorHandler(e, '', this.router)
        }
    },
    methods: {
        logout() {
            this.$q
                .dialog({
                    title: 'Confirm',
                    message: 'Do you really want to log out',
                    cancel: true,
                    persistent: true,
                })
                .onOk(async () => {
                    await this.logoutFunction('Logged out successfully')
                })
        },
        logoutFunction: async function (message, color = 'green') {
            this.$q.loading.show({
                message: 'Some important process  is in progress. Hang on...',
            })
            try {
                await this.authStore.logout()
                this.$q.loading.hide()
                this.$q.notify({
                    message: message,
                    color,
                })
                localStorage.removeItem('token')
                await this.router.push({ path: '/login' })
            } catch (e) {
                this.$q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
                this.$q.loading.hide()
            }
            // console.log('>>>> OK')
        },
        changePassword(showCloseButton) {
            this.$q.dialog({
                component: ChangePasswordComponent,
                componentProps: {
                    showCloseButton: showCloseButton,
                },
            })
        },
    },
})
</script>
