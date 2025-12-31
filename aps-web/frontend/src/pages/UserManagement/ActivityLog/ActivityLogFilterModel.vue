<template>
    <q-dialog :model-value="true">
        <q-card style="width: 500px">
            <q-card-section>
                <h2 class="text-xl font-bold">Filter activity log</h2>
            </q-card-section>
            <form>
                <q-card-section>
                    <p class="text-lg font-bold">
                        Activity performed from - to
                    </p>
                    <q-date today-btn v-model="model" range class="w-full" />
                    <div class="mt-4">
                        <lazy-load-select-component
                            :url="appRoutes.user_management.users.api"
                            option-label="full_name"
                            label="Search users"
                            :on-change="data => setUser(data)"
                            :default-values="model.users"
                        />
                        <q-select
                            v-model="events"
                            :options="['created', 'updated', 'deleted']"
                            label="Events"
                            dense
                            outlined
                            multiple
                            use-chips
                        />
                    </div>
                </q-card-section>
                <q-card-actions align="right">
                    <q-btn
                        outline
                        size="small"
                        color="primary"
                        icon-right="filter_alt"
                        @click="onSave"
                    >
                        {{ $translate('Filter') }}
                    </q-btn>
                    <q-btn
                        outline
                        size="small"
                        icon-right="close"
                        color="red"
                        @click="handleModal(false, {})"
                    >
                        Close
                    </q-btn>
                </q-card-actions>
            </form>
        </q-card>
    </q-dialog>
</template>
<script>
import { defineComponent } from 'vue'
import LazyLoadSelectComponent from 'components/LazyLoadSelectComponent.vue'
import { appRoutes } from 'src/appRouter/routes'

export default defineComponent({
    name: 'ActivityLogFilterModel',
    components: { LazyLoadSelectComponent },
    props: ['handleModal', 'filters'],
    setup() {
        return {
            appRoutes,
        }
    },
    data() {
        return {
            model: {
                from: '',
                to: '',
                users: [],
            },
            events: [],
        }
    },
    methods: {
        setUser(users) {
            this.model = {
                ...this.model,
                users,
            }
        },
        onSave() {
            const filters = {
                from: this.model.from,
                to: this.model.to,
                users: this.model.users?.map(user => ({
                    full_name: user.full_name,
                    id: user.id,
                })),
                events: this.events?.map(event => ({
                    name: event,
                })),
            }
            this.handleModal(false, filters)
        },
    },
    mounted() {
        const { from, to } = this.$router.currentRoute.value.query
        if (Object.entries(this.filters).length > 0) {
            this.model = this.filters
        }
        if (from && to) {
            this.model = {
                from,
                to,
            }
        }
        const data = this.$router.currentRoute.value.query
        const users = []
        const events = []
        for (let i = 0; data[`users[${i}][full_name]`]; i++) {
            const fullName = data[`users[${i}][full_name]`].trim()
            const id = parseInt(data[`users[${i}][id]`])
            users.push({ full_name: fullName, id: id })
        }
        for (let i = 0; data[`events[${i}][name]`]; i++) {
            const name = data[`events[${i}][name]`].trim()
            events.push(name)
        }

        this.model = {
            ...this.model,
            users: users,
        }
        this.events = events
    },
})
</script>
