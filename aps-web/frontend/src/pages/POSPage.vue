<template>
    <validation-form
        v-if="$generalStore.store_settings"
        :validation-schema="schema"
        v-slot="{ values }"
        @submit="onSubmit"
    >
        <div class="p-4 bg-blue-100 h-[100vh]">
            <div class="grid grid-cols-9 gap-x-5">
                <div class="col-span-3 h-full">
                    <q-card class="h-[80px]">
                        <q-card-section>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <field
                                        name="customer_id"
                                        :value="
                                            $generalStore?.store_settings
                                                ?.customer?.id
                                        "
                                        v-slot="{ errorMessage, field }"
                                    >
                                        <select-component
                                            id="customers"
                                            :created-able="true"
                                            icon="person"
                                            :url="
                                                appRoutes.user_management
                                                    .customers.api +
                                                '?for-api=true'
                                            "
                                            :error-message="
                                                $translate(errorMessage)
                                            "
                                            option-label="full_name"
                                            option-value="id"
                                            :default-value="{
                                                label:
                                                    $generalStore.store_settings
                                                        .customer.first_name +
                                                    ' ' +
                                                    $generalStore.store_settings
                                                        .customer.last_name,
                                                value: $generalStore
                                                    .store_settings.customer.id,
                                            }"
                                            :on-change="
                                                value => {
                                                    field.onChange(value?.value)
                                                    setCustomer(value)
                                                }
                                            "
                                            :label="$translate('Customer')"
                                        />
                                    </field>
                                </div>
                                <div>
                                    <field
                                        name="warehouse_id"
                                        :value="
                                            $generalStore?.store_settings
                                                ?.warehouse?.id
                                        "
                                        v-slot="{ errorMessage, field }"
                                    >
                                        <select-component
                                            icon="home"
                                            :url="
                                                appRoutes.configurations
                                                    .systemConfiguration
                                                    .warehouse.api +
                                                '?for-api=true'
                                            "
                                            :error-message="
                                                $translate(errorMessage)
                                            "
                                            option-label="name"
                                            option-value="id"
                                            :default-value="{
                                                label: $generalStore
                                                    .store_settings.warehouse
                                                    .name,
                                                value: $generalStore
                                                    .store_settings.warehouse
                                                    .id,
                                            }"
                                            :on-change="
                                                value => {
                                                    field.onChange(value?.value)
                                                    pmStore.clearProducts()
                                                    // posStore.fetchProducts()
                                                    posStore.setWarehouse(
                                                        value?.value,
                                                    )
                                                }
                                            "
                                            :label="$translate('Warehouse')"
                                        />
                                    </field>
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                    <q-card class="mt-4">
                        <q-card-section>
                            <q-scroll-area
                                class="h-[80vh] relative"
                                :thumb-style="{
                                    right: '4px',
                                    borderRadius: '5px',
                                    width: '5px',
                                    opacity: 0.75,
                                }"
                            >
                                <div>
                                    <div class="flex-1">
                                        <OrderItems />
                                    </div>
                                    <div
                                        class="grid grid-cols-2 fixed w-full bottom-0 bg-white"
                                    >
                                        <div class="space-y-2">
                                            <q-input
                                                dense
                                                v-model="pmStore.tax"
                                                :label="$translate('Tax')"
                                                outlined
                                                type="number"
                                                :maxlength="100"
                                                :disable="edit_due"
                                            >
                                                <template v-slot:append>
                                                    <span class="text-sm">
                                                        %
                                                    </span>
                                                </template>
                                            </q-input>
                                            <q-input
                                                dense
                                                v-model="pmStore.discount"
                                                :label="$translate('Discount')"
                                                outlined
                                                type="number"
                                                :disable="edit_due"
                                                maxlength="100"
                                            >
                                                <template v-slot:append>
                                                    <span class="text-sm">
                                                        {{
                                                            pmStore?.currency
                                                                ?.symbol
                                                        }}
                                                    </span>
                                                </template>
                                            </q-input>
                                            <q-input
                                                dense
                                                v-model="pmStore.shipping"
                                                :label="$translate('Shipping')"
                                                :disable="edit_due"
                                                outlined
                                                type="number"
                                                maxlength="100"
                                            >
                                                <template v-slot:append>
                                                    <span class="text-sm">
                                                        {{
                                                            pmStore?.currency
                                                                ?.symbol
                                                        }}
                                                    </span>
                                                </template>
                                            </q-input>
                                        </div>
                                        <div class="text-right mt-12">
                                            <p class="text-lg text-gray-500">
                                                {{ $translate('Total QTY') }}:
                                                {{
                                                    pmStore?.products.reduce(
                                                        (
                                                            accumulator,
                                                            currentValue,
                                                        ) => {
                                                            return (
                                                                parseFloat(
                                                                    accumulator,
                                                                ) +
                                                                parseFloat(
                                                                    currentValue.qty,
                                                                )
                                                            )
                                                        },
                                                        0,
                                                    )
                                                }}
                                            </p>
                                            <p class="text-xl font-bold">
                                                {{ $translate('Total') }}:
                                                {{
                                                    parseFloat(
                                                        pmStore.subtotal(),
                                                    ).toLocaleString()
                                                }}
                                                {{ pmStore?.currency?.symbol }}
                                            </p>
                                        </div>
                                        <div
                                            class="col-span-2 grid grid-cols-3 gap-2 mt-3"
                                        >
                                            <q-btn
                                                :label="$translate('Cancel')"
                                                icon-right="close"
                                                color="red"
                                            />
                                            <q-btn
                                                :label="$translate('Reset')"
                                                icon-right="refresh"
                                                @click="pmStore.clearProducts()"
                                                color="primary"
                                            />
                                            <q-btn
                                                type="submit"
                                                :label="$translate('Pay now')"
                                                icon-right="save"
                                                color="green"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </q-scroll-area>
                        </q-card-section>
                    </q-card>
                </div>
                <q-scroll-area
                    class="col-span-6 h-full"
                    :thumb-style="{
                        right: '4px',
                        borderRadius: '5px',
                        width: '5px',
                        opacity: 0.75,
                    }"
                >
                    <q-card class="h-[80px] overflow-visible z-50">
                        <q-card-section>
                            <div class="flex items-center space-x-3">
                                <div class="flex-1 -mt-5">
                                    <product-select
                                        :on-change="
                                            product => handleAddProduct(product)
                                        "
                                        :disable-label="true"
                                        :currency_id="pmStore.currency?.id"
                                        stock-behavior="decrement"
                                        :warehouse_id="values?.warehouse_id"
                                    />
                                </div>
                                <div>
                                    <field
                                        name="currency_id"
                                        v-if="pmStore?.currency"
                                        :value="pmStore?.currency?.id"
                                        v-slot="{ errorMessage, field }"
                                    >
                                        <select-component
                                            v-if="pmStore?.currency"
                                            :default-value="{
                                                label:
                                                    pmStore?.currency?.name +
                                                    ' (' +
                                                    pmStore?.currency?.symbol +
                                                    ')',
                                                value: pmStore?.currency?.id,
                                            }"
                                            :url="
                                                appRoutes.configurations
                                                    .systemConfiguration
                                                    .currencyConfiguration.api +
                                                '?api=true'
                                            "
                                            :on-change="
                                                data => {
                                                    field.onChange(data?.value)
                                                    pmStore.setCurrency(data)
                                                    pmStore.clearProducts()
                                                    posStore.fetchProducts()
                                                }
                                            "
                                            :error-message="
                                                $translate(errorMessage)
                                            "
                                            :label="$translate('Currencies')"
                                            option-label="name_with_symbol"
                                            option-value="id"
                                        />
                                    </field>
                                </div>
                                <div class="-mt-5 space-x-1">
                                    <q-btn
                                        @click="$q.fullscreen.toggle()"
                                        :icon="
                                            $q.fullscreen.isActive
                                                ? 'fullscreen_exit'
                                                : 'fullscreen'
                                        "
                                        outline
                                        color="primary"
                                    />
                                    <q-btn
                                        icon="currency_exchange"
                                        outline
                                        @click="handleModel(true)"
                                        color="primary"
                                    >
                                        <q-tooltip>{{
                                            $translate('Exhcnage product')
                                        }}</q-tooltip>
                                    </q-btn>
                                    <q-btn
                                        icon="real_estate_agent"
                                        outline
                                        @click="directSaleForm(true)"
                                        color="primary"
                                    >
                                        <q-tooltip>{{
                                            $translate('Direct sale')
                                        }}</q-tooltip>
                                    </q-btn>
                                    <q-btn
                                        icon="dashboard"
                                        outline
                                        color="primary"
                                        to="/"
                                    />
                                    <notification-component :for-p-o-s="true" />
                                </div>
                            </div>
                        </q-card-section>
                    </q-card>
                    <q-card class="mt-4 h-[83.8vh] overflow-hidden !z-10">
                        <q-card-section>
                            <q-scroll-area
                                style="height: 87vh; max-width: 100%"
                                :thumb-style="{
                                    right: '1px',
                                    borderRadius: '5px',
                                    width: '2px',
                                    opacity: 0.75,
                                }"
                            >
                                <div class="bg-white sticky top-0 z-50">
                                    <p-o-s-categories />
                                    <p-o-sbrands />
                                </div>
                                <p-o-s-products v-if="pmStore.currency" />
                            </q-scroll-area>
                        </q-card-section>
                    </q-card>
                </q-scroll-area>
            </div>
        </div>
        <product-details-edit-modal
            :product="pmStore.edit_product.product"
            :model="pmStore.edit_product.model"
            :handle-model="pmStore.setEditProduct"
            :for-sale="true"
            stock-behavior="decrement"
            :warehouse-id="values?.warehouse_id"
        />
        <p-o-s-sale-confirmation
            :customer="customer"
            :values="form_values"
            v-if="pmStore.products.length > 0 && posStore.payment_model"
        />
        <p-o-s-invoice />
        <exchange-form
            v-if="exchange_form.model"
            :handle-model="handleModel"
            :exchange_form="exchange_form.data"
            :currency_id="values?.customer_id"
            :warehouse_id="values?.warehouse_id"
            :customer_id="values?.customer_id"
        />
        <product-exchange-invoice
            v-if="print_invoice.model"
            :exchange-id="print_invoice.id"
            :handle-model="handelInvoiceModel"
        />
        <direct-sale-form
            :warehouse_id="values?.warehouse_id"
            :currency_id="values?.currency_id"
            :customer_id="values?.customer_id"
            v-if="direct_sale_form"
            :handle-model="directSaleForm"
        />
        <direct-sale-invoice
            v-if="direct_sale_invoice.model"
            :data="direct_sale_invoice.data"
            :handle-form="directSaleInvoiceForm"
        />
    </validation-form>
</template>
<script>
import { appRoutes } from 'src/appRouter/routes'
import SelectComponent from 'components/SelectComponent.vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import { useProductManagementStore } from 'stores/productManagementStore'
import * as yup from 'yup'
import ProductSelect from 'pages/ProductManagement/Products/ProductSelect.vue'
import POSCategories from 'components/POSComponents/POSCategories.vue'
import POSbrands from 'components/POSComponents/POSbrands.vue'
import POSProducts from 'components/POSComponents/POSProducts.vue'
import { usePOSStore } from 'stores/POSstore'
import ProductDetailsEditModal from 'pages/ProductManagement/Products/ProductDetailsEditModal.vue'
import POSSaleConfirmation from 'components/POSComponents/POSSaleConfirmation.vue'
import POSInvoice from 'components/POSComponents/POSInvoice.vue'
import NotificationComponent from 'components/NotificationComponent.vue'
import { onMounted } from 'vue'
import ProductExchangeInvoice from 'components/ProductExchangeInvoice.vue'
import ExchangeForm from 'pages/SalesManagement/Exchange/ExchangeForm.vue'
import DirectSaleForm from 'pages/SalesManagement/DirectSale/DirectSaleForm.vue'
import { api } from 'boot/axios'
import DirectSaleInvoice from 'pages/SalesManagement/DirectSale/DirectSaleInvoice.vue'
import OrderItems from 'components/POSComponents/OrderItems.vue'

export default {
    components: {
        OrderItems,
        DirectSaleInvoice,
        DirectSaleForm,
        ExchangeForm,
        ProductExchangeInvoice,
        NotificationComponent,
        POSInvoice,
        POSSaleConfirmation,
        ProductDetailsEditModal,
        POSProducts,
        POSbrands,
        POSCategories,
        ProductSelect,
        SelectComponent,
        ValidationForm,
        Field,
    },
    setup() {
        const pmStore = useProductManagementStore()
        const posStore = usePOSStore()
        const schema = yup.object({
            warehouse_id: yup.number().required('This section is required'),
            customer_id: yup.number().required('This section is required'),
            currency_id: yup.number().required('This section is required'),
        })
        onMounted(() => {
            pmStore.reset()
        })
        return {
            appRoutes,
            pmStore,
            schema,
            posStore,
        }
    },
    mounted() {
        this.pmStore.setStockBehavior('decrement')
        if (this.$generalStore.store_settings) {
            this.pmStore.setCurrency(this.$generalStore.store_settings.currency)
        }
        this.$echo
            .private('applicationChannel')
            .listen('NotifyEvent', message => {
                this.posStore.fetchProducts()
            })
            .subscribe()
    },
    data() {
        return {
            fullscreen: false,
            form_values: null,
            customer: null,
            exchange_form: {
                model: false,
                data: null,
            },
            print_invoice: {
                model: false,
                id: 0,
            },
            direct_sale_form: false,
            direct_sale_invoice: {
                model: false,
                data: null,
            },
        }
    },
    methods: {
        directSaleInvoiceForm(model, data) {
            this.direct_sale_invoice = {
                model,
                data,
            }
        },
        directSaleForm(model, data, id) {
            this.direct_sale_form = model

            if (id > 0) {
                this.handlePrintInvoice(id)
            }
        },
        handleModel(model, id = 0) {
            this.exchange_form = {
                model,
            }
            if (id > 0) {
                this.handelInvoiceModel(true, id)
            }
        },
        handelInvoiceModel(condition, id = 0) {
            this.print_invoice = {
                model: condition,
                id,
            }
        },
        handleAddProduct(product) {
            const result = this.pmStore.addProduct(product)
            if (!result.status) {
                this.$q.notify({
                    message: result.message,
                    color: 'red',
                })
            }
        },
        setCustomer(customer) {
            this.customer = customer
        },
        handleProductQty(product, type) {
            if (!this.pmStore.updateProductQty(product, type)) {
                this.$q.notify({
                    message: 'Out of stock',
                    color: 'red',
                })
            }
        },
        onSubmit(values, actions) {
            if (this.pmStore.products.length > 0) {
                this.form_values = values
                this.posStore.handlePayment(true)
            } else {
                this.$q.notify({
                    message: this.$translate('Please select a product'),
                    color: 'red',
                })
            }
        },
        async handlePrintInvoice(id) {
            this.$q.loading.show()
            try {
                const result = await api.get(
                    appRoutes.direct_sale.api + '/' + id,
                )
                this.direct_sale_invoice = {
                    data: result.data.data,
                    model: true,
                }
            } catch (err) {
                console.log(err)
                this.$q.notify({
                    message: this.$translate('Something went wrong'),
                    color: 'red',
                })
            } finally {
                this.$q.loading.hide()
            }
        },
    },
}
</script>
