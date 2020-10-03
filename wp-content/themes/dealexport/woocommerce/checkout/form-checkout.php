<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
    exit;
}

wc_print_notices();

if (!$checkout->enable_signup && !$checkout->enable_guest_checkout && !is_user_logged_in()) {
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'dealexport'));
    return;
}

$get_checkout_url = apply_filters('woocommerce_get_checkout_url', WC()->cart->get_checkout_url());
?>
<form name="checkout" method="post" class="mt-3  checkout woocommerce-checkout" action="<?php echo esc_url($get_checkout_url); ?>" enctype="multipart/form-data">
    <div class="sevencol column">
        <?php if (sizeof($checkout->checkout_fields) > 0) : ?>
            <?php do_action('woocommerce_checkout_before_customer_details'); ?>
            <div id="customer_details" class="ui accordion">
                <?php do_action('woocommerce_checkout_billing'); ?>
                <?php do_action('woocommerce_checkout_shipping'); ?>
                <?php do_action('woocommerce_review_order_before_shipping'); ?>
                <?php
               
                wc_cart_totals_shipping_html();
                ?>
                <?php do_action('woocommerce_review_order_after_shipping'); ?>
                <?php do_action('woocommerce_checkout_order_review_payment'); ?>

                <!-- <div class="checkout-order-notes">
                    <?php do_action('woocommerce_before_order_notes', $checkout); ?>
                    <?php foreach ($checkout->checkout_fields['order'] as $key => $field) : ?>
                        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                    <?php endforeach; ?>
                    <?php do_action('woocommerce_after_order_notes', $checkout); ?>
                </div> -->

            </div>
            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>
    </div>
</form>
<div id="order_review" class="woocommerce-checkout-review-order fourcol column last">
    <?php do_action('woocommerce_checkout_order_review'); ?>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>

<script>
    jQuery(document).ready(function() {
        jQuery('.ui.accordion').accordion();

        jQuery('#customer_details').accordion({
            selector: {
                trigger: '.title',
                title: '.title',
                content: '.content',
            }
        });

        jQuery('.section-edit').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            jQuery(this).parent().parent().toggleClass('show-detail');
        })
    });
</script>