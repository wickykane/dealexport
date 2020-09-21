<?php
/*
  Template Name: Service
 */

if (!defined('ABSPATH')) {
    exit;
}

global $woocommerce_loop, $layout;

$view = ThemedbCore::getOption('products_view', 'grid');
if (!isset($layout)) {
    $layout = ThemedbCore::getOption('products_layout', 'right');
}

$woocommerce_loop['view'] = themedb_value('view', $_GET, $view);
$woocommerce_loop['columns'] = 4;
if ($layout != 'full') {
    $woocommerce_loop['columns'] = 3;
}

get_header('shop');
if ($layout == 'left') {
    ?>
    <aside class="column threecol">
        <?php ThemedbSidebar::renderSidebar('products', true); ?>
        <?php include_once 'service-filter.php'; ?>
    </aside>
    <div class="column ninecol last">
    <?php } else if ($layout == 'right') { ?>
        <div class="column eightcol">
        <?php } else { ?>
            <div class="fullcol">
            <?php } ?>
            <?php do_action('woocommerce_before_main_content'); ?>
            <?php do_action('woocommerce_archive_description'); ?>
            <?php
            if (((isset($_GET['country-filter']) && $_GET['country-filter'] != NULL) || (isset($_GET['region-filter']) && $_GET['region-filter'] != NULL)) && !isset($_GET['product-cat'])) {
                if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL && (!isset($_GET['region-filter']) || $_GET['region-filter'] == NULL)) {
                    $term_filter = $_GET['country-filter'];
                } else {
                    $term_filter = $_GET['region-filter'];
                }
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_country_region',
                        'field' => 'id',
                        'terms' => $term_filter,
                    ),
                    array(
                        'taxonomy' => 'product_custome_type',
                        'field' => 'slug',
                        'terms' => 'service-for-exporter',
                        'operator' => 'IN'
                    ),
                );
            } elseif ((!isset($_GET['country-filter']) || $_GET['country-filter'] == NULL) && (isset($_GET['product-cat']) && $_GET['product-cat'] != NULL)) {
                $term_filter = $_GET['product-cat'];
                $tax_query = array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $term_filter,
                    ),
                    array(
                        'taxonomy' => 'product_custome_type',
                        'field' => 'slug',
                        'terms' => 'service-for-exporter',
                        'operator' => 'IN'
                    ),
                );
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
                    'terms' => 'service-for-exporter',
                    'operator' => 'IN'
                );
                if (!empty($tax_query)) {
                    $tax_query['relation'] = 'AND'; // you can also use 'OR' here
                }
            } else {
                $tax_query = array(
                    array(
                        'taxonomy' => 'product_custome_type',
                        'field' => 'slug',
                        'terms' => 'service-for-exporter',
                        'operator' => 'IN'
                ));
            }
            $service_args = array(
                'posts_per_page' => 12,
                'post_type' => 'product',
                'orderby' => 'title',
                'order' => 'ASC',
                'post_status' => 'publish',
                'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1),
                'suppress_filters' => true,
                'tax_query' => $tax_query
    
            );


            ?>
            <?php $service_query = new WP_Query($service_args); ?>
            <?php if ($service_query->have_posts()) { ?>
                <?php wc_print_notices(); ?>
                <!-- TODO : remove item toolbar order 
                <div class="items-toolbar clearfix">
                <?php // do_action('woocommerce_before_shop_loop');  ?>			
                </div> -->		
                <?php woocommerce_product_loop_start(); ?>
                <?php woocommerce_product_subcategories(); ?>
                <?php
                while ($service_query->have_posts()) {
                    $service_query->the_post();
                    wc_get_template_part('content', 'product');
                }
                ?>
                <?php woocommerce_product_loop_end(); ?>
                <nav class="pagination clearfix">
                    <?php
                    $big = 999999999; // need an unlikely integer
                    $args = array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '',
                        'total' => $service_query->max_num_pages,
                        'current' => max(1, get_query_var('paged')),
                        'prev_text' => '',
                        'next_text' => '',
                        'type' => 'plain',
                        'end_size' => 3,
                        'mid_size' => 3,
                    );
                    echo paginate_links($args);
                    ?>
                </nav>
            <?php } else if (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) { ?>
                <?php wc_get_template('loop/no-products-found.php'); ?>
            <?php } ?>
            <?php do_action('woocommerce_after_main_content'); ?>
        </div>

        <?php if ($layout == 'right') { ?>
            <aside class="column fourcol last">
                <?php ThemedbSidebar::renderSidebar('products', true); ?>
            </aside>
        <?php } ?>
        <?php if (!isset($woocommerce_loop['single'])) { ?>
            <?php get_footer('shop'); ?>
        <?php } ?>