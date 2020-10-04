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
                <section class="checkout-delivery-section checkout-section">
                    <h5 class="section-title title"><span class="section-order">3</span><?php _e('DELIVERY METHOD', 'dealexport'); ?></h5>
                    <div class="woocommerce-shipping-methods section-content content">
                        <?php wc_cart_totals_shipping_html(); ?>
                        <div class="checkout-order-notes">
                            <?php do_action('woocommerce_before_order_notes', $checkout); ?>
                            <p class="form-row notes" id="order_comments_field" data-priority="">
                                <div for="order_comments" class="">
                                    <?php _e("Si vous voulez nous laisser un message à propos de votre commande, merci de bien vouloir le renseigner dans le champ ci-contre");  ?>
                                </div>
                                <div>
                                    <textarea style="width: 100%" name="order_comments" class="input-text mt-3" id="order_comments" placeholder="Commentaires concernant votre commande" rows="3" cols="5" spellcheck="false"></textarea>
                                </div>
                            </p>
                            <?php do_action('woocommerce_after_order_notes', $checkout); ?>
                        </div>
                    </div>
                </section>
                <?php do_action('woocommerce_review_order_after_shipping'); ?>
                <?php do_action('woocommerce_checkout_order_review_payment'); ?>

                <div class="checkout-condition-to-approve">
                    <input id="conditions_to_approve" class="input-checkbox" type="checkbox" value="1" />
                    <label for="conditions_to_approve">
                        J'ai lu les <a href="#">conditions générales de vente</a> et j'y adhère sans réserve.
                    </label>
                </div>
                <?php
                $order_button_text = __('Order', 'dealexport');
                echo apply_filters('woocommerce_order_button_html', '<button disabled type="submit" style="width: 150px; float: right;" class="button  cart-page-summary-footer-button alt" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr($order_button_text) . '" data-value="' . esc_attr($order_button_text) . '">' . esc_html($order_button_text) . '</button>'); // @codingStandardsIgnoreLine 
                ?>

            </div>
            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>
    </div>
</form>
<div id="order_review" class="woocommerce-checkout-review-order fourcol column last">
    <?php do_action('woocommerce_checkout_order_review'); ?>
</div>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>