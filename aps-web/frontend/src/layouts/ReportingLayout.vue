<template>
    <protected-component permission-key="reporting-access" is-page>
        <q-intersection transition="jump-right">
            <div class="p-4">
                <p class="text-lg font-bold pb-2">
                    {{ $translate('Reporting section') }}
                </p>
                <q-card>
                    <q-card-section>
                        <div class="flex items-center border-b">
                            <protected-component
                                v-for="link in [
                                    {
                                        permission:
                                            'reporting-financial-reporting',
                                        to: '/reporting/finance',
                                        name: 'financial-reports',
                                        icon: 'attach_money',
                                        label: 'Financial reporting',
                                    },
                                    {
                                        permission:
                                            'reporting-warehouse-reports',
                                        to: '/reporting/warehouse',
                                        name: 'warehouse-reports',
                                        icon: 'warehouse',
                                        label: 'Warehouse reports',
                                    },
                                    {
                                        permission:
                                            'reporting-customers-report',
                                        to: '/reporting/customer',
                                        name: 'customer-reports',
                                        icon: 'groups',
                                        label: 'Customer reports',
                                    },
                                    {
                                        permission:
                                            'reporting-supplier-reports',
                                        to: '/reporting/supplier',
                                        name: 'supplier-reports',
                                        icon: 'people',
                                        label: 'Supplier reports',
                                    },
                                    {
                                        permission: 'reporting-product-report',
                                        to: '/reporting/product',
                                        name: 'product-report',
                                        icon: 'category',
                                        label: 'Product reports',
                                    },
                                ]"
                                :permission-key="link.permission"
                                :key="link.to"
                            >
                                <router-link :to="link.to">
                                    <div
                                        class="flex items-center cursor-pointer py-1 px-3 pb-2"
                                        :class="
                                            $route.meta.active === link.name
                                                ? 'text-blue-500 border-b-2 border-blue-500'
                                                : ''
                                        "
                                    >
                                        <q-icon :name="link.icon" size="xs" />
                                        <p class="px-2">
                                            {{ $translate(link.label) }}
                                        </p>
                                    </div>
                                </router-link>
                            </protected-component>
                        </div>
                        <div class="px-2 py-4">
                            <router-view />
                        </div>
                    </q-card-section>
                    <!--          -->
                </q-card>
            </div>
        </q-intersection>
    </protected-component>
</template>
<script>
import ProtectedComponent from 'components/ProtectedComponent.vue'
export default {
    components: { ProtectedComponent },
    mounted() {
        this.$generalStore.setActivePage('reporting')
        this.$generalStore.setPageTitle('Reporting page')
    },
}
</script>
