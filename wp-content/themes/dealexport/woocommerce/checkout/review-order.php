<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

if (!defined('ABSPATH')) {
	exit;
}
$fee  = apply_filters('woocommerce_get_shipping_flat_rate', true);
$feeText = $fee > 0.00? wc_price($fee): 'gratuit';

?>
<div class="cart_totals">
	<?php do_action('woocommerce_before_cart_totals'); ?>
	<?php do_action('woocommerce_review_order_before_cart_contents'); ?>
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
			<div class="ui accordion" style="width: 100%;">
				<span class="title"> <?php _e('afficher les détails', 'dealexport'); ?></span>
				<div class="content">
					<?php
					do_action('woocommerce_review_order_before_cart_contents');

					foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
						$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
					?>
							<div class="checkout-cart-items">
								<div class="product-name">
									<?php echo apply_filters('woocommerce_cart_item_name', _e($_product->get_name()), $cart_item, $cart_item_key) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
									<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
									<?php echo wc_get_formatted_cart_item_data($cart_item);
									?>
								</div>
								<div class="product-total">
									<?php echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
									?>
								</div>
							</div>
					<?php
						}
					}

					do_action('woocommerce_review_order_after_cart_contents');
					?>
				</div>
			</div>
		</div>
		<div class="cart-page-summary-item">
			<div class="cart-page-summary-item-label">
				Livraison
			</div>
			<div class="cart-page-summary-item-value">
				<?php
				echo $feeText;
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
							<form action="<?php echo esc_url(wc_get_checkout_url()); ?>" method="post">
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

					<form class="cart-coupon" action="<?php echo esc_url(wc_get_checkout_url()); ?>" method="post">
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
	<?php do_action('woocommerce_review_order_after_order_total'); ?>
	<?php do_action('woocommerce_after_cart_totals'); ?>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery('.ui.accordion').accordion();
	});
</script>