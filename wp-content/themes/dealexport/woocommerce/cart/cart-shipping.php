<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
?>
<?php if (!empty($available_methods)) : ?>
  <?php
  $method_config = apply_filters('woocommerce_checkout_shipping_method_config', null);
  foreach ($available_methods as $id => $method) {
    if ($method->method_id === 'free_shipping') {
      $hasFreeship = true;
    }
  }
  ?>

  <?php

  foreach ($available_methods as $id => $method) :
    $currenConfig = $method_config[$method->method_id];
  ?>
    <?php if ($hasFreeship && $method->method_id != 'flat_rate' || !$hasFreeship && $method->method_id != 'free_shipping'): ?>
    <div class="checkout-delivery-option-icon">
      <span class="custom-radio float-xs-left">
        <input type="radio" name="shipping_method[0]" id="shipping_method_0_<?php echo $id ?>" value="<?php echo $id; ?>" <?php checked($id, $chosen_method); ?> data-index="0">
        <span></span>
      </span>
      <span class="checkout-delivery-image">
        <span class="fa <?php echo $currenConfig['icon']; ?>"></span>
      </span>
      <span class="checkout-delivery-name">
        <?php echo $currenConfig['name']; ?>
      </span>
      <span class="checkout-delivery-des">
        <?php echo $currenConfig['des']; ?>
      </span>
      <span class="checkout-delivery-fee">
        <?php echo ($method->cost == 0 ? $currenConfig['is_free'] :  wc_price($method->cost)); ?>
      </span>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>
<?php else : ?>
  <p><?php _e('Please fill in your details to see available shipping methods.', 'dealexport'); ?></p>
<?php endif; ?>