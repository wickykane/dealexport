<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
?>
<?php if (!empty($available_methods)) : ?>
  <div class="checkout-delivery-option">
    <?php if ($chosen_method != 'free_shipping:2') : ?>
      <div class="checkout-delivery-option-icon">
        <span class="custom-radio float-xs-left">
          <input type="radio" name="shipping_method[0]" id="shipping_method_0_flat_rate1" value="flat_rate:1" <?php echo  $chosen_method == 'flat_rate:1' ?  'checked' : '' ?> data-index="0">
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
          echo ($price != 0.00) ? wc_price($price) : __('gratuit', 'dealexport'); ?>
        </span>
      </div>
    <?php else : ?>
      <div class="checkout-delivery-option-icon">
        <span class="custom-radio float-xs-left">
          <input type="radio" name="shipping_method[0]" id="shipping_method_0_free_shipping2" value="free_shipping:2" <?php echo $chosen_method == 'free_shipping:2' ?  'checked' : '' ?> data-index="0">
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
          <?php _e('gratuit', 'dealexport');?>
        </span>
      </div>
    <?php endif; ?>
    <div class="checkout-delivery-option-icon">
      <span class="custom-radio float-xs-left">
        <input <?php echo $chosen_method == 'local_pickup:3' ?  'checked' : '' ?> type="radio" name="shipping_method[0]" id="shipping_method_0_local_pickup3" value="local_pickup:3" data-index="0">
        <span></span>
      </span>
      <span class="checkout-delivery-image">
        <span class="fa fa-shopping-cart"></span> </span>
      <span class="checkout-delivery-name">
        Point de vente
      </span>
      <span class="checkout-delivery-des">
        Lundi au vendredi au 104 Rue Nationale, 59800 Lille, France
      </span>
      <span class="checkout-delivery-fee">
        <?php
        $price = $available_methods['local_pickup:3']->cost;
        echo ($price != 0.00) ? wc_price($price) : __('Click and collect', 'dealexport'); ?>
      </span>
    </div>
  </div>
<?php else : ?>
  <p><?php _e('Please fill in your details to see available shipping methods.', 'dealexport'); ?></p>
<?php endif; ?>