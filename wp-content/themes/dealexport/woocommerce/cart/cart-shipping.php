<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
$selectedMethod = WC()->session->get('chosen_shipping_methods')[0];
?>
<?php if (!empty($available_methods)) : ?>
  <div class="checkout-delivery-option">
    <?php if ($selectedMethod != 'free_shipping:6') : ?>
      <div class="checkout-delivery-option-icon">
        <span class="custom-radio float-xs-left">
          <input type="radio" name="shipping_method[0]" id="shipping_method_0_flat_rate1" value="flat_rate:1" <?php echo  $selectedMethod  == 'flat_rate:1' ?  'checked' : '' ?> data-index="0">
          <span></span>
        </span>
        <span class="checkout-delivery-image">
          <span class="fa fa-truck"></span>
        </span>
        <span class="checkout-delivery-name">
          LIVRAISON À DOMICILE
        </span>
        <span class="checkout-delivery-des">
          2-5 jours ouvrés
        </span>
        <span class="checkout-delivery-fee">
          <?php
          $price = $available_methods['flat_rate:1']->cost;
          echo ($price != 0.00) ? wc_price($price) : 'gratuit'; ?>
        </span>
      </div>
    <?php else : ?>
      <div class="checkout-delivery-option-icon">
        <span class="custom-radio float-xs-left">
          <input type="radio" name="shipping_method[0]" id="shipping_method_0_free_shipping2" value="free_shipping:6" <?php echo $selectedMethod  == 'free_shipping:6' ?  'checked' : '' ?> data-index="0">
          <span></span>
        </span>
        <span class="checkout-delivery-image">
          <span class="fa fa-truck"></span>
        </span>
        <span class="checkout-delivery-name">
          LIVRAISON À DOMICILE
        </span>
        <span class="checkout-delivery-des">
          2-5 jours ouvrés
        </span>
        <span class="checkout-delivery-fee">
        gratuit
        </span>
      </div>
    <?php endif; ?>
    <div class="checkout-delivery-option-icon">
      <span class="custom-radio float-xs-left">
        <input <?php echo $selectedMethod == 'local_pickup:2' ?  'checked' : '' ?> type="radio" name="shipping_method[0]" id="shipping_method_0_local_pickup3" value="local_pickup:2" data-index="0">
        <span></span>
      </span>
      <span class="checkout-delivery-image">
        <span class="fa fa-shopping-cart"></span> </span>
      <span class="checkout-delivery-name">
        Point de vente
      </span>
      <span class="checkout-delivery-des">
        Lundi au vendredi
      </span>
      <span class="checkout-delivery-fee">
        <?php
        $price = $available_methods['local_pickup:2']->cost;
        echo ($price != 0.00) ? wc_price($price) : 'gratuit'; ?>
      </span>
    </div>
  </div>
<?php else : ?>
  <p><?php _e('Please fill in your details to see available shipping methods.', 'dealexport'); ?></p>
<?php endif; ?>
