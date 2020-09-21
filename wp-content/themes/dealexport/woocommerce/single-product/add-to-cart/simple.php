<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

global $product;

if(!$product->is_purchasable()) {
    return;
}

if(!$product->is_in_stock()) {
    $availability=$product->get_availability();
    $availability_html=empty($availability['availability'])?'':'<p class="stock '.esc_attr( $availability['class']).'">'.esc_html($availability['availability']).'</p>';

    echo apply_filters('woocommerce_stock_html', $availability_html, $availability['availability'], $product);
}
    
if($product->is_in_stock()) {
?>
<?php do_action('woocommerce_before_add_to_cart_form'); ?>
<div class="item-options clearfix">
    <?php woocommerce_template_single_price(); ?>
</div>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>
<?php } ?>