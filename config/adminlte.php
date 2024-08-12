<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Sofia Organic',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>SOFIA</b>organic',
    'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-1',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => true,
    'sidebar_collapse_remember' => true,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'dashboard',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => true,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */
     
        'menu' => [
            // Navbar items:
            [
                'type' => 'navbar-search',
                'text' => 'search',
                'topnav_right' => true,
            ],
            [
                'type' => 'fullscreen-widget',
                'topnav_right' => true,
            ],

            // Sidebar items:
            [
                'type' => 'sidebar-menu-search',
                'text' => 'search',
            ],
            [
                'text' => 'ዳሽቦርድ',
                'route' => 'dashboard',
                'icon' => 'fas fa-fw fa-home',
            ],
           
            [
                'text' => 'የተጠቃሚ አስተዳደር',
                'icon' => 'fas fa-fw fa-users',
                'submenu' =>[

                    [
                        'text' => 'ተጠቃሚ',
                        'url' => '/users/user',
                        'permission' => 'edit-user',
                        'can' => 'view users',
                    ],
                    [
                        'text' => 'ሚና',
                        'url' => '/users/role',
                        'can' => 'view role',
                    ]
                    // [
                    //     'text' => 'ፍቃድ',
                    //     'url' => '/users/permission',
                    // ]

                ],
                
                
            ],
            [
                'text' => 'የሰራተኞች አስተዳደር',
                'icon' => 'fas fa-fw fa-users',
                'submenu' =>[

                    [
                        'text' => 'ሰራተኛ',
                        'url' => '/employees/employee',
                        'can' => 'view employee',
                    ],
                    [
                        'text' => 'የሰራተኛ ደሞዝ',
                        'url' => '/employees/salary',
                        'can' => 'view employee salary',
                    ],
                    [
                        'text' => 'የሰራተኛ ብድር',
                        'url' => '/employees/credit',
                        'can' => 'view employee credit',
                    ],

                ],
                
            ],
            
                
            [
                'text' => 'የአድራሻ አስተዳደር',
                'icon' => 'fas fa-fw fa-map-marker',
                'submenu' =>[

                    [
                        'text' => 'ክልል',
                        'url' => '/address/region',
                        'can' => 'view region',
                    ],
                    [
                        'text' => 'ዞን',
                        'url' => '/address/zone',
                        'can' => 'view zone',
                    ],
                    [
                        'text' => 'ወረዳ',
                        'url' => '/address/woreda',
                        'can' => 'view woreda',
                    ],
                    [
                        'text' => 'ቅርንጫፍ',
                        'url' => '/address/branch',
                        'can' => 'view branch',
                    ],

                ],
                
            ],
            [
                'text' => 'የቁሳቁስ አስተዳደር',
                'icon' => 'fas fa-fw fa-cubes',
                'submenu' =>[

                    [
                        'text' => 'ጫት',
                        'url' => '/material/khat',
                        'can' => 'view khat',
                    ],
                    [
                        'text' => 'ለስላሳ መጠጥ',
                        'url' => '/material/soft_drink',
                        'can' => 'view soft drink',
                    ],
                    [
                        'text' => 'ሲጋራ',
                        'url' => '/material/cigarate',
                        'can' => 'view cigarate',
                    ],
                    [
                        'text' => 'ሎዝ',
                        'url' => '/material/lozi',
                        'can' => 'view lozi',
                    ],
                    [
                        'text' => 'መደብር',
                        'url' => '/material/store',
                        'can' => 'view store',
                    ],

                ],
                
            ],
            [
                'text' => 'የቀን ሕሳብ',
                'icon' => 'fas fa-fw fa-briefcase',
                'submenu' =>[
                    
                    
                    [
                        'text' => 'የመጣ ጫት',
                        'url' => '/dailywork/yemetakhat',
                        'can' => 'view yemeta khat',
                    ],
                    [
                        'text' => 'የጫት ሕሳብ',
                        'url' => '/dailywork/dailyworkkhat',
                        'can' => 'view khat hisabi',
                    ],
                    [
                        'text' => 'የለስላሳ መጠጦች ሕሳብ',
                        'url' => '/dailywork/dailyworksoftdrink',
                        'can' => 'view soft drink hisabi',
                    ],
                    [
                        'text' => 'የሎዝ ሕሳብ',
                        'url' => '/dailywork/dailyworklozi',
                        'can' => 'view lozi hisabi',
                    ],
                    [
                        'text' => 'የሲጋራ ሕሳብ',
                        'url' => '/dailywork/dailyworkcigarates',
                        'can' => 'view cigarate hisabi',
                    ],
                    [
                        'text' => 'አካውንት',
                        'url' => '/dailywork/dailyworkaccount',
                        'can' => 'view account',
                    ],
                    [
                        'text' => 'ዱቤ',
                        'url' => '/dailywork/dailyworkcredit',
                        'can' => 'view credit',
                    ],
                    [
                        'text' => 'የተከፈለ',
                        'url' => '/dailywork/dailyworkyetekefele',
                        'can' => 'view yetekefele',
                    ],
                    [
                        'text' => 'ወጭ',
                        'url' => '/dailywork/dailyworkwoci',
                        'can' => 'view woci',
                    ],
                    [
                        'text' => 'ብር',
                        'url' => '/dailywork/dailyworkbirr',
                        'can' => 'view birr',
                    ],

                ],
                
            ],
            [
                'text' => 'ሪፖርት',
                'icon' => 'fas fa-fw fa-chart-bar',
                'submenu' =>[

                    [
                        'text' => 'የቅሪንጫፍ ሕሳብ',
                        'url' => '/report/branchreport',
                        'can' => 'view branch report',
                    ],
                    [
                        'text' => 'የጎደለ ሕሳብ',
                        'url' => '/dailywork/dailyworkgudilet',
                        'can' => 'view gudilet',
                    ],
                    
                    [
                        'text' => 'የላክዎች ሕሳብ',
                        'url' => '/report/exportereport',
                        'can' => 'view exporter report',
                    ],
                    
                    [
                        'text' => 'የጠፋ  ፋይል',
                        'url' => 'deleted_files',
                        'can' => 'view deleted file',
                    ],
                    
                    

                ],
                // 'can' => 'view branch report',
                
            ],
            




        ],

    
    
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
