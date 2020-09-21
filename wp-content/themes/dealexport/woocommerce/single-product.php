<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

if( has_term( 'product-for-exporter', 'product_custome_type' ) || has_term( 'service-for-exporter', 'product_custome_type' ) ) {
    get_header('service');
}
else {
    get_header('');
}

do_action('woocommerce_before_main_content');
the_post();
wc_get_template_part('content', 'single-product');
do_action('woocommerce_after_main_content');
get_footer('shop');