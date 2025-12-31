<template>
    <div
        class="md:px-2 md:px-1 py-4"
        ref="datatablePrintRef"
        id="datatablePrintRef"
    >
        <q-table
            flat
            bordered
            ref="tableRef"
            :rows="rows"
            :columns="options"
            row-key="id"
            v-model:pagination="pagination"
            :loading="loading"
            binary-state-sort
            separator="cell"
            @request="onRequest"
            dense
            selection="single"
            v-model:selected="selectedRow"
            :visible-columns="visibleColumns"
            :fullscreen="fullWidth"
            :rows-per-page-options="[10, 30, 50, 100, 200, 500]"
        >
            <template v-slot:loading>
                <q-inner-loading showing color="primary" />
            </template>
            <template v-slot:header="props">
                <q-tr :props="props" class="bg-gray-100">
                    <q-th class="print:hidden" />
                    <q-th
                        v-for="col in props.cols.filter(obj => !obj?.hidden)"
                        :key="col.name"
                        :props="props"
                        class="!py-2"
                    >
                        {{ col.label }}
                    </q-th>
                </q-tr>
            </template>
            <template v-slot:body="props">
                <q-tr
                    :props="props"
                    :class="
                        updatedRow === props.row['id']
                            ? 'bg-green-500 !text-white'
                            : rowColor && rowColor(props.row)
                    "
                >
                    <q-td class="print:hidden">
                        <q-checkbox
                            dense
                            v-model="props.selected"
                            class="print:hidden"
                        />
                    </q-td>
                    <q-td
                        :props="props"
                        v-for="col in columns.filter(obj => !obj?.hidden)"
                        :key="col.name"
                    >
                        <div
                            @click="
                                typeof col.onClick !== 'undefined' &&
                                    col?.onClick(props.row)
                            "
                            :class="`${col?.class} ${
                                typeof col?.onClick !== 'undefined' &&
                                'cursor-pointer'
                            }`"
                            v-if="col?.is_image"
                        >
                            <q-img :src="props.row[col.name]" />
                        </div>
                        <span
                            v-else
                            @click="
                                typeof col.onClick !== 'undefined' &&
                                    col?.onClick(props.row)
                            "
                            :class="`${col?.class} ${
                                typeof col?.link !== 'undefined'
                                    ? 'text-blue-700 underline cursor-pointer'
                                    : ''
                            } ${conditionalClass(
                                col?.conditionalClass,
                                props.row,
                            )} ${
                                typeof col?.cellColor !== 'undefined' &&
                                col?.cellColor(props.row)
                            }`"
                        >
                            <router-link
                                v-if="typeof col?.link !== 'undefined'"
                                :to="col?.link?.replace(':id', props.row['id'])"
                            >
                                {{ props.row[col.name] }}
                            </router-link>
                            <span v-else>
                                {{ props.row[col.name] }}
                            </span>
                        </span>
                    </q-td>
                </q-tr>
            </template>
            <template v-slot:top>
                <div
                    class="w-full flex items-center justify-between flex-col md:flex-row print:hidden"
                >
                    <div
                        class="flex-1 md:flex-initial w-full md:w-fit flex items-center pb-1 md:pb-0"
                    >
                        <q-input
                            borderless
                            dense
                            class="flex-1"
                            outlined
                            debounce="1000"
                            v-model="filter"
                            :placeholder="languageStore.translate('Search')"
                            clearable
                        >
                            <template v-slot:append>
                                <q-icon name="search" />
                            </template>
                        </q-input>
                        <q-btn
                            flat
                            round
                            class="visible md:hidden"
                            dense
                            :icon="fullWidth ? 'fullscreen_exit' : 'fullscreen'"
                            @click="fullWidth = !fullWidth"
                        />
                        <q-btn
                            color="primary"
                            icon="archive"
                            class="ml-2"
                            size="sm"
                            round
                            @click="exportTable"
                        >
                            <q-tooltip>
                                {{ languageStore.translate('Download') }}
                                (CVS)
                            </q-tooltip>
                        </q-btn>
                        <q-btn
                            color="primary"
                            icon="refresh"
                            class="ml-1"
                            size="sm"
                            round
                            @click="revalidate"
                        >
                            <q-tooltip>
                                {{ languageStore.translate('Refresh') }}
                            </q-tooltip>
                        </q-btn>
                        <q-btn
                            color="primary"
                            icon="print"
                            class="ml-1"
                            size="sm"
                            round
                            @click="handlePrint"
                        >
                            <q-tooltip>
                                {{ languageStore.translate('Print') }}
                            </q-tooltip>
                        </q-btn>
                    </div>
                    <div
                        class="flex items-center w-full md:w-fit flex-row-reverse justify-end"
                    >
                        <div class="flex items-center md:mt-0">
                            <div>
                                <q-btn
                                    icon="view_column"
                                    color="primary"
                                    round
                                    outline
                                    size="sm"
                                    class="ml-2"
                                >
                                    <q-menu
                                        transition-show="flip-right"
                                        transition-hide="flip-left"
                                    >
                                        <q-card>
                                            <q-card-section>
                                                <div class="column">
                                                    <div
                                                        class="text-h6 q-mb-md"
                                                    >
                                                        {{
                                                            $translate(
                                                                'Table columns',
                                                            )
                                                        }}
                                                    </div>
                                                    <q-toggle
                                                        :model-value="
                                                            visibleColumns.includes(
                                                                col.name,
                                                            )
                                                        "
                                                        v-for="col in options"
                                                        :key="col.name"
                                                        :label="col.label"
                                                        @click="
                                                            filterTableColumns(
                                                                col.name,
                                                            )
                                                        "
                                                    />
                                                </div>
                                            </q-card-section>
                                        </q-card>
                                    </q-menu>
                                    <q-tooltip>
                                        {{ $translate('Columns') }}
                                    </q-tooltip>
                                </q-btn>
                            </div>
                            <div>
                                <q-btn
                                    flat
                                    round
                                    dense
                                    class="hidden md:!block mt-2"
                                    :icon="
                                        fullWidth
                                            ? 'fullscreen_exit'
                                            : 'fullscreen'
                                    "
                                    @click="fullWidth = !fullWidth"
                                />
                            </div>
                        </div>
                        <div class="q-gutter-sm">
                            <protected-component
                                v-if="selectedRow.length > 0"
                                :permission-key="deletePermissionKey"
                            >
                                <q-btn
                                    v-if="deleteAction"
                                    round
                                    color="red"
                                    :disable="loading"
                                    @click="onRecordDeleted"
                                    size="sm"
                                    outline
                                    icon="delete"
                                >
                                    <q-tooltip>{{
                                        languageStore.translate('Delete record')
                                    }}</q-tooltip>
                                </q-btn>
                            </protected-component>
                            <protected-component
                                v-if="selectedRow.length > 0"
                                :permission-key="editPermissionKey"
                            >
                                <q-btn
                                    round
                                    color="warning"
                                    v-if="
                                        selectedRow.length === 1 && editAction
                                    "
                                    @click="onRecordEdited"
                                    size="sm"
                                    icon="edit"
                                    outline
                                >
                                    <q-tooltip>
                                        {{
                                            languageStore.translate(
                                                'Edit record',
                                            )
                                        }}
                                    </q-tooltip>
                                </q-btn>
                            </protected-component>
                            <protected-component
                                v-for="(action, index) in datatableActions"
                                :key="index"
                                :for-all="action?.forAll || false"
                                :permission-key="action?.permission_key"
                            >
                                <q-btn
                                    v-if="
                                        action?.show_on_select
                                            ? selectedRow.length > 0
                                            : true
                                    "
                                    :color="action.color ?? 'primary'"
                                    :label="
                                        languageStore.translate(action?.label)
                                    "
                                    :icon="action.icon"
                                    size="sm"
                                    @click="action.onClick(selectedRow[0])"
                                    outline
                                    round
                                >
                                    <q-tooltip v-if="action?.tooltip">
                                        {{
                                            languageStore.translate(
                                                action?.tooltip,
                                            )
                                        }}
                                    </q-tooltip>
                                </q-btn>
                            </protected-component>
                        </div>
                    </div>
                </div>
            </template>

            <template v-slot:top-right></template>

            <template v-slot:no-data="{ message }">
                <div class="text-center w-full py-8 text-red-600">
                    <span> {{ message }} </span>
                </div>
            </template>
        </q-table>
        <slot name="filter_options" />
    </div>
</template>
<script>
import { onMounted, ref, watch } from 'vue'
import { api } from 'boot/axios'
import { errorHandler } from 'src/lib/errorHandler'
import { resolve } from 'src/lib/helpers'
import { exportFile, useQuasar } from 'quasar'
import { useGeneralStore } from 'stores/generalStore'
import { useRouter } from 'vue-router'
import ProtectedComponent from 'components/ProtectedComponent.vue'
import { useLanguageStore } from 'stores/languageStore'
import { useVueToPrint } from 'vue-to-print'

export default {
    components: { ProtectedComponent },
    props: {
        url: {
            type: String,
            default: '',
        },
        rowColor: {
            type: Function,
            default: () => undefined,
        },
        deleteUrl: {
            type: String,
            default: null,
        },
        columns: {
            type: Array,
            default: () => [],
        },
        tableName: {
            type: String,
            default: 'table',
        },
        defaultOrderBy: {
            type: String,
            default: 'id',
        },
        deleteAction: {
            type: Boolean,
            default: true,
        },
        editAction: {
            type: Boolean,
            default: true,
        },
        deletePermissionKey: {
            type: String,
            default: '',
        },
        editPermissionKey: {
            type: String,
            default: '',
        },
        onEdit: {
            type: Function,
            default: undefined,
        },
        datatableActions: {
            type: Array,
            default: () => [],
        },
        filters: {
            type: Object,
            default: () => {},
        },
    },
    setup(setupProps) {
        const generalStore = useGeneralStore()
        const router = useRouter()
        const tableRef = ref()
        const rows = ref([])
        const filter = ref('')
        const loading = ref(false)
        const selectedRow = ref([])
        let visibleColumns = ref([])
        let options = ref([])
        let updatedRow = ref(0)
        const languageStore = useLanguageStore()

        const q = useQuasar()

        const pagination = ref({
            sortBy: setupProps.defaultOrderBy,
            descending: true,
            page: 1,
            rowsPerPage: 20,
            rowsNumber: 20,
        })
        options.value = setupProps.columns.map(column => ({
            name: column.name,
            field: column.name,
            label: languageStore.translate(column.label),
            sortable: column.sortable,
            align: 'center',
            hidden: !!column?.hidden,
            class: column?.class,
        }))
        visibleColumns.value = setupProps.columns.map(column => column.name)
        const datatablePrintRef = ref()

        watch(
            () => [languageStore.selected_language, languageStore.words],
            () => {
                options.value = setupProps.columns.map(column => ({
                    name: column.name,
                    field: column.name,
                    label: languageStore.translate(column.label),
                    sortable: column.sortable,
                    align: 'center',
                }))
            },
        )

        const fetcher = async (
            filter,
            page,
            rowsPerPage,
            sortBy,
            descending,
            router,
        ) => {
            loading.value = true
            try {
                const query = {
                    ...router.currentRoute.value.query,
                    ...setupProps.filters,
                    order_by: sortBy,
                    direction: descending ? 'desc' : 'asc',
                    limit: rowsPerPage,
                    page: page,
                }
                return await api
                    .get(
                        `${setupProps.url}?${new URLSearchParams(
                            query,
                        ).toString()}`,
                    )
                    .then(res => res.data)
                    .catch(err => errorHandler(err))
            } catch (e) {
                q.notify({
                    message: 'Something went wrong',
                    color: 'red',
                })
            } finally {
                loading.value = false
            }
        }

        const onRequest = async props => {
            const { page, rowsPerPage, sortBy, descending } = props.pagination
            const filter = props.filter
            loading.value = true
            const data = await fetcher(
                filter,
                page,
                rowsPerPage,
                sortBy,
                descending,
                router,
            )
            rows.value = data.data.map(data => {
                const row = {}
                setupProps.columns.forEach(col => {
                    row[col.name] = resolve(col.name, data)
                })
                return row
            })
            pagination.value = {
                sortBy: sortBy === 'desc' ? 'id' : sortBy,
                descending: descending,
                page: data.meta.current_page,
                rowsPerPage: data.meta.per_page,
                rowsNumber: data.meta.total,
            }
        }

        const wrapCsvValue = (val, formatFn, row) => {
            let formatted = formatFn !== void 0 ? formatFn(val, row) : val

            formatted =
                formatted === void 0 || formatted === null
                    ? ''
                    : String(formatted)

            formatted = formatted.split('"').join('""')
            return `"${formatted}"`
        }

        const exportTable = () => {
            const content = [
                options.value.map(col =>
                    visibleColumns.value.includes(col.name)
                        ? wrapCsvValue(col.label)
                        : null,
                ),
            ]
                .concat(
                    rows.value.map(row =>
                        options.value
                            .map(col =>
                                visibleColumns.value.includes(col.name)
                                    ? wrapCsvValue(
                                          typeof col.field === 'function'
                                              ? col.field(row)
                                              : row[
                                                    col.field === void 0
                                                        ? col.name
                                                        : col.field
                                                ],
                                          col.format,
                                          row,
                                      )
                                    : null,
                            )
                            .join(','),
                    ),
                )
                .join('\r\n')

            const status = exportFile(
                `${setupProps.tableName}.csv`,
                content,
                'text/csv',
            )

            if (status !== true) {
                $q.notify({
                    message: 'Browser denied file download...',
                    color: 'negative',
                    icon: 'warning',
                })
            }
        }

        const fullPageRoute = router.currentRoute.value.fullPath

        onMounted(() => {
            tableRef?.value?.requestServerInteraction()
            const {
                sortBy,
                descending,
                rowsPerPage,
                filter: search,
                page,
            } = router.currentRoute.value.query

            const query = {
                ...router.currentRoute.value.query,
                sortBy: sortBy ? sortBy : pagination.value.sortBy,
                descending: descending
                    ? descending
                    : pagination.value.descending,
                rowsPerPage: rowsPerPage
                    ? rowsPerPage
                    : pagination.value.rowsPerPage,
                filter: search ? search : filter.value,
                page: page ? page : pagination.value.page,
            }
            if (search) filter.value = search
            if (page) pagination.value.page = parseInt(page)
            if (sortBy) pagination.value.sortBy = sortBy
            if (descending) pagination.value.descending = descending === 'true'
            if (rowsPerPage)
                pagination.value.rowsPerPage = parseInt(rowsPerPage)
            router.push({ path: fullPageRoute, query })
        })

        watch(
            () => generalStore.table,
            (newValue, oldValue) => {
                if (newValue !== null && newValue === setupProps.tableName) {
                    tableRef?.value?.requestServerInteraction()
                    generalStore.revalidate(null)
                    selectedRow.value = []
                }
            },
        )
        watch(filter, async newValue => {
            const query = {
                ...router.currentRoute.value.query,
                sortBy: pagination.value.sortBy,
                descending: pagination.value.descending,
                rowsPerPage: pagination.value.rowsPerPage,
                filter: newValue,
                page: pagination.value.page,
            }
            await router.push({ path: fullPageRoute, query })
            tableRef?.value?.requestServerInteraction()
        })
        watch(pagination, () => {
            const query = {
                ...router.currentRoute.value.query,
                sortBy: pagination.value.sortBy,
                descending: pagination.value.descending,
                rowsPerPage: pagination.value.rowsPerPage,
                filter: filter.value,
                page: pagination.value.page,
            }
            router.push({ path: fullPageRoute, query })
        })
        watch(
            () => setupProps.filters,
            async newValue => {
                return false
                if (newValue !== null) {
                    if (Object.keys(newValue).length > 0) {
                        const query = {
                            ...router.currentRoute.value.query,
                            ...newValue,
                        }
                        for (const prop in newValue) {
                            if (Array.isArray(newValue[prop])) {
                                newValue[prop].forEach((item, index) => {
                                    for (const key in item) {
                                        query[`${prop}[${index}][${key}]`] =
                                            item[key]
                                    }
                                })
                            }
                            if (typeof newValue[prop] === 'object') {
                                delete query[prop]
                            }
                        }
                        await router.push({ path: fullPageRoute, query })
                        tableRef?.value?.requestServerInteraction()
                    } else {
                        const query = {
                            sortBy: pagination.value.sortBy,
                            descending: pagination.value.descending,
                            rowsPerPage: pagination.value.rowsPerPage,
                            filter: filter.value,
                            page: pagination.value.page,
                        }
                        await router.push({ path: fullPageRoute, query })
                        tableRef?.value?.requestServerInteraction()
                    }
                }
            },
        )
        watch(
            () => generalStore.filters.options,
            async newValue => {
                if (Object.keys(newValue).length > 0) {
                    const query = {
                        ...router.currentRoute.value.query,
                        ...newValue,
                        ...filter,
                    }
                    for (const prop in newValue) {
                        if (Array.isArray(newValue[prop])) {
                            newValue[prop].forEach((item, index) => {
                                for (const key in item) {
                                    query[`${prop}[${index}][${key}]`] =
                                        item[key]
                                }
                            })
                        }
                        if (typeof newValue[prop] === 'object') {
                            delete query[prop]
                        }
                    }
                    await router.push({ path: fullPageRoute, query })
                    tableRef?.value?.requestServerInteraction()
                } else {
                    const query = {
                        sortBy: pagination.value.sortBy,
                        descending: pagination.value.descending,
                        rowsPerPage: pagination.value.rowsPerPage,
                        filter: filter.value,
                        page: pagination.value.page,
                    }
                    await router.push({ path: fullPageRoute, query })
                    tableRef?.value?.requestServerInteraction()
                }
            },
        )
        watch(
            () => generalStore.update_id,
            newValue => {
                if (newValue !== 0) {
                    updatedRow.value = newValue
                }
            },
        )
        watch(updatedRow, newValue => {
            if (newValue !== 0) {
                setTimeout(() => {
                    updatedRow.value = 0
                    generalStore.setUpdateId(0)
                }, 5000)
            }
        })
        const filterTableColumns = colName => {
            if (visibleColumns.value.includes(colName)) {
                visibleColumns.value = visibleColumns.value.filter(
                    item => item !== colName,
                )
            } else {
                visibleColumns.value.push(colName)
            }
        }
        const revalidate = () => {
            tableRef?.value?.requestServerInteraction()
        }

        const { handlePrint } = useVueToPrint({
            content: () => datatablePrintRef.value,
        })

        return {
            tableRef,
            filter,
            loading,
            pagination,
            rows,
            selectedRow,
            options,
            onRequest,
            exportTable,
            visibleColumns,
            fetcher,
            generalStore,
            q,
            api,
            router,
            languageStore,
            updatedRow,
            filterTableColumns,
            revalidate,
            datatablePrintRef,
            handlePrint,
        }
    },
    data() {
        return {
            fullWidth: false,
        }
    },
    methods: {
        onRecordDeleted() {
            this.q
                .dialog({
                    title: this.$translate('Are you sure'),
                    message: this.$translate('Do you really want to delete'),
                    cancel: true,
                })
                .onOk(async () => {
                    this.q.loading.show()
                    try {
                        const result = await this.api.delete(
                            this.url + '/' + this.selectedRow[0]?.id,
                        )
                        if (result.data.result) {
                            this.q.notify({
                                message: this.$translate(result.data.message),
                                color: 'green',
                            })
                            this.generalStore.revalidate(this.tableName)
                            this.selectedRow = []
                        } else {
                            this.q.notify({
                                message: this.$translate(result.data.message),
                                color: 'red',
                            })
                        }
                    } catch (err) {
                        this.q.notify({
                            message: 'Something went wrong',
                            color: 'red',
                        })

                        errorHandler(err, _, this.router)
                    } finally {
                        this.q.loading.hide()
                    }
                })
        },
        onRecordEdited() {
            if (typeof this.onEdit !== 'undefined') {
                this.onEdit(this.selectedRow[0])
            }
        },
        conditionalClass(conditions, data) {
            if (!conditions) return

            const filterValue = resolve(conditions.filter_field, data)

            switch (conditions.condition) {
                case '===':
                    return conditions.value === filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                case '>':
                    return conditions.value > filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                case '<':
                    return conditions.value < filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                case '>=':
                    return conditions.value >= filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                case '<=':
                    return conditions.value <= filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                case '!==':
                    return conditions.value !== filterValue
                        ? conditions.trueClass
                        : conditions?.falseClass
                default:
                    return undefined
            }
        },
    },
}
</script>
