<template>
    <div
        v-if="fullPageLoading"
        class="flex items-center justify-center h-screen bg-gradient-to-br from-blue-50 to-indigo-100"
    >
        <div class="text-center">
            <q-spinner color="primary" size="4rem" :thickness="3" />
            <p class="mt-4 text-gray-600 font-medium">Loading...</p>
        </div>
    </div>

    <div
        v-else
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-100 flex items-center justify-center p-4"
    >
        <!-- Background decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"
            ></div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"
            ></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"
            ></div>
        </div>

        <div
            class="relative w-full max-w-md transform transition-all duration-500 hover:scale-[1.02]"
        >


            <!-- Login Card -->
            <div
                class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl shadow-blue-100/50 border border-white/20 overflow-hidden"
            >
                <!-- Header with gradient -->
                <div
                    class="relative bg-gradient-to-r from-blue-500 via-blue-600 to-purple-600 px-6 py-8"
                >
                    <div class="absolute inset-0 bg-black/5"></div>
                    <h3
                        class="text-2xl font-bold text-center text-white relative z-10"
                    >
                        {{ $translate('Sign in') }}
                    </h3>
                    <div class="flex justify-center mt-2">
                        <div class="w-12 h-1 bg-white/40 rounded-full"></div>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="p-8">
                    <ValidationForm
                        :validation-schema="schema"
                        @submit="onSubmit"
                        class="space-y-6"
                    >
                        <!-- Email Field -->
                        <Field
                            name="email"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-medium text-gray-700 flex items-center"
                                >
                                    <q-icon
                                        name="email"
                                        size="1rem"
                                        class="mr-2 text-blue-500"
                                    />
                                    Email Address
                                </label>
                                <q-input
                                    :model-value="value"
                                    v-bind="field"
                                    :error-message="$translate(errorMessage)"
                                    :error="!!errorMessage"
                                    outlined
                                    dense
                                    placeholder="Enter your email"
                                    class="rounded-lg"
                                    :class="{
                                        'shake-animation': !!errorMessage,
                                    }"
                                >
                                    <template v-slot:prepend>
                                        <q-icon
                                            name="person"
                                            class="text-blue-500"
                                        />
                                    </template>
                                </q-input>
                                <div
                                    v-if="errorMessage"
                                    class="flex items-center text-red-500 text-sm mt-1 animate-fade-in"
                                >
                                    <q-icon
                                        name="error"
                                        size="1rem"
                                        class="mr-1"
                                    />
                                    {{ $translate(errorMessage) }}
                                </div>
                            </div>
                        </Field>

                        <!-- Password Field -->
                        <Field
                            name="password"
                            v-slot="{ errorMessage, value, field }"
                        >
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-medium text-gray-700 flex items-center"
                                >
                                    <q-icon
                                        name="lock"
                                        size="1rem"
                                        class="mr-2 text-blue-500"
                                    />
                                    Password
                                </label>
                                <q-input
                                    :model-value="value"
                                    v-bind="field"
                                    :error-message="$translate(errorMessage)"
                                    :error="!!errorMessage"
                                    outlined
                                    dense
                                    placeholder="Enter your password"
                                    class="rounded-lg"
                                    :type="showPassword ? 'text' : 'password'"
                                    :class="{
                                        'shake-animation': !!errorMessage,
                                    }"
                                >
                                    <template v-slot:prepend>
                                        <q-icon
                                            name="lock"
                                            class="text-blue-500"
                                        />
                                    </template>
                                    <template v-slot:append>
                                        <q-btn
                                            :icon="
                                                showPassword
                                                    ? 'visibility_off'
                                                    : 'visibility'
                                            "
                                            size="sm"
                                            round
                                            flat
                                            dense
                                            @click="onPasswordButtonClick"
                                            class="text-gray-500 hover:text-blue-500 transition-colors"
                                        />
                                    </template>
                                </q-input>
                                <div
                                    v-if="errorMessage"
                                    class="flex items-center text-red-500 text-sm mt-1 animate-fade-in"
                                >
                                    <q-icon
                                        name="error"
                                        size="1rem"
                                        class="mr-1"
                                    />
                                    {{ $translate(errorMessage) }}
                                </div>
                            </div>
                        </Field>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <Field name="remember" v-slot="{ value, field }">
                                <q-toggle
                                    v-bind="field"
                                    :model-value="value"
                                    :label="$translate('Remember me')"
                                    color="blue"
                                    size="sm"
                                />
                            </Field>
                            <a
                                href="#"
                                class="text-sm text-blue-600 hover:text-blue-800 transition-colors font-medium"
                            >
                                Forgot password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <q-btn
                            color="primary"
                            :loading="loading"
                            type="submit"
                            class="w-full rounded-lg py-3 shadow-lg hover:shadow-xl transform transition-all duration-300 hover:-translate-y-0.5"
                            :icon-right="loading ? '' : 'login'"
                            :label="
                                loading
                                    ? 'Signing in...'
                                    : $translate('Sign In')
                            "
                            :disable="loading"
                        >
                            <template v-slot:loading>
                                <q-spinner color="white" size="1.5rem" />
                            </template>
                        </q-btn>
                    </ValidationForm>

                    <!-- Divider -->
<!--                    <div class="relative my-8">-->
<!--                        <div class="absolute inset-0 flex items-center">-->
<!--                            <div class="w-full border-t border-gray-300"></div>-->
<!--                        </div>-->
<!--                        <div class="relative flex justify-center text-sm">-->
<!--                            <span class="px-4 bg-white/80 text-gray-500"-->
<!--                                >Or continue with</span-->
<!--                            >-->
<!--                        </div>-->
<!--                    </div>-->

                    <!-- Social Login -->
<!--                    <div class="grid grid-cols-2 gap-3">-->
<!--                        <q-btn-->
<!--                            outline-->
<!--                            color="gray"-->
<!--                            class="rounded-lg border-gray-300 hover:border-blue-400 hover:bg-blue-50 transition-all"-->
<!--                            icon="img:/google.svg"-->
<!--                            label="Google"-->
<!--                        />-->
<!--                        <q-btn-->
<!--                            outline-->
<!--                            color="gray"-->
<!--                            class="rounded-lg border-gray-300 hover:border-blue-400 hover:bg-blue-50 transition-all"-->
<!--                            icon="img:/github.svg"-->
<!--                            label="GitHub"-->
<!--                        />-->
<!--                    </div>-->

<!--                    &lt;!&ndash; Sign Up Link &ndash;&gt;-->
<!--                    <div class="text-center mt-8">-->
<!--                        <p class="text-gray-600">-->
<!--                            Don't have an account?-->
<!--                            <a-->
<!--                                href="#"-->
<!--                                class="text-blue-600 hover:text-blue-800 font-semibold transition-colors ml-1"-->
<!--                            >-->
<!--                                Sign up-->
<!--                            </a>-->
<!--                        </p>-->
<!--                    </div>-->
                </div>
            </div>

            <!-- Copyright -->
            <div class="text-center mt-6">
                <p class="text-gray-400 text-sm">
                    © 2024 Your Company. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import { computed, defineComponent, ref } from 'vue'
import { Form as ValidationForm, Field } from 'vee-validate'
import * as yup from 'yup'
import { useAuthStore } from 'stores/UserManagementStores/AuthStore'
import { useQuasar } from 'quasar'
import { errorHandler } from 'src/lib/errorHandler'
import { useRouter } from 'vue-router/dist/vue-router'

export default defineComponent({
    name: 'LoginPage',
    components: {
        ValidationForm,
        Field,
    },
    setup() {
        const authStore = useAuthStore()
        const q = useQuasar()
        const router = useRouter()
        const schema = yup.object({
            email: yup
                .string()
                .email('Please enter a valid email')
                .required('Email is required'),
            remember: yup.boolean().default(false),
            password: yup
                .string()
                .required('Password is required')
                .min(6, 'Password must be at least 6 characters')
                .label('Password'),
        })
        return {
            schema,
            q,
            router,
            authStore,
        }
    },
    data() {
        return {
            email: '',
            password: '',
            showPassword: false,
            loading: false,
            fullPageLoading: true,
        }
    },
    methods: {
        onPasswordButtonClick() {
            this.showPassword = !this.showPassword
        },
        async onSubmit(values, actions) {
            this.loading = true

            try {
                await this.authStore.getToken()
                const result = await this.authStore.login(
                    values?.email,
                    values?.password,
                    values?.remember,
                )
                this.loading = false
                this.authStore.token = result.data
                localStorage.setItem('token', result.data)

                // Success notification with animation
                this.$q.notify({
                    message: 'Logged in successfully!',
                    color: 'positive',
                    icon: 'check_circle',
                    position: 'top-right',
                    timeout: 2000,
                    progress: true,
                    classes: 'animated fadeInRight',
                })

                await this.router.push('/')
                window.location.reload()
            } catch (e) {
                this.loading = false

                // Error notification
                this.$q.notify({
                    message: 'Login failed. Please check your credentials.',
                    color: 'negative',
                    icon: 'error',
                    position: 'top-right',
                    timeout: 3000,
                    progress: true,
                    classes: 'animated shake',
                })

                errorHandler(e, actions.setErrors)
            }
        },
    },
    async mounted() {
        try {
            await this.authStore.getLoggedInUse()
            this.router.push('/')
        } catch (e) {
            this.fullPageLoading = false
        }
    },
})
</script>

<style scoped>
/* Animations */
@keyframes blob {
    0% {
        transform: translate(0px, 0px) scale(1);
    }
    33% {
        transform: translate(30px, -50px) scale(1.1);
    }
    66% {
        transform: translate(-20px, 20px) scale(0.9);
    }
    100% {
        transform: translate(0px, 0px) scale(1);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%,
    100% {
        transform: translateX(0);
    }
    10%,
    30%,
    50%,
    70%,
    90% {
        transform: translateX(-5px);
    }
    20%,
    40%,
    60%,
    80% {
        transform: translateX(5px);
    }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

.shake-animation {
    animation: shake 0.5s ease-in-out;
}

/* Custom scrollbar for form */
::v-deep(.q-field__control) {
    border-radius: 0.5rem !important;
    transition: all 0.3s ease !important;
}

::v-deep(.q-field--outlined .q-field__control:before) {
    border-color: #e5e7eb !important;
}

::v-deep(.q-field--outlined:hover .q-field__control:before) {
    border-color: #3b82f6 !important;
}

::v-deep(.q-field--focused .q-field__control:before) {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Custom button styling */
::v-deep(.q-btn--primary) {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%) !important;
    border: none !important;
}

::v-deep(.q-btn--primary:hover:not(.disabled)) {
    background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%) !important;
    transform: translateY(-1px);
}
</style>
