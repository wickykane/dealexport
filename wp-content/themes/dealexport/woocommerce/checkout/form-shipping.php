<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
    exit;
}
?>
<section class="checkout-billing-section checkout-section">
    <h5 class="section-title title"><span class="section-order">2</span><?php _e('ADRESSES', 'dealexport'); ?></h5>
    <div class="woocommerce-shipping-fields section-content content">
        <div><?php _e("L'adresse sélectionnée sera utilisée à la fois comme adresse personnelle (pour la facturation) et comme adresse de livraison.", 'dealexport'); ?></div>
        <div class="checkout-addresses">
            <div class="checkout-address-box">
                <span class="checkbox">
                    <input type="radio" checked>
                </span>
                <div class="checkout-address-box-info">
                    <h5 class="checkout-address-box-info-name">MON ADRESSE</h5>
                    <div><?php echo WC()->customer->get_billing_first_name() . ' ' . WC()->customer->get_billing_last_name(); ?></div>
                    <div><?php echo WC()->customer->get_billing_address(); ?></div>
                    <div><?php echo WC()->customer->get_billing_postcode(); ?> <?php echo WC()->customer->get_billing_city(); ?></div>
                    <div><?php echo  WC()->countries->countries[WC()->customer->get_billing_country()]; ?></div>
                    <div><?php echo WC()->customer->get_billing_phone(); ?></div>
                </div>
            </div>
        </div>
        <?php if (WC()->cart->needs_shipping_address() === true) : ?>
            <?php
            if (empty($_POST)) {
                $ship_to_different_address = get_option('woocommerce_ship_to_destination') === 'shipping' ? 1 : 0;
                $ship_to_different_address = apply_filters('woocommerce_ship_to_different_address_checked', $ship_to_different_address);
            } else {
                $ship_to_different_address = $checkout->get_value('ship_to_different_address');
            }
            ?>
            <div id="ship-to-different-address" class="form-row last">
                <input id="ship-to-different-address-checkbox" class="input-checkbox" type="checkbox" name="ship_to_different_address" value="1" />
                <label for="ship-to-different-address-checkbox" class="checkbox"><?php _e("L'adresse de facturation est différente de l'adresse de livraison", 'dealexport'); ?></label>
            </div>
            <div>
                <div class="shipping_address">
                    <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>
                    <?php foreach ($checkout->checkout_fields['shipping'] as $key => $field) : ?>
                        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                    <?php endforeach; ?>
                    <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>