<template>
    <div class="flex flex-col flex-1 h-full">
        <!-- Chat Header -->
        <div
            v-if="selectedChat"
            class="flex items-center justify-between px-4 py-3 bg-white border-b border-gray-200"
        >
            <div class="flex items-center">
                <div class="relative">
                    <div class="w-10 h-10 mr-3 overflow-hidden rounded-full">
                        <img
                            :src="selectedChat?.image"
                            class="object-cover w-full h-full"
                        />
                    </div>
                    <div
                        v-if="selectedChat?.message.online"
                        class="absolute bottom-0 right-2 w-2.5 h-2.5 bg-green-500 rounded-full border-2 border-white"
                    ></div>
                </div>
                <div>
                    <h6 class="font-semibold text-gray-800 !my-0">
                        {{ selectedChat.first_name }}
                        {{ selectedChat.last_name }}
                    </h6>
                    <p class="text-xs text-green-500 !my-0">
                        {{
                            selectedChat?.message.online
                                ? 'online'
                                : 'last seen recently'
                        }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div
            v-if="selectedChat"
            class="flex-1 overflow-y-auto bg-[url('https://web.whatsapp.com/img/bg-chat-tile-dark_a4be512e7195b6b733d9110b408f075d.png')] bg-gray-100 bg-opacity-90"
            ref="messagesContainer"
        >
            <server-data
                :url="url"
                v-slot="{ data: messages }"
                id="messages"
                @loaded="handleMessagesLoaded"
            >
                <div class="p-4 space-y-4">
                    <!-- Date Separator -->

                    <!-- Empty state -->

                    <div v-if="messages.length > 0">
                        <div v-for="chat in messages" :key="chat.id">
                            <!-- Received Message -->
                            <div
                                class="flex items-end my-1 space-x-2"
                                v-if="!chat.is_admin"
                            >
                                <div
                                    class="flex-shrink-0 w-6 h-6 overflow-hidden rounded-full"
                                >
                                    <img
                                        :src="selectedChat?.image"
                                        class="object-cover w-full h-full"
                                    />
                                </div>
                                <div
                                    class="max-w-lg px-4 py-2 bg-white rounded-bl-none shadow-sm rounded-2xl"
                                >
                                    <img
                                        v-if="chat.imagePath"
                                        :src="chat.imagePath"
                                        class="max-w-full mt-2 rounded-md"
                                    />
                                    <p class="text-gray-800 break-words">
                                        {{ chat.message }}
                                    </p>
                                    <p
                                        class="mt-1 text-xs text-right text-gray-500"
                                    >
                                        {{ formatTime(chat.created_at) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Sent Message -->
                            <div
                                class="flex items-end justify-end my-1 space-x-2"
                                v-else
                            >
                                <div
                                    class="max-w-lg px-4 py-2 bg-green-100 rounded-br-none shadow-sm rounded-2xl"
                                >
                                    admin@gmail.com
                                    <p class="text-gray-800 break-words">
                                        {{ chat.message }}
                                    </p>
                                    <p
                                        class="flex items-center justify-end mt-1 space-x-1 text-xs text-right text-gray-500"
                                    >
                                        <span>{{
                                            formatTime(chat.created_at)
                                        }}</span>
                                        <svg
                                            class="w-4 h-4 text-gray-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            />
                                        </svg>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </server-data>
        </div>

        <!-- Message Input -->
        <div v-if="selectedChat" class="p-4 bg-white border-t border-gray-200">
            <protected-component
                permission-key="messaging-system-message-response"
            >
                <div class="flex items-center space-x-2">
                    <input
                        v-model="newMessage"
                        @keyup.enter="sendMessage"
                        type="text"
                        placeholder="Type a message"
                        class="flex-1 px-4 py-2 bg-gray-100 border-none rounded-full focus:ring-2 focus:ring-green-500 focus:outline-none"
                    />
                    <button
                        @click="sendMessage"
                        :disabled="!newMessage?.trim()"
                        :class="[
                            'p-2 rounded-full transition-colors',
                            newMessage?.trim()
                                ? 'bg-green-500 hover:bg-green-600'
                                : 'bg-gray-300',
                        ]"
                    >
                        <svg
                            class="w-5 h-5 text-white"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </div>
            </protected-component>
        </div>

        <!-- Empty State -->
        <div v-else class="flex items-center justify-center flex-1 bg-gray-50">
            <div class="p-8 text-center">
                <div class="w-32 h-32 mx-auto mb-6">
                    <svg
                        class="w-full h-full text-gray-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                        />
                    </svg>
                </div>
                <h3 class="mb-2 text-xl font-semibold text-gray-700">
                    Select a chat
                </h3>
                <p class="text-gray-500">
                    Choose a conversation from the list to start messaging
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import ServerData from 'components/ServerData.vue'
import { api } from 'boot/axios'
import { useGeneralStore } from 'stores/generalStore'
import authStore from 'src/boot/authStore'
import ProtectedComponent from 'src/components/ProtectedComponent.vue'

export default {
    name: 'MessagesComponent',
    components: { ServerData },
    props: ['selectedChat', 'url'],
    data() {
        return {
            newMessage: '',
            replyId: null,
            generalStore: useGeneralStore(),
        }
    },
    methods: {
        async sendMessage() {
            if (!this.newMessage.trim()) return
            try {
                await api.post('response-message', {
                    reply_id: this.replyId,
                    message: this.newMessage,
                    user_id: this.selectedChat?.id,
                })

                this.generalStore.revalidate('messages')
                this.newMessage = ''

                // Give time for revalidation to fetch new data
                setTimeout(() => {
                    this.scrollToBottom()
                }, 2)
            } catch (e) {
                console.error('Error sending message:', e)
            }
        },
        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer
                if (container) {
                    container.scrollTop = container.scrollHeight
                }
            })
        },
        handleMessagesLoaded() {
            // Scroll when messages are loaded
            setTimeout(() => {
                this.scrollToBottom()
            }, 500)
        },
        formatTime(timestamp) {
            // Format your timestamp here if needed
            return timestamp
        },
    },
    mounted() {
        // initial scroll
        setTimeout(() => {
            this.scrollToBottom()
        }, 100)

        // echo listener
        this.$echo.channel('support').listen('.Support', e => {
            this.generalStore.revalidate('messages')
            setTimeout(() => {
                this.scrollToBottom()
            }, 500)
        })
    },

    watch: {
        selectedChat: {
            immediate: true,
            handler() {
                // Scroll when chat changes
                setTimeout(() => {
                    this.scrollToBottom()
                }, 300)
            },
        },
    },
}
</script>

<style scoped>
/* Ensure messages container takes full height */
.messages-container {
    display: flex;
    flex-direction: column;
}

/* Add smooth scrolling */
.overflow-y-auto {
    scroll-behavior: smooth;
}
</style>
