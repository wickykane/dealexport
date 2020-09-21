<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

wc_print_notices();
do_action('woocommerce_before_checkout_form', $checkout);

if(! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in()){
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'dealexport'));
    return;
}

$get_checkout_url=apply_filters('woocommerce_get_checkout_url', WC()->cart->get_checkout_url());
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url($get_checkout_url); ?>" enctype="multipart/form-data">
    <div class="sixcol column">
    <?php if(sizeof($checkout->checkout_fields)> 0): ?>
        <?php do_action('woocommerce_checkout_before_customer_details'); ?>
        <div id="customer_details">
            <?php do_action('woocommerce_checkout_billing'); ?>
            <?php do_action('woocommerce_checkout_shipping'); ?>
        </div>
        <?php do_action('woocommerce_checkout_after_customer_details'); ?>		
    <?php endif; ?>
    </div>
    <div id="order_review" class="woocommerce-checkout-review-order sixcol column last">
        <?php do_action('woocommerce_checkout_order_review'); ?>
    </div>
</form>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>