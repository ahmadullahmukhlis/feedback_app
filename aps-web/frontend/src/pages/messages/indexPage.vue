<template>
    <protected-component permission-key="messaging-system-view-messages">
        <q-intersection transition="fade" class="">
            <div class="bg-gray-50">
                <!-- WhatsApp-like UI -->
                <div class="flex h-screen overflow-hidden">
                    <MessagePeople
                        :onSelect="
                            chat => {
                                url = null
                                selectedChat = chat
                                url = '/messages-admin/' + chat.id
                            }
                        "
                    />

                    <messages-component
                        :selectedChat="selectedChat"
                        :url="url"
                        :key="url"
                    />

                    <!-- Right Side - Chat Area -->
                </div>
            </div>
        </q-intersection>
    </protected-component>
</template>

<script>
import { defineComponent, ref } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'
import MessagePeople from 'pages/messages/MessagePeople.vue'
import MessagesComponent from 'pages/messages/MessagesComponent.vue'

export default defineComponent({
    name: 'IndexPage',
    components: {
        MessagesComponent,
        MessagePeople,
        ProtectedComponent,
    },
    data() {
        return {
            selectedChat: null,
            generalStore: useGeneralStore(),
            url: null,
        }
    },

    mounted() {
        this.generalStore.setActivePage('messages')
        this.generalStore.setPageTitle('Messages page')
    },
})
</script>

<style scoped>
/* Additional custom styles if needed */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e0;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a0aec0;
}

.max-w-2\/3 {
    max-width: 66.666667%;
}
</style>
