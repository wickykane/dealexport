<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
$fee  = apply_filters('woocommerce_get_shipping_flat_rate', true);
$feeText = $fee > 0.00? wc_price($fee): 'gratuit';

?>
<div class="mt-3 cart_totals cart-totals-summary <?php if (WC()->customer->has_calculated_shipping()) echo 'calculated_shipping'; ?>">
  <?php do_action('woocommerce_before_cart_totals'); ?>

  <div class="cart-page-summary">
    <div class="cart-page-summary-item">
      <div class="cart-page-summary-item-label a-cart-total-items">
        <?php echo WC()->cart->get_cart_contents_count() . ' articles'; ?>
      </div>
      <div class="cart-page-summary-item-value a-cart-subtotal-price">
        <span class="cart-page-table-item-total-price">
          <?php
          echo WC()->cart->get_cart_subtotal(); ?>
        </span>
      </div>
    </div>
    <div class="cart-page-summary-item">
      <div class="cart-page-summary-item-label">
        Livraison
      </div>
      <div class="cart-page-summary-item-value">
        <?php
        echo $feeText
        ?>
      </div>
      <div class="cart-page-summary-item-coupon ui accordion">
        <?php foreach (WC()->cart->get_applied_coupons() as $code => $coupon) :
        ?>
          <div class="cart-page-summary-item">
            <div class="cart-page-summary-item-label">
              <?php wc_cart_totals_coupon_label($coupon); ?>
            </div>
            <div class="cart-page-summary-item-value mod-flex">
              <?php echo wc_price(WC()->cart->get_coupon_discount_amount($coupon)); ?>
              <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <input class="hidden" name="remove_coupon" value="<?php echo $coupon ?>" />
                <button class="remove-coupon-btn" type="submit"> <span class="fa fa-times"></span></button>
              </form>

            </div>
          </div>
        <?php endforeach; ?>
        <?php
        echo apply_filters('woocommerce_display_coupon_applied_result', null);
        ?>
        <a class="cart-page-summary-coupon-button title">
          Vous avez un code promo ?
        </a>
        <div class="content">
          <form class="cart-coupon" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <input class="cart-coupon-input" name="coupon" id="coupon" placeholder="<?php echo _e('Promo Code', 'dealexport') ?>" />
            <button <?php
                    echo $fee == 0.00 ? 'disabled' : '';
                    ?> class="button cart-coupon-submit cart-page-summary-footer-button" type="submit">Ajouter</button>
            <?php do_action('add_coupon_code_to_cart'); ?>
          </form>
        </div>
      </div>
    </div>
    <div class="cart-page-summary-item mod-border-0">
      <div class="cart-page-summary-item-label mod-big ">
        <?php _e('TOTAL', 'dealexport') ?>
      </div>
      <div class="cart-page-summary-item-value">
        <span class="cart-page-table-item-total-price">
          <?php echo WC()->cart->get_total(); ?>
        </span>
      </div>
    </div>
  </div>
  <div class="cart-page-summary-footer">
    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="cart-page-summary-footer-button button element-button">
      <?php _e('Order', 'dealexport') ?>
    </a>
  </div>
  <?php do_action('woocommerce_after_cart_totals'); ?>
</div>

<script>
  jQuery(document).ready(function() {
    jQuery('.ui.accordion').accordion();
  });
</script>