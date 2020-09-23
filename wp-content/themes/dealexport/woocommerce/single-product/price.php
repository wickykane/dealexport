<?php
/*
  @version 3.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $product;
?>
<div class="item-price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <span><?php
    _e('Departing', 'dealexport');?> :</span>
    <?php echo $product->get_price_html();
    ?>
    <?php // $arv_price = get_post_meta($product->id, 'arv_price', true); ?><br>
    <!-- <span><?php
    // _e('Arrival', 'dealexport');?>:</span> -->
    <?php // echo woocommerce_price($arv_price);
    ?>
    <meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
<div class="item-price" style="clear: both;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <span><?php
    _e('DepartingAvec', 'dealexport');?> :</span>
    <?php echo $product->get_price_html();
    ?>
    <?php // $arv_price = get_post_meta($product->id, 'arv_price', true); ?><br>
    <!-- <span><?php
    // _e('Arrival', 'dealexport');?>:</span> -->
    <?php // echo woocommerce_price($arv_price);
    ?>
    <meta itemprop="price"  content="<?php echo $product->get_price(); ?>" />
    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>