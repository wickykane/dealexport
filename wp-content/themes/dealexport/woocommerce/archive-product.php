<?php
/*
  @version 3.0.0
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
$woocommerce_loop['columns'] = 5;
if ($layout != 'full') {
    $woocommerce_loop['columns'] = 3;
}

if( has_term('product-for-exporter', 'product_custome_type') || has_term('service-for-exporter', 'product_custome_type') ) {
    get_header('service');
}
else {
    get_header('');
}

if ($layout == 'left') {
    ?>
    <aside class="column threecol">
        <?php ThemedbSidebar::renderSidebar('products', false); ?>
<!--        --><?php //include_once 'product-filter.php'; ?>
        <?php if( has_term('product-for-exporter', 'product_custome_type') || has_term('service-for-exporter', 'product_custome_type') ) {
            include_once 'service-filter.php';
//            echo "For exporter? true";
        } else {
            include_once 'product-filter.php';
//            echo "For exporter? false";
        } ?>
    </aside>
    <div class="column ninecol last">
    <?php } else if ($layout == 'right') { ?>
        <div class="column ninecol">
        <?php } else { ?>
            <div class="fullcol">
            <?php } ?>
            <?php do_action('woocommerce_before_main_content'); ?>
            <?php if (apply_filters('woocommerce_show_page_title', true)) { ?>
                <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
            <?php } ?>
            <?php do_action('woocommerce_archive_description'); ?>
            <div class="single-shop-related-product">
<!--                <h3 class="great-product">--><?php //_e('Their Great Products (archive-product.php)', 'dealexport'); ?><!--</h3>-->
                <h3 class="great-product"><?php _e('Their Great Products', 'dealexport'); ?></h3>
            <?php

            ?>


            <?php if (have_posts()) { ?>
                <?php wc_print_notices(); ?>
                <!-- TODO : remove item toolbar order 
                <div class="items-toolbar clearfix">
                <?php // do_action('woocommerce_before_shop_loop');  ?>
                </div> -->		
                <?php woocommerce_product_loop_start(); ?>
                <?php woocommerce_product_subcategories(); ?>
                <?php
                while (have_posts()) {
                    the_post();
                    wc_get_template_part('content', 'product');
                }
                ?>
                <?php woocommerce_product_loop_end(); ?>
                <?php do_action('woocommerce_after_shop_loop'); ?>
            <?php } else if (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) { ?>
                <?php wc_get_template('loop/no-products-found.php'); ?>
            <?php } ?>
            </div>
            <?php do_action('woocommerce_after_main_content'); ?>
        </div>
        <?php if ($layout == 'right') { ?>
            <aside class="column fourcol last">
                <?php ThemedbSidebar::renderSidebar('products', false); ?>
            </aside>
        <?php } ?>
        <?php if (!isset($woocommerce_loop['single'])) { ?>
            <?php get_footer('shop'); ?>
        <?php } ?>