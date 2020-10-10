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
    
if(true || $product->is_in_stock()) {
?>
<?php do_action('woocommerce_before_add_to_cart_form'); ?>
<div class="item-options clearfix">
    <?php woocommerce_template_single_price(); ?>
</div>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>
<?php } ?>