<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}

$cart = ThemedbWoo::getCart();

wc_print_notices();
// do_action('woocommerce_before_cart');
?>
<div id="content" class="woo-cart-container">
  <div class="mt-3 eightcol column">
    <form action="<?php echo esc_url(WC()->cart->get_cart_url()); ?>" method="POST">
      <?php do_action('woocommerce_before_cart_table'); ?>
      <h1 class="cart-page-title"><?php _e('Basket', 'dealexport') ?></h1>
      <hr class="separator">
      <div class="cart-page-table-container">
        <table class="cart-page-table">
          <?php
          foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
          ?>
              <tbody>
                <tr>
                  <td>
                    <?php
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(array(300)), $cart_item, $cart_item_key);
                    if (!$_product->is_visible())
                      printf('<div class="cart-page-table-thumbnail">%s</div>', $thumbnail);
                    else
                      printf('<a  class="cart-page-table-thumbnail" href="%s">%s</a>', $_product->get_permalink(), $thumbnail);
                    ?>
                  </td>
                  <td>
                    <?php
                    if (!$_product->is_visible())
                      echo apply_filters('woocommerce_cart_item_name', __($_product->get_title()), $cart_item, $cart_item_key);
                    else
                      echo apply_filters('woocommerce_cart_item_name', sprintf('<a class="cart-page-table-item-name" href="%s">%s</a>', $_product->get_permalink(), __($_product->get_title())), $cart_item, $cart_item_key);

                    echo WC()->cart->get_item_data($cart_item);

                    if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity']))
                      echo '<p class="backorder_notification">' . __('Available on backorder', 'dealexport') . '</p>';
                    ?>
                    <div class="cart-page-table-item-price">
                      <?php
                      echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                      ?>
                    </div>
                  </td>
                  <td>
                    <div class="cart-page-table-item-qty">
                      <?php
                      if ($_product->is_sold_individually()) {
                        $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                      } else {
                        $product_quantity = woocommerce_quantity_input(array(
                          'input_name'  => "cart[{$cart_item_key}][qty]",
                          'input_id'  => $cart_item_key,
                          'input_value' => $cart_item['quantity'],
                          'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
                          'min_value'   => '1'
                        ), $_product, false);
                      }
                      echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key);
                      ?>
                    </div>

                  </td>
                  <td>
                    <div class="cart-page-table-item-total-price">
                      <?php
                      echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                      ?>
                    </div>
                  </td>
                  <td>
                    <div class="cart-page-table-action">
                      <?php
                      echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
                        '<a href="%s" class="remove-from-cart" title="%s"><span class="fa fa-times"></span></a>',
                        esc_url(WC()->cart->get_remove_url($cart_item_key)),
                        __('Remove this item', 'dealexport')
                      ), $cart_item_key);
                      ?>
                    </div>
                  </td>
                </tr>
              </tbody>
          <?php
            }
          }
          do_action('woocommerce_recalculate_item_sub_total');
          do_action('woocommerce_cart_contents');
          ?>
        </table>
        <a href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>" class="button element-button cart-page-table-continue-shopping"><?php _e('Continue to Shopping', 'dealexport') ?></a>
      </div>
    </form>
  </div>
  <div class="fourcol column last">
    <?php do_action('woocommerce_cart_collaterals'); ?>
  </div>
</div>
<?php // do_action('woocommerce_after_cart'); 
?>