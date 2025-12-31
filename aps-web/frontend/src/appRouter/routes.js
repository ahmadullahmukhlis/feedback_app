export const appRoutes = {
    user_management: {
        users: {
            api: '/user-management/users',
            details: {
                path: '/user-management/users/:id/:active',
            },
        },
        customers: {
            api: '/user-management/customers',
            details: {
                path: '/user-management/customers/:id/:active',
            },
        },
        suppliers: {
            api: '/user-management/suppliers',
        },
        activity_log: {
            api: {
                user_log: 'user-management/activity-log/user-log/:id',
                get_log: 'user-management/activity-log/:log',
                restore_log: 'user-management/activity-log/restore-log/:log',
                index: 'user-management/activity-log',
            },
        },
        login_log: {
            api: 'user-management/login-log',
        },
        roles: {
            api: '/user-management/roles',
            role_details: {
                path: '/user-management/roles/{id}/{name}',
                api: '/user-management/roles/{id}',
            },
        },
        permission: {
            api: '/user-management/permission',
            permission_group_api: '/user-management/permission-groups',
        },
    },
    product_management: {
        products: {
            api: 'products-management/products',
            product_stock_api: 'products-management/product/stock/:id',
            product_unit_conversions:
                'products-management/product/unit_conversions/:id',
            image_update_api: 'products-management/update/product/image',
            image_delete_api: 'products-management/delete/product/image/:id',
        },
        categories: {
            api: 'products-management/categories',
        },
        brands: {
            api: 'products-management/brands',
        },
        units: {
            base_units: {
                api: 'products-management/units/base-units',
                units_api: 'products-management/units/base-unit/{unit}/units',
            },
            units_conversion: {
                api: 'products-management/units/conversions',
            },
        },
    },
    expenseManagement: {
        expenses: {
            api: 'expenses',
        },
        expenses_categories: {
            api: 'expense-category',
        },
    },
    adjustments: {
        api: '/adjustments',
    },
    purchase: {
        api: '/purchase',
    },
    sale: {
        api: '/sale',
    },
    direct_sale: {
        api: '/direct-sale',
    },
    exchange: {
        api: '/product_exchange',
    },
    quotation: {
        api: '/quotations',
    },
    sale_return: {
        api: '/sale_return',
        search_api: '/sale_return/search',
    },
    transfer: {
        api: '/transfer',
    },
    payment: {
        api: '/payment',
    },
    purchase_return: {
        api: '/purchase_return',
        search_api: '/purchase_return/search',
    },
    configurations: {
        systemConfiguration: {
            softwareConfiguration: {
                api: 'configurations/software-configurations/software-settings',
            },
            currencyConfiguration: {
                api: 'configurations/software-configurations/currency',
            },
            warehouse: {
                api: 'configurations/software-configurations/warehouse',
            },
            payment_methods: {
                api: 'configurations/software-configurations/payment-methods',
            },
            capital_entry: {
                api: 'configurations/software-configurations/capital-entry',
            },
            profit_withdrawal: {
                api: 'configurations/software-configurations/profit-withdrawal',
            },
        },
        languages: {
            api: 'configurations/languages',
            details: {
                path: '/configurations/languages/:id/:name',
                api: 'configurations/language/words',
            },
        },
        backup: {
            api: 'configurations/backup/run',
            index_api: 'configurations/backup',
            backup_list_api: 'configurations/backup/list',
            change_backup: 'configurations/backup/change',
            delete_api: 'configurations/backup/delete',
        },
    },
    general_apis: {
        province: 'general/province',
    },
    reporting: {
        api: 'reporting/{report}',
    },
}
