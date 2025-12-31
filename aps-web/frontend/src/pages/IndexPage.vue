<template>
    <protected-component for-all>
        <q-intersection transition="fade">
            <q-page class="q-pa-lg">
                <!-- Header -->
                <div class="text-h4 text-weight-bold text-grey-9 q-mb-md">
                    Messaging Statistics
                </div>
                <q-separator class="q-mb-lg" />
                <server-data url="statistics" v-slot="{ data }">
                    <div class="row q-col-gutter-lg">
                        <!-- Current Week Messages -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <q-card class="stat-card bg-blue-1" flat bordered>
                                <q-card-section class="text-center">
                                    <q-icon
                                        name="date_range"
                                        size="48px"
                                        color="blue-7"
                                    />
                                    <div
                                        class="text-h3 text-weight-bold text-blue-9 q-mt-sm q-mb-xs"
                                    >
                                        {{ data.week_m }}
                                    </div>
                                    <div class="text-h6 text-grey-8">
                                        Weekly Messages
                                    </div>
                                    <div
                                        class="text-caption text-grey-6 q-mt-xs"
                                    >
                                        Current week (Mon-Sun)
                                    </div>
                                </q-card-section>
                                <q-separator />
                                <q-card-section class="text-center bg-blue-2">
                                    <div class="text-caption text-blue-9">
                                        <q-icon name="trending_up" size="sm" />
                                        {{ data.week_m }} from last week
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>

                        <!-- Monthly Messages -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <q-card class="stat-card bg-green-1" flat bordered>
                                <q-card-section class="text-center">
                                    <q-icon
                                        name="calendar_month"
                                        size="48px"
                                        color="green-7"
                                    />
                                    <div
                                        class="text-h3 text-weight-bold text-green-9 q-mt-sm q-mb-xs"
                                    >
                                        {{ data.month_m }}
                                    </div>
                                    <div class="text-h6 text-grey-8">
                                        Monthly Messages
                                    </div>
                                    <div
                                        class="text-caption text-grey-6 q-mt-xs"
                                    >
                                        Current month total
                                    </div>
                                </q-card-section>
                                <q-separator />
                                <q-card-section class="text-center bg-green-2">
                                    <div class="text-caption text-green-9">
                                        <q-icon name="trending_up" size="sm" />
                                        {{ data.month_m }} from last month
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>

                        <!-- Monthly Active Users -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <q-card class="stat-card bg-orange-1" flat bordered>
                                <q-card-section class="text-center">
                                    <q-icon
                                        name="people"
                                        size="48px"
                                        color="orange-7"
                                    />
                                    <div
                                        class="text-h3 text-weight-bold text-orange-9 q-mt-sm q-mb-xs"
                                    >
                                        {{ data.monthly_user }}
                                    </div>
                                    <div class="text-h6 text-grey-8">
                                        Monthly Users
                                    </div>
                                    <div
                                        class="text-caption text-grey-6 q-mt-xs"
                                    >
                                        Active users this month
                                    </div>
                                </q-card-section>
                                <q-separator />
                                <q-card-section class="text-center bg-orange-2">
                                    <div class="text-caption text-orange-9">
                                        <q-icon name="person_add" size="sm" />
                                        +42 new users
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>

                        <!-- Weekly Active Users -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <q-card class="stat-card bg-purple-1" flat bordered>
                                <q-card-section class="text-center">
                                    <q-icon
                                        name="group"
                                        size="48px"
                                        color="purple-7"
                                    />
                                    <div
                                        class="text-h3 text-weight-bold text-purple-9 q-mt-sm q-mb-xs"
                                    >
                                        {{ data.weekly_user }}
                                    </div>
                                    <div class="text-h6 text-grey-8">
                                        Weekly Users
                                    </div>
                                    <div
                                        class="text-caption text-grey-6 q-mt-xs"
                                    >
                                        Active users this week
                                    </div>
                                </q-card-section>
                                <q-separator />
                                <q-card-section class="text-center bg-purple-2">
                                    <div class="text-caption text-purple-9">
                                        <q-icon name="trending_up" size="sm" />
                                        +18% from last week
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </server-data>

                <!-- Main Statistics Grid -->
                <server-data url="chart" v-slot="{ data }">
                    <!-- Detailed Statistics -->
                    <div class="row q-col-gutter-lg q-mt-lg">
                        <!-- Weekly Breakdown -->
                        <div class="col-12 col-md-6">
                            <q-card flat bordered>
                                <q-card-section>
                                    <div class="text-h6 text-grey-8">
                                        Weekly Breakdown
                                    </div>
                                    <div class="text-subtitle2 text-grey-6">
                                        Daily message distribution
                                    </div>
                                </q-card-section>
                                <q-card-section>
                                    <div class="q-gutter-y-md">
                                        <div
                                            v-for="day in data.weeklyBreakdown"
                                            :key="day.name"
                                            class="items-center row"
                                        >
                                            <div class="col-3 text-grey-8">
                                                {{ day.name }}
                                            </div>
                                            <div class="col-7">
                                                <q-linear-progress
                                                    :value="day.value"
                                                    :color="day.color"
                                                    size="20px"
                                                    rounded
                                                >
                                                    <div
                                                        class="flex absolute-full flex-center"
                                                    >
                                                        <span
                                                            class="text-white text-caption"
                                                            >{{
                                                                day.count
                                                            }}
                                                            messages</span
                                                        >
                                                    </div>
                                                </q-linear-progress>
                                            </div>
                                            <div
                                                class="text-right col-2 text-grey-8"
                                            >
                                                {{ day.percentage }}%
                                            </div>
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>

                        <!-- Monthly Trends -->
                        <div class="col-12 col-md-6">
                            <q-card flat bordered>
                                <q-card-section>
                                    <div class="text-h6 text-grey-8">
                                        Monthly Trends
                                    </div>
                                    <div class="text-subtitle2 text-grey-6">
                                        Last 6 months Messages comparison
                                    </div>
                                </q-card-section>

                                <q-card-section>
                                    <div class="q-gutter-y-sm">
                                        <div
                                            v-for="month in data.monthlyTrends"
                                            :key="month.name"
                                            class="items-center row"
                                        >
                                            <div class="col-4 text-grey-8">
                                                {{ month.name }}
                                            </div>
                                            <div class="col-4">
                                                <div
                                                    class="text-h6 text-grey-9"
                                                >
                                                    {{
                                                        month.messages.toLocaleString()
                                                    }}
                                                </div>
                                            </div>
                                            <div class="text-right col-4">
                                                <q-icon
                                                    :name="
                                                        month.change >= 0
                                                            ? 'arrow_upward'
                                                            : 'arrow_downward'
                                                    "
                                                    :color="
                                                        month.change >= 0
                                                            ? 'green'
                                                            : 'red'
                                                    "
                                                    size="sm"
                                                />
                                                <span
                                                    :class="
                                                        month.change >= 0
                                                            ? 'text-green'
                                                            : 'text-red'
                                                    "
                                                >
                                                    {{
                                                        Math.abs(month.change)
                                                    }}%
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </server-data>
                <!-- User Statistics Summary -->
                <server-data url="chart_all" v-slot="{ data }">
                    <div class="row q-col-gutter-lg q-mt-lg">
                        <div class="col-12">
                            <q-card flat bordered>
                                <q-card-section>
                                    <div class="text-h6 text-grey-8">
                                        User Activity Summary
                                    </div>
                                </q-card-section>
                                <q-card-section>
                                    <div class="row">
                                        <div
                                            class="text-center col-12 col-md-4 q-pa-md"
                                        >
                                            <q-circular-progress
                                                show-value
                                                font-size="12px"
                                                :value="75"
                                                size="100px"
                                                :thickness="0.2"
                                                color="blue"
                                                track-color="grey-3"
                                                class="q-ma-md"
                                            >
                                                {{ data.user }}%
                                            </q-circular-progress>
                                            <div
                                                class="text-h6 text-grey-8 q-mt-sm"
                                            >
                                                Active Users
                                            </div>
                                            <div
                                                class="text-caption text-grey-6"
                                            >
                                                Weekly engagement rate
                                            </div>
                                        </div>
                                        <div
                                            class="text-center col-12 col-md-4 q-pa-md"
                                        >
                                            <q-circular-progress
                                                show-value
                                                font-size="12px"
                                                :value="62"
                                                size="100px"
                                                :thickness="0.2"
                                                color="green"
                                                track-color="grey-3"
                                                class="q-ma-md"
                                            >
                                                {{ data.replays }}%
                                            </q-circular-progress>
                                            <div
                                                class="text-h6 text-grey-8 q-mt-sm"
                                            >
                                                Message Replies
                                            </div>
                                            <div
                                                class="text-caption text-grey-6"
                                            >
                                                Response rate this week
                                            </div>
                                        </div>
                                        <div
                                            class="text-center col-12 col-md-4 q-pa-md"
                                        >
                                            <q-circular-progress
                                                show-value
                                                font-size="12px"
                                                :value="89"
                                                size="100px"
                                                :thickness="0.2"
                                                color="orange"
                                                track-color="grey-3"
                                                class="q-ma-md"
                                            >
                                                {{ data.users }}%
                                            </q-circular-progress>
                                            <div
                                                class="text-h6 text-grey-8 q-mt-sm"
                                            >
                                                ALl Users
                                            </div>
                                            <div
                                                class="text-caption text-grey-6"
                                            >
                                                All System Users
                                            </div>
                                        </div>
                                    </div>
                                </q-card-section>
                            </q-card>
                        </div>
                    </div>
                </server-data>
            </q-page>
        </q-intersection>
    </protected-component>
</template>

<script>
import { defineComponent } from 'vue'
import { useGeneralStore } from 'stores/generalStore'
import ProtectedComponent from 'components/ProtectedComponent.vue'

import ServerData from 'src/components/ServerData.vue'

export default defineComponent({
    name: 'IndexPage',
    components: {
        ProtectedComponent,
        ServerData,
    },

    data() {
        const generalStore = useGeneralStore()
        return {
            generalStore,
        }
    },
    mounted() {
        this.generalStore.setActivePage('home')
        this.generalStore.setPageTitle('Home Dashboard')
    },
})
</script>

<style scoped>
.stat-card {
    transition: transform 0.3s ease;
    border-radius: 12px;
}

.stat-card:hover {
    transform: translateY(-4px);
}

.q-linear-progress__model {
    border-radius: 10px;
}
</style>
