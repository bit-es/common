<?php

// config for Bites/Base
return [

    'service-menu' => [
        'options' => [
            'sss' => 'Staff Self Service',
            'pc' => 'Payroll and Compensation',
            'la' => 'Leave and Attendance',
            'be' => 'Benefits and Entitlements',
            'pm' => 'Performance Management',
            'cc' => 'Communication and Collaboration',
            'em' => 'Expense Management',
            'oo' => 'Onboarding and Offboarding',
            'sa' => 'Self-Service Analytics',
            'sh' => 'Support and Helpdesk',
            'op' => 'Operations',
            'sp' => 'Support',
            'lm' => 'Learning',
            'kb' => 'Knowledge Base',
            'ip' => 'Ideas',

        ],
        'icons' => [
            'sss' => 'heroicon-o-cursor-arrow-ripple',
            'pc' => 'hugeicons-bandage',
            'la' => 'hugeicons-bandage',
            'be' => 'hugeicons-bandage',
            'pm' => 'hugeicons-bandage',
            'cc' => 'hugeicons-bandage',
            'em' => 'hugeicons-bandage',
            'oo' => 'hugeicons-bandage',
            'sa' => 'hugeicons-bandage',
            'sh' => 'heroicon-o-lifebuoy',
            'op' => 'hugeicons-bandage',
            'sp' => 'heroicon-o-hand-raised',
            'lm' => 'heroicon-o-academic-cap',
            'kb' => 'hugeicons-bookshelf-03',
            'ip' => 'hugeicons-bandage',
            'td' => 'icon-turtle',
        ],
    ],

    'show_application_tab' => true,
    'show_logo_and_favicon' => false,
    'show_analytics_tab' => true,
    'show_seo_tab' => true,
    'show_email_tab' => true,
    'show_social_networks_tab' => true,
    'expiration_cache_config_time' => 60,
    'd_color' => '#f43f5e',
    'g_color' => '#6b7280',
    'i_color' => '#3b82f6',
    'p_color' => '#14b8a6',
    's_color' => '#10b981',
    'w_color' => '#f97316',

    'login_thru' => env('AUTH_METHOD', 'BuiltIn'),

    'initial_install' => false,  // Set this to true if install was done previously.
    'config-copy' => [
        __DIR__.'/../src/Enums' => app_path('Enums'),
        __DIR__.'/../src/Filament' => app_path('Filament'),
        __DIR__.'/../src/Models' => app_path('Models'),
        __DIR__.'/../src/Observers' => app_path('Observers'),
        __DIR__.'/../src/Providers' => app_path('Providers'),
        __DIR__.'/../src/Services' => app_path('Services'),
        __DIR__.'/../src/Storage/app/public' => storage_path('app/public'),
        __DIR__.'/../src/Storage/app/private' => storage_path('/app/private'),
        __DIR__.'/../src/Public' => public_path(),
        __DIR__.'/../database/seeders' => database_path('seeders'),
        __DIR__.'/../database/factories' => database_path('factories'),
        __DIR__.'/../resources/views' => resource_path('views'),
    ],
    'addServiceProviders' => [
        'App\\Providers\\Filament\\AdminPanelProvider',
        'App\\Providers\\Filament\\EditorPanelProvider',
        'App\\Providers\\Filament\\StaffPanelProvider',
        'App\\Providers\\FolioServiceProvider',
    ],
    'appendItems' => [
        // 'providers' => [
        //     'paths' => base_path('bootstrap/providers.php'),
        //     'before' => '];',
        //     'items' => [
        //         'App\\Providers\\Filament\\AdminPanelProvider::class,',
        //         'App\\Providers\\Filament\\EditorPanelProvider::class,',
        //         'App\\Providers\\Filament\\StaffPanelProvider::class,',
        //     ],
        // ],
        'env' => [
            'paths' => base_path('./.env'),
            'before' => 'EOF',
            'items' => [
                'AUTH_METHOD=socialite',
                '',
                'MANDATORY_RETIREMENT_AGE=65',
            ],
        ],
        'web routes' => [
            'paths' => base_path('routes/web.php'),
            'before' => "Route::view('dashboard', 'dashboard')->name('dashboard');",
            'items' => [
                "Route::view('self-service', 'self-service')->name('self-service');",
                "Route::view('test', 'test')->name('test');",
            ],
        ],
    ],
    'appendConfigFiles' => [
        'app' => [
            'paths' => base_path('config/app.php'),
            'items' => [
                'name' => "env('APP_NAME', 'Bites')", // Laravel
                'url' => "env('APP_URL', 'http://localhost')",
                'timezone' => "'Asia/Kuala_Lumpur'", // UTC
                'locale' => "env('APP_LOCALE', 'en')", // en
                'fallback_locale' => "env('APP_FALLBACK_LOCALE', 'ms')", // en
                'faker_locale' => "env('APP_FAKER_LOCALE', 'ms')", // en
            ],
        ],
    ],
    'roles' => [

        // 'resources' => [
        //     'PermissionResource' => \App\Filament\Resources\PermissionResource::class,
        //     'RoleResource' => \App\Filament\Resources\RoleResource::class,
        // ],

        'preload_roles' => true,

        'preload_permissions' => true,

        'navigation_section_group' => 'roles.section.roles_and_permissions', // Default uses language constant

        // 'team_model' => \App\Models\Team::class,

        'scope_to_tenant' => true,

        'super_admin_role_name' => 'Super Admin',

        /*
         * Set as false to remove from navigation.
         */
        'should_register_on_navigation' => [
            'permissions' => true,
            'roles' => true,
        ],

        'should_show_permissions_for_roles' => true,

        /*
         * Set as true to use simple modal resource.
         */
        'should_use_simple_modal_resource' => [
            'permissions' => false,
            'roles' => false,
        ],

        /*
         * Set as true to remove empty state actions.
         */
        'should_remove_empty_state_actions' => [
            'permissions' => false,
            'roles' => false,
        ],

        /**
         * Set to true to redirect to the resource index instead of the view
         */
        'should_redirect_to_index' => [
            'permissions' => [
                'after_create' => false,
                'after_edit' => false,
            ],
            'roles' => [
                'after_create' => false,
                'after_edit' => false,
            ],
        ],

        /**
         * Set to true to display relation managers in the resources
         */
        'should_display_relation_managers' => [
            'permissions' => true,
            'users' => true,
            'roles' => true,
        ],

        /*
         * If you want to place the Resource in a Cluster, then set the required Cluster class.
         * Eg. \App\Filament\Clusters\Cluster::class
         */
        'clusters' => [
            'permissions' => null,
            'roles' => null,
        ],

        'guard_names' => [
            'web' => 'web',
            'api' => 'api',
        ],

        'toggleable_guard_names' => [
            'roles' => [
                'isToggledHiddenByDefault' => true,
            ],
            'permissions' => [
                'isToggledHiddenByDefault' => true,
            ],
        ],

        'default_guard_name' => null,

        // if false guard option will not be show on screen. You should set a default_guard_name in this case
        'should_show_guard' => true,

        'model_filter_key' => 'return \'%\'.$value;', // Eg: 'return \'%\'.$key.'\%\';'

        'user_name_column' => 'name',

        /*
         * If user_name_column is an accessor from a model, then list columns to search.
         * Default: null, will search by user_name_column
         *
         * Example:
         *
         * 'user_name_searchable_columns' => ['first_name', 'last_name']
         *
         * and in your model:
         *
         * public function getFullNameAttribute() {
         *    return $this->first_name . ' ' . $this->last_name;
         * }
         *
         */
        'user_name_searchable_columns' => ['name'],

        /*
         * Icons to use for navigation
         */
        'icons' => [
            'role_navigation' => 'phosphor-key',
            'permission_navigation' => 'phosphor-lock-key',
        ],

        /*
         *  Navigation items order - int value, false  restores the default position
         */

        'sort' => [
            'role_navigation' => false,
            'permission_navigation' => false,
        ],

        'generator' => [

            'guard_names' => [
                'web',
                'api',
            ],

            'permission_affixes' => [

                /*
                 * Permissions Aligned with Policies.
                 * DO NOT change the keys unless the genericPolicy.stub is published and altered accordingly
                 */
                'viewAnyPermission' => 'view-any',
                'viewPermission' => 'view',
                'createPermission' => 'create',
                'updatePermission' => 'update',
                'deletePermission' => 'delete',
                'deleteAnyPermission' => 'delete-any',
                'replicatePermission' => 'replicate',
                'restorePermission' => 'restore',
                'restoreAnyPermission' => 'restore-any',
                'reorderPermission' => 'reorder',
                'forceDeletePermission' => 'force-delete',
                'forceDeleteAnyPermission' => 'force-delete-any',
            ],

            /*
             * returns the "name" for the permission.
             *
             * $permission which is an iteration of [permission_affixes] ,
             * $model The model to which the $permission will be concatenated
             *
             * Eg: 'permission_name' => 'return $permissionAffix . ' ' . Str::kebab($modelName),
             *
             * Note: If you are changing the "permission_name" , It's recommended to run with --clean to avoid duplications
             */
            'permission_name' => 'return $permissionAffix . \' \' . $modelName;',

            /*
             * Permissions will be generated for the models associated with the respective Filament Resources
             */
            'discover_models_through_filament_resources' => false,

            /*
             * Include directories which consists of models.
             */
            'model_directories' => [
                app_path('Models'),
                // app_path('Domains/Forum')
            ],

            /*
             * Define custom_models
             */
            'custom_models' => [
                //
            ],

            /*
             * Define excluded_models
             */
            'excluded_models' => [
                //
            ],

            'excluded_policy_models' => [
                \App\Models\User::class,
            ],

            /*
             * Define any other permission that should be synced with the DB
             */
            'custom_permissions' => [
                // 'view-log'
            ],

            'user_model' => \App\Models\User::class,

            'policies_namespace' => 'App\Policies',
        ],
    ],
];
