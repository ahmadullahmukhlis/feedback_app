<template>
    <!-- Left Sidebar - Chat List -->
    <div class="flex flex-col w-1/3 bg-white border-r border-gray-200 md:w-1/4">
        <!-- Profile Section -->
        <div class="flex items-center p-4 border-b border-gray-200">
            <div class="w-10 h-10 mr-3 overflow-hidden rounded-full">
                <img
                    :src="user.image ? user.image : '/user.png'"
                    class="object-cover w-full h-full"
                />
            </div>
            <div class="flex-1">
                <div class="font-semibold text-gray-800">
                    {{ user.first_name }} {{ user.last_name }}
                </div>
                <div class="text-xs text-gray-500">Online</div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="p-3 border-b border-gray-200">
            <div class="relative">
                <input
                    type="text"
                    placeholder="Search or start new chat"
                    class="w-full py-2 pl-10 pr-4 text-sm bg-gray-100 border-none rounded-lg focus:ring-2 focus:ring-green-500 focus:outline-none"
                />
                <div class="absolute -translate-y-1/2 left-3 top-1/2">
                    <svg
                        class="w-4 h-4 text-gray-500"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto">
            <div class="divide-y divide-gray-100">
                <server-data url="people" v-slot="{ data }">
                    <div
                        v-for="user in data"
                        :key="user.id"
                        @click="selectChat(user)"
                        :class="[
                            'p-3 hover:bg-gray-50 cursor-pointer transition-colors relative',
                            { 'bg-blue-50': selectedChat?.id === user.id },
                            { 'bg-gray-100': user.message.unread },
                        ]"
                    >
                        <div class="flex items-start">
                            <!-- Avatar -->
                            <div class="relative mr-3">
                                <div
                                    class="w-12 h-12 overflow-hidden rounded-full"
                                >
                                    <img
                                        :src="user.image"
                                        class="object-cover w-full h-full"
                                    />
                                </div>

                                <!-- Online Dot -->
                                <div
                                    v-if="user.message.online"
                                    class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"
                                ></div>
                            </div>

                            <!-- User Info -->
                            <div class="flex-1 min-w-0">
                                <h6
                                    class="font-semibold text-gray-800 truncate"
                                >
                                    {{ user.first_name }} {{ user.last_name }}
                                </h6>
                                <p class="text-gray-900 truncate">
                                    {{
                                        truncateMessage(
                                            user.message.last_message,
                                            3,
                                        )
                                    }}
                                </p>
                            </div>

                            <!-- Unread Badge (fixed in the same place) -->
                            <div
                                v-if="user.message.unread"
                                class="absolute flex items-center justify-center w-5 h-5 text-xs text-white bg-gray-500 rounded-full right-2 top-8"
                            >
                                1
                            </div>
                        </div>
                    </div>
                </server-data>
            </div>
        </div>
    </div>
</template>

<script>
import { defineComponent } from 'vue'
import ServerData from 'components/ServerData.vue'
import { useAuthStore } from 'src/stores/UserManagementStores/AuthStore'

export default defineComponent({
    name: 'MessagePeople',
    components: { ServerData },

    props: {
        onSelect: {
            type: Function,
            required: true,
        },
    },

    data() {
        return {
            selectedChat: null,
            user: useAuthStore().user,
        }
    },

    methods: {
        selectChat(user) {
            this.selectedChat = user
            this.onSelect(user)
        },
        truncateMessage(message, wordLimit = 5) {
            if (!message) return ''
            const words = message.split(' ')
            if (words.length <= wordLimit) return message
            return words.slice(0, wordLimit).join(' ') + '...'
        },
    },
    mounted() {
        // echo listener
        this.$echo.channel('support').listen('.Support', e => {
            this.generalStore.revalidate('messages')
            setTimeout(() => {
                this.scrollToBottom()
            }, 500)
        })
    },
})
</script>

<style scoped></style>
