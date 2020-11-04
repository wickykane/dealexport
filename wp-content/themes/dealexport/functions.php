<?php

include_once 'framework/devb_utilities.php';

//Define constants
define('SITE_URL', home_url() . '/');
define('AJAX_URL', admin_url('admin-ajax.php'));
define('THEME_PATH', get_template_directory() . '/');
define('CHILD_PATH', get_stylesheet_directory() . '/');
define('THEME_URI', get_template_directory_uri() . '/');
define('CHILD_URI', get_stylesheet_directory_uri() . '/');
define('THEMEDB_PATH', THEME_PATH . 'framework/');
define('THEMEDB_URI', THEME_URI . 'framework/');
define('THEMEDB_PREFIX', 'themedb_');


//Set content width
$content_width = 1200; // Mark: original: 940

//Load language files
load_theme_textdomain('dealexport', THEME_PATH . 'languages');

//Include theme functions
include(THEMEDB_PATH . 'functions.php');

//Include configuration
include(THEMEDB_PATH . 'config.php');

//Include core class
include(THEMEDB_PATH . 'classes/themedb.core.php');

// add Email Template page
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(__('Email Template', 'dealexport'));
}

//Create theme instance
$themedb = new ThemedbCore($config);

// remove item-options right
function remove_loop_button()
{
  remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
  remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
}

add_action('init', 'remove_loop_button');

// create email template editor page
if (function_exists('acf_add_options_page')) {
  acf_add_options_page(__('Email Template', 'sb_theme'));
}

/*
 *  CUSTOM LOGIN PAGE
 */

function db_custom_login()
{
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/custom-login/custom-login-styles.css" />';
}

add_action('login_head', 'db_custom_login');

function db_login_logo_url()
{
  return get_bloginfo('url');
}

add_filter('login_headerurl', 'db_login_logo_url');

function db_login_logo_url_title()
{
  return 'Deal Export - Connecting market';
}

add_filter('login_headertitle', 'db_login_logo_url_title');

function de_add_select2_script()
{
  wp_dequeue_style('select2');
  wp_deregister_style('select2');

  wp_dequeue_script('select2');
  wp_deregister_script('select2');
  //-- CSS HTML here
  wp_enqueue_style('select2', THEME_URI . 'js/select2/select2.min.css', array(), '4.0.1', 'screen');

  //-- JS HTML here
  //-- JS IN HEADER
  wp_enqueue_script('select2', THEME_URI . 'js/select2/select2.min.js', array('jquery'), '4.0.1', false);


  //-- AOS animate on scroll
  wp_enqueue_style('aos-css', 'https://unpkg.com/aos@2.3.1/dist/aos.css', false);
  wp_enqueue_script('aos-script', 'https://unpkg.com/aos@2.3.1/dist/aos.js', array('jquery'), true);
}

add_action('wp_enqueue_scripts', 'de_add_select2_script', 100);

function add_semantic_ui_scripts()
{
  //-- Semantic JS
  wp_enqueue_style('sematic-ui-css', THEME_URI . 'assets/semantic-ui/semantic.min.css', false);
  wp_enqueue_script('sematic-ui-script', THEME_URI . 'assets/semantic-ui/semantic.min.js', array('jquery'), true);
}

add_action('wp_enqueue_scripts', 'add_semantic_ui_scripts', 10);

function de_create_taxonomy()
{

  /***************************************************************************
        Register Taxonomies for Products
   ***************************************************************************/
  // Add new "Products per User" taxonomy to Product
  register_taxonomy('product_custome_type', 'product', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Product Display Menu', 'taxonomy general name', 'dealexport'), // Product per User
      'singular_name' => _x('Product Display Menu', 'taxonomy singular name', 'dealexport'), // Product per User
      'search_items' => __('Product Display Menu', 'dealexport'), // Product per User
      'all_items' => __('All Product Display Menu', 'dealexport'), // Product per User
      'parent_item' => __('Parent Product Display Menu', 'dealexport'), // Product per User
      'parent_item_colon' => __('Parent Product Display Menu:', 'dealexport'), // Product per User
      'edit_item' => __('Edit Product Display Menu', 'dealexport'), // Product per User
      'update_item' => __('Update Product Display Menu', 'dealexport'), // Product per User
      'add_new_item' => __('Add New Product Display Menu', 'dealexport'), // Product per User
      'new_item_name' => __('New Product Display Menu name', 'dealexport'), // Product per User
      'menu_name' => __('Product Display Menu', 'dealexport'), // Product per User
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'product_custome_type', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));


  // Add "Type of Industries"
  register_taxonomy('type_of_industry', array('shop', 'product'), array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Type of Industry', 'taxonomy general name', 'dealexport'),
      'singular_name' => _x('Type of Industry', 'taxonomy singular name', 'dealexport'),
      'search_items' => __('Search Type of Industry', 'dealexport'),
      'all_items' => __('All Types of Industry', 'dealexport'),
      'parent_item' => __('Parent Type of Industry', 'dealexport'),
      'parent_item_colon' => __('Parent Type of Industry:', 'dealexport'),
      'edit_item' => __('Edit Type of Industry', 'dealexport'),
      'update_item' => __('Update Type of Industry', 'dealexport'),
      'add_new_item' => __('Add New Type of Industry', 'dealexport'),
      'new_item_name' => __('New Type of Industry Name', 'dealexport'),
      'menu_name' => __('Type of Industry', 'dealexport'),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'type_of_industry', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => false // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));


  // Add new "Level of expertise"
  register_taxonomy('level_of_expertise', array('shop', 'product'), array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Level of Expertise', 'taxonomy general name', 'dealexport'), // NOT ok
      'singular_name' => _x('Level of Expertise', 'taxonomy singular name', 'dealexport'),
      'search_items' => __('Search Level of Expertise', 'dealexport'),
      'all_items' => __('All Levels of Expertise', 'dealexport'),
      'parent_item' => __('Parent Level of Expertise', 'dealexport'),
      'parent_item_colon' => __('Parent Level of Expertise:', 'dealexport'),
      'edit_item' => __('Edit Level of Expertise', 'dealexport'),
      'update_item' => __('Update Level of Expertise', 'dealexport'),
      'add_new_item' => __('Add New Level of Expertise', 'dealexport'),
      'new_item_name' => __('New Level of Expertise Name', 'dealexport'),
      'menu_name' => __('Level of Expertise', 'dealexport'), // ok
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'level_of_expertise', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));

  // Add new "Level of Development" (previous name: "International development stage")
  register_taxonomy('level_of_development', 'product', array( // previous taxonomy: "international_development_stage"
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Level of Development', 'taxonomy general name', 'dealexport'),
      'singular_name' => _x('Level of Development', 'taxonomy singular name', 'dealexport'),
      'search_items' => __('Search Level of Development', 'dealexport'),
      'all_items' => __('All Levels of Development', 'dealexport'),
      'parent_item' => __('Parent Level of Development', 'dealexport'),
      'parent_item_colon' => __('Parent Level of Development:', 'dealexport'),
      'edit_item' => __('Edit Level of Development', 'dealexport'),
      'update_item' => __('Update Level of Development', 'dealexport'),
      'add_new_item' => __('Add New Level of Development', 'dealexport'),
      'new_item_name' => __('New Level of Development Name', 'dealexport'),
      'menu_name' => __('Level of Development', 'dealexport'),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'level_of_development', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));


  // Add new "Country/Region" taxonomy to Product
  register_taxonomy('product_country_region', 'product', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Country/Region', 'taxonomy general name', 'dealexport'),
      'singular_name' => _x('Country/Region', 'taxonomy singular name', 'dealexport'),
      'search_items' => __('Search Country/Region', 'dealexport'),
      'all_items' => __('All Country/Region', 'dealexport'),
      'parent_item' => __('Parent Country/Region', 'dealexport'),
      'parent_item_colon' => __('Parent Country/Region:', 'dealexport'),
      'edit_item' => __('Edit Country/Region', 'dealexport'),
      'update_item' => __('Update Country/Region', 'dealexport'),
      'add_new_item' => __('Add New Country/Region', 'dealexport'),
      'new_item_name' => __('New Country/Region Name', 'dealexport'),
      'menu_name' => __('Country/Region', 'dealexport'),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'product_country_region', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));


  register_sidebar(array(
    'name'          => 'Advancetage-Box',
    'id'            => 'advancetage-box',
    'before_widget' => '<div class="chw-widget">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="chw-title">',
    'after_title'   => '</h2>',
  ));


  /***************************************************************************
        Register Taxonomies for Exporters
   ***************************************************************************/


  // 9th Jan 2019 - Remove "Category " 
  // register_taxonomy('shop_category', 'shop', array(
  //     'hierarchical' => true,
  //     'show_in_nav_menus' => true,
  //     'labels' => array(
  //         'name' => _x('Category of Products/Services', 'taxonomy general name', 'dealexport'),
  //         'singular_name' => _x('Category of Products/Services', 'taxonomy singular name', 'dealexport'),
  //         'search_items' => __('Search Category of Products/Services', 'dealexport'),
  //         'all_items' => __('All Categories of Products/Services', 'dealexport'),
  //         'parent_item' => __('Parent Category of Products/Services', 'dealexport'),
  //         'parent_item_colon' => __('Parent Category of Products/Services:', 'dealexport'),
  //         'edit_item' => __('Edit Category of Products/Services', 'dealexport'),
  //         'update_item' => __('Update Category of Products/Services', 'dealexport'),
  //         'add_new_item' => __('Add New Category of Products/Services', 'dealexport'),
  //         'new_item_name' => __('New Category of Products/Services Name', 'dealexport'),
  //         'menu_name' => __('Category of Products/Services', 'dealexport'),
  //     ),
  //     // Control the slugs used for this taxonomy
  //     'rewrite' => array(
  //         'slug' => 'shop_category', // This controls the base slug that will display before each term
  //         'with_front' => false, // Don't display the category base before "/locations/"
  //         'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
  //     ),
  // ));


  // Add new "Country/Region" taxonomy to Shop
  register_taxonomy('shop_country_region', 'shop', array(
    'hierarchical' => true,
    'labels' => array(
      'name' => _x('Country/Region', 'taxonomy general name', 'dealexport'),
      'singular_name' => _x('Country/Region', 'taxonomy singular name', 'dealexport'),
      'search_items' => __('Search Country/Region', 'dealexport'),
      'all_items' => __('All Country/Region', 'dealexport'),
      'parent_item' => __('Parent Country/Region', 'dealexport'),
      'parent_item_colon' => __('Parent Country/Region:', 'dealexport'),
      'edit_item' => __('Edit Country/Region', 'dealexport'),
      'update_item' => __('Update Country/Region', 'dealexport'),
      'add_new_item' => __('Add New Country/Region', 'dealexport'),
      'new_item_name' => __('New Country/Region Name', 'dealexport'),
      'menu_name' => __('Country/Region', 'dealexport'),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'shop_country_region', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}

add_action('init', 'de_create_taxonomy', 0);


/**
 * Overwrite product_tag taxonomy properties to effectively hide it from WP admin ..
 */
add_action('init', function () {
  register_taxonomy('product_tag', 'product', [
    'public'            => false,
    'show_ui'           => false,
    'show_admin_column' => false,
    'show_in_nav_menus' => false,
    'show_tagcloud'     => false,
  ]);
}, 100);

/**
 * .. and also remove the column from Products table - it's also hardcoded there.
 */
add_action('admin_init', function () {
  add_filter('manage_product_posts_columns', function ($columns) {
    unset($columns['product_tag']);
    return $columns;
  }, 100);
});

function modify_shop_default_category()
{

  $product_category_args = get_taxonomy('product_cat');
  $product_category_args->labels->name = 'Category of Products/Services';
  $product_category_args->labels->singular_name = 'Category of Products/Services';
  $product_category_args->labels->search_items = 'Search Category of Products/Services';
  $product_category_args->labels->all_items = 'All Categories of Products/Services';
  $product_category_args->labels->parent_item = 'Category of Products/Services';
  $product_category_args->labels->parent_item_colon = 'Category of Products/Services';
  $product_category_args->labels->edit_item = 'Category of Products/Services';
  $product_category_args->labels->update_item = 'Category of Products/Services';
  $product_category_args->labels->add_new_item = 'Category of Products/Services';
  $product_category_args->labels->menu_name = 'Category of Products/Services';
  // re-register the taxonomy
  register_taxonomy('product_cat', 'product', (array) $product_category_args);
  flush_rewrite_rules();
}
// hook it up to 11 so that it overrides the original register_taxonomy function
add_action('init', 'modify_shop_default_category', 11);



/*
 * Product filter function 
 */

function de_get_product_country()
{
  $country_arr = array();
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => FALSE,
  );
  $taxonomy = 'product_country_region';
  $terms = get_terms($taxonomy, $args);
  foreach ($terms as $term) {
    if ($term->parent == 0) {
      $country_arr[] = array('id' => $term->term_id, 'text' => $term->name);
    }
  }
  return $country_arr;
}

function de_get_region_by_country_id($country_id)
{
  $child_term_arr = get_term_children($country_id, 'product_country_region');
  return $child_term_arr;
}

function de_get_list_region_by_country_id($country_id)
{
  $region_list = array();
  $sort = array();
  $region_id_arr = de_get_region_by_country_id($country_id);
  foreach ($region_id_arr as $region_id) {
    $region_data = get_term($region_id, 'product_country_region', OBJECT);
    $region_list[] = array('slug' => $region_data->slug, 'title' => $region_data->name);
  }
  if (!empty($region_list)) {
    foreach ($region_list as $k => $v) {
      $sort['text'][$k] = $v['text'];
    }
    array_multisort($sort['text'], SORT_ASC, SORT_STRING, $region_list);
  }
  return $region_list;
  //    return $region_list;
}

function de_get_list_region_of_country()
{
  if (isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != NULL) {
    $country_id = $_REQUEST['country_id'];
    $region_list = de_get_list_region_by_country_id($country_id);
  }
  wp_send_json($region_list);
  //    return $region_list;
}

add_action('wp_ajax_de_get_list_region_of_country', 'de_get_list_region_of_country');
add_action('wp_ajax_nopriv_de_get_list_region_of_country', 'de_get_list_region_of_country');

function de_add_product_country_filter_query($query)
{
  if (is_shop()) {
    if (!$query->is_main_query() || is_admin()) {
      return $query;
    }
    //Not sure the purpose
    // $query->set('tax_query', array(
    //     array(
    //         'taxonomy' => 'product_custome_type',
    //         'field' => 'slug',
    //         'terms' => 'service',
    //         'operator' => 'NOT IN'
    //     ),
    // ));



    if (((isset($_GET['country-filter']) && $_GET['country-filter'] != NULL) || (isset($_GET['region-filter']) && $_GET['region-filter'] != NULL)) && !isset($_GET['product-cat'])) {
      if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL && (!isset($_GET['region-filter']) || $_GET['region-filter'] == NULL)) {
        $term_filter = $_GET['country-filter'];
      } else {
        $term_filter = $_GET['region-filter'];
      }
      $query->set('tax_query', array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'product_country_region',
          'field' => 'id',
          'terms' => $term_filter,
        ),
        array(
          'taxonomy' => 'product_custome_type',
          'field' => 'slug',
          'terms' => 'service',
          'operator' => 'NOT IN'
        ),
      ));
    } elseif ((!isset($_GET['country-filter']) || $_GET['country-filter'] == NULL) && (isset($_GET['product-cat']) && $_GET['product-cat'] != NULL)) {
      $term_filter = $_GET['product-cat'];
      $query->set('tax_query', array(
        'relation' => 'AND',
        array(
          'taxonomy' => 'product_cat',
          'field' => 'id',
          'terms' => $term_filter,
        ),
        array(
          'taxonomy' => 'product_custome_type',
          'field' => 'slug',
          'terms' => 'service',
          'operator' => 'NOT IN'
        ),
      ));
    } elseif (isset($_GET['country-filter']) && isset($_GET['region-filter']) && isset($_GET['product-cat'])) {
      if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL && (!isset($_GET['region-filter']) || $_GET['region-filter'] == NULL)) {
        $location_term_filter = $_GET['country-filter'];
      } else {
        $location_term_filter = $_GET['region-filter'];
      }
      $cat_term_filter = $_GET['product-cat'];
      $tax_query = array();
      $tax_query[] = array(
        'taxonomy' => 'product_country_region',
        'field' => 'id',
        'terms' => $location_term_filter,
      );
      $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field' => 'id',
        'terms' => $cat_term_filter,
      );
      $tax_query[] = array(
        'taxonomy' => 'product_custome_type',
        'field' => 'slug',
        'terms' => 'service',
        'operator' => 'NOT IN'
      );
      if (!empty($tax_query)) {
        $tax_query['relation'] = 'AND'; // you can also use 'OR' here
        $query->set('tax_query', $tax_query);
      }
    }
    $query->set('orderby', array('menu_order' => 'ASC', 'title' => 'ASC'));
    return $query;
  }
}

//add_filter('pre_get_posts', 'de_add_product_country_filter_query');

// Remove breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

function de_get_product_categories()
{
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => FALSE,
  );
  $taxonomy = 'product_cat';
  $terms = get_terms($taxonomy, $args);

  return $terms;
}

function hierarchical_category_tree($pterm, $taxonomy, $termType, $type, $is_service, $service_term_id)
{
  $terms = get_terms($taxonomy, array('parent' => $pterm->term_id, 'orderby' => 'slug', 'hide_empty' => false));
  if (count($terms) > 0) {
    $out .= "<ul class='product-child-categorie'>";
    foreach ($terms as $term) {
      $termID = $term->term_id;
      if (!isset($_GET['country-filter']) || ($_GET['country-filter'] == NULL && $_GET['region-filter'] == NULL)) {
        $term_count = de_count_item_in_category_with_filter('', $termID, $type, $is_service, $service_term_id);
      } else {
        if ($_GET['region-filter'] == NULL) {
          $location_filter_to_count = $_GET['country-filter'];
        } else {
          $location_filter_to_count = $_GET['region-filter'];
        }
        $term_count = de_count_item_in_category_with_filter($location_filter_to_count, $termID, $type, $is_service, $service_term_id);
      }
      if ($type != 'shop') {
        $product_cat_url = get_permalink(woocommerce_get_page_id('shop')) .
          (isset($_GET['country-filter']) ? '?country-filter=' . $_GET['country-filter'] : '?') .
          (isset($_GET['region-filter']) ? '&region-filter=' . $_GET['region-filter'] : '') . '&' . $termType . '=' . $termID;
      } else {
        $product_cat_url = get_permalink(get_page_by_path('shops')) .
          (isset($_GET['country-filter']) ? '?country-filter=' . $_GET['country-filter'] : '?') .
          (isset($_GET['region-filter']) ? '&region-filter=' . $_GET['region-filter'] : '') . '&' . $termType . '=' . $termID;
      }
      if ($term_count > 0) :
        $out .= "<li class='cat-item'>
                            <a href='" . $product_cat_url . "'>" . $term->name . "</a>
                                    <span class='count'>(" . $term_count . ")</span>";
      endif;
      $out .= hierarchical_category_tree($term, $taxonomy, $termType, $type, $is_service, $service_term_id);
    }
  } else {
    return $out .= "</li>";
  }

  $out .= '</ul>';
  return $out;
}

/*
 * 
 * Shop filter function 
 *  
 */

function de_get_shop_country()
{
  $country_arr = array();
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => FALSE,
  );
  $taxonomy = 'shop_country_region';
  $terms = get_terms($taxonomy, $args);
  foreach ($terms as $term) {
    if ($term->parent == 0) {
      $country_arr[] = array('id' => $term->term_id, 'text' => $term->name);
    }
  }
  return $country_arr;
}

function de_get_shop_region_by_country_id($country_id)
{
  $child_term_arr = get_term_children($country_id, 'shop_country_region');
  return $child_term_arr;
}

function de_get_shop_list_region_by_country_id($country_id)
{
  $region_list = array();
  $sort = array();
  $region_id_arr = de_get_shop_region_by_country_id($country_id);
  foreach ($region_id_arr as $region_id) {
    $region_data = get_term($region_id, 'shop_country_region', OBJECT);
    $region_list[] = array('id' => $region_id, 'text' => $region_data->name);
  }
  if (!empty($region_list)) {
    foreach ($region_list as $k => $v) {
      $sort['text'][$k] = $v['text'];
    }
    array_multisort($sort['text'], SORT_ASC, SORT_STRING, $region_list);
  }
  return $region_list;
}

function de_get_shop_list_region_of_country()
{
  if (isset($_REQUEST['country_id']) && $_REQUEST['country_id'] != NULL) {
    $country_id = $_REQUEST['country_id'];
    $region_list = de_get_shop_list_region_by_country_id($country_id);
  }
  wp_send_json($region_list);
  //    return $region_list;
}

add_action('wp_ajax_de_get_shop_list_region_of_country', 'de_get_shop_list_region_of_country');
add_action('wp_ajax_nopriv_de_get_shop_list_region_of_country', 'de_get_shop_list_region_of_country');

function de_get_shop_categories()
{
  $args = array(
    'orderby' => 'name',
    'order' => 'ASC',
    'hide_empty' => FALSE,
  );
  $taxonomy = 'shop_category';
  $terms = get_terms($taxonomy, $args);
  return $terms;
}

function de_count_item_in_category_with_filter($location_id = '', $category_id = '', $post_type = '', $is_service = false, $service_id = '')
{
  global $wpdb;
  $sql = "SELECT DISTINCT object_id FROM " . $wpdb->prefix . "term_relationships tr INNER JOIN " . $wpdb->prefix . "posts p"
    . " ON tr.object_id = p.ID"
    . " WHERE p.post_type = '" . $post_type . "' AND p.post_status = 'publish' AND"
    . " object_id IN (SELECT object_id FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id = " . $category_id . ")";
  if ($is_service == false && $service_id != '') {
    $sql .= " AND object_id NOT IN (SELECT object_id FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id = " . $service_id . ")";
  }
  if ($is_service == true && $service_id != '') {
    $sql .= " AND object_id IN (SELECT object_id FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id = " . $service_id . ")";
  }
  if ($location_id != '') {
    $sql .= " AND object_id IN (SELECT object_id FROM " . $wpdb->prefix . "term_relationships WHERE term_taxonomy_id = " . $location_id . ")";
  }
  $result = $wpdb->get_results($sql);
  return count($result);
}

/*
 * 
 * Add arrival price field for product 
 *  
 */

function de_product_arrival_price_field()
{
  woocommerce_wp_text_input(array('id' => 'arv_price', 'class' => 'wc_input_price short', 'label' => __('Arrival Price', 'dealexport') . ' (' . get_woocommerce_currency_symbol() . ')'));
}

add_action('woocommerce_product_options_pricing', 'de_product_arrival_price_field');

function de_product_arrival_price_save($product_id)
{
  // If this is a auto save do nothing, we only save when update button is clicked
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;
  if (isset($_POST['arv_price'])) {
    if (is_numeric($_POST['arv_price']))
      update_post_meta($product_id, 'arv_price', $_POST['arv_price']);
  } else
    delete_post_meta($product_id, 'arv_price');
}

add_action('save_post', 'de_product_arrival_price_save');

function save_out_of_stock_message($product_id)
{
  // If this is a auto save do nothing, we only save when update button is clicked
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    return;
  if (isset($_POST['_out_of_stock_message'])) {
    update_post_meta($product_id, '_out_of_stock_message', $_POST['_out_of_stock_message']);
  } else
    delete_post_meta($product_id, '_out_of_stock_message');
}

add_action('save_post', 'save_out_of_stock_message');

function de_update_shop_author_to_product($product_id)
{


  if (get_field('de_shop', $product_id)->post_author != NULL) {
    $shop_author_id = get_field('de_shop', $product_id)->post_author;
  } else {
    $shop_author_id = get_field('de_shop_manager', $product_id)['ID'];
  }

  if (!wp_is_post_revision($product_id)) {

    // unhook this function so it doesn't loop infinitely
    remove_action('save_post', 'de_update_shop_author_to_product');

    // If this is a auto save do nothing, we only save when update button is clicked

    $args = array(
      'ID' => $product_id,
      'post_author' => (int) $shop_author_id,
    );
    // Update the post into the database
    wp_update_post($args);

    // re-hook this function
    add_action('save_post', 'de_update_shop_author_to_product');
  }
}

add_action('save_post', 'de_update_shop_author_to_product');

// return youtube video id 
function get_video_id($video_url)
{
  $str1 = str_replace('watch?v=', '', array_pop(explode("/", $video_url)));
  if (strpos($str1, '&list=') != FALSE) {
    $str2 = substr($str1, 0, strpos($str1, '&list='));
  } elseif (strpos($str1, '?list=') != FALSE) {
    $str2 = substr($str1, 0, strpos($str1, '?list='));
  } else {
    $str2 = $str1;
  }
  return $str2;
}

// Function remove character from file name when upload
function de_sanitize_filename_on_upload($filename)
{
  //    $special_chars = array("á", "é", "í", "ó", "ú", "Á", "É", "Í", "Ó", "Ú", "ñ", "Ñ", "Ç", "ç", "è", "ï");
  //    $replacement_chars = array("a", "e", "i", "o", "u", "A", "E", "I", "O", "U", "n", "N", "C", "c", "e", "i");
  //    $replaced_string = str_replace($special_chars, $replacement_chars, $filename);
  //    return $replaced_string;
  $replace = array(
    "ъ" => "-", "Ь" => "-", "Ъ" => "-", "ь" => "-",
    "Ă" => "A", "Ą" => "A", "À" => "A", "Ã" => "A", "Á" => "A", "Æ" => "A", "Â" => "A", "Å" => "A", "Ä" => "Ae",
    "Þ" => "B",
    "Ć" => "C", "ץ" => "C", "Ç" => "C",
    "È" => "E", "Ę" => "E", "É" => "E", "Ë" => "E", "Ê" => "E",
    "Ğ" => "G",
    "İ" => "I", "Ï" => "I", "Î" => "I", "Í" => "I", "Ì" => "I",
    "Ł" => "L",
    "Ñ" => "N", "Ń" => "N",
    "Ø" => "O", "Ó" => "O", "Ò" => "O", "Ô" => "O", "Õ" => "O", "Ö" => "Oe",
    "Ş" => "S", "Ś" => "S", "Ș" => "S", "Š" => "S",
    "Ț" => "T",
    "Ù" => "U", "Û" => "U", "Ú" => "U", "Ü" => "Ue",
    "Ý" => "Y",
    "Ź" => "Z", "Ž" => "Z", "Ż" => "Z",
    "â" => "a", "ǎ" => "a", "ą" => "a", "á" => "a", "ă" => "a", "ã" => "a", "Ǎ" => "a", "а" => "a", "А" => "a", "å" => "a", "à" => "a", "א" => "a", "Ǻ" => "a", "Ā" => "a", "ǻ" => "a", "ā" => "a", "ä" => "ae", "æ" => "ae", "Ǽ" => "ae", "ǽ" => "ae",
    "б" => "b", "ב" => "b", "Б" => "b", "þ" => "b",
    "ĉ" => "c", "Ĉ" => "c", "Ċ" => "c", "ć" => "c", "ç" => "c", "ц" => "c", "צ" => "c", "ċ" => "c", "Ц" => "c", "Č" => "c", "č" => "c", "Ч" => "ch", "ч" => "ch",
    "ד" => "d", "ď" => "d", "Đ" => "d", "Ď" => "d", "đ" => "d", "д" => "d", "Д" => "D", "ð" => "d",
    "є" => "e", "ע" => "e", "е" => "e", "Е" => "e", "Ə" => "e", "ę" => "e", "ĕ" => "e", "ē" => "e", "Ē" => "e", "Ė" => "e", "ė" => "e", "ě" => "e", "Ě" => "e", "Є" => "e", "Ĕ" => "e", "ê" => "e", "ə" => "e", "è" => "e", "ë" => "e", "é" => "e",
    "ф" => "f", "ƒ" => "f", "Ф" => "f",
    "ġ" => "g", "Ģ" => "g", "Ġ" => "g", "Ĝ" => "g", "Г" => "g", "г" => "g", "ĝ" => "g", "ğ" => "g", "ג" => "g", "Ґ" => "g", "ґ" => "g", "ģ" => "g",
    "ח" => "h", "ħ" => "h", "Х" => "h", "Ħ" => "h", "Ĥ" => "h", "ĥ" => "h", "х" => "h", "ה" => "h",
    "î" => "i", "ï" => "i", "í" => "i", "ì" => "i", "į" => "i", "ĭ" => "i", "ı" => "i", "Ĭ" => "i", "И" => "i", "ĩ" => "i", "ǐ" => "i", "Ĩ" => "i", "Ǐ" => "i", "и" => "i", "Į" => "i", "י" => "i", "Ї" => "i", "Ī" => "i", "І" => "i", "ї" => "i", "і" => "i", "ī" => "i", "ĳ" => "ij", "Ĳ" => "ij",
    "й" => "j", "Й" => "j", "Ĵ" => "j", "ĵ" => "j", "я" => "ja", "Я" => "ja", "Э" => "je", "э" => "je", "ё" => "jo", "Ё" => "jo", "ю" => "ju", "Ю" => "ju",
    "ĸ" => "k", "כ" => "k", "Ķ" => "k", "К" => "k", "к" => "k", "ķ" => "k", "ך" => "k",
    "Ŀ" => "l", "ŀ" => "l", "Л" => "l", "ł" => "l", "ļ" => "l", "ĺ" => "l", "Ĺ" => "l", "Ļ" => "l", "л" => "l", "Ľ" => "l", "ľ" => "l", "ל" => "l",
    "מ" => "m", "М" => "m", "ם" => "m", "м" => "m",
    "ñ" => "n", "н" => "n", "Ņ" => "n", "ן" => "n", "ŋ" => "n", "נ" => "n", "Н" => "n", "ń" => "n", "Ŋ" => "n", "ņ" => "n", "ŉ" => "n", "Ň" => "n", "ň" => "n",
    "о" => "o", "О" => "o", "ő" => "o", "õ" => "o", "ô" => "o", "Ő" => "o", "ŏ" => "o", "Ŏ" => "o", "Ō" => "o", "ō" => "o", "ø" => "o", "ǿ" => "o", "ǒ" => "o", "ò" => "o", "Ǿ" => "o", "Ǒ" => "o", "ơ" => "o", "ó" => "o", "Ơ" => "o", "œ" => "oe", "Œ" => "oe", "ö" => "oe",
    "פ" => "p", "ף" => "p", "п" => "p", "П" => "p",
    "ק" => "q",
    "ŕ" => "r", "ř" => "r", "Ř" => "r", "ŗ" => "r", "Ŗ" => "r", "ר" => "r", "Ŕ" => "r", "Р" => "r", "р" => "r",
    "ș" => "s", "с" => "s", "Ŝ" => "s", "š" => "s", "ś" => "s", "ס" => "s", "ş" => "s", "С" => "s", "ŝ" => "s", "Щ" => "sch", "щ" => "sch", "ш" => "sh", "Ш" => "sh", "ß" => "ss",
    "т" => "t", "ט" => "t", "ŧ" => "t", "ת" => "t", "ť" => "t", "ţ" => "t", "Ţ" => "t", "Т" => "t", "ț" => "t", "Ŧ" => "t", "Ť" => "t", "™" => "tm",
    "ū" => "u", "у" => "u", "Ũ" => "u", "ũ" => "u", "Ư" => "u", "ư" => "u", "Ū" => "u", "Ǔ" => "u", "ų" => "u", "Ų" => "u", "ŭ" => "u", "Ŭ" => "u", "Ů" => "u", "ů" => "u", "ű" => "u", "Ű" => "u", "Ǖ" => "u", "ǔ" => "u", "Ǜ" => "u", "ù" => "u", "ú" => "u", "û" => "u", "У" => "u", "ǚ" => "u", "ǜ" => "u", "Ǚ" => "u", "Ǘ" => "u", "ǖ" => "u", "ǘ" => "u", "ü" => "ue",
    "в" => "v", "ו" => "v", "В" => "v",
    "ש" => "w", "ŵ" => "w", "Ŵ" => "w",
    "ы" => "y", "ŷ" => "y", "ý" => "y", "ÿ" => "y", "Ÿ" => "y", "Ŷ" => "y",
    "Ы" => "y", "ž" => "z", "З" => "z", "з" => "z", "ź" => "z", "ז" => "z", "ż" => "z", "ſ" => "z", "Ж" => "zh", "ж" => "zh"
  );
  return strtr($filename, $replace);
}

add_filter('sanitize_file_name', 'de_sanitize_filename_on_upload', 10, 2);

/**
 * Custom walker class.
 */
class db_Walker_Nav_Menu extends Walker_Nav_Menu
{

  /**
   * Starts the list before the elements are added.
   *
   * Adds classes to the unordered list sub-menus.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   */
  function start_lvl(&$output, $depth = 0, $args = array())
  {
    // Depth-dependent classes.
    $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
    $display_depth = ($depth + 1); // because it counts the first submenu as 0
    $classes = array(
      'ui-beacon-subs'
      /* ,( $display_depth % 2  ? 'menu-odd' : 'menu-even' ),
                  ( $display_depth >=2 ? 'sub-sub-menu' : '' ),
                  'menu-depth-' . $display_depth */
    );
    $class_names = implode(' ', $classes);

    // Build HTML for output.
    $output .= "\n" . $indent . '<ul class="' . $class_names . '">' . "\n";
  }

  /**
   * Start the element output.
   *
   * Adds main/sub-classes to the list items and links.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param object $item   Menu item data object.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   * @param int    $id     Current item ID.
   */
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
    global $wp_query;
    $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
    // Depth-dependent classes.
    $depth_classes = array(
      ($depth == 0 ? 'ui-beacon-item ui-beacon-drop' : 'ui-beacon-sub')
    );
    $depth_class_names = esc_attr(implode(' ', $depth_classes));

    // Passed classes.
    $classes = empty($item->classes) ? array() : (array) $item->classes;
    $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

    // Build HTML.
    $output .= $indent . '<li id="nav-menu-item-' . $item->ID . '" class="' . $depth_class_names . '">';

    // Link attributes.
    $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
    $attributes .= ' class=" ' . ($depth > 0 ? 'ui-beacon-sub-link' : 'ui-beacon-item-link') . '"';

    // Build HTML output and pass through the proper filter.
    $item_output = sprintf('%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s', $args->before, $attributes, $args->link_before, apply_filters('the_title', $item->title, $item->ID), (($item->hasChildren) ? $args->link_after : ''), $args->after);
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }

  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
  {
    // check, whether there are children for the given ID and append it to the element with a (new) ID
    $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]);

    return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }


  // overide image size of woocomerce
  private function add_image_sizes()
  {
    $shop_thumbnail = wc_get_image_size('shop_thumbnail');
    $shop_catalog   = wc_get_image_size('shop_catalog');
    $shop_single    = wc_get_image_size('shop_single');

    add_image_size('shop_thumbnail', $shop_thumbnail['width'], $shop_thumbnail['height'], false);
    add_image_size('shop_catalog', $shop_catalog['width'], $shop_catalog['height'], false);
    add_image_size('shop_single', $shop_single['width'], $shop_single['height'], false);
  }
}

add_filter('woocommerce_shortcode_products_query', 'removeAudioTags');
function removeAudioTags($args)
{

  $args['tax_query'] = array(array(

    'taxonomy' => 'product_custome_type',

    'field' => 'slug',

    'terms' => array('service'),

    'operator' => 'NOT IN'
  ));

  return $args;
}


/*===================================================================================================================================================================================================*/
/*========================== Duc - GENERAL ==========================*/
/**
 * Disable Gutenberg editor for Post/Pages
 *
 */
add_filter('use_block_editor_for_post', '__return_false', 10);
add_filter('use_block_editor_for_post_type', '__return_false', 10);


/*===================================================================================================================================================================================================*/
/*========================== Duc - HEADER ==========================*/
add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {

  if ($args->theme_location === 'main_menu_service') {
    $atts['data-filter'] = $item->classes[0];
  }

  return $atts;
}, 10, 3);


/**
 * Register new Feature Menu
 */
add_action('after_setup_theme', 'register_icon_menu_func');
function register_icon_menu_func()
{
  register_nav_menu('feature_menu', __('Feature Menu', 'dealexport'));
}


/**
 * Append the User navigation (My account, Logout) to the top menu
 * @require Top menu ID = 60
 */
//add_filter( 'wp_nav_menu_items', 'add_custom_menu_item_func', 10, 2 );
function add_custom_menu_item_func($items, $args)
{
  if ($args->theme_location == 'top_menu' && $args->menu->term_id == 60) {
    if (is_user_logged_in()) {
      $user = wp_get_current_user();
      $user_name = sprintf(__('Hello <strong>%1$s</strong>', 'woocommerce'), $user->display_name);
      $items .= '<li id="nav-menu-item-user" class="ui-beacon-item ui-beacon-drop"><svg class="user_icon" data-name="mk-moon-user-4" data-cacheid="icon-5bf7a9166cf66" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 64c52.935 0 96 43.065 96 96s-43.065 96-96 96-96-43.065-96-96 43.065-96 96-96m0-32c-70.692 0-128 57.308-128 128s57.308 128 128 128 128-57.308 128-128-57.308-128-128-128zm128 320c52.935 0 96 43.065 96 96h-448c0-52.935 43.065-96 96-96h256m0-32h-256c-70.692 0-128 57.309-128 128v32h512v-32c0-70.691-57.308-128-128-128z"></path></svg><a class="ui-beacon-item-link">' . $user_name . '</a><ul class="ui-beacon-subs">
    <li id="nav-menu-item-349" class="ui-beacon-sub"><a href="' . ThemedbUser::$data['current']['links']['profile']['url'] . '" class="user-link ui-beacon-sub-link">' . __('My Account', 'dealexport') . '</a><a href="' . wp_logout_url(SITE_URL) . '" class="user-link ui-beacon-sub-link">' . __('Sign Out', 'dealexport') . '</a></li>
</ul></li>';
    }
  } else if ($args->theme_location == 'feature_menu') {
    $items_array = array();
    while (false !== ($item_pos = strpos($items, '<li', 3))) {
      $items_array[] = substr($items, 0, $item_pos);
      $items = substr($items, $item_pos);
    }
    $items_array[] = $items;
    array_splice($items_array, 2, 0, '<li class="ui-beacon-item ui-beacon-drop"><a href="' . SITE_URL . '" rel="home"><img src="' . ThemedbCore::getOption("site_logo", THEME_URI . "images/logo.png") . '" alt=' . bloginfo("name") . '/></a></li>'); // insert custom item after 2nd one

    $items = implode('', $items_array);
  }
  return $items;
}




/**
 * Append the icons to each Menu item
 */
add_filter('wp_nav_menu_objects', 'add_icon_menu_objects_func', 10, 2);
function add_icon_menu_objects_func($items, $args)
{
  foreach ($items as &$item) {
    $svgImg = get_field('menu_icon', $item, 'option');

    if ($svgImg) {
      $item->title = '<span class="menu_icon">' . file_get_contents($svgImg) . '</span>' . $item->title;
    }
  }
  return $items;
}

// if (!function_exists('in_array')) {
//     function acf_get_field() {
//         if (!class_exists('ACF')) {

//         }
//     }
// }




/*========================== Duc - WooCommerce Customization ==========================*/
/**
 * Modify Loop Product Template
 */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
add_action('woocommerce_after_shop_loop_item_title', 'add_woocommerce_template_loop_price', 10);
if (!function_exists('add_woocommerce_template_loop_price')) {
  function add_woocommerce_template_loop_price()
  {
    global $product;
?>
    <?php
    $arv_price = get_post_meta($product->id, 'arv_price', true);
    if ($arv_price) : ?>
      <div class="item-category">
        <?php
        $recentCategory = get_category_by_level(get_the_id(), 0);
        echo $recentCategory->name;
        ?>
      </div>
      <div class="item-price">
        <div style="" class="main-price">
          <!-- TODO: need to translate Price -->
          <!-- <span class="price"> <?php //_e('Departing', 'dealexport'); 
                                    ?>: </span> -->
          <span class="amount"><?php echo wc_price($arv_price); ?></span>
        </div>


        <!-- TODO: Enable if necessary -->
        <?php //if ($ship_price_html) { 
        ?>
        <!--  <div style="" class="ship-price"> -->
        <!-- <span class="price"><?php //__('Ship price', 'dealexport') 
                                  ?>: </span> -->
        <!-- <span class="amount"><?php //echo $price_html; 
                                  ?></span> -->
        <!-- </div>   -->
        <?php //} 
        ?>


      </div>
    <?php endif; ?>
  <?php
  }
}

/**
 * Get The most recent category name
 */
function get_category_by_level($product_id, $level)
{
  // get all product cats for the current post
  $categories = get_the_terms($product_id, 'product_cat');

  // wrapper to hide any errors from top level categories or products without category
  if ($categories && !is_wp_error($category)) :

    // loop through each cat
    foreach ($categories as $category) :
      // get the children (if any) of the current cat
      $children = get_categories(array('taxonomy' => 'product_cat', 'parent' => $category->term_id));

      if (count($children) == $level) {
        // if no children, then echo the category name.
        $lastCategory = $category;
      }
    endforeach;

  endif;

  return $lastCategory;
}

/**
 * Render the Slider
 */
function render_ecommerce_slider($attr)
{
  ob_start();
  get_template_part('module', 'slider');
  return ob_get_clean();
}
add_shortcode('ecommerce_slider', 'render_ecommerce_slider');


/**
 * will be eventually removed
 */
function custom_dump($anything)
{
  add_action('shutdown', function () use ($anything) {
    echo "<div style='position: fixed; z-index: 100; left: 30px; top: 100px; right: 30px; background-color: #150202; color: #13f5e8;'>";
    var_dump($anything);
    echo "</div>";
  });
}

/**
 * Modify Loop Query
 * Excluded Exporter's products/services from Archive pages
 */
function modify_loop_query($query)
{

  if (!$query->is_main_query()) {
    return;
  }

  // Excluded Exporter's products/services 
  $excluded_exporter_terms = array('product-for-exporter', 'service-for-exporter');

  // Check for single page, like a Post or Attachment page 
  if ($query->is_singular) {
    return;
  }

  // If we are not on the Category Archive we don't want to exclude the posts
  // if ( ! is_category() ) {
  //     return;
  // }

  $current_object = get_queried_object();
  if ($current_object->taxonomy === 'product_cat' || $current_object->taxonomy === 'product_custome_type') {
    if (!in_array($current_object->slug, $excluded_exporter_terms)) {
      $tax_query = array('relation' => 'AND');
      foreach ($excluded_exporter_terms as $term) {
        $tax_query[] =  array(
          'taxonomy' => 'product_custome_type',
          'field' => 'slug',
          'terms' => $term,
          'operator' => 'NOT IN'
        );
      }
    }
  } else {
    return;
  }

  $query->set('tax_query', $tax_query);
  return $query;
}
//add_action( 'pre_get_posts', 'modify_loop_query' ); // Mark: temporarily disable


function filter_exporter($query)
{
  $current_object = get_queried_object();

  $filter_taxonomies =  array('level_of_expertise', 'international_development_stage', 'type_of_industry');
  $tax_query = array('relation' => 'AND');


  if ($current_object->post_name === 'service') {
    $require_terms = array('product-for-exporter', 'service-for-exporter');

    $require_tax_query = array('relation' => 'OR');

    foreach ($require_terms as $term) {
      $require_tax_query[] =  array(
        'taxonomy' => 'product_custome_type',
        'field' => 'slug',
        'terms' => $term
      );
    }

    $tax_query[] =  $require_tax_query;

    foreach ($filter_taxonomies as $taxonomy) {
      if (isset($_GET[$taxonomy])) {
        $term = $_GET[$taxonomy];
        $tax_query[] =  array(
          'taxonomy' => $taxonomy,
          'field' => 'slug',
          'terms' => $term
        );
      }
    }
  }

  $query->set('tax_query', $tax_query);
  return $query;
}
// add_filter('pre_get_posts', 'filter_exporter'); // Mark: this filter causes page "service" unable to display the menu items since each menu item is treated like a post. Therefore I temporarily disable it. :)




//Not all the taxonomies have been registered when an ajax call was made so we need to launch the ajax after the initialization 
add_action('init', function () {
  //add the ajax hook only when all the taxonomies have been registered
  add_action('wp_ajax_filter_action', 'filter_action');
  add_action('wp_ajax_nopriv_filter_action', 'filter_action');
}, 99);



function ajax_scripts()
{
  $ajaxurl = admin_url('admin-ajax.php');
  wp_localize_script('general', 'filter_ajax', array('ajax_url' => $ajaxurl));
}
add_action('wp_enqueue_scripts', 'ajax_scripts', 99);


function filter_action()
{
  if (isset($_POST["filter_data"]) && !empty($_POST["filter_data"])) {
    $filter_data = json_decode(stripslashes($_POST["filter_data"]));

    $result_array = amagumo_query_filter($filter_data);
    if (count($result_array) > 0) {
      foreach ($result_array as $result) {
        $post = get_post($result);
        $post_title = $post->post_title;
        $shop = ThemedbUser::getShop($post->post_author);
        if (!empty($shop)) {
          $post_author = get_the_title($shop);
          $post_author_url = get_permalink($shop);
        }
        $thumbnail_url = generateCustomImageThumbnailWithouHTML(wp_get_attachment_url(get_post_thumbnail_id($result)), 300, 300);
        $recentCategory = get_category_by_level($result, 0);
        //echo $recentCategory->name;

        // processed qtranstranlate string
        $post_title = __($post_title);

        $response[] = (object) array('title' => $post_title, 'ID' => $result, 'author' => $post_author,  'author_url' => $post_author_url, 'category' => $recentCategory->name, 'thumbnail' => $thumbnail_url, 'post_url' => get_permalink($result));
        //print_r($response);

        //echo json_encode($response);
        //echo 'ID '. $result .' ; ' . 'Name ' . $post_title . ' ; ' . 'Author ' . $post_author .' ; ' . 'Category ' . $recentCategory->name .' ; ' . 'Url '. get_permalink( $result );

        //echo $result . ' - ' . get_post($result) -> post_name . 'img: ' . get_the_post_thumbnail_url($result) . ',    ';
      }
    } else {
      // echo 'Filter result: No Record found!';
    }

    echo json_encode($response);

    // TODO: đứa kết quả vào một array để trả về dạng JSON: ID, post_name, post_title
    $a = 1; // for debug purpose only: đặt breakpoint tại dòng này để xem kết quả trong $result_array, xóa khi debug xong

  }
  die();
}


/**
 * Add WooCommerce Taxonomy for Custom Post Type
 * @author Amagumo Labs
 */
add_action('init', 'add_product_cat_to_custom_post_type', 11);
function add_product_cat_to_custom_post_type()
{
  register_taxonomy_for_object_type('product_cat', 'shop');
}


function generateCustomImageThumbnailWithouHTML($url, $width = 300, $heigth = 300,  $type = 2, $default_img = 'images/product.png')
{
  if ($url != false  && checkUrlExits($url)) {
    $image_resize_link = resize_image($url, $width, $heigth, $type);
    if ($image_resize_link == NULL) {
      $pathinfo = pathinfo($url);
      $image_resize_link = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-dex_resize' . '-' . $width . '-' . $heigth . '.' . $pathinfo['extension'];
    }
    return $image_resize_link;
  }
  return THEME_URI . $default_img;
}


/**
 * To create an options page
 */
if (function_exists('acf_add_options_page')) {
  acf_add_options_page();
}






/*========================== WooCommerce Customizations ==========================*/
/**
 * Return an array of ID(s) of posts which satisfy multiple slug; Operator: OR if the slugs share the same taxonomy, AND if the slugs share different taxonomies
 * @param $master_array array consists multiple $sub_array, each $sub_array consists of multiple slugs sharing the same taxonomy
 * @author Amagumo Labs
 * @return array|bool|object|null
 */
function amagumo_query_filter($master_array)
{
  global $wpdb;
  $count = ""; // add COUNT section to SQL script
  $having = ""; // add HAVING section to SQL script
  if ($master_array != null) {
    foreach ($master_array as $master_key => $sub_array) { // duyệt qua tất cả các slug của param truyền vào hàm
      reset($master_array); // trả pointer của $master_array về vị trí đầu tiên để check xem phần tử đang duyệt có phải là phần tử đầu tiên không
      if ($sub_array != NULL) {
        foreach ($sub_array as $sub_key => $slug) {
          reset($sub_array); // trả pointer của $sub_array về vị trí đầu tiên để check xem phần tử đang duyệt có phải là phần tử đầu tiên không
          $count = $count . ", COUNT( CASE WHEN db_term_relationships.term_taxonomy_id = ( SELECT db_terms.term_id FROM db_terms WHERE slug = '" . $slug . "' ) THEN 1 ELSE NULL END ) AS count" . str_replace('-', '', $slug); // thực hiện COUNT các record có slug là $slug, record nào thỏa thì tạo COLUMN mới tên "count[slug]" và đánh dấu bằng giá trị 1, không thỏa trả về NULL
          if ($sub_key === key($sub_array)) {
            if ($master_key === key($master_array)) {
              $having = $having . "HAVING ( count" . str_replace('-', '', $slug) . " >= 1 "; // nếu duyệt qua slug đầu tiên trong mảng $sub_array VÀ mảng $sub_array này cũng là mảng đầu tiên của $master_array thì thêm đoạn "HAVING ( count" cho slug đầu tiên
            } else {
              $having = $having . "AND ( count" . str_replace('-', '', $slug) . " >= 1 "; // nếu duyệt qua slug đầu tiên trong mảng $sub_array NHƯNG mảng này ko phải là mảng đầu tiên trong $master_array thì là đang duyệt tới một taxonomy mới, truyền vào "AND ( count" cho slug đầu tiên của taxonomy hiện tại
            }
          } else {
            $having = $having .  "OR count" . str_replace('-', '', $slug) . " >= 1 "; // nếu slug đang duyệt không phải slug đầu tiên của cả $sub_array và $master_array thì là đang duyệt tới một slug thứ 2 trở đi của một nhóm taxonomy, truyền vào "OR ( count" cho slug này của taxonomy hiện tại
          }
          end($sub_array); // đưa pointer về vị trí cuối cùng
          if ($sub_key === key($sub_array)) {
            $having = $having . " ) "; // kiểm tra xem slug đang duyệt có phải là slug cuối cùng của $sub_array không, nếu có thì thêm dấu đóng ngoặc " ) " trong câu query sql
          }
        }
      }
      end($master_array); // đưa pointer về vị trí cuối cùng của $master_array
      //			if ( $master_key === key($master_array) ) {
      //			    echo 'Làm gì khi duyệt tới hết?';
      //			}
    }
  } else {
    return false;
  }
  $sql = "SELECT filter_result.object_id FROM (SELECT db_term_relationships.object_id" . $count . " FROM db_term_relationships GROUP BY db_term_relationships.object_id " . $having . ") filter_result;"; // nên debug để xem giá trị của biến $sql sau khi thực hiện xong hàm để dễ hiểu hơn :'(
  $temp_array = $wpdb->get_results($sql); // // use $temp_array to handle some stdClass obj

  $result_array = array();
  foreach ($temp_array as $temp_item) {
    array_push($result_array, $temp_item->object_id);
  }
  return $result_array; // return an array which consists of id(s)
}


/**
 * Add additional param to shortcode "products" of WooCommerce plugin to filter product with taxonomy 'product_custome_type' (declared in 'functions.php')
 * USAGE: when a shortcode 'products' is added to a certain page, for example, if it is required to filter only products which are either 'product-for-buyer' OR 'service-for-buyer', please add this shortcode accompanied with the param like [products class="product_custome_type,product-for-buyer,service-for-buyer"] to enable the filter
 * @param $query_args
 * @param $atts
 * @param $loop_name
 * @author Amagumo Labs
 * @return mixed
 */
function amagumo_extend_products_shortcode_to_product_custome_type($query_args, $atts, $loop_name)
{
  if (!empty($atts['class']) && strpos($atts['class'], 'product_custome_type') !== false) {
    global $wpdb;

    $terms = array_map('sanitize_title', explode(',', $atts['class'])); //
    array_shift($terms); //
    $terms = implode(',', $terms); //
    $terms = str_replace(",", "','", $terms); //

    $ids = $wpdb->get_col("
                                        SELECT DISTINCT
                                          tr.object_id
                                        FROM
                                          {$wpdb->prefix}term_relationships as tr
                                        INNER JOIN {$wpdb->prefix}term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                                        INNER JOIN {$wpdb->prefix}terms as t ON tt.term_id = t.term_id
                                        WHERE tt.taxonomy LIKE 'product_custome_type' AND t.slug IN ('$terms')
                                      ");

    if (!empty($ids)) { //
      if (1 === count($ids)) {
        $query_args['p'] = $ids[0];
      } else {
        $query_args['post__in'] = $ids;
      }
    }
  }
  return $query_args;
}
add_filter('woocommerce_shortcode_products_query', 'amagumo_extend_products_shortcode_to_product_custome_type', 10, 3);


/**
 * Count the number of slug which is either 'product-for-exporter' or 'service-for-exporter'
 * @param $slug
 * @return mixed
 * @author Amagumo Labs
 */
function amagumo_count_posts_for_exporter_by_slug($slug)
{
  global $wpdb;
  $sql = "SELECT
                count( filter_result.object_id ) AS result
            FROM
                
                    (
                    SELECT
                        db_term_relationships.object_id,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = '$slug' ) THEN 1 ELSE NULL END ) AS count,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = 'product-for-exporter' ) THEN 1 ELSE NULL END ) AS countpfe,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = 'service-for-exporter' ) THEN 1 ELSE NULL END ) AS countsfe 
                    FROM
                        {$wpdb->prefix}term_relationships 
                    GROUP BY
                        {$wpdb->prefix}term_relationships.object_id 
                    HAVING
                        count >= 1 
                        AND ( countpfe >= 1 OR countsfe >= 1 ) 
                    ) filter_result 
                ";
  $temp_array = $wpdb->get_results($sql); //
  $result_array = array();
  foreach ($temp_array as $temp_item) {
    array_push($result_array, $temp_item->result);
  }
  return $result_array[0];
}

/**
 * Count the number of slug which is either 'product-for-buyer' or 'service-for-buyer'
 * @param $slug
 * @return mixed
 * @author Amagumo Labs
 */
function amagumo_count_posts_for_buyer_by_slug($slug)
{
  global $wpdb;
  $sql = "SELECT
                count( filter_result.object_id ) AS result
            FROM
                
                    (
                    SELECT
                        db_term_relationships.object_id,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = '$slug' ) THEN 1 ELSE NULL END ) AS count,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = 'product-for-buyer' ) THEN 1 ELSE NULL END ) AS countpfb,
                        count( CASE WHEN {$wpdb->prefix}term_relationships.term_taxonomy_id = ( SELECT {$wpdb->prefix}terms.term_id FROM {$wpdb->prefix}terms WHERE {$wpdb->prefix}terms.slug = 'service-for-buyer' ) THEN 1 ELSE NULL END ) AS countsfb 
                    FROM
                        {$wpdb->prefix}term_relationships 
                    GROUP BY
                        {$wpdb->prefix}term_relationships.object_id 
                    HAVING
                        count >= 1 
                        AND ( countpfb >= 1 OR countsfb >= 1 ) 
                    ) filter_result 
                ";
  $temp_array = $wpdb->get_results($sql); //
  $result_array = array();
  foreach ($temp_array as $temp_item) {
    array_push($result_array, $temp_item->result);
  }
  return $result_array[0];
}


/**
 * Display the red badge 'DEAL' on products which has attribute 'deal' (slug == 'pa_deal')
 */
function amagumo_display_the_badges_for_deals()
{
  global $product;
  if (($product->get_attributes())['pa_deal']['options'][0] == 145) { // TODO: review code. This does not make sense
    echo '<div class="deal-badge-background"></div>';
    echo '<div class="deal-badge-text">DEAL</div>';
    //		echo $product -> post -> post_excerpt;
  }
}
add_action('woocommerce_before_shop_loop_item_title', 'amagumo_display_the_badges_for_deals', 10);


/*========================== Back Office Utilities ==========================*/
/**
 * Add filter by custom taxonomy 'product_custome_type'
 * @param $output
 * @return string
 * @author Amagumo Labs
 */
function amagumo_filter_by_custom_taxonomy_product_custome_type_dashboard_products($output)
{
  global $wp_query;

  $output .= wc_product_dropdown_categories(array(
    'show_option_none' => 'Filter by product_custome_type',
    'taxonomy' => 'product_custome_type',
    'name' => 'product_custome_type',
    'selected' => isset($wp_query->query_vars['product_custome_type']) ? $wp_query->query_vars['product_custome_type'] : '',
  ));

  return $output;
}
add_filter('woocommerce_product_filters', 'amagumo_filter_by_custom_taxonomy_product_custome_type_dashboard_products');


/**
 * Add filter by custom taxonomy 'level_of_development'
 * @param $output
 * @return string
 * @author Amagumo Labs
 */
function amagumo_filter_by_custom_taxonomy_level_of_development_dashboard_products($output)
{
  global $wp_query;

  $output .= wc_product_dropdown_categories(array(
    'show_option_none' => 'Filter by level_of_development',
    'taxonomy' => 'level_of_development',
    'name' => 'level_of_development',
    'selected' => isset($wp_query->query_vars['level_of_development']) ? $wp_query->query_vars['level_of_development'] : '',
  ));

  return $output;
}
add_filter('woocommerce_product_filters', 'amagumo_filter_by_custom_taxonomy_level_of_development_dashboard_products');

/**
 * Add filter by custom taxonomy 'type_of_industry'
 * @param $output
 * @return string
 * @author Amagumo Labs
 */
function amagumo_filter_by_custom_taxonomy_type_of_industry_dashboard_products($output)
{
  global $wp_query;

  $output .= wc_product_dropdown_categories(array(
    'show_option_none' => 'Filter by type_of_industry',
    'taxonomy' => 'type_of_industry',
    'name' => 'type_of_industry',
    'selected' => isset($wp_query->query_vars['type_of_industry']) ? $wp_query->query_vars['type_of_industry'] : '',
  ));

  return $output;
}
add_filter('woocommerce_product_filters', 'amagumo_filter_by_custom_taxonomy_type_of_industry_dashboard_products');

/**
 * Add filter by custom taxonomy 'level_of_expertise'
 * @param $output
 * @return string
 * @author Amagumo Labs
 */
function amagumo_filter_by_custom_taxonomy_level_of_expertise_dashboard_products($output)
{
  global $wp_query;

  $output .= wc_product_dropdown_categories(array(
    'show_option_none' => 'Filter by level_of_expertise',
    'taxonomy' => 'level_of_expertise',
    'name' => 'level_of_expertise',
    'selected' => isset($wp_query->query_vars['level_of_expertise']) ? $wp_query->query_vars['level_of_expertise'] : '',
  ));

  return $output;
}
add_filter('woocommerce_product_filters', 'amagumo_filter_by_custom_taxonomy_level_of_expertise_dashboard_products');

/*========================== Menus ==========================*/
function register_my_menu()
{
  register_nav_menu('main_menu_service', __('Main Menu of Service Page'));
}
add_action('init', 'register_my_menu');

function get_last_word($string)
{
  $last_word_start = strrpos($string, '/') + 1; // +1 so we don't include the space in our result
  $last_word = substr($string, $last_word_start);
  return $last_word;
}

function trim_last_slash($string)
{
  return rtrim($string, "/");
}


/**
 * Create custom breadcrumbs
 * @author: www.thewebtaylor.com
 */
function custom_breadcrumbs()
{

  // Settings
  $separator          = '&gt;';
  $breadcrums_id      = 'breadcrumbs';
  $breadcrums_class   = 'breadcrumbs';
  $home_title         = 'Home';

  // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
  $custom_taxonomy    = 'product_cat';

  // Get the query & post information
  global $post, $wp_query;

  // Do not display on the homepage
  if (!is_front_page()) {

    // Build the breadcrums
    echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

    // Home page
    echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
    echo '<li class="separator separator-home"> ' . $separator . ' </li>';

    if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

      echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';
    } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if ($post_type != 'post') {

        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        //                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>'; // Mark: turn off the "Products" label
        //                echo '<li class="separator"> ' . $separator . ' </li>'; // Mark: turn off the "Products" label

      }

      $custom_tax_name = get_queried_object()->name;
      echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';
    } else if (is_single()) {

      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if ($post_type != 'post') {

        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
        echo '<li class="separator"> ' . $separator . ' </li>';
      }

      // Get post category info
      $category = get_the_category();

      if (!empty($category)) {

        // Get last category post is in
        $last_category = end(array_values($category));

        // Get parent any categories and create array
        $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','), ',');
        $cat_parents = explode(',', $get_cat_parents);

        // Loop through parent categories and store in variable $cat_display
        $cat_display = '';
        foreach ($cat_parents as $parents) {
          $cat_display .= '<li class="item-cat">' . $parents . '</li>';
          $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
        }
      }

      // If it's a custom post type within a custom taxonomy
      $taxonomy_exists = taxonomy_exists($custom_taxonomy);
      if (empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

        $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
        $cat_id         = $taxonomy_terms[0]->term_id;
        $cat_nicename   = $taxonomy_terms[0]->slug;
        $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
        $cat_name       = $taxonomy_terms[0]->name;
      }

      // Check if the post is in a category
      if (!empty($last_category)) {
        echo $cat_display;
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

        // Else if post is in a custom taxonomy
      } else if (!empty($cat_id)) {

        echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
        echo '<li class="separator"> ' . $separator . ' </li>';
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
      } else {

        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
      }
    } else if (is_category()) {

      // Category page
      echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
    } else if (is_page()) {

      // Standard page
      if ($post->post_parent) {

        // If child page, get parents
        $anc = get_post_ancestors($post->ID);

        // Get parents in the right order
        $anc = array_reverse($anc);

        // Parent page loop
        if (!isset($parents)) $parents = null;
        foreach ($anc as $ancestor) {
          $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
          $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
        }

        // Display parent pages
        echo $parents;

        // Current page
        echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
      } else {

        // Just display current page if not parents
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
      }
    } else if (is_tag()) {

      // Tag page

      // Get tag information
      $term_id        = get_query_var('tag_id');
      $taxonomy       = 'post_tag';
      $args           = 'include=' . $term_id;
      $terms          = get_terms($taxonomy, $args);
      $get_term_id    = $terms[0]->term_id;
      $get_term_slug  = $terms[0]->slug;
      $get_term_name  = $terms[0]->name;

      // Display the tag name
      echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
    } elseif (is_day()) {

      // Day archive

      // Year link
      echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
      echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

      // Month link
      echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
      echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

      // Day display
      echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
    } else if (is_month()) {

      // Month Archive

      // Year link
      echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link(get_the_time('Y')) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
      echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

      // Month display
      echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
    } else if (is_year()) {

      // Display year archive
      echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
    } else if (is_author()) {

      // Auhor archive

      // Get the author information
      global $author;
      $userdata = get_userdata($author);

      // Display author name
      echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
    } else if (get_query_var('paged')) {

      // Paginated archives
      echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">' . __('Page') . ' ' . get_query_var('paged') . '</strong></li>';
    } else if (is_search()) {

      // Search results page
      echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
    } elseif (is_404()) {

      // 404 page
      echo '<li>' . 'Error 404' . '</li>';
    }

    echo '</ul>';
  }
}
add_action('woocommerce_before_single_product', 'custom_breadcrumbs', 10);











/**
 * HELPER - wp_footer HOOK 
 */
add_action('wp_footer', function () {
});

function get_current_year()
{
  return date("Y");
}
add_shortcode('get_current_year', 'get_current_year');


include(get_template_directory() . '/dealexport-child-functions.php');

/**
 * CUSTOM EMPTY CART MESSAGE
 */

remove_action('woocommerce_cart_is_empty', 'wc_empty_cart_message', 10);
add_action('woocommerce_cart_is_empty', 'custom_empty_cart_message', 10);

function custom_empty_cart_message()
{
  $html  = '<p class="cart-empty mt-3">';
  $html .= wp_kses_post(apply_filters('wc_empty_cart_message', __('Your cart is currently empty.', 'woocommerce')));
  echo $html . '</p>';
}

// if ( function_exists( 'add_image_size' ) ) {
// 	add_image_size( 'custom-thumb', 100, 100 ); // 100 wide and 100 high
// }

add_action('woocommerce_recalculate_item_sub_total', 'woocommerce_recalculate_item_sub_total', 100);
function woocommerce_recalculate_item_sub_total()
{
  ?>
  <script>
    jQuery(function($) {
      var selector = '.cart-page-table-item-qty input.qty';
      $(selector).change(function() {
        var cart_item_key = $(this).attr("id");
        var qty = this.value;

        $.ajax({
          type: 'POST',
          dataType: 'json',
          url: '<?php echo admin_url('admin-ajax.php'); ?>',
          data: {
            action: 'update_item_from_cart',
            'cart_item_key': cart_item_key,
            'qty': qty,
          },
          success: function(data) {

            if (!data || data.error)
              return;

            var fragments = data.fragments;

            var totalItems = 0;
            var subtotal = 0;

            for (var item in data.cart) {
              totalItems += item.quantity;
              subtotal += item.line_total * item.quantity;
            }

            // Replace fragments
            if (fragments) {
              $.each(fragments, function(key, value) {
                $(key).replaceWith(value);
              });
            }
          }
        });
      })
    });
  </script>
<?php
}

function update_item_from_cart()
{
  $cart_item_key = $_POST['cart_item_key'];
  $quantity = $_POST['qty'];

  WC()->session->set('custom_discount', null);

  // Get mini cart
  ob_start();

  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    if ($cart_item_key == $_POST['cart_item_key']) {
      WC()->cart->set_quantity($cart_item_key, $quantity, $refresh_totals = true);
    }
  }

  WC()->cart->calculate_totals();
  WC()->cart->maybe_set_cart_cookies();

  woocommerce_mini_cart();
  $mini_cart = ob_get_clean();
  ob_end_clean();

  ob_start();
  wc_get_template('cart/cart.php');
  $cart_page_template = ob_get_clean();

  // Fragments and mini cart are returned
  $product = WC()->cart->get_cart_item($cart_item_key);
  $data = array(
    'fragments' => apply_filters('woocommerce_add_to_cart_fragments', array(
      'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
      'div.woo-cart-container' =>  $cart_page_template
    )),
    'cart_hash' => apply_filters('woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5(json_encode(WC()->cart->get_cart_for_session())) : '', WC()->cart->get_cart_for_session())
  );

  wp_send_json($data);

  die();
}

add_action('wp_ajax_update_item_from_cart', 'update_item_from_cart');
add_action('wp_ajax_nopriv_update_item_from_cart', 'update_item_from_cart');


function cart_item_price_filter($price)
{
  echo get_woocommerce_currency_symbol();
  printf("<span class='cart-item-price'>%s</span>", number_format($price, 2));
}

add_filter('woocommerce_cart_item_price_filter', 'cart_item_price_filter');


add_filter('woocommerce_get_shipping_fee', 'get_shipping_fee');
function get_shipping_fee($isNumber)
{

  $fee = 0;
  $shipingMethod = WC()->session->get('chosen_shipping_methods')[0];

  // if ($total >  250) {
  //   $isPickup = strpos($shipingMethod, 'local_pickup') !== false;
  //   if (!$isPickup) {
  //     do_action('woocommerce_remove_applied_discount_if_free_shipping');
  //     WC()->session->set('chosen_shipping_methods', array('free_shipping:6'));
  //   }
  // }

  WC()->cart->calculate_fees();
  WC()->cart->calculate_totals();

  foreach (WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate) {
    if ($method_id == WC()->session->get('chosen_shipping_methods')[0]) {
      $fee = $rate->cost;
      break;
    }
  }
  //  Click and collect
  $isPickup = strpos($shipingMethod, 'local_pickup') !== false;

  return  $isNumber ? $fee : ($fee != 0 ? wc_price($fee) : ($isPickup ? 'Click & Collect' : 'Gratuit'));
}

// Reset Shipping method to flat rate
add_action('woocommerce_reset_discount', 'reset_shipping_method');
add_action('xoo_wsc_before_footer_btns', 'reset_shipping_method');
add_action('woocommerce_before_cart_table', 'reset_shipping_method');

function reset_shipping_method()
{
  $shipingMethod = WC()->session->get('chosen_shipping_methods')[0];
  if (count(WC()->cart->get_applied_coupons()) == 0) {
    $packages = WC()->shipping()->get_packages();
    foreach ($packages[0]['rates'] as $key => $package) {
      if ($package->method_id === 'local_pickup' && strpos($shipingMethod, 'free_shipping') === false && strpos($shipingMethod, 'flat_rate') === false) {
        WC()->session->set('chosen_shipping_methods', array($key));
        break;
      }
    }
  }
  WC()->cart->calculate_fees();
  WC()->cart->calculate_totals();
}

// add_action('woocommerce_remove_applied_discount_if_free_shipping', 'remove_applied_discount_if_free_shipping');
// function remove_applied_discount_if_free_shipping()
// {
//   $method = WC()->session->get('chosen_shipping_methods')[0];
//   if ($method !== 'free_shipping:6') {
//     WC()->cart->remove_coupons();
//   }
// }

/** DISCOUNT **/

add_action('woocommerce_before_cart_totals', 'display_coupon_field');
function display_coupon_field()
{
  if (isset($_POST['remove_coupon'])) {
    if ($coupon = esc_attr($_POST['remove_coupon'])) {
      $c = new WC_Coupon($coupon);
      WC()->cart->remove_coupon($coupon);
      if ($c->enable_free_shipping()) {
        do_action('woocommerce_reset_discount');
      }
    }
    return;
  }
  if (isset($_POST['coupon'])) {
    if ($coupon = esc_attr($_POST['coupon'])) {
      WC()->cart->apply_coupon($coupon);
    }
  }
}

add_filter('woocommerce_display_coupon_applied_result', 'display_coupon_applied_result');
function display_coupon_applied_result()
{
  if (isset($_POST['remove_coupon'])) {
    return;
  }
  if (isset($_POST['coupon'])) {
    if ($coupon = esc_attr($_POST['coupon'])) {
      $applied = WC()->cart->has_discount($coupon);
    } else {
      $coupon = false;
    }

    $success = '';
    $error   = __("This Coupon can't be applied", 'dealexport');

    $message = isset($applied) && $applied ? $success : $error;
  }
  $output = $message ? '<p class="applied-error-result">' . $message . '</p>' : '';
  return $output;
}

// Huy remove action to change position of payment
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_checkout_order_review_payment', 'woocommerce_checkout_payment', 20);

// Use arv_price to calculate
add_action('woocommerce_before_calculate_totals', 'add_custom_price');
function add_custom_price()
{
  foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
    $arv_price = get_post_meta($cart_item['product_id'], 'arv_price', true) ?:  $cart_item['data']->price;
    $cart_item['data']->set_price($arv_price);
  }
}

add_filter('woocommerce_update_order_review_fragments', 'update_cart_checkout_total');
function update_cart_checkout_total($fragments)
{
  WC()->cart->calculate_totals();
  ob_start();
  wc_get_template('checkout/review-order.php');
  $container = ob_get_clean();
  $fragments['div.cart_totals'] = $container;
  return $fragments;
}

/**
 * Redirect non-admin users to home page
 */
add_action('admin_init', 'redirect_non_admin_users');
function redirect_non_admin_users()
{
  if (!current_user_can('manage_options') && ('/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'])) {
    wp_redirect(home_url());
    exit;
  }
}

// Change order form 

add_filter('woocommerce_checkout_fields', 'move_country_position');
function move_country_position($checkout_fields)
{
  $checkout_fields['billing']['billing_country']['priority'] = 71;
  return $checkout_fields;
}

add_filter('woocommerce_checkout_shipping_method_config', 'checkout_shipping_method_config');
function checkout_shipping_method_config()
{
  $method_config = array(
    'free_shipping' => array(
      'icon' => 'fa-truck',
      'name' => ' LIVRAISON À DOMICILE',
      'des' => '2-5 jours ouvrés',
      'is_free' => 'Gratuit',
    ),
    'flat_rate' => array(
      'icon' => 'fa-truck',
      'name' => ' LIVRAISON À DOMICILE',
      'des' => 'Les livraisons seront effectuées le 4 décembre 2020. Le montant de la livraison sera reversé au CHU de Lille',
      'is_free' =>  'Gratuit',
    ),
    'local_pickup' => array(
      'icon' => 'fa-shopping-cart',
      'name' => 'Point de vente',
      'des' => '<div>Weréso Lille</div><div>104 rue Nationale, 59800 Lille</div><div>Lundi au vendredi de 9h à 18h</div>',
      'is_free' => 'Click & Collect',
    )
  );
  return $method_config;
}

/** "New user" email  instead of admin. */
// add_filter( 'wp_new_user_notification_email_admin', 'my_wp_new_user_notification_email_admin', 10, 3 );
// function my_wp_new_user_notification_email_admin( $notification, $user, $blogname ) {
//   $notification['to'] = 'contact@dealexport.com';
//   return $notification;
// }

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar()
{
  // show admin bar only for admins
  // if (!current_user_can('manage_options')) {
  //   add_filter('show_admin_bar', '__return_false');
  // }
  // // show admin bar only for admins and editors
  // if (!current_user_can('edit_posts')) {
  //   add_filter('show_admin_bar', '__return_false');
  // }

  if (!current_user_can('administrator') && !is_admin()) {
    add_filter('show_admin_bar', '__return_false');
  }
}

add_filter( 'send_password_change_email', '__return_false' );
add_action('after_password_reset', 'send_notification_password_changed_to_user');
function send_notification_password_changed_to_user($user) {
  if ( 0 !== strcasecmp( $user->user_email, get_option( 'admin_email' ) ) ) {
    $subject=__('DealExport | Mot de passe changé', 'dealexport');
    $content_user_mail = "<p>Bonjour ".$user->first_name." ".$user->last_name.",</p>
    <p>Votre mot de passe a été modifié.</p>
    <p>Merci.</p>
    <p>L'équipe DealExport</p>";
    themedb_mail($user->user_email, $subject, $content_user_mail);
  }
}

/**
 * Output Facebook Open Graph meta.
 */
if ( ! function_exists( 'mk_open_graph_meta' ) ) {
	function mk_open_graph_meta() {

		$output = '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '"/>';
		$output .= '<meta property="og:url" content="' . esc_url( get_permalink() ) . '"/>';

		$output .= '<meta property="og:description" content="' . esc_attr( get_the_excerpt() ) . '"/>';
    $output .= '<meta property="og:type" content="article"/>';
    $output .= '<meta property="og:image" content="' . esc_url("https://champagne.dealexport.fr/wp-content/uploads/2020/09/dealexport_logo_light.png" ) . '"/>';
    $output .= '<link rel="shortcut icon" type="image/png" href="https://champagne.dealexport.fr/wp-content/uploads/2015/12/cropped-logo.png">';
    echo $output;
	}
	add_action( 'wp_head', 'mk_open_graph_meta' );
}
