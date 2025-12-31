import {
    __VLS_internalComponent,
    __VLS_componentsOption,
    __VLS_name,
} from './DashboardChart.vue'

function __VLS_template() {
    let __VLS_ctx!: InstanceType<
        __VLS_PickNotAny<typeof __VLS_internalComponent, new () => {}>
    > & {}
    /* Components */
    let __VLS_otherComponents!: NonNullable<
        typeof __VLS_internalComponent extends { components: infer C } ? C : {}
    > &
        typeof __VLS_componentsOption
    let __VLS_own!: __VLS_SelfComponent<
        typeof __VLS_name,
        typeof __VLS_internalComponent &
            (new () => { $slots: typeof __VLS_slots })
    >
    let __VLS_localComponents!: typeof __VLS_otherComponents &
        Omit<typeof __VLS_own, keyof typeof __VLS_otherComponents>
    let __VLS_components!: typeof __VLS_localComponents &
        __VLS_GlobalComponents &
        typeof __VLS_ctx
    /* Style Scoped */
    type __VLS_StyleScopedClasses = {}
    let __VLS_styleScopedClasses!:
        | __VLS_StyleScopedClasses
        | keyof __VLS_StyleScopedClasses
        | (keyof __VLS_StyleScopedClasses)[]
    /* CSS variable injection */
    /* CSS variable injection end */
    let __VLS_resolvedLocalAndGlobalComponents!: {} & __VLS_WithComponent<
        'ProtectedComponent',
        typeof __VLS_localComponents,
        'ProtectedComponent',
        'ProtectedComponent',
        'ProtectedComponent'
    >
    __VLS_components.ProtectedComponent
    __VLS_components.ProtectedComponent
    // @ts-ignore
    ;[ProtectedComponent, ProtectedComponent]
    {
        let __VLS_0!: 'ProtectedComponent' extends keyof typeof __VLS_ctx
            ? typeof __VLS_ctx.ProtectedComponent
            : (typeof __VLS_resolvedLocalAndGlobalComponents)['ProtectedComponent']
        const __VLS_1 = __VLS_asFunctionalComponent(
            __VLS_0,
            new __VLS_0({ ...{} }),
        )
        ;(({}) as { ProtectedComponent: typeof __VLS_0 }).ProtectedComponent
        ;(({}) as { ProtectedComponent: typeof __VLS_0 }).ProtectedComponent
        const __VLS_2 = __VLS_1(
            { ...{} },
            ...__VLS_functionalComponentArgsRest(__VLS_1),
        )
        ;(
            ({}) as (
                props: __VLS_FunctionalComponentProps<
                    typeof __VLS_0,
                    typeof __VLS_2
                > &
                    Record<string, unknown>,
            ) => void
        )({ ...{} })
        const __VLS_3 = __VLS_pickFunctionalComponentCtx(__VLS_0, __VLS_2)!
        let __VLS_4!: __VLS_NormalizeEmits<typeof __VLS_3.emit>
    }
    if (
        typeof __VLS_styleScopedClasses === 'object' &&
        !Array.isArray(__VLS_styleScopedClasses)
    ) {
    }
    var __VLS_slots!: {}
    return __VLS_slots
}
