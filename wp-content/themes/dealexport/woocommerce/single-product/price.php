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
            _e('Departing', 'dealexport'); ?> :</span>
    <?php echo $product->get_price_html();
    ?>
    <?php // $arv_price = get_post_meta($product->id, 'arv_price', true); 
    ?><br>
    <!-- <span><?php
                // _e('Arrival', 'dealexport');
                ?>:</span> -->
    <?php // echo woocommerce_price($arv_price);
    ?>
    <meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
<div class="item-price" style="clear: both;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <span><?php
            _e('DepartingAvec', 'dealexport'); ?> :</span>
    <?php
    $arv_price = get_post_meta($product->id, 'arv_price', true); ?>
    <span><?php echo wc_price($arv_price); ?></span>
    <meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
    <meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
    <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
<div class="stock-status" style="clear: both;">
    <?php
    $out_of_stock_message = get_post_meta($product->id, '_out_of_stock_message', true);
    $stock_status = str_replace(array('instock', 'outofstock'), array('En Stock', 'En rupture de stock'), $product->get_stock_status());
    if ($product->is_in_stock()) { ?>
        <div class="text-green"><?php echo  $stock_status; ?><?php echo $product->get_stock_quantity()? ' : '.$product->get_stock_quantity().' '.__('bouteilles', 'dealexport') : null; ?></div>
    <?php } else { ?>
        <div class="text-orange"><?php echo   $out_of_stock_message?  $out_of_stock_message: $stock_status;  ?></div>
    <?php } ?>
</div>