export const configurationRoutes = {
    component: () => import('layouts/ConfigurationsLayout.vue'),
    path: '/configurations',
    children: [
        {
            path: '',
            component: () =>
                import('pages/Configurations/ConfigurationsPage.vue'),
            meta: {
                breadcrumb: [
                    {
                        text: 'Configurations',
                        link: '',
                    },
                ],
                active: '',
            },
        },
        {
            path: 'languages',
            children: [
                {
                    path: '',
                    component: () =>
                        import(
                            'pages/Configurations/Languages/LanguagePage.vue'
                        ),
                    meta: {
                        active: 'languages',
                        breadcrumb: [
                            {
                                text: 'Configurations',
                                link: '/configurations',
                            },
                            {
                                text: 'Languages',
                                link: '/configurations/languages',
                            },
                        ],
                    },
                },
                {
                    path: ':id/:name',
                    component: () =>
                        import(
                            'pages/Configurations/Languages/LanguageDetails/LanguageDetailsPage.vue'
                        ),
                    meta: {
                        active: 'languages',
                        breadcrumb: [
                            {
                                text: 'Configurations',
                                link: '/configurations',
                            },
                            {
                                text: 'Languages',
                                link: '/configurations/languages',
                            },
                            {
                                text: 'Language dictionary',
                                link: '',
                            },
                        ],
                    },
                },
            ],
        },
        {
            path: 'backups',
            children: [
                {
                    path: '',
                    component: () =>
                        import('pages/Configurations/Backups/BackupsPage.vue'),
                },
            ],
            meta: {
                breadcrumb: [
                    {
                        text: 'Configurations',
                        link: '/configurations',
                    },
                    {
                        text: 'Backups',
                        link: '/configurations/languages',
                    },
                ],
                active: 'backups',
            },
        },
    ],
}
