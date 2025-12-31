<template>
    <div>
        <validation-form
            :validation-schema="validationSchema"
            @submit="onSubmit"
            :class="className"
            v-slot="{ values }"
        >
            <template v-for="field in visibleFields(values)" :key="field.name">
                <field
                    :name="field.name"
                    :value="field.value"
                    v-slot="{ errorMessage, value, field: formField }"
                >
                    <div :class="field?.className">
                        <q-input
                            v-if="['text', 'number'].includes(field.type)"
                            :model-value="value"
                            :error="!!errorMessage"
                            v-bind="formField"
                            outlined
                            :disable="field?.disabled ?? false"
                            dense
                            :label="$translate(field.label)"
                            :type="field?.type ?? 'text'"
                            :error-message="errorMessage?.replaceAll('_', ' ')"
                            :mask="field?.mask"
                            :hint="field?.hint"
                            :disabled="field?.disabled ?? false"
                        >
                            <template v-slot:prepend>
                                <q-icon
                                    v-if="field?.prepend_icon"
                                    :name="field?.prepend_icon"
                                />
                            </template>
                            <template v-slot:append>
                                <span class="text-xs">{{
                                    field?.append_text
                                }}</span>
                            </template>
                        </q-input>

                        <div v-else-if="field?.type === 'datepicker'">
                            <datepicker-component
                                :label="$translate(field.label)"
                                :value="value"
                                :disabled="field?.disabled ?? false"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                                :on-change="date => formField.onChange(date)"
                            />
                        </div>

                        <div v-else-if="field?.type === 'server-select'">
                            <new-select-component
                                :disabled="field?.disabled ?? false"
                                :find-from-id="field?.find_from_id ?? true"
                                :url="resolveUrl(field, values)"
                                :from-resource="field?.from_resource ?? true"
                                :server-search-able="
                                    field?.server_search_able ?? false
                                "
                                :option-label="field?.option_label ?? 'name'"
                                :option-value="field?.option_value ?? 'id'"
                                :default-value="value"
                                :select-type="field?.select_type"
                                :error-message="errorMessage"
                                :created-able="field.create_able"
                                :id="field.name"
                                :handle-creatable="field?.handle_create"
                                :on-change="
                                    data => {
                                        handleSelectChange(
                                            field,
                                            data,
                                            formField,
                                        )
                                        if (
                                            typeof field?.on_select ===
                                            'function'
                                        ) {
                                            this.field?.on_select(data)
                                        }
                                    }
                                "
                                :label="$translate(field.label)"
                            />
                        </div>
                        <div v-else-if="field.type === 'select'">
                            <q-select
                                :disable="field?.disabled ?? false"
                                :model-value="value"
                                :options="field.options"
                                :label="$translate(field.label)"
                                dense
                                :use-input="field?.creatable ?? false"
                                :use-chips="field?.creatable ?? false"
                                :error-message="
                                    errorMessage?.replaceAll('_', ' ')
                                "
                                new-value-mode="add-unique"
                                :multiple="field?.multiple ?? false"
                                :error="!!errorMessage"
                                outlined
                                @update:model-value="
                                    value => formField.onChange(value)
                                "
                            />
                        </div>
                        <div v-else-if="field.type === 'radio'">
                            <p>{{ $translate(field.label) }}</p>
                            <q-radio
                                :disable="field?.disabled ?? false"
                                v-for="(option, index) in field.options"
                                :key="index"
                                :model-value="value"
                                :val="option"
                                :label="$translate(option)"
                                @update:model-value="
                                    radioValue => {
                                        if (
                                            typeof field?.on_change !==
                                            'undefined'
                                        ) {
                                            field?.on_change(radioValue)
                                        }
                                        formField.onChange(radioValue)
                                    }
                                "
                            />
                            <p
                                class="text-xs text-red-500"
                                v-if="!!errorMessage"
                            >
                                {{ errorMessage }}
                            </p>
                        </div>
                        <div v-else-if="field.type === 'file'">
                            <file-selector-component
                                :value="value"
                                :form-field="formField"
                                :field="field"
                                :error-message="errorMessage"
                                :scanable="field?.scanable ?? true"
                                :disabled="field?.disabled ?? false"
                            />
                        </div>
                        <div v-else-if="field.type === 'div'">
                            <p :class="field.div_class">
                                {{ $translate(field.label) }}
                            </p>
                        </div>
                        <div v-else-if="field.type === 'money'">
                            <money-input
                                :error-message="errorMessage"
                                :model-value="value"
                                :label="$translate(field.label)"
                                :append-text="field.append_text"
                                :disabled="field?.disabled"
                                :on-change="
                                    moneyValue => formField.onChange(moneyValue)
                                "
                            />
                        </div>
                        <div v-else-if="field.type === 'color'">
                            <color-packer
                                :error-message="errorMessage"
                                :model-value="value"
                                :label="$translate(field.label)"
                                :append-text="field.append_text"
                                :disabled="field?.disabled"
                                :on-change="
                                    moneyValue => formField.onChange(moneyValue)
                                "
                            />
                        </div>
                        <div
                            v-if="field.type === 'radio_buttons'"
                            :class="
                                !!errorMessage &&
                                'border border-red-500 p-3 text-red-500 my-2'
                            "
                        >
                            <p class="">{{ $translate(field.label) }}</p>
                            <q-radio
                                v-for="(option, index) in field.options"
                                :key="index"
                                :label="$translate(option)"
                                :disable="field?.disabled ?? false"
                                :model-value="$translate(value)"
                                :val="option"
                                @update:model-value="
                                    radioValue => formField.onChange(radioValue)
                                "
                            />
                            <p
                                class="mb-3 text-xs text-red-500"
                                v-if="!!errorMessage"
                            >
                                {{ errorMessage?.replaceAll('_', ' ') }}
                            </p>
                        </div>
                        <div v-if="field.type === 'editor'">
                            <full-editor-component
                                :label="field.label"
                                :value="field.value"
                                :on-change="data => formField.onChange(data)"
                                :error="errorMessage"
                            />
                        </div>
                        <!-- <div v-if="field.type === 'tip_editor'">
                            <p class="font-bold">{{ field?.label }}</p>
                            <tip-editor
                                :defaultValue="value"
                                :errorMessage="errorMessage"
                                @onChange="data => formField.onChange(data)"
                            />
                        </div> -->
                    </div>
                </field>
            </template>

            <slot name="form_body" />

            <div :class="submitAreaClassName">
                <slot name="other_actions" />
                <q-btn
                    :label="$translate(submitLabel ?? 'Save')"
                    :icon-right="submitIcon ?? 'save'"
                    color="green"
                    type="submit"
                    size="small"
                    :loading="loading"
                    :disable="loading"
                    v-if="!hideSubmitButton && !progress"
                />
                <q-circular-progress
                    v-if="loading && progress"
                    show-value
                    font-size="12px"
                    :value="percent"
                    size="50px"
                    :thickness="0.22"
                    color="primary"
                    track-color="grey-3"
                    class="q-ma-md"
                >
                    {{ percent }}%
                </q-circular-progress>
                <slot :formValues="values" />
            </div>
            <form-values-listener
                :form-values="values"
                :on-values-changes="onValuesChanged"
            />
        </validation-form>
    </div>
</template>

<script>
import { Form as ValidationForm, Field, useForm } from 'vee-validate'
import * as yup from 'yup'
import DatepickerComponent from 'components/DatepickerComponent.vue'
import { resolve } from 'src/lib/helpers'
import { computed } from 'vue'
import { errorHandler } from 'src/lib/errorHandler'
import NewSelectComponent from 'components/NewSelectComponent.vue'
import FormValuesListener from 'components/FormValuesListener.vue'
import MoneyInput from 'components/MonyField.vue'
import FileSelectorComponent from 'components/FileSelectorComponent.vue'
import FullEditorComponent from 'components/FullEditorComponent.vue'
// import TipEditorComponent from 'components/TipEditor/TipEditorComponent.vue'
import ColorPacker from './ColorPacker.vue'

export default {
    components: {
        // TipEditor: TipEditorComponent,
        FullEditorComponent,
        FileSelectorComponent,
        MoneyInput,
        FormValuesListener,
        DatepickerComponent,
        ValidationForm,
        Field,
        NewSelectComponent,
        ColorPacker,
    },
    props: [
        'fields',
        'className',
        'submitLabel',
        'submitIcon',
        'submitAreaClassName',
        'action',
        'onSubmitCompleted',
        'method',
        'beforeSubmit',
        'hideSubmitButton',
        'onValuesChanged',
        'needConfirmation',
        'confirmationTitle',
        'confirmationMessage',
        'hiddenFields',
    ],
    setup(props) {
        const validationSchema = computed(() =>
            yup.object(
                props.fields.reduce((acc, field) => {
                    acc[field.name] = field.validation
                    return acc
                }, {}),
            ),
        )

        const visibleFields = values => {
            return props.fields.filter(field =>
                typeof field.show === 'function' ? field.show(values) : true,
            )
        }

        const resolveUrl = (field, values) => {
            return typeof field.url === 'function'
                ? field.url(values)
                : field.url
        }

        const handleSelectChange = (field, data, formField) => {
            const value = resolve(field?.change_value ?? 'id', data)
            formField.onChange(value)
            if (typeof field?.on_select === 'function') {
                field.on_select(data)
            }
        }

        return {
            validationSchema,
            visibleFields,
            resolveUrl,
            handleSelectChange,
            resolve,
        }
    },
    methods: {
        async submitForm(values, actions) {
            if (typeof this.beforeSubmit !== 'undefined') {
                this.beforeSubmit()
            }
            this.loading = true
            const checkFileExistence = this.fields.findIndex(
                field => field.type === 'file',
            )
            let formValues = null
            if (checkFileExistence !== -1) {
                this.progress = true
                this.percent = 0
                const formData = new FormData()
                for (let key in values) {
                    formData.append(key, values[key] ?? '')
                }
                if (typeof this.hiddenFields !== 'undefined') {
                    for (let key in this.hiddenFields) {
                        formData.append(
                            this.hiddenFields[key]['name'],
                            this.hiddenFields[key]['value'],
                        )
                    }
                }
                formValues = formData
            } else {
                formValues = values
                if (typeof this.hiddenFields !== 'undefined') {
                    for (let key in this.hiddenFields) {
                        values[this.hiddenFields[key]['name']] =
                            this.hiddenFields[key]['value']
                    }
                }
            }
            try {
                const result = await this.$api({
                    url: this.action,
                    method: this.method ?? 'POST',
                    data: formValues,
                    onUploadProgress: progressEvent => {
                        this.percent = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total,
                        )
                    },
                })
                if (typeof this.onSubmitCompleted === 'function') {
                    this.onSubmitCompleted(result)
                }
                if ('result' in result.data) {
                    if (typeof result.data.result === 'boolean') {
                        if (result.data.result === false) {
                            this.$q.notify({
                                message: this.$translate(
                                    result?.data?.message ??
                                        'Something went wrong',
                                ),
                                color: 'red',
                            })
                        }
                    }
                }
            } catch (err) {
                errorHandler(err, actions.setErrors, this.$router)
            } finally {
                this.loading = false
                this.percent = 0
                this.progress = false
            }
        },
        async onSubmit(values, actions) {
            if (this.needConfirmation) {
                this.$q
                    .dialog({
                        title:
                            this.confirmationTitle ??
                            this.$translate('Confirmation'),
                        message:
                            this.confirmationMessage ??
                            this.$translate('Are you sure?'),
                        dir: this.$localization.direction,
                        cancel: {
                            label: this.$translate('No'),
                            color: 'green',
                        },
                        ok: {
                            label: this.$translate('Yes'),
                            color: 'red',
                        },
                    })
                    .onOk(async () => {
                        await this.submitForm(values, actions)
                    })
            } else {
                await this.submitForm(values, actions)
            }
        },
        onRejected(rejectedEntries) {
            this.$q.notify({
                type: 'negative',
                message: `${rejectedEntries.length} file(s) did not pass validation constraints`,
            })
        },
        handleDonwloadLink(download_link, target = '_blank') {
            window.open(download_link, target)
        },
    },
    data() {
        return {
            loading: false,
            progress: false,
            percent: 60,
        }
    },
}
</script>
