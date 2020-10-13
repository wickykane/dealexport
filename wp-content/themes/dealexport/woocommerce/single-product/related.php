<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
    exit;
}

global $product, $woocommerce_loop;

if (empty($product) || !$product->exists()) {
    return;
}

$related = $product->get_related($posts_per_page);
if (sizeof($related) == 0) {
    return;
}

$args = apply_filters('woocommerce_related_products_args', array(
    'post_type' => 'product',
    'ignore_sticky_posts' => 1,
    'no_found_rows' => 1,
    'posts_per_page' => $posts_per_page,
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'post__in' => $related,
    'post__not_in' => array($product->id),
));

$products = new WP_Query($args);
$woocommerce_loop['columns'] = $columns;

if ($products->have_posts()) {
    ?>
    <div class="item-related clearfix">
        <div class="element-title indented">
<!--            <h3>--><?php //_e('Their Great Products (related.php)', 'dealexport'); ?><!--</h3>-->
            <h3><?php _e('Their Great Products', 'dealexport'); ?></h3>
        </div>
        <?php woocommerce_product_loop_start(); ?>
        <?php
        $woocommerce_loop['columns'] = 5;
        while ($products->have_posts()) { ?>
            <?php $products->the_post(); ?>
            <?php wc_get_template_part('content', 'product'); ?>
        <?php } ?>
        <?php woocommerce_product_loop_end(); ?>

    </div>
<?php } ?>
<?php wp_reset_postdata(); ?>