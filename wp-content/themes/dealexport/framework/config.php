<?php
//Theme Configuration
$config = array (
    
    //Theme Modules
    'modules' => array(
        'ThemedbInterface',
        'ThemedbShortcode',
        'ThemedbSidebar',
        'ThemedbForm',
        'ThemedbStyle',
        'ThemedbUser',
        'ThemedbShop',
        'ThemedbWoo',
        'ThemedbFacebook',
    ),
    
    //Theme Components
    'components' => array(
    
        //Supports
        'supports' => array (
            'automatic-feed-links',
            'post-thumbnails',
            'woocommerce',
        ),
        
        //Rewrite Rules
        'rewrite_rules' => array (
            'register' => array(
                'title' => __('Registration', 'dealexport'),
                'name' => 'register',
                'rule' => 'register/?',
                'rewrite' => 'index.php?register=1',
                'position' => 'top',
                'private' => false,
            ),
            
            'profile' => array(
                'name' => 'profile',
                'rule' => 'author_base',
                'rewrite' => 'profile',
                'position' => 'top',
                'replace' => true,
                'dynamic' => true,
                'private' => true,
            ),
            
            'profile-address' => array(
                'title' => __('My Account', 'dealexport'),
                'name' => 'profile-address',
                'rule' => 'profile-address/?',
                'rewrite' => 'index.php?profile-address=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'profile-links' => array(
                'title' => __('My Account', 'dealexport'),
                'name' => 'profile-links',
                'rule' => 'profile-links/?',
                'rewrite' => 'index.php?profile-links=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'profile-settings' => array(
                'title' => __('My Account', 'dealexport'),
                'name' => 'profile-settings',
                'rule' => 'profile-settings/?',
                'rewrite' => 'index.php?profile-settings=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'profile-referrals' => array(
                'title' => __('My Account', 'dealexport'),
                'name' => 'profile-referrals',
                'rule' => 'profile-referrals/?',
                'rewrite' => 'index.php?profile-referrals=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'profile-earnings' => array(
                'title' => __('My Account', 'dealexport'),
                'name' => 'profile-earnings',
                'rule' => 'profile-earnings/?',
                'rewrite' => 'index.php?profile-earnings=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'shop-settings' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-settings',
                'rule' => 'shop-settings/?',
                'rewrite' => 'index.php?shop-settings=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'shop-products' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-products',
                'rule' => 'shop-products/?',
                'rewrite' => 'index.php?shop-products=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'shop-product' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-product',
                'rule' => 'shop-product/([^/]+)',
                'rewrite' => 'index.php?shop-product=$matches[1]',
                'position' => 'top',
                'dynamic' => true,
                'private' => true,
            ),
            
            'shop-orders' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-orders',
                'rule' => 'shop-orders/?',
                'rewrite' => 'index.php?shop-orders=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'shop-order' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-order',
                'rule' => 'shop-order/([^/]+)',
                'rewrite' => 'index.php?shop-order=$matches[1]',
                'position' => 'top',
                'dynamic' => true,
                'private' => true,
            ),
            
            'shop-shipping' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-shipping',
                'rule' => 'shop-shipping/?',
                'rewrite' => 'index.php?shop-shipping=1',
                'position' => 'top',
                'private' => true,
            ),
            
            'shop-membership' => array(
                'title' => __('My Shop', 'dealexport'),
                'name' => 'shop-membership',
                'rule' => 'shop-membership/?',
                'rewrite' => 'index.php?shop-membership=1',
                'position' => 'top',
                'private' => true,
            ),
        ),
    
        //User Roles
        'user_roles' => array(
            array(
                'role' => 'inactive',
                'name' => __('Inactive', 'dealexport'),
                'capabilities' => array(),
            ),
        ),
        
        //Custom Menus
        'custom_menus' => array(
            array(
                'slug' => 'top_menu',
                'name' => __('Top Menu', 'dealexport'),
            ),
            array(
                'slug' => 'main_menu',
                'name' => __('Main Menu', 'dealexport'),
            ),
            
            array(
                'slug' => 'footer_menu',
                'name' => __('Footer Menu', 'dealexport'),
            ),
        ),
        
        //Image Sizes
        'image_sizes' => array (
            array(
                'name' => 'small',
                'width' => 200,
                'height' => 200,
                'crop' => true,
            ),
            
            array(
                'name' => 'normal',
                'width' => 420,
                'height' => 9999,
                'crop' => false,
            ),
            
            array(
                'name' => 'extended',
                'width' => 738,
                'height' => 9999,
                'crop' => false,
            ),	
        ),
        
        //Editor styles
        'editor_styles' => array(

        ),
        
        //Admin Styles
        'admin_styles' => array(
            
            //colorpicker
            array(
                'name' => 'wp-color-picker',
            ),
            
            //thickbox
            array(	
                'name' => 'thickbox',
            ),
            
            //interface
            array(	
                'name' => 'Themedb-style',
                'uri' => THEMEDB_URI.'assets/css/style.css'
            ),			
        ),
        
        //Admin Scripts
        'admin_scripts' => array(
            
            //colorpicker
            array(
                'name' => 'wp-color-picker',
            ),
            
            //thickbox
            array(	
                'name' => 'thickbox',
            ),
            
            //uploader
            array(	
                'name' => 'media-upload',
            ),
            
            //slider
            array(	
                'name' => 'jquery-ui-slider',
            ),
            
            //popup
            array(
                'name' => 'Themedb-popup',
                'uri' => THEMEDB_URI.'assets/js/themedb.popup.js',
            ),
            
            //interface
            array(
                'name' => 'Themedb-interface',
                'uri' => THEMEDB_URI.'assets/js/themedb.interface.js',
            ),
        ),
        
        //User Styles
        'user_styles' => array(
        
            //colorbox
            array(	
                'name' => 'colorbox',
                'uri' => THEME_URI.'js/colorbox/colorbox.css',
            ),
        
            //general
            array(	
                'name' => 'general',
                'uri' => CHILD_URI.'style.css',
            ),
            //beacon-ui style
            array(
                    'name' => 'beacon ui',
                    'uri' => CHILD_URI.'beacon-ui.css',
            ),
        ),
        
        //User Scripts
        'user_scripts' => array(
            
            //jquery
            array(	
                'name' => 'jquery',
            ),
            
            //comment reply
            array(	
                'name' => 'comment-reply',
            ),
            
            //hover intent
            array(	
                'name' => 'hover-intent',
                'uri' => THEME_URI.'js/jquery.hoverIntent.min.js',
            ),
            
            //colorbox
            array(	
                'name' => 'colorbox',
                'uri' => THEME_URI.'js/colorbox/jquery.colorbox.min.js',
            ),
            
            //placeholder
            array(	
                'name' => 'placeholder',
                'uri' => THEME_URI.'js/jquery.placeholder.min.js',
            ),
            
            //slider
            array(	
                'name' => 'Themedb-slider',
                'uri' => THEME_URI.'js/jquery.themedbSlider.js',
            ),
            
            //autosave
            array(	
                'name' => 'Themedb-autosave',
                'uri' => THEME_URI.'js/jquery.themedbAutosave.js',
            ),
            
            //raty
            array(	
                'name' => 'raty',
                'uri' => THEME_URI.'js/jquery.raty.min.js',
                'options' => array(
                    'templateDirectory' => THEME_URI,
                ),
            ),

            //general
            array(
                'name' => 'general',
                'uri' => THEME_URI.'js/general.js',
                'options' => array(
                    'templateDirectory' => THEME_URI,
                ),
            ),
        ),
        
        //Widget Settings
        'widget_settings' => array (
            'before_widget' => '<div class="widget sidebar-widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="widget-title"><h4>',
            'after_title' => '</h4></div>',
        ),
        
        //Widget Areas
        'widget_areas' => array (
        
            array(
                'id' => 'profile',
                'name' => __('Profile', 'dealexport'),
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',
            ),
            
            array(
                'id' => 'shops',
                'name' => __('Shops', 'dealexport'),
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',
            ),
            
            array(
                'id' => 'shop',
                'name' => __('Shop', 'dealexport'),
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',
            ),
            
            array(
                'id' => 'products',
                'name' => __('Products', 'dealexport'),
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',
            ),
            
            array(
                'id' => 'product',
                'name' => __('Product', 'dealexport'),
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',
            ),
            
            array(
                'id' => 'footer',
                'name' => __('Footer', 'dealexport'),
                'before_widget' => '<div class="container"><div class="footer-widget %2$s">',
                'after_widget' => '</div></div>',
                'before_title' => '<div class="widget-title"><h4>',
                'after_title' => '</h4></div>',	
            ),
        ),
        
        //Widgets
        'widgets' => array (
            'ThemedbSearch',
        ),
        
        //Post Types
        'post_types' => array (
        
            //Shop
            array (
                'id' => 'shop',
                'labels' => array (
                    'name' => __('Shops', 'dealexport'),
                    'singular_name' => __('Shop', 'dealexport' ),
                    'add_new' => __('Add New', 'dealexport'),
                    'add_new_item' => __('Add New Shop', 'dealexport'),
                    'edit_item' => __('Edit Shop', 'dealexport'),
                    'new_item' => __('New Shop', 'dealexport'),
                    'view_item' => __('View Shop', 'dealexport'),
                    'search_items' => __('Search Shops', 'dealexport'),
                    'not_found' =>  __('No Shops Found', 'dealexport'),
                    'not_found_in_trash' => __('No Shops Found in Trash', 'dealexport'),
                ),
                'public' => true,
                'exclude_from_search' => false,
                'capability_type' => 'page',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'thumbnail', 'author', 'revisions'),
                'rewrite' => array('slug' => __('shop', 'dealexport')),
            ),
            
            //Membership
            array (
                'id' => 'membership',
                'labels' => array (
                    'name' => __('Memberships', 'dealexport'),
                    'singular_name' => __( 'Membership', 'dealexport' ),
                    'add_new' => __('Add New', 'dealexport'),
                    'add_new_item' => __('Add New Membership', 'dealexport'),
                    'edit_item' => __('Edit Membership', 'dealexport'),
                    'new_item' => __('New Membership', 'dealexport'),
                    'view_item' => __('View Membership', 'dealexport'),
                    'search_items' => __('Search Memberships', 'dealexport'),
                    'not_found' =>  __('No Memberships Found', 'dealexport'),
                    'not_found_in_trash' => __('No Memberships Found in Trash', 'dealexport'),
                ),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => 'edit.php?post_type=shop',
                'exclude_from_search' => true,
                'capability_type' => 'page',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'page-attributes'),
                'rewrite' => array('slug' => __('membership', 'dealexport')),
            ),
            
            //Withdrawal
            array (
                'id' => 'withdrawal',
                'labels' => array (
                    'name' => __('Withdrawals', 'dealexport'),
                    'singular_name' => __( 'Withdrawal', 'dealexport' ),
                    'add_new' => __('Add New', 'dealexport'),
                    'add_new_item' => __('Add New Withdrawal', 'dealexport'),
                    'edit_item' => __('Edit Withdrawal', 'dealexport'),
                    'new_item' => __('New Withdrawal', 'dealexport'),
                    'view_item' => __('View Withdrawal', 'dealexport'),
                    'search_items' => __('Search Withdrawals', 'dealexport'),
                    'not_found' =>  __('No Withdrawals Found', 'dealexport'),
                    'not_found_in_trash' => __('No Withdrawals Found in Trash', 'dealexport'),
                ),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'exclude_from_search' => true,
                'capability_type' => 'page',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'author'),
                'rewrite' => array('slug' => __('withdrawal', 'dealexport')),
            ),
            
            //Testimonial
            array (
                'id' => 'testimonial',
                'labels' => array (
                    'name' => __('Testimonials', 'dealexport'),
                    'singular_name' => __( 'Testimonial', 'dealexport' ),
                    'add_new' => __('Add New', 'dealexport'),
                    'add_new_item' => __('Add New Testimonial', 'dealexport'),
                    'edit_item' => __('Edit Testimonial', 'dealexport'),
                    'new_item' => __('New Testimonial', 'dealexport'),
                    'view_item' => __('View Testimonial', 'dealexport'),
                    'search_items' => __('Search Testimonials', 'dealexport'),
                    'not_found' =>  __('No Testimonials Found', 'dealexport'),
                    'not_found_in_trash' => __('No Testimonials Found in Trash', 'dealexport'),
                ),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'exclude_from_search' => true,
                'capability_type' => 'page',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'thumbnail'),
                'rewrite' => array('slug' => __('testimonial', 'dealexport')),
            ),
            
            //Slide
            array (
                'id' => 'slide',
                'labels' => array (
                    'name' => __('Slides', 'dealexport'),
                    'singular_name' => __( 'Slide', 'dealexport' ),
                    'add_new' => __('Add New', 'dealexport'),
                    'add_new_item' => __('Add New Slide', 'dealexport'),
                    'edit_item' => __('Edit Slide', 'dealexport'),
                    'new_item' => __('New Slide', 'dealexport'),
                    'view_item' => __('View Slide', 'dealexport'),
                    'search_items' => __('Search Slides', 'dealexport'),
                    'not_found' =>  __('No Slides Found', 'dealexport'),
                    'not_found_in_trash' => __('No Slides Found in Trash', 'dealexport'),
                ),
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'exclude_from_search' => true,
                'capability_type' => 'page',
                'map_meta_cap' => true,
                'hierarchical' => false,
                'menu_position' => null,
                'supports' => array('title', 'editor', 'page-attributes'),
                'rewrite' => array('slug' => __('slide', 'dealexport')),
            ),
        ),
        
        //Taxonomies
        'taxonomies' => array (
        
            //Shop Category
            // array(
            //     'taxonomy' => 'shop_category',
            //     'object_type' => array('shop'),
            //     'settings' => array(
            //         'hierarchical' => true,
            //         'show_in_nav_menus' => true,
            //         'labels' => array(
            //             'name' => __( 'Shop Categories', 'dealexport'),
            //             'singular_name' => __( 'Shop Category', 'dealexport'),
            //             'menu_name' => __( 'Categories', 'dealexport' ),
            //             'search_items' => __( 'Search Shop Categories', 'dealexport'),
            //             'all_items' => __( 'All Shop Categories', 'dealexport'),
            //             'parent_item' => __( 'Parent Shop Category', 'dealexport'),
            //             'parent_item_colon' => __( 'Parent Shop Category', 'dealexport'),
            //             'edit_item' => __( 'Edit Shop Category', 'dealexport'),
            //             'update_item' => __( 'Update Shop Category', 'dealexport'),
            //             'add_new_item' => __( 'Add New Shop Category', 'dealexport'),
            //             'new_item_name' => __( 'New Shop Category Name', 'dealexport'),
            //         ),
            //         'rewrite' => array(
            //             'slug' => __('shops', 'dealexport'),
            //             'hierarchical' => true,
            //         ),
            //     ),
            // ),
            
            //Testimonial Category
            array(
                'taxonomy' => 'testimonial_category',
                'object_type' => array('testimonial'),
                'settings' => array(
                    'hierarchical' => true,
                    'show_in_nav_menus' => true,			
                    'labels' => array(
                        'name' => __( 'Testimonial Categories', 'dealexport'),
                        'singular_name' => __( 'Testimonial Category', 'dealexport'),
                        'menu_name' => __( 'Categories', 'dealexport' ),
                        'search_items' => __( 'Search Testimonial Categories', 'dealexport'),
                        'all_items' => __( 'All Testimonial Categories', 'dealexport'),
                        'parent_item' => __( 'Parent Testimonial Category', 'dealexport'),
                        'parent_item_colon' => __( 'Parent Testimonial Category', 'dealexport'),
                        'edit_item' => __( 'Edit Testimonial Category', 'dealexport'),
                        'update_item' => __( 'Update Testimonial Category', 'dealexport'),
                        'add_new_item' => __( 'Add New Testimonial Category', 'dealexport'),
                        'new_item_name' => __( 'New Testimonial Category Name', 'dealexport'),
                    ),
                    'rewrite' => array(
                        'slug' => __('testimonials', 'dealexport'),
                        'hierarchical' => true,
                    ),
                ),
            ),
        ),
        
        //Meta Boxes
        'meta_boxes' => array(
        
            //Shop
            array(
                'id' => 'shop_details_metabox',
                'title' =>  __('Shop Details', 'dealexport'),
                'page' => 'shop',
                'context' => 'normal',
                'priority' => 'high',
                'callback' => array('ThemedbShop', 'renderShop'),
                'options' => array(
                    array(	
                        'name' => __('Custom Rate', 'dealexport'),
                        'id' => 'rate',
                        'type' => 'number',
                    ),
                ),
            ),
            
            array(
                'id' => 'shop_pages_metabox',
                'title' =>  __('Shop Pages', 'dealexport'),
                'page' => 'shop',
                'context' => 'normal',
                'priority' => 'high',
                'options' => array(
                    array(	
                        'name' => __('About', 'dealexport'),
                        'id' => 'about',
                        'type' => 'editor',		
                    ),
                    
                    array(	
                        'name' => __('Policies', 'dealexport'),
                        'id' => 'policy',
                        'type' => 'editor',		
                    ),
                ),
            ),
            
            //Membership
            array(
                'id' => 'membership_metabox',
                'title' =>  __('Membership Options', 'dealexport'),
                'page' => 'membership',
                'context' => 'normal',
                'priority' => 'high',
                'options' => array(
                    array(	
                        'name' => __('Product', 'dealexport'),
                        'id' => 'product',
                        'type' => 'select_post',
                        'post_type' => 'product',
                    ),
                    
                    array(
                        'name' => __('Period', 'dealexport'),
                        'id' => 'period',
                        'type' => 'select',
                        'options' => array(
                            '0' => __('None', 'dealexport'),
                            '7' => __('Week', 'dealexport'),
                            '31' => __('Month', 'dealexport'),
                            '93' => __('3 Months', 'dealexport'),
                            '186' => __('6 Months', 'dealexport'),
                            '279' => __('9 Months', 'dealexport'),
                            '365' => __('Year', 'dealexport'),
                        ),
                    ),
                    
                    array(
                        'name' => __('Products','dealexport'),
                        'id' => 'products',
                        'type' => 'number',
                        'default' => '0',
                    ),
                    
                    array(
                        'name' => __('Members', 'dealexport'),
                        'id' => 'users',
                        'type' => 'users',
                    ),	
                ),
            ),
            
            //Withdrawal
            array(
                'id' => 'withdrawal_metabox',
                'title' =>  __('Withdrawal Details', 'dealexport'),
                'page' => 'withdrawal',
                'context' => 'normal',
                'priority' => 'high',
                'callback' => array('ThemedbShop', 'renderWithdrawal'),
                'options' => array(
                    
                ),
            ),
        ),
        
        //Custom Forms
        'forms' => array(
            'profile' => array(
                array(
                    'label' => __('First Name', 'dealexport'),
                    'name' => 'first_name',
                    'alias' => 'billing_first_name',
                    'type' => 'text',
                    'prefix' => false,
                ),
                array(
                    'label' => __('Last Name', 'dealexport'),
                    'name' => 'last_name',
                    'alias' => 'billing_last_name',
                    'type' => 'text',
                    'prefix' => false,
                ),
                array(
                		'label' => __('Postcode/ Zip', 'dealexport'),
                		'name' => 'billing_postcode',
                		'alias' => 'billing_postcode',
                		'type' => 'text',
                		'prefix' => false,
                ),
                array(
                    'label' => __('City', 'dealexport'),
                    'name' => 'billing_city',
                    'type' => 'text',
                    'prefix' => false,
                ),
                array(
                        'label' => __('Region', 'dealexport'),
                        'name' => 'billing_state',
                        'type' => 'text',
                        'prefix' => false,
                ),
                array(
                        'label' => __('Country', 'dealexport'),
                        'name' => 'billing_country',
                        'type' => 'select_country',
                        'prefix' => false,
                ),
                array(
                        'label' => __('Email', 'dealexport'),
                        'name' => 'billing_email',
                        'type' => 'text',
                        'prefix' => false,
                ),
                array(
                		'label' => __('Phone', 'dealexport'),
                		'name' => 'billing_phone',
                		'type' => 'text',
                		'prefix' => false,
                ),
                
            ),
            'links' => array(
                array(
                    'label' => __('Facebook', 'dealexport'),
                    'name' => 'facebook',
                    'type' => 'text',
                ),
                array(
                    'label' => __('Twitter', 'dealexport'),
                    'name' => 'twitter',
                    'type' => 'text',
                ),
                array(
                    'label' => __('Google', 'dealexport'),
                    'name' => 'google',
                    'type' => 'text',
                ),
                array(
                    'label' => __('Tumblr', 'dealexport'),
                    'name' => 'tumblr',
                    'type' => 'text',
                ),
                array(
                    'label' => __('Pinterest', 'dealexport'),
                    'name' => 'pinterest',
                    'type' => 'text',
                ),
                array(
                    'label' => __('Instagram', 'dealexport'),
                    'name' => 'instagram',
                    'type' => 'text',
                ),
                array(
                    'label' => __('YouTube', 'dealexport'),
                    'name' => 'youtube',
                    'type' => 'text',
                ),
            ),
            'address' => array(
                
            ),
            'withdrawal' => array(
                'amount' => array(
                    'label' => __('Withdrawal Amount', 'dealexport'),
                    'name' => 'amount',
                    'type' => 'text',
                ),
                'method' => array(
                    'label' => __('Withdrawal Method', 'dealexport'),
                    'name' => 'method',
                    'type' => 'select',
                    'options' => array(
                        'paypal' => __('PayPal', 'dealexport'),
                        'skrill' => __('Skrill', 'dealexport'),
                        'swift' => __('SWIFT', 'dealexport'),
                    ),
                ),
                'paypal' => array(
                    array(
                        'label' => __('PayPal Email', 'dealexport'),
                        'name' => 'paypal',
                        'type' => 'email',
                    ),	
                ),
                'skrill' => array(
                    array(
                        'label' => __('Skrill Email', 'dealexport'),
                        'name' => 'skrill',
                        'type' => 'email',
                    ),
                ),
                'swift' => array(
                    'account_name' => array(
                        'label' => __('Account Holder Name', 'dealexport'),
                        'name' => 'account_name',
                        'type' => 'text',
                    ),
                    'account_number' => array(
                        'label' => __('Account Number/IBAN', 'dealexport'),
                        'name' => 'account_number',
                        'type' => 'text',
                    ),
                    'swift_code' => array(
                        'label' => __('SWIFT Code', 'dealexport'),
                        'name' => 'swift_code',
                        'type' => 'text',
                    ),
                    'bank_name' => array(
                        'label' => __('Bank Name', 'dealexport'),
                        'name' => 'bank_name',
                        'type' => 'text',
                    ),
                    'bank_country' => array(
                        'label' => __('Bank Country', 'dealexport'),
                        'name' => 'bank_country',
                        'type' => 'select_country',
                    ),
                ),
            ),
        ),
        
        //Shortcodes
        'shortcodes' => array(
            
            //Button
            array(
                'id' => 'button',
                'name' => __('Button', 'dealexport'),
                'shortcode' => '[button color="{{color}}" size="{{size}}" url="{{url}}" target="{{target}}"]{{content}}[/button]',
                'options' => array(
                    array(
                        'id' => 'color',
                        'name' => __('Color', 'dealexport'),		
                        'type' => 'select',
                        'options' => array(
                            'default' => __('Default', 'dealexport'),
                            'primary' => __('Primary', 'dealexport'),
                            'secondary' => __('Secondary', 'dealexport'),
                            'opaque' => __('Opaque', 'dealexport'),
                        ),
                    ),
                
                    array(			
                        'id' => 'size',
                        'name' => __('Size', 'dealexport'),		
                        'type' => 'select',
                        'options' => array(
                            'small' => __('Small', 'dealexport'),
                            'medium' => __('Medium', 'dealexport'),
                            'large' => __('Large', 'dealexport'),
                        ),
                    ),
                    
                    array(			
                        'id' => 'url',
                        'name' => __('Link', 'dealexport'),			
                        'type' => 'text',
                    ),
                    
                    array(			
                        'id' => 'target',
                        'name' => __('Target', 'dealexport'),			
                        'type' => 'select',
                        'options' => array(
                            'self' => __('Current Tab', 'dealexport'),
                            'blank' => __('New Tab', 'dealexport'),
                        ),
                    ),
                    
                    array(
                        'id' => 'content',
                        'name' => __('Text', 'dealexport'),		
                        'type' => 'text',
                    ),
                ),
            ),
            
            //Columns
            array(
                'id' => 'column',
                'name' => __('Columns', 'dealexport'),
                'shortcode' => '{{clone}}',
                'clone' => array(
                    'shortcode' => '[{{column}}]{{content}}[/{{column}}]',
                    'options' => array(
                        array(
                            'id' => 'column',
                            'name' => __('Width', 'dealexport'),
                            'type' => 'select',
                            'options' => array(
                                'one_sixth' => __('One Sixth', 'dealexport'),
                                'one_sixth_last' => __('One Sixth Last', 'dealexport'),
                                'one_fourth' => __('One Fourth', 'dealexport'),
                                'one_fourth_last' => __('One Fourth Last', 'dealexport'),
                                'one_third' => __('One Third', 'dealexport'),
                                'one_third_last' => __('One Third Last', 'dealexport'),
                                'five_twelfths' => __('Five Twelfths', 'dealexport'),
                                'five_twelfths_last' => __('Five Twelfths Last', 'dealexport'),
                                'one_half' => __('One Half', 'dealexport'),
                                'one_half_last' => __('One Half Last', 'dealexport'),
                                'seven_twelfths' => __('Seven Twelfths', 'dealexport'),
                                'seven_twelfths_last' => __('Seven Twelfths Last', 'dealexport'),
                                'two_thirds' => __('Two Thirds', 'dealexport'),
                                'two_thirds_last' => __('Two Thirds Last', 'dealexport'),
                                'three_fourths' => __('Three Fourths', 'dealexport'),
                                'three_fourths_last' => __('Three Fourths Last', 'dealexport'),
                                'div_section' => __('Generate secion in home page', 'dealexport'),
                            ),
                        ),
                        
                        array(
                            'id' => 'content',
                            'name' => __('Text', 'dealexport'),		
                            'type' => 'textarea',
                        ),
                    ),
                ),
            ),

            //Section
            array(
                'id' => 'section',
                'name' => __('Section', 'dealexport'),
                'shortcode' => '[section background="{{background}}"]{{content}}[/section]',
                'options' => array(
                    array(			
                        'id' => 'background',
                        'name' => __('Background', 'dealexport'),		
                        'type' => 'text',
                    ),
            
                    array(
                        'id' => 'content',
                        'name' => __('Text', 'dealexport'),		
                        'type' => 'textarea',
                    ),
                ),
            ),
            
            //Shops
            array(
                'id' => 'shops',
                'name' => __('Shops', 'dealexport'),
                'shortcode' => '[shops number="{{number}}" columns="{{columns}}" order="{{order}}" category="{{category}}"]',
                'options' => array(
                    array(
                        'id' => 'number',
                        'name' => __('Number', 'dealexport'),
                        'value' => '3',
                        'type' => 'number',
                    ),

                    array(
                        'id' => 'columns',
                        'name' => __('Columns', 'dealexport'),
                        'value' => '3',
                        'type' => 'select',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                    ),
                    
                    array(			
                        'id' => 'order',
                        'name' => __('Order', 'dealexport'),			
                        'type' => 'select',
                        'options' => array(
                            'date' => __('Date', 'dealexport'),
                            'title' => __('Title', 'dealexport'),
                            'rating' => __('Rating', 'dealexport'),
                            'sales' => __('Sales', 'dealexport'),
                            'admirers' => __('Admirers', 'dealexport'),			
                            'random' => __('Random', 'dealexport'),
                        ),
                    ),
                    
                    array(
                        'id' => 'category',
                        'name' => __('Category', 'dealexport'),			
                        'type' => 'select_category',
                        'taxonomy' => 'shop_category',
                    ),
                ),
            ),
            
            //Services
            array(
            		'id' => 'services',
            		'name' => __('Services', 'dealexport'),
            		'shortcode' => '[services number="{{number}}" columns="{{columns}}" order="{{order}}" category="{{category}}"]',
            		'options' => array(
            				array(
            						'id' => 'number',
            						'name' => __('Number', 'dealexport'),
            						'value' => '3',
            						'type' => 'number',
            				),
            
            				array(
            						'id' => 'columns',
            						'name' => __('Columns', 'dealexport'),
            						'value' => '3',
            						'type' => 'select',
            						'options' => array(
            								'1' => '1',
            								'2' => '2',
            								'3' => '3',
            								'4' => '4',
            						),
            				),
            
            				array(
            						'id' => 'order',
            						'name' => __('Order', 'dealexport'),
            						'type' => 'select',
            						'options' => array(
            								'date' => __('Date', 'dealexport'),
            								'title' => __('Title', 'dealexport'),
            								'rating' => __('Rating', 'dealexport'),
            								'sales' => __('Sales', 'dealexport'),
            								'admirers' => __('Admirers', 'dealexport'),
            								'random' => __('Random', 'dealexport'),
            						),
            						),
            
            						array(
            						'id' => 'category',
            						'name' => __('Category', 'dealexport'),
            						'type' => 'select_category',
            						'taxonomy' => 'shop_category',
            						),
            		),
            ),
            
            //Testimonials
            array(
                'id' => 'testimonials',
                'name' => __('Testimonials', 'dealexport'),
                'shortcode' => '[testimonials number="{{number}}" order="{{order}}" category="{{category}}"]',
                'options' => array(
                    array(
                        'id' => 'number',
                        'name' => __('Number', 'dealexport'),
                        'value' => '3',
                        'type' => 'number',
                    ),		
                    
                    array(		
                        'id' => 'order',
                        'name' => __('Order', 'dealexport'),			
                        'type' => 'select',
                        'options' => array(
                            'date' => __('Date', 'dealexport'),
                            'random' => __('Random', 'dealexport'),
                        ),
                    ),
                    
                    array(			
                        'id' => 'category',
                        'name' => __('Category', 'dealexport'),		
                        'type' => 'select_category',
                        'taxonomy' => 'testimonial_category',
                    ),
                    
                    array(
                        'id' => 'pause',
                        'name' => __('Pause', 'dealexport'),
                        'value' => '0',
                        'type' => 'number',
                    ),
                    
                    array(
                        'id' => 'speed',
                        'name' => __('Speed', 'dealexport'),
                        'value' => '900',
                        'type' => 'number',
                    ),
                ),
            ),
            
            //Title
            array(
                'id' => 'title',
                'name' => __('Title', 'dealexport'),
                'shortcode' => '[title indent="{{indent}}"]{{content}}[/title]',
                'options' => array(
                    array(
                        'id' => 'content',
                        'name' => __('Title', 'dealexport'),
                        'type' => 'text',
                    ),
                    
                    array(			
                        'id' => 'indent',
                        'name' => __('Indent', 'dealexport'),			
                        'type' => 'number',
                        'value' => '0',
                    )
                ),
            ),
            
            //Users
            array(
                'id' => 'users',
                'name' => __('Users', 'dealexport'),
                'shortcode' => '[users number="{{number}}" columns="{{columns}}" order="{{order}}"]',
                'options' => array(
                    array(
                        'id' => 'number',
                        'name' => __('Number', 'dealexport'),
                        'value' => '3',
                        'type' => 'number',
                    ),
                    
                    array(
                        'id' => 'columns',
                        'name' => __('Columns', 'dealexport'),
                        'value' => '3',
                        'type' => 'select',
                        'options' => array(
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                        ),
                    ),
                    
                    array(
                        'id' => 'order',
                        'name' => __('Order', 'dealexport'),			
                        'type' => 'select',
                        'options' => array(
                            'date' => __('Date', 'dealexport'),
                            'name' => __('Name', 'dealexport'),
                            'activity' => __('Activity', 'dealexport'),
                        ),
                    ),			
                ),
            ),
        ),
        
        //Custom Styles
        'custom_styles' => array(
            array(
                'elements' => '.header-wrap,.section-wrap,.footer-wrap,.widget-title,.header-menu ul ul',
                'attributes' => array(
                    array(
                        'name' => 'background-image',
                        'option' => 'background_image',
                    ),
                ),
            ),
            
            array(
                'elements' => '.header-wrap,.section-wrap,.footer-wrap',
                'attributes' => array(
                    array(
                        'name' => 'background-size',
                        'option' => 'background_type',
                    ),
                ),
            ),
            
            array(
                'elements' => 'body, input, select, textarea',
                'attributes' => array(
                    array(
                        'name' => 'font-family',
                        'option' => 'content_font',
                    ),
                ),
            ),
            
            array(
                'elements' => 'h1,h2,h3,h4,h5,h6',
                'attributes' => array(
                    array(
                        'name' => 'font-family',
                        'option' => 'heading_font',
                    ),
                ),
            ),
            
            array(
                'elements' => '.item-preview .item-options a.primary.active,.item-preview .item-options a.primary:hover,.item-sale,.element-button.primary,.element-button.active,.woocommerce #review_form #respond .form-submit input,.woocommerce #review_form #respond .form-submit input:hover,.woocommerce .widget_shopping_cart .button.checkout,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,.woocommerce #content input.button.alt,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce #content input.button.alt:hover',
                'attributes' => array(
                    array(
                        'name' => 'background-color',
                        'option' => 'primary_color',
                    ),
                ),
            ),
            
            array(
                'elements' => '.item-preview .item-options a.primary.active,.item-preview .item-options a.primary:hover,.element-button.primary,.element-button.active,.woocommerce #review_form #respond .form-submit input,.woocommerce #review_form #respond .form-submit input:hover,.woocommerce .widget_shopping_cart .button.checkout,.woocommerce a.button.alt,.woocommerce button.button.alt,.woocommerce input.button.alt,.woocommerce #respond input#submit.alt,.woocommerce #content input.button.alt,.woocommerce a.button.alt:hover,.woocommerce button.button.alt:hover,.woocommerce input.button.alt:hover,.woocommerce #respond input#submit.alt:hover,.woocommerce #content input.button.alt:hover',
                'attributes' => array(
                    array(
                        'name' => 'border-color',
                        'option' => 'primary_color',
                    ),
                ),
            ),
            
            array(
                'elements' => '.element-button,.header-cart,.items-toolbar a.active,.pagination > span,.item-preview .item-options a.active,.item-preview .item-options a.added,.item-preview .item-options a.loading,.item-preview .item-options a:hover,.woocommerce .widget_price_filter .ui-slider .ui-slider-range,.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit,.woocommerce #content input.button,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce #content input.button:hover',
                'attributes' => array(
                    array(
                        'name' => 'background-color',
                        'option' => 'secondary_color',
                    ),
                ),
            ),
            
            array(
                'elements' => '.element-button,.items-toolbar a.active,.pagination > span,.item-preview .item-options a.active,.item-preview .item-options a.added,.item-preview .item-options a.loading,.item-preview .item-options a:hover,.woocommerce a.button,.woocommerce button.button,.woocommerce input.button,.woocommerce #respond input#submit,.woocommerce #content input.button,.woocommerce a.button:hover,.woocommerce button.button:hover,.woocommerce input.button:hover,.woocommerce #respond input#submit:hover,.woocommerce #content input.button:hover',
                'attributes' => array(
                    array(
                        'name' => 'border-color',
                        'option' => 'secondary_color',
                    ),
                ),
            ),
        ),
        
        //Fonts
        'fonts' => array(
            'ABeeZee' => 'ABeeZee',
            'Abel' => 'Abel',
            'Abril Fatface' => 'Abril Fatface',
            'Aclonica' => 'Aclonica',
            'Acme' => 'Acme',
            'Actor' => 'Actor',
            'Adamina' => 'Adamina',
            'Advent Pro' => 'Advent Pro',
            'Aguafina Script' => 'Aguafina Script',
            'Aladin' => 'Aladin',
            'Aldrich' => 'Aldrich',
            'Alegreya' => 'Alegreya',
            'Alegreya SC' => 'Alegreya SC',
            'Alex Brush' => 'Alex Brush',
            'Alfa Slab One' => 'Alfa Slab One',
            'Alice' => 'Alice',
            'Alike' => 'Alike',
            'Alike Angular' => 'Alike Angular',
            'Allan' => 'Allan',
            'Allerta' => 'Allerta',
            'Allerta Stencil' => 'Allerta Stencil',
            'Allura' => 'Allura',
            'Almendra' => 'Almendra',
            'Almendra SC' => 'Almendra SC',
            'Amaranth' => 'Amaranth',
            'Amatic SC' => 'Amatic SC',
            'Amethysta' => 'Amethysta',
            'Andada' => 'Andada',
            'Andika' => 'Andika',
            'Angkor' => 'Angkor',
            'Annie Use Your Telescope' => 'Annie Use Your Telescope',
            'Anonymous Pro' => 'Anonymous Pro',
            'Antic' => 'Antic',
            'Antic Didone' => 'Antic Didone',
            'Antic Slab' => 'Antic Slab',
            'Anton' => 'Anton',
            'Arapey' => 'Arapey',
            'Arbutus' => 'Arbutus',
            'Architects Daughter' => 'Architects Daughter',
            'Arimo' => 'Arimo',
            'Arizonia' => 'Arizonia',
            'Armata' => 'Armata',
            'Artifika' => 'Artifika',
            'Arvo' => 'Arvo',
            'Asap' => 'Asap',
            'Asset' => 'Asset',
            'Astloch' => 'Astloch',
            'Asul' => 'Asul',
            'Atomic Age' => 'Atomic Age',
            'Aubrey' => 'Aubrey',
            'Audiowide' => 'Audiowide',
            'Average' => 'Average',
            'Averia Gruesa Libre' => 'Averia Gruesa Libre',
            'Averia Libre' => 'Averia Libre',
            'Averia Sans Libre' => 'Averia Sans Libre',
            'Averia Serif Libre' => 'Averia Serif Libre',
            'Bad Script' => 'Bad Script',
            'Balthazar' => 'Balthazar',
            'Bangers' => 'Bangers',
            'Basic' => 'Basic',
            'Battambang' => 'Battambang',
            'Baumans' => 'Baumans',
            'Bayon' => 'Bayon',
            'Belgrano' => 'Belgrano',
            'Belleza' => 'Belleza',
            'Bentham' => 'Bentham',
            'Berkshire Swash' => 'Berkshire Swash',
            'Bevan' => 'Bevan',
            'Bigshot One' => 'Bigshot One',
            'Bilbo' => 'Bilbo',
            'Bilbo Swash Caps' => 'Bilbo Swash Caps',
            'Bitter' => 'Bitter',
            'Black Ops One' => 'Black Ops One',
            'Bokor' => 'Bokor',
            'Bonbon' => 'Bonbon',
            'Boogaloo' => 'Boogaloo',
            'Bowlby One' => 'Bowlby One',
            'Bowlby One SC' => 'Bowlby One SC',
            'Brawler' => 'Brawler',
            'Bree Serif' => 'Bree Serif',
            'Bubblegum Sans' => 'Bubblegum Sans',
            'Buda' => 'Buda',
            'Buenard' => 'Buenard',
            'Butcherman' => 'Butcherman',
            'Butterfly Kids' => 'Butterfly Kids',
            'Cabin' => 'Cabin',
            'Cabin Condensed' => 'Cabin Condensed',
            'Cabin Sketch' => 'Cabin Sketch',
            'Caesar Dressing' => 'Caesar Dressing',
            'Cagliostro' => 'Cagliostro',
            'Calligraffitti' => 'Calligraffitti',
            'Cambo' => 'Cambo',
            'Candal' => 'Candal',
            'Cantarell' => 'Cantarell',
            'Cantata One' => 'Cantata One',
            'Cardo' => 'Cardo',
            'Carme' => 'Carme',
            'Carter One' => 'Carter One',
            'Caudex' => 'Caudex',
            'Cedarville Cursive' => 'Cedarville Cursive',
            'Ceviche One' => 'Ceviche One',
            'Changa One' => 'Changa One',
            'Chango' => 'Chango',
            'Chau Philomene One' => 'Chau Philomene One',
            'Chelsea Market' => 'Chelsea Market',
            'Chenla' => 'Chenla',
            'Cherry Cream Soda' => 'Cherry Cream Soda',
            'Chewy' => 'Chewy',
            'Chicle' => 'Chicle',
            'Chivo' => 'Chivo',
            'Coda' => 'Coda',
            'Coda Caption' => 'Coda Caption',
            'Codystar' => 'Codystar',
            'Comfortaa' => 'Comfortaa',
            'Coming Soon' => 'Coming Soon',
            'Concert One' => 'Concert One',
            'Condiment' => 'Condiment',
            'Content' => 'Content',
            'Contrail One' => 'Contrail One',
            'Convergence' => 'Convergence',
            'Cookie' => 'Cookie',
            'Copse' => 'Copse',
            'Corben' => 'Corben',
            'Cousine' => 'Cousine',
            'Coustard' => 'Coustard',
            'Covered By Your Grace' => 'Covered By Your Grace',
            'Crafty Girls' => 'Crafty Girls',
            'Creepster' => 'Creepster',
            'Crete Round' => 'Crete Round',
            'Crimson Text' => 'Crimson Text',
            'Crushed' => 'Crushed',
            'Cuprum' => 'Cuprum',
            'Cutive' => 'Cutive',
            'Damion' => 'Damion',
            'Dancing Script' => 'Dancing Script',
            'Dangrek' => 'Dangrek',
            'Dawning of a New Day' => 'Dawning of a New Day',
            'Days One' => 'Days One',
            'Delius' => 'Delius',
            'Delius Swash Caps' => 'Delius Swash Caps',
            'Delius Unicase' => 'Delius Unicase',
            'Della Respira' => 'Della Respira',
            'Devonshire' => 'Devonshire',
            'Didact Gothic' => 'Didact Gothic',
            'Diplomata' => 'Diplomata',
            'Diplomata SC' => 'Diplomata SC',
            'Doppio One' => 'Doppio One',
            'Dorsa' => 'Dorsa',
            'Dosis' => 'Dosis',
            'Dr Sugiyama' => 'Dr Sugiyama',
            'Droid Sans' => 'Droid Sans',
            'Droid Sans Mono' => 'Droid Sans Mono',
            'Droid Serif' => 'Droid Serif',
            'Duru Sans' => 'Duru Sans',
            'Dynalight' => 'Dynalight',
            'EB Garamond' => 'EB Garamond',
            'Eater' => 'Eater',
            'Economica' => 'Economica',
            'Electrolize' => 'Electrolize',
            'Emblema One' => 'Emblema One',
            'Emilys Candy' => 'Emilys Candy',
            'Engagement' => 'Engagement',
            'Enriqueta' => 'Enriqueta',
            'Erica One' => 'Erica One',
            'Esteban' => 'Esteban',
            'Euphoria Script' => 'Euphoria Script',
            'Ewert' => 'Ewert',
            'Exo' => 'Exo',
            'Expletus Sans' => 'Expletus Sans',
            'Fanwood Text' => 'Fanwood Text',
            'Fascinate' => 'Fascinate',
            'Fascinate Inline' => 'Fascinate Inline',
            'Federant' => 'Federant',
            'Federo' => 'Federo',
            'Felipa' => 'Felipa',
            'Fjord One' => 'Fjord One',
            'Flamenco' => 'Flamenco',
            'Flavors' => 'Flavors',
            'Fondamento' => 'Fondamento',
            'Fontdiner Swanky' => 'Fontdiner Swanky',
            'Forum' => 'Forum',
            'Francois One' => 'Francois One',
            'Fredericka the Great' => 'Fredericka the Great',
            'Fredoka One' => 'Fredoka One',
            'Freehand' => 'Freehand',
            'Fresca' => 'Fresca',
            'Frijole' => 'Frijole',
            'Fugaz One' => 'Fugaz One',
            'GFS Didot' => 'GFS Didot',
            'GFS Neohellenic' => 'GFS Neohellenic',
            'Galdeano' => 'Galdeano',
            'Gentium Basic' => 'Gentium Basic',
            'Gentium Book Basic' => 'Gentium Book Basic',
            'Geo' => 'Geo',
            'Geostar' => 'Geostar',
            'Geostar Fill' => 'Geostar Fill',
            'Germania One' => 'Germania One',
            'Give You Glory' => 'Give You Glory',
            'Glass Antiqua' => 'Glass Antiqua',
            'Glegoo' => 'Glegoo',
            'Gloria Hallelujah' => 'Gloria Hallelujah',
            'Goblin One' => 'Goblin One',
            'Gochi Hand' => 'Gochi Hand',
            'Gorditas' => 'Gorditas',
            'Goudy Bookletter 1911' => 'Goudy Bookletter 1911',
            'Graduate' => 'Graduate',
            'Gravitas One' => 'Gravitas One',
            'Great Vibes' => 'Great Vibes',
            'Gruppo' => 'Gruppo',
            'Gudea' => 'Gudea',
            'Habibi' => 'Habibi',
            'Hammersmith One' => 'Hammersmith One',
            'Handlee' => 'Handlee',
            'Hanuman' => 'Hanuman',
            'Happy Monkey' => 'Happy Monkey',
            'Henny Penny' => 'Henny Penny',
            'Herr Von Muellerhoff' => 'Herr Von Muellerhoff',
            'Holtwood One SC' => 'Holtwood One SC',
            'Homemade Apple' => 'Homemade Apple',
            'Homenaje' => 'Homenaje',
            'IM Fell DW Pica' => 'IM Fell DW Pica',
            'IM Fell DW Pica SC' => 'IM Fell DW Pica SC',
            'IM Fell Double Pica' => 'IM Fell Double Pica',
            'IM Fell Double Pica SC' => 'IM Fell Double Pica SC',
            'IM Fell English' => 'IM Fell English',
            'IM Fell English SC' => 'IM Fell English SC',
            'IM Fell French Canon' => 'IM Fell French Canon',
            'IM Fell French Canon SC' => 'IM Fell French Canon SC',
            'IM Fell Great Primer' => 'IM Fell Great Primer',
            'IM Fell Great Primer SC' => 'IM Fell Great Primer SC',
            'Iceberg' => 'Iceberg',
            'Iceland' => 'Iceland',
            'Imprima' => 'Imprima',
            'Inconsolata' => 'Inconsolata',
            'Inder' => 'Inder',
            'Indie Flower' => 'Indie Flower',
            'Inika' => 'Inika',
            'Irish Grover' => 'Irish Grover',
            'Istok Web' => 'Istok Web',
            'Italiana' => 'Italiana',
            'Italianno' => 'Italianno',
            'Jim Nightshade' => 'Jim Nightshade',
            'Jockey One' => 'Jockey One',
            'Jolly Lodger' => 'Jolly Lodger',
            'Josefin Sans' => 'Josefin Sans',
            'Josefin Slab' => 'Josefin Slab',
            'Judson' => 'Judson',
            'Julee' => 'Julee',
            'Junge' => 'Junge',
            'Jura' => 'Jura',
            'Just Another Hand' => 'Just Another Hand',
            'Just Me Again Down Here' => 'Just Me Again Down Here',
            'Kameron' => 'Kameron',
            'Karla' => 'Karla',
            'Kaushan Script' => 'Kaushan Script',
            'Kelly Slab' => 'Kelly Slab',
            'Kenia' => 'Kenia',
            'Khmer' => 'Khmer',
            'Knewave' => 'Knewave',
            'Kotta One' => 'Kotta One',
            'Koulen' => 'Koulen',
            'Kranky' => 'Kranky',
            'Kreon' => 'Kreon',
            'Kristi' => 'Kristi',
            'Krona One' => 'Krona One',
            'La Belle Aurore' => 'La Belle Aurore',
            'Lancelot' => 'Lancelot',
            'Lato' => 'Lato',
            'League Script' => 'League Script',
            'Leckerli One' => 'Leckerli One',
            'Ledger' => 'Ledger',
            'Lekton' => 'Lekton',
            'Lemon' => 'Lemon',
            'Lilita One' => 'Lilita One',
            'Limelight' => 'Limelight',
            'Linden Hill' => 'Linden Hill',
            'Lobster' => 'Lobster',
            'Lobster Two' => 'Lobster Two',
            'Londrina Outline' => 'Londrina Outline',
            'Londrina Shadow' => 'Londrina Shadow',
            'Londrina Sketch' => 'Londrina Sketch',
            'Londrina Solid' => 'Londrina Solid',
            'Lora' => 'Lora',
            'Love Ya Like A Sister' => 'Love Ya Like A Sister',
            'Loved by the King' => 'Loved by the King',
            'Lovers Quarrel' => 'Lovers Quarrel',
            'Luckiest Guy' => 'Luckiest Guy',
            'Lusitana' => 'Lusitana',
            'Lustria' => 'Lustria',
            'Macondo' => 'Macondo',
            'Macondo Swash Caps' => 'Macondo Swash Caps',
            'Magra' => 'Magra',
            'Maiden Orange' => 'Maiden Orange',
            'Mako' => 'Mako',
            'Marck Script' => 'Marck Script',
            'Marko One' => 'Marko One',
            'Marmelad' => 'Marmelad',
            'Marvel' => 'Marvel',
            'Mate' => 'Mate',
            'Mate SC' => 'Mate SC',
            'Maven Pro' => 'Maven Pro',
            'Meddon' => 'Meddon',
            'MedievalSharp' => 'MedievalSharp',
            'Medula One' => 'Medula One',
            'Megrim' => 'Megrim',
            'Merienda One' => 'Merienda One',
            'Merriweather' => 'Merriweather',
            'Metal' => 'Metal',
            'Metamorphous' => 'Metamorphous',
            'Metrophobic' => 'Metrophobic',
            'Michroma' => 'Michroma',
            'Miltonian' => 'Miltonian',
            'Miltonian Tattoo' => 'Miltonian Tattoo',
            'Miniver' => 'Miniver',
            'Miss Fajardose' => 'Miss Fajardose',
            'Modern Antiqua' => 'Modern Antiqua',
            'Molengo' => 'Molengo',
            'Monofett' => 'Monofett',
            'Monoton' => 'Monoton',
            'Monsieur La Doulaise' => 'Monsieur La Doulaise',
            'Montaga' => 'Montaga',
            'Montez' => 'Montez',
            'Montserrat' => 'Montserrat',
            'Moul' => 'Moul',
            'Moulpali' => 'Moulpali',
            'Mountains of Christmas' => 'Mountains of Christmas',
            'Mr Bedfort' => 'Mr Bedfort',
            'Mr Dafoe' => 'Mr Dafoe',
            'Mr De Haviland' => 'Mr De Haviland',
            'Mrs Saint Delafield' => 'Mrs Saint Delafield',
            'Mrs Sheppards' => 'Mrs Sheppards',
            'Muli' => 'Muli',
            'Mystery Quest' => 'Mystery Quest',
            'Neucha' => 'Neucha',
            'Neuton' => 'Neuton',
            'News Cycle' => 'News Cycle',
            'Niconne' => 'Niconne',
            'Nixie One' => 'Nixie One',
            'Nobile' => 'Nobile',
            'Nokora' => 'Nokora',
            'Norican' => 'Norican',
            'Nosifer' => 'Nosifer',
            'Nothing You Could Do' => 'Nothing You Could Do',
            'Noticia Text' => 'Noticia Text',
            'Nova Cut' => 'Nova Cut',
            'Nova Flat' => 'Nova Flat',
            'Nova Mono' => 'Nova Mono',
            'Nova Oval' => 'Nova Oval',
            'Nova Round' => 'Nova Round',
            'Nova Script' => 'Nova Script',
            'Nova Slim' => 'Nova Slim',
            'Nova Square' => 'Nova Square',
            'Numans' => 'Numans',
            'Nunito' => 'Nunito',
            'Odor Mean Chey' => 'Odor Mean Chey',
            'Old Standard TT' => 'Old Standard TT',
            'Oldenburg' => 'Oldenburg',
            'Oleo Script' => 'Oleo Script',
            'Open Sans' => 'Open Sans',
            'Open Sans Condensed' => 'Open Sans Condensed',
            'Orbitron' => 'Orbitron',
            'Original Surfer' => 'Original Surfer',
            'Oswald' => 'Oswald',
            'Over the Rainbow' => 'Over the Rainbow',
            'Overlock' => 'Overlock',
            'Overlock SC' => 'Overlock SC',
            'Ovo' => 'Ovo',
            'Oxygen' => 'Oxygen',
            'PT Mono' => 'PT Mono',
            'PT Sans' => 'PT Sans',
            'PT Sans Caption' => 'PT Sans Caption',
            'PT Sans Narrow' => 'PT Sans Narrow',
            'PT Serif' => 'PT Serif',
            'PT Serif Caption' => 'PT Serif Caption',
            'Pacifico' => 'Pacifico',
            'Parisienne' => 'Parisienne',
            'Passero One' => 'Passero One',
            'Passion One' => 'Passion One',
            'Patrick Hand' => 'Patrick Hand',
            'Patua One' => 'Patua One',
            'Paytone One' => 'Paytone One',
            'Permanent Marker' => 'Permanent Marker',
            'Petrona' => 'Petrona',
            'Philosopher' => 'Philosopher',
            'Piedra' => 'Piedra',
            'Pinyon Script' => 'Pinyon Script',
            'Plaster' => 'Plaster',
            'Play' => 'Play',
            'Playball' => 'Playball',
            'Playfair Display' => 'Playfair Display',
            'Podkova' => 'Podkova',
            'Poiret One' => 'Poiret One',
            'Poller One' => 'Poller One',
            'Poly' => 'Poly',
            'Pompiere' => 'Pompiere',
            'Pontano Sans' => 'Pontano Sans',
            'Port Lligat Sans' => 'Port Lligat Sans',
            'Port Lligat Slab' => 'Port Lligat Slab',
            'Prata' => 'Prata',
            'Preahvihear' => 'Preahvihear',
            'Press Start 2P' => 'Press Start 2P',
            'Princess Sofia' => 'Princess Sofia',
            'Prociono' => 'Prociono',
            'Prosto One' => 'Prosto One',
            'Puritan' => 'Puritan',
            'Quantico' => 'Quantico',
            'Quattrocento' => 'Quattrocento',
            'Quattrocento Sans' => 'Quattrocento Sans',
            'Questrial' => 'Questrial',
            'Quicksand' => 'Quicksand',
            'Qwigley' => 'Qwigley',
            'Radley' => 'Radley',
            'Raleway' => 'Raleway',
            'Rammetto One' => 'Rammetto One',
            'Rancho' => 'Rancho',
            'Rationale' => 'Rationale',
            'Redressed' => 'Redressed',
            'Reenie Beanie' => 'Reenie Beanie',
            'Revalia' => 'Revalia',
            'Ribeye' => 'Ribeye',
            'Ribeye Marrow' => 'Ribeye Marrow',
            'Righteous' => 'Righteous',
            'Roboto' => 'Roboto',
            'Roboto Condensed' => 'Roboto Condensed',
            'Rochester' => 'Rochester',
            'Rock Salt' => 'Rock Salt',
            'Rokkitt' => 'Rokkitt',
            'Ropa Sans' => 'Ropa Sans',
            'Rosario' => 'Rosario',
            'Rosarivo' => 'Rosarivo',
            'Rouge Script' => 'Rouge Script',
            'Ruda' => 'Ruda',
            'Ruge Boogie' => 'Ruge Boogie',
            'Ruluko' => 'Ruluko',
            'Ruslan Display' => 'Ruslan Display',
            'Russo One' => 'Russo One',
            'Ruthie' => 'Ruthie',
            'Sail' => 'Sail',
            'Salsa' => 'Salsa',
            'Sanchez' => 'Sanchez',
            'Sancreek' => 'Sancreek',
            'Sansita One' => 'Sansita One',
            'Sarina' => 'Sarina',
            'Satisfy' => 'Satisfy',
            'Schoolbell' => 'Schoolbell',
            'Seaweed Script' => 'Seaweed Script',
            'Sevillana' => 'Sevillana',
            'Shadows Into Light' => 'Shadows Into Light',
            'Shadows Into Light Two' => 'Shadows Into Light Two',
            'Shanti' => 'Shanti',
            'Share' => 'Share',
            'Shojumaru' => 'Shojumaru',
            'Short Stack' => 'Short Stack',
            'Siemreap' => 'Siemreap',
            'Sigmar One' => 'Sigmar One',
            'Signika' => 'Signika',
            'Signika Negative' => 'Signika Negative',
            'Simonetta' => 'Simonetta',
            'Sirin Stencil' => 'Sirin Stencil',
            'Six Caps' => 'Six Caps',
            'Slackey' => 'Slackey',
            'Smokum' => 'Smokum',
            'Smythe' => 'Smythe',
            'Sniglet' => 'Sniglet',
            'Snippet' => 'Snippet',
            'Sofia' => 'Sofia',
            'Sonsie One' => 'Sonsie One',
            'Sorts Mill Goudy' => 'Sorts Mill Goudy',
            'Special Elite' => 'Special Elite',
            'Spicy Rice' => 'Spicy Rice',
            'Spinnaker' => 'Spinnaker',
            'Spirax' => 'Spirax',
            'Squada One' => 'Squada One',
            'Stardos Stencil' => 'Stardos Stencil',
            'Stint Ultra Condensed' => 'Stint Ultra Condensed',
            'Stint Ultra Expanded' => 'Stint Ultra Expanded',
            'Stoke' => 'Stoke',
            'Sue Ellen Francisco' => 'Sue Ellen Francisco',
            'Sunshiney' => 'Sunshiney',
            'Supermercado One' => 'Supermercado One',
            'Suwannaphum' => 'Suwannaphum',
            'Swanky and Moo Moo' => 'Swanky and Moo Moo',
            'Syncopate' => 'Syncopate',
            'Tangerine' => 'Tangerine',
            'Taprom' => 'Taprom',
            'Telex' => 'Telex',
            'Tenor Sans' => 'Tenor Sans',
            'The Girl Next Door' => 'The Girl Next Door',
            'Tienne' => 'Tienne',
            'Tinos' => 'Tinos',
            'Titan One' => 'Titan One',
            'Trade Winds' => 'Trade Winds',
            'Trocchi' => 'Trocchi',
            'Trochut' => 'Trochut',
            'Trykker' => 'Trykker',
            'Tulpen One' => 'Tulpen One',
            'Ubuntu' => 'Ubuntu',
            'Ubuntu Condensed' => 'Ubuntu Condensed',
            'Ubuntu Mono' => 'Ubuntu Mono',
            'Ultra' => 'Ultra',
            'Uncial Antiqua' => 'Uncial Antiqua',
            'UnifrakturCook' => 'UnifrakturCook',
            'UnifrakturMaguntia' => 'UnifrakturMaguntia',
            'Unkempt' => 'Unkempt',
            'Unlock' => 'Unlock',
            'Unna' => 'Unna',
            'VT323' => 'VT323',
            'Varela' => 'Varela',
            'Varela Round' => 'Varela Round',
            'Vast Shadow' => 'Vast Shadow',
            'Vibur' => 'Vibur',
            'Vidaloka' => 'Vidaloka',
            'Viga' => 'Viga',
            'Voces' => 'Voces',
            'Volkhov' => 'Volkhov',
            'Vollkorn' => 'Vollkorn',
            'Voltaire' => 'Voltaire',
            'Waiting for the Sunrise' => 'Waiting for the Sunrise',
            'Wallpoet' => 'Wallpoet',
            'Walter Turncoat' => 'Walter Turncoat',
            'Wellfleet' => 'Wellfleet',
            'Wire One' => 'Wire One',
            'Yanone Kaffeesatz' => 'Yanone Kaffeesatz',
            'Yellowtail' => 'Yellowtail',
            'Yeseva One' => 'Yeseva One',
            'Yesteryear' => 'Yesteryear',
            'Zeyada' => 'Zeyada',
        ),
        
        'countries' => array(
            'AF'=>__('Afghanistan', 'dealexport'),
            'AX'=>__('&#197;land Islands', 'dealexport'),
            'AL'=>__('Albania', 'dealexport'),
            'DZ'=>__('Algeria', 'dealexport'),
            'AD'=>__('Andorra', 'dealexport'),
            'AO'=>__('Angola', 'dealexport'),
            'AI'=>__('Anguilla', 'dealexport'),
            'AQ'=>__('Antarctica', 'dealexport'),
            'AG'=>__('Antigua and Barbuda', 'dealexport'),
            'AR'=>__('Argentina', 'dealexport'),
            'AM'=>__('Armenia', 'dealexport'),
            'AW'=>__('Aruba', 'dealexport'),
            'AU'=>__('Australia', 'dealexport'),
            'AT'=>__('Austria', 'dealexport'),
            'AZ'=>__('Azerbaijan', 'dealexport'),
            'BS'=>__('Bahamas', 'dealexport'),
            'BH'=>__('Bahrain', 'dealexport'),
            'BD'=>__('Bangladesh', 'dealexport'),
            'BB'=>__('Barbados', 'dealexport'),
            'BY'=>__('Belarus', 'dealexport'),
            'BE'=>__('Belgium', 'dealexport'),
            'PW'=>__('Belau', 'dealexport'),
            'BZ'=>__('Belize', 'dealexport'),
            'BJ'=>__('Benin', 'dealexport'),
            'BM'=>__('Bermuda', 'dealexport'),
            'BT'=>__('Bhutan', 'dealexport'),
            'BO'=>__('Bolivia', 'dealexport'),
            'BQ'=>__('Bonaire, Saint Eustatius and Saba', 'dealexport'),
            'BA'=>__('Bosnia and Herzegovina', 'dealexport'),
            'BW'=>__('Botswana', 'dealexport'),
            'BV'=>__('Bouvet Island', 'dealexport'),
            'BR'=>__('Brazil', 'dealexport'),
            'IO'=>__('British Indian Ocean Territory', 'dealexport'),
            'VG'=>__('British Virgin Islands', 'dealexport'),
            'BN'=>__('Brunei', 'dealexport'),
            'BG'=>__('Bulgaria', 'dealexport'),
            'BF'=>__('Burkina Faso', 'dealexport'),
            'BI'=>__('Burundi', 'dealexport'),
            'KH'=>__('Cambodia', 'dealexport'),
            'CM'=>__('Cameroon', 'dealexport'),
            'CA'=>__('Canada', 'dealexport'),
            'CV'=>__('Cape Verde', 'dealexport'),
            'KY'=>__('Cayman Islands', 'dealexport'),
            'CF'=>__('Central African Republic', 'dealexport'),
            'TD'=>__('Chad', 'dealexport'),
            'CL'=>__('Chile', 'dealexport'),
            'CN'=>__('China', 'dealexport'),
            'CX'=>__('Christmas Island', 'dealexport'),
            'CC'=>__('Cocos (Keeling) Islands', 'dealexport'),
            'CO'=>__('Colombia', 'dealexport'),
            'KM'=>__('Comoros', 'dealexport'),
            'CG'=>__('Congo (Brazzaville)', 'dealexport'),
            'CD'=>__('Congo (Kinshasa)', 'dealexport'),
            'CK'=>__('Cook Islands', 'dealexport'),
            'CR'=>__('Costa Rica', 'dealexport'),
            'HR'=>__('Croatia', 'dealexport'),
            'CU'=>__('Cuba', 'dealexport'),
            'CW'=>__('Cura&Ccedil;ao', 'dealexport'),
            'CY'=>__('Cyprus', 'dealexport'),
            'CZ'=>__('Czech Republic', 'dealexport'),
            'DK'=>__('Denmark', 'dealexport'),
            'DJ'=>__('Djibouti', 'dealexport'),
            'DM'=>__('Dominica', 'dealexport'),
            'DO'=>__('Dominican Republic', 'dealexport'),
            'EC'=>__('Ecuador', 'dealexport'),
            'EG'=>__('Egypt', 'dealexport'),
            'SV'=>__('El Salvador', 'dealexport'),
            'GQ'=>__('Equatorial Guinea', 'dealexport'),
            'ER'=>__('Eritrea', 'dealexport'),
            'EE'=>__('Estonia', 'dealexport'),
            'ET'=>__('Ethiopia', 'dealexport'),
            'FK'=>__('Falkland Islands', 'dealexport'),
            'FO'=>__('Faroe Islands', 'dealexport'),
            'FJ'=>__('Fiji', 'dealexport'),
            'FI'=>__('Finland', 'dealexport'),
            'FR'=>__('France', 'dealexport'),
            'GF'=>__('French Guiana', 'dealexport'),
            'PF'=>__('French Polynesia', 'dealexport'),
            'TF'=>__('French Southern Territories', 'dealexport'),
            'GA'=>__('Gabon', 'dealexport'),
            'GM'=>__('Gambia', 'dealexport'),
            'GE'=>__('Georgia', 'dealexport'),
            'DE'=>__('Germany', 'dealexport'),
            'GH'=>__('Ghana', 'dealexport'),
            'GI'=>__('Gibraltar', 'dealexport'),
            'GR'=>__('Greece', 'dealexport'),
            'GL'=>__('Greenland', 'dealexport'),
            'GD'=>__('Grenada', 'dealexport'),
            'GP'=>__('Guadeloupe', 'dealexport'),
            'GT'=>__('Guatemala', 'dealexport'),
            'GG'=>__('Guernsey', 'dealexport'),
            'GN'=>__('Guinea', 'dealexport'),
            'GW'=>__('Guinea-Bissau', 'dealexport'),
            'GY'=>__('Guyana', 'dealexport'),
            'HT'=>__('Haiti', 'dealexport'),
            'HM'=>__('Heard Island and McDonald Islands', 'dealexport'),
            'HN'=>__('Honduras', 'dealexport'),
            'HK'=>__('Hong Kong', 'dealexport'),
            'HU'=>__('Hungary', 'dealexport'),
            'IS'=>__('Iceland', 'dealexport'),
            'IN'=>__('India', 'dealexport'),
            'ID'=>__('Indonesia', 'dealexport'),
            'IR'=>__('Iran', 'dealexport'),
            'IQ'=>__('Iraq', 'dealexport'),
            'IE'=>__('Republic of Ireland', 'dealexport'),
            'IM'=>__('Isle of Man', 'dealexport'),
            'IL'=>__('Israel', 'dealexport'),
            'IT'=>__('Italy', 'dealexport'),
            'CI'=>__('Ivory Coast', 'dealexport'),
            'JM'=>__('Jamaica', 'dealexport'),
            'JP'=>__('Japan', 'dealexport'),
            'JE'=>__('Jersey', 'dealexport'),
            'JO'=>__('Jordan', 'dealexport'),
            'KZ'=>__('Kazakhstan', 'dealexport'),
            'KE'=>__('Kenya', 'dealexport'),
            'KI'=>__('Kiribati', 'dealexport'),
            'KW'=>__('Kuwait', 'dealexport'),
            'KG'=>__('Kyrgyzstan', 'dealexport'),
            'LA'=>__('Laos', 'dealexport'),
            'LV'=>__('Latvia', 'dealexport'),
            'LB'=>__('Lebanon', 'dealexport'),
            'LS'=>__('Lesotho', 'dealexport'),
            'LR'=>__('Liberia', 'dealexport'),
            'LY'=>__('Libya', 'dealexport'),
            'LI'=>__('Liechtenstein', 'dealexport'),
            'LT'=>__('Lithuania', 'dealexport'),
            'LU'=>__('Luxembourg', 'dealexport'),
            'MO'=>__('Macao S.A.R., China', 'dealexport'),
            'MK'=>__('Macedonia', 'dealexport'),
            'MG'=>__('Madagascar', 'dealexport'),
            'MW'=>__('Malawi', 'dealexport'),
            'MY'=>__('Malaysia', 'dealexport'),
            'MV'=>__('Maldives', 'dealexport'),
            'ML'=>__('Mali', 'dealexport'),
            'MT'=>__('Malta', 'dealexport'),
            'MH'=>__('Marshall Islands', 'dealexport'),
            'MQ'=>__('Martinique', 'dealexport'),
            'MR'=>__('Mauritania', 'dealexport'),
            'MU'=>__('Mauritius', 'dealexport'),
            'YT'=>__('Mayotte', 'dealexport'),
            'MX'=>__('Mexico', 'dealexport'),
            'FM'=>__('Micronesia', 'dealexport'),
            'MD'=>__('Moldova', 'dealexport'),
            'MC'=>__('Monaco', 'dealexport'),
            'MN'=>__('Mongolia', 'dealexport'),
            'ME'=>__('Montenegro', 'dealexport'),
            'MS'=>__('Montserrat', 'dealexport'),
            'MA'=>__('Morocco', 'dealexport'),
            'MZ'=>__('Mozambique', 'dealexport'),
            'MM'=>__('Myanmar', 'dealexport'),
            'NA'=>__('Namibia', 'dealexport'),
            'NR'=>__('Nauru', 'dealexport'),
            'NP'=>__('Nepal', 'dealexport'),
            'NL'=>__('Netherlands', 'dealexport'),
            'AN'=>__('Netherlands Antilles', 'dealexport'),
            'NC'=>__('New Caledonia', 'dealexport'),
            'NZ'=>__('New Zealand', 'dealexport'),
            'NI'=>__('Nicaragua', 'dealexport'),
            'NE'=>__('Niger', 'dealexport'),
            'NG'=>__('Nigeria', 'dealexport'),
            'NU'=>__('Niue', 'dealexport'),
            'NF'=>__('Norfolk Island', 'dealexport'),
            'KP'=>__('North Korea', 'dealexport'),
            'NO'=>__('Norway', 'dealexport'),
            'OM'=>__('Oman', 'dealexport'),
            'PK'=>__('Pakistan', 'dealexport'),
            'PS'=>__('Palestinian Territory', 'dealexport'),
            'PA'=>__('Panama', 'dealexport'),
            'PG'=>__('Papua New Guinea', 'dealexport'),
            'PY'=>__('Paraguay', 'dealexport'),
            'PE'=>__('Peru', 'dealexport'),
            'PH'=>__('Philippines', 'dealexport'),
            'PN'=>__('Pitcairn', 'dealexport'),
            'PL'=>__('Poland', 'dealexport'),
            'PT'=>__('Portugal', 'dealexport'),
            'QA'=>__('Qatar', 'dealexport'),
            'RE'=>__('Reunion', 'dealexport'),
            'RO'=>__('Romania', 'dealexport'),
            'RU'=>__('Russia', 'dealexport'),
            'RW'=>__('Rwanda', 'dealexport'),
            'BL'=>__('Saint Barth&eacute;lemy', 'dealexport'),
            'SH'=>__('Saint Helena', 'dealexport'),
            'KN'=>__('Saint Kitts and Nevis', 'dealexport'),
            'LC'=>__('Saint Lucia', 'dealexport'),
            'MF'=>__('Saint Martin (French part)', 'dealexport'),
            'SX'=>__('Saint Martin (Dutch part)', 'dealexport'),
            'PM'=>__('Saint Pierre and Miquelon', 'dealexport'),
            'VC'=>__('Saint Vincent and the Grenadines', 'dealexport'),
            'SM'=>__('San Marino', 'dealexport'),
            'ST'=>__('S&atilde;o Tom&eacute; and Pr&iacute;ncipe', 'dealexport'),
            'SA'=>__('Saudi Arabia', 'dealexport'),
            'SN'=>__('Senegal', 'dealexport'),
            'RS'=>__('Serbia', 'dealexport'),
            'SC'=>__('Seychelles', 'dealexport'),
            'SL'=>__('Sierra Leone', 'dealexport'),
            'SG'=>__('Singapore', 'dealexport'),
            'SK'=>__('Slovakia', 'dealexport'),
            'SI'=>__('Slovenia', 'dealexport'),
            'SB'=>__('Solomon Islands', 'dealexport'),
            'SO'=>__('Somalia', 'dealexport'),
            'ZA'=>__('South Africa', 'dealexport'),
            'GS'=>__('South Georgia/Sandwich Islands', 'dealexport'),
            'KR'=>__('South Korea', 'dealexport'),
            'SS'=>__('South Sudan', 'dealexport'),
            'ES'=>__('Spain', 'dealexport'),
            'LK'=>__('Sri Lanka', 'dealexport'),
            'SD'=>__('Sudan', 'dealexport'),
            'SR'=>__('Suriname', 'dealexport'),
            'SJ'=>__('Svalbard and Jan Mayen', 'dealexport'),
            'SZ'=>__('Swaziland', 'dealexport'),
            'SE'=>__('Sweden', 'dealexport'),
            'CH'=>__('Switzerland', 'dealexport'),
            'SY'=>__('Syria', 'dealexport'),
            'TW'=>__('Taiwan', 'dealexport'),
            'TJ'=>__('Tajikistan', 'dealexport'),
            'TZ'=>__('Tanzania', 'dealexport'),
            'TH'=>__('Thailand', 'dealexport'),
            'TL'=>__('Timor-Leste', 'dealexport'),
            'TG'=>__('Togo', 'dealexport'),
            'TK'=>__('Tokelau', 'dealexport'),
            'TO'=>__('Tonga', 'dealexport'),
            'TT'=>__('Trinidad and Tobago', 'dealexport'),
            'TN'=>__('Tunisia', 'dealexport'),
            'TR'=>__('Turkey', 'dealexport'),
            'TM'=>__('Turkmenistan', 'dealexport'),
            'TC'=>__('Turks and Caicos Islands', 'dealexport'),
            'TV'=>__('Tuvalu', 'dealexport'),
            'UG'=>__('Uganda', 'dealexport'),
            'UA'=>__('Ukraine', 'dealexport'),
            'AE'=>__('United Arab Emirates', 'dealexport'),
            'GB'=>__('United Kingdom (UK)', 'dealexport'),
            'US'=>__('United States (US)', 'dealexport'),
            'UY'=>__('Uruguay', 'dealexport'),
            'UZ'=>__('Uzbekistan', 'dealexport'),
            'VU'=>__('Vanuatu', 'dealexport'),
            'VA'=>__('Vatican', 'dealexport'),
            'VE'=>__('Venezuela', 'dealexport'),
            'VN'=>__('Vietnam', 'dealexport'),
            'WF'=>__('Wallis and Futuna', 'dealexport'),
            'EH'=>__('Western Sahara', 'dealexport'),
            'WS'=>__('Western Samoa', 'dealexport'),
            'YE'=>__('Yemen', 'dealexport'),
            'ZM'=>__('Zambia', 'dealexport'),
            'ZW'=>__('Zimbabwe', 'dealexport')
        ),
    ),
    
    //Theme Options
    'options' => array(
    
        //General
        array(	
            'name' => __('General', 'dealexport'),
            'type' => 'section'
        ),

            array(	
                'name' => __('Site Favicon', 'dealexport'),
                'description' => __('Choose an image to replace the default site favicon', 'dealexport'),
                'id' => 'favicon',
                'type' => 'uploader',
            ),

            array(	
                'name' => __('Site Logo', 'dealexport'),
                'description' => __('Choose an image to replace the default theme logo', 'dealexport'),
                'id' => 'site_logo',
                'type' => 'uploader',
            ),
            
            array(	
                'name' => __('Login Logo', 'dealexport'),
                'description' => __('Choose an image to replace the default WordPress login logo', 'dealexport'),
                'id' => 'login_logo',
                'type' => 'uploader',
            ),

            array(	
                'name' => __('Copyright Text', 'dealexport'),
                'description' => __('Enter copyright text to show in the theme footer', 'dealexport'),
                'id' => 'copyright',
                'type' => 'textarea',
            ),

            array(	
                'name' => __('Tracking Code', 'dealexport'),
                'description' => __('Enter Google Analytics code to track your site visitors', 'dealexport'),
                'id' => 'tracking',
                'type' => 'textarea',
            ),

        //Styling
        array(
            'name' => __('Styling', 'dealexport'),
            'type' => 'section',
        ),	

            array(	
                'name' => __('Primary Color', 'dealexport'),
                'default' => '#ea6254',
                'id' => 'primary_color',
                'type' => 'color',
            ),

            array(	
                'name' => __('Secondary Color', 'dealexport'),
                'default' => '#4e8ed6',
                'id' => 'secondary_color',
                'type' => 'color',
            ),
            
            array(	
                'name' => __('Background Image', 'dealexport'),
                'id' => 'background_image',
                'description' => __('Choose background image from WordPress media library', 'dealexport'),
                'type' => 'uploader',
            ),
            
            array(	
                'name' => __('Background Type', 'dealexport'),
                'id' => 'background_type',
                'type' => 'select',
                'options' => array(
                    'auto' => __('Tiled', 'dealexport'),
                    'cover' => __('Full Width', 'dealexport'),	
                ),
            ),
            
            array(	
                'name' => __('Heading Font' ,'dealexport'),	
                'id' => 'heading_font',
                'default' => 'Asap',
                'type' => 'select_font',
            ),

            array(	
                'name' => __('Content Font', 'dealexport'),
                'id' => 'content_font',
                'default' => 'Open Sans',
                'type' => 'select_font',
            ),

            array(	
                'name' => __('Custom CSS', 'dealexport'),
                'description' => __('Enter custom CSS code to overwrite the default theme styles', 'dealexport'),
                'id' => 'css',
                'type' => 'textarea',
            ),
            
        //Slider
        array(
            'name' => __('Slider', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('Slider Pause', 'dealexport'),
                'default' => '0',
                'id' => 'slider_pause',
                'min_value' => 0,
                'max_value' => 15000,
                'unit'=>'ms',
                'type' => 'slider',
            ),
            
            array(	
                'name' => __('Slider Speed', 'dealexport'),
                'default' => '1000',
                'id' => 'slider_speed',
                'min_value' => 0,
                'max_value' => 1000,
                'unit'=>'ms',
                'type' => 'slider',
            ),
            
        //Registration
        array(
            'name' => __('Registration', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('Enable Email Confirmation', 'dealexport'),
                'id' => 'user_activation',
                'type' => 'checkbox',
            ),
        
            array(
                'name' => __('Enable Captcha Protection', 'dealexport'),
                'id' => 'user_captcha',
                'type' => 'checkbox',
            ),
            
            array(	
                'name' => __('Enable Facebook Login', 'dealexport'),
                'id' => 'user_facebook',
                'type' => 'checkbox',
            ),
            
            array(	
                'name' => __('Facebook Application ID', 'dealexport'),
                'id' => 'user_facebook_id',
                'type' => 'text',
                'parent' => array(
                    'id' => 'user_facebook',
                    'value' => 'true',
                ),
            ),
            
            array(	
                'name' => __('Facebook Application Secret', 'dealexport'),
                'id' => 'user_facebook_secret',
                'type' => 'text',
                'parent' => array(
                    'id' => 'user_facebook',
                    'value' => 'true',
                ),
            ),
            
            array(	
                'name' => __('Registration Email', 'dealexport'),
                'id' => 'email_registration',
                'description' => __('Add registration email text, you can use %username%, %password% and %link% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(	
                'name' => __('Password Reset Email', 'dealexport'),
                'id' => 'email_password',
                'description' => __('Add password reset email text, you can use %username% and %link% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
        //Shops
        array(
            'name' => __('Shops', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('Shops Layout', 'dealexport'),
                'id' => 'shops_layout',
                'type' => 'select_image',
                'options' => array(
                    'full' => THEMEDB_URI.'assets/images/layouts/layout-full.png',
                    'left' => THEMEDB_URI.'assets/images/layouts/layout-left.png',
                    'right' => THEMEDB_URI.'assets/images/layouts/layout-right.png',
                ),
            ),
            
            array(	
                'name' => __('Shops Per Page', 'dealexport'),
                'id' => 'shops_per_page',
                'type' => 'number',
                'default' => '6',
            ),
            
            array(
                'name' => __('Disable Multiple Shops', 'dealexport'),
                'id' => 'shop_multiple',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Disable Shop Referrals', 'dealexport'),
                'id' => 'shop_referrals',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Disable Approving Shops', 'dealexport'),
                'id' => 'shop_approve',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Disable Custom Shipping', 'dealexport'),
                'id' => 'shop_shipping',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Rating', 'dealexport'),
                'id' => 'shop_rating',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Sales', 'dealexport'),
                'id' => 'shop_sales',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Favorites', 'dealexport'),
                'id' => 'shop_favorites',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Questions', 'dealexport'),
                'id' => 'shop_questions',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Reports', 'dealexport'),
                'id' => 'shop_reports',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Shop Policies', 'dealexport'),
                'id' => 'shop_policy',
                'type' => 'textarea',
            ),
        
        //Products
        array(
            'name' => __('Products', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('Products Layout', 'dealexport'),
                'id' => 'products_layout',
                'type' => 'select_image',
                'options' => array(
                    'full' => THEMEDB_URI.'assets/images/layouts/layout-full.png',
                    'left' => THEMEDB_URI.'assets/images/layouts/layout-left.png',
                    'right' => THEMEDB_URI.'assets/images/layouts/layout-right.png',
                ),
            ),
            
            array(	
                'name' => __('Products View', 'dealexport'),
                'id' => 'products_view',
                'type' => 'select',
                'options' => array(
                    'grid' => __('Grid', 'dealexport'),
                    'list' => __('List', 'dealexport'),
                ),
            ),
            
            array(	
                'name' => __('Products Per Page', 'dealexport'),
                'id' => 'products_per_page',
                'type' => 'number',
                'default' => '9',
            ),
            
            array(	
                'name' => __('Related Products Number', 'dealexport'),
                'id' => 'product_related_number',
                'type' => 'number',
                'default' => '5',
            ),
            
            array(	
                'name' => __('Upsell Products Number', 'dealexport'),
                'id' => 'product_upsell_number',
                'type' => 'number',
                'default' => '4',
            ),
            
            array(
                'name' => __('Product Types', 'dealexport'),
                'id' => 'product_type',
                'type' => 'select',
                'options' => array(
                    'all' => __('All Types', 'dealexport'),
                    'virtual' => __('Virtual', 'dealexport'),
                    'physical' => __('Physical', 'dealexport'),
                ),
            ),
            
            array(	
                'name' => __('File Extensions', 'dealexport'),
                'id' => 'product_extensions',
                'description' => __('Enter comma separated file extensions for products', 'dealexport'),
                'type' => 'text',
                'default' => 'zip',
            ),
            
            array(
                'name' => __('Disable Approving Products', 'dealexport'),
                'id' => 'product_approve',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Tags', 'dealexport'),
                'id' => 'product_tags',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Price', 'dealexport'),
                'id' => 'product_price',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Attributes', 'dealexport'),
                'id' => 'product_attributes',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Variations', 'dealexport'),
                'id' => 'product_variations',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Favorites', 'dealexport'),
                'id' => 'product_favorites',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Questions', 'dealexport'),
                'id' => 'product_questions',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Order Note', 'dealexport'),
                'id' => 'order_note',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Order Address', 'dealexport'),
                'id' => 'order_address',
                'type' => 'checkbox',
            ),
        
        //Posts
        array(
            'name' => __('Posts', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('Posts Layout', 'dealexport'),
                'id' => 'posts_layout',
                'type' => 'select_image',
                'options' => array(
                    'left' => THEMEDB_URI.'assets/images/layouts/layout-left.png',
                    'right' => THEMEDB_URI.'assets/images/layouts/layout-right.png',
                ),
            ),
            
            array(
                'name' => __('Hide Post Author', 'dealexport'),
                'id' => 'post_author',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Post Date', 'dealexport'),
                'id' => 'post_date',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Post Image', 'dealexport'),
                'id' => 'post_image',
                'type' => 'checkbox',
            ),
            
        //Profiles
        array(
            'name' => __('Profiles', 'dealexport'),
            'type' => 'section',
        ),
        
            array(
                'name' => __('Hide Name', 'dealexport'),
                'id' => 'profile_name',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Location', 'dealexport'),
                'id' => 'profile_location',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Date', 'dealexport'),
                'id' => 'profile_date',
                'type' => 'checkbox',
            ),			
            
            array(
                'name' => __('Hide Links', 'dealexport'),
                'id' => 'profile_links',
                'type' => 'checkbox',
            ),
            
            array(
                'name' => __('Hide Address', 'dealexport'),
                'id' => 'profile_address',
                'type' => 'checkbox',
            ),
            
            array(
                'id' => 'ThemedbForm',
                'slug' => 'profile',
                'type' => 'module',
            ),
            
        //Payments
        array(
            'name' => __('Payments', 'dealexport'),
            'type' => 'section',
        ),
        
            array(
                'name' => __('Referral Rate', 'dealexport'),
                'id' => 'shop_rate_referral',
                'description' => __('Enter affiliate commission rate earned for referred orders', 'dealexport'),
                'type' => 'number',
                'default' => '30',
            ),
        
            array(	
                'name' => __('Minimum Rate', 'dealexport'),
                'id' => 'shop_rate_min',
                'description' => __('Enter minimum shop commission rate per order', 'dealexport'),
                'type' => 'number',
                'default' => '50',
            ),
            
            array(	
                'name' => __('Maximum Rate', 'dealexport'),
                'id' => 'shop_rate_max',
                'description' => __('Enter maximum shop commission rate per order', 'dealexport'),
                'type' => 'number',
                'default' => '70',
            ),
            
            array(	
                'name' => __('Maximum Revenue', 'dealexport'),
                'id' => 'shop_rate_amount',
                'description' => __('Enter revenue amount for the maximum commission rate', 'dealexport'),
                'type' => 'number',
                'default' => '1000',
            ),
            
            array(	
                'name' => __('Minimum Withdrawal', 'dealexport'),
                'id' => 'withdrawal_min',
                'description' => __('Enter minimum withdrawal amount per request', 'dealexport'),
                'type' => 'number',
                'default' => '50',
            ),
            
            array(	
                'name' => __('Withdrawal Methods', 'dealexport'),
                'id' => 'withdrawal_methods',
                'description' => __('Select available withdrawal methods, hold the CTRL or CMD key to select multiple items', 'dealexport'),
                'type' => 'select',
                'options' => array(
                    'paypal' => __('PayPal', 'dealexport'),
                    'skrill' => __('Skrill', 'dealexport'),
                    'swift' => __('SWIFT', 'dealexport'),
                ),
                'attributes' => array(
                    'multiple' => 'multiple',
                ),
                'default' => array(
                    'paypal',
                    'skrill',
                    'swift',
                ),
            ),
            
        //Membership
        array(
            'name' => __('Membership', 'dealexport'),
            'type' => 'section',
        ),
        
            array(
                'name' => __('Disable Free Membership', 'dealexport'),
                'id' => 'membership_free',
                'type' => 'checkbox',
            ),
            
            array(	
                'name' => __('Free Membership Duration','dealexport'),
                'id' => 'membership_period',
                'type' => 'number',
                'default' => '31',
            ),
            
            array(	
                'name' => __('Free Products Number','dealexport'),
                'id' => 'membership_products',
                'type' => 'number',
                'default' => '10',
            ),
            
        //Notifications
        array(
            'name' => __('Notifications', 'dealexport'),
            'type' => 'section',
        ),
        
            array(	
                'name' => __('New Message Email', 'dealexport'),
                'id' => 'email_message',
                'description' => __('Add new message email text, you can use %user% and %message% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(
                'name' => __('New Order Email', 'dealexport'),
                'id' => 'email_order_received',
                'description' => __('Add new order email text, you can use %username% and %order% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(
                'name' => __('New Referral Email', 'dealexport'),
                'id' => 'email_order_referral',
                'description' => __('Add new referral email text, you can use %username% and %order% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(
                'name' => __('Shop Question Email', 'dealexport'),
                'id' => 'email_shop_question',
                'description' => __('Add shop question email text, you can use %user%, %shop% and %question% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(	
                'name' => __('Shop Report Email', 'dealexport'),
                'id' => 'email_shop_report',
                'description' => __('Add shop report email text, you can use %user%, %shop% and %reason% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(	
                'name' => __('Shop Approval Email', 'dealexport'),
                'id' => 'email_shop_approved',
                'description' => __('Add shop approval email text, you can use %username% and %shop% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(	
                'name' => __('Product Question Email', 'dealexport'),
                'id' => 'email_product_question',
                'description' => __('Add product question email text, you can use %user%, %product% and %question% keywords', 'dealexport'),
                'type' => 'textarea',
            ),

            array(
                'name' => __('Product Approval Email', 'dealexport'),
                'id' => 'email_product_approved',
                'description' => __('Add product approval email text, you can use %username% and %product% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
            
            array(
                'name' => __('Processed Withdrawal Email', 'dealexport'),
                'id' => 'email_withdrawal_processed',
                'description' => __('Add processed withdrawal email text, you can use %username%, %method% and %amount% keywords', 'dealexport'),
                'type' => 'textarea',
            ),
    ),
);