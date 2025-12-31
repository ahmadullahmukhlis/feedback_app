<template>
    <protected-component permission-key="users-access" is-pages>
        <div class="bg-white p-3">
            <q-breadcrumbs>
                <q-breadcrumbs-el icon="home" to="/" />
                <q-breadcrumbs-el
                    :label="translate('User management')"
                    to="/user-management"
                />
                <q-breadcrumbs-el :label="translate('Users')" />
            </q-breadcrumbs>
        </div>
        <div>
            <UserManagementLayout active="users">
                <div class="md:px-2 py-4">
                    <div class="flex items-center justify-between">
                        <p class="text-lg font-semibold">
                            {{ translate('List of users') }}
                        </p>
                        <protected-component permission-key="users-create">
                            <q-btn
                                @click="handleUserFormModel()"
                                color="primary"
                                size="small"
                                icon-right="add"
                            >
                                {{ translate('Add new user') }}
                            </q-btn>
                        </protected-component>
                    </div>
                    <datatable-component
                        :url="appRoutes.user_management.users.api"
                        table-name="users"
                        :on-edit="user => handleUserFormModel(user)"
                        :filters="filters"
                        edit-permission-key="users-edit"
                        delete-permission-key="users-delete"
                        :datatable-actions="[
                            {
                                icon: 'visibility',
                                tooltip: 'View details',
                                permission_key: 'users-view-details',
                                show_on_select: true,
                                onClick: data => {
                                    router.push({
                                        path: appRoutes.user_management.users.details.path
                                            .replace(':id', data.id)
                                            .replace(':active', 'info'),
                                    })
                                },
                            },
                            {
                                icon: 'filter_alt',
                                forAll: true,
                                tooltip: 'Filter users',
                                onClick: () => {
                                    handleFilterModel(true, filters)
                                },
                            },
                        ]"
                        :columns="[
                            {
                                label: 'Id',
                                name: 'id',
                                sortable: true,
                            },
                            {
                                label: 'First name',
                                name: 'first_name',
                                sortable: true,
                                link: '/user-management/users/:id/info',
                            },
                            {
                                label: 'Last name',
                                name: 'last_name',
                                sortable: true,
                            },
                            {
                                label: 'Email or username',
                                name: 'email',
                                sortable: true,
                            },
                            {
                                label: 'Is active',
                                name: 'is_active',
                                conditionalClass: {
                                    filter_field: 'is_active',
                                    condition: '===',
                                    value: true,
                                    trueClass:
                                        'bg-green-500 px-2 text-center py-1 text-white rounded-full',
                                    falseClass:
                                        'bg-red-500 px-2 text-center py-1 text-white rounded-full',
                                },
                            },
                            {
                                label: 'Created at',
                                name: 'created_at',
                                sortable: true,
                            },
                        ]"
                    />
                </div>
            </UserManagementLayout>
        </div>
        <user-form-model
            :user="user"
            v-if="model"
            :handle-model-close="handleModelClose"
        />
        <user-filter-model
            v-if="filter"
            :filters="filters"
            :handle-close-model="handleFilterModel"
        />
    </protected-component>
</template>
<script>
import { defineComponent } from 'vue'
import UserManagementLayout from 'layouts/UserManagementLayout.vue'
import { useGeneralStore } from 'stores/generalStore'
import UserFormModel from 'pages/UserManagement/Users/UserFormModel.vue'
import { appRoutes } from 'src/appRouter/routes'
import DatatableComponent from 'components/DatatableComponent.vue'
import UserFilterModel from 'pages/UserManagement/Users/UserFilterModel.vue'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useRouter } from 'vue-router'
import { useLanguageStore } from 'stores/languageStore'

export default defineComponent({
    name: 'UserPage',
    components: {
        ProtectedComponent,
        UserFilterModel,
        DatatableComponent,
        UserFormModel,
        UserManagementLayout,
    },
    setup() {
        const generalStore = useGeneralStore()
        const router = useRouter()
        const { translate } = useLanguageStore()
        return {
            generalStore,
            appRoutes,
            router,
            translate,
        }
    },
    data() {
        return {
            model: false,
            user: null,
            filter: false,
            filters: {},
        }
    },
    mounted() {
        this.generalStore.setPageTitle('Users')
        this.generalStore.setActivePage('user-management')
    },
    methods: {
        handleUserFormModel(user = null) {
            this.model = true
            this.user = user
        },
        handleFilterModel(open = true, filters) {
            this.filter = open
            this.filters = filters
        },
        handleModelClose() {
            this.model = false
            this.filter = false
        },
    },
})
</script>
