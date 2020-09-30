<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}

global $post, $product;

$cat_count = sizeof(get_the_terms($post->ID, 'product_cat'));
$tag_count = sizeof(get_the_terms($post->ID, 'product_tag'));
?>
<footer class="item-footer clearfix">
  <?php do_action('woocommerce_product_meta_start'); ?>
  <div class="column twelvecol">
    <?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
      <div class="item-sku left">
        <span class="fa fa-inbox"></span>
        <span class="sku" itemprop="sku"><?php echo ($sku = $product->get_sku()) ? $sku : __('N/A', 'dealexport'); ?></span>
      </div>
    <?php endif; ?>
    <div class="item-category left">
      <span class="fa fa-reorder"></span>
      <?php echo $product->get_categories(', '); ?>
    </div>
  </div>
  <div class="column twelvecol last">
    <div class="tagcloud right">
      <?php echo $product->get_tags(''); ?>
    </div>
  </div>
  <?php do_action('woocommerce_product_meta_end'); ?>
</footer>

<div class="clearfix add-to-cart-form mt-3">
  <form class="cart" action="<?php echo themedb_url(); ?>" method="POST" enctype="multipart/form-data">
    <?php do_action('woocommerce_before_add_to_cart_button'); ?>
    <?php
    if (!$product->is_sold_individually()) { ?>
      <div class="product-quantity ">
        <label><?php _e('Quantity', 'dealexport')?></label>
        <?php
        woocommerce_quantity_input(array(
          'min_value' => apply_filters('woocommerce_quantity_input_min', 1, $product),
          'max_value' => apply_filters('woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product),
        ));
        ?>
      </div>

    <?php } ?>

    <!-- <a href="#" class="element-button element-submit item-cart primary"><?php echo $product->single_add_to_cart_text(); ?></a>
        <a href="#" class="element-button element-submit cart-button square primary" title="<?php echo $product->single_add_to_cart_text(); ?>"><span class="fa fa-shopping-cart large"></span></a>
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>" /> -->

    <div class="btn-group">
      <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="element-button cart-button aligncenter" title="<?php _e('Cart', 'dealexport'); ?>">
        <span class="fa fa-shopping-cart large"></span>
        <span><?php _e('Add to basket', 'dealexport'); ?></span>
      </button>
      <!-- <button class="element-button like-button aligncenter" title="<?php _e('Like', 'dealexport'); ?>">
        <span class="fa fa-heart large"></span>
        <span class="like-text"><?php _e('Like', 'dealexport'); ?></span>
      </button> -->
    </div>
    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
  </form>
  <!-- TNH disbale  comment and favorite button -->
  <?php if (false) { ?>
    <?php if (is_user_logged_in()) { ?>
      <?php if (!ThemedbCore::checkOption('product_favorites')) { ?>
        <form class="element-form" method="POST" action="<?php echo AJAX_URL; ?>">
          <?php if (in_array($product->id, ThemedbUser::$data['current']['favorites'])) { ?>
            <a href="#" title="<?php _e('Remove from Favorites', 'dealexport'); ?>" class="element-button element-submit secondary active" data-title="<?php _e('Add to Favorites', 'dealexport'); ?>"><span class="fa fa-heart"></span></a>
            <input type="hidden" name="user_action" class="toggle" value="remove_relation" data-value="add_relation" />
          <?php } else { ?>
            <a href="#" title="<?php _e('Add to Favorites', 'dealexport'); ?>" class="element-button element-submit secondary" data-title="<?php _e('Remove from Favorites', 'dealexport'); ?>"><span class="fa fa-heart"></span></a>
            <input type="hidden" name="user_action" class="toggle" value="add_relation" data-value="remove_relation" />
          <?php } ?>
          <input type="hidden" name="relation_type" value="product" />
          <input type="hidden" name="relation_id" value="<?php echo $product->id; ?>" />
          <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
        </form>
      <?php } ?>
      <?php if (!ThemedbCore::checkOption('product_questions')) { ?>
        <a href="#contact_form_<?php echo $product->id; ?>" class="element-button element-colorbox square secondary" title="<?php _e('Ask a Question', 'dealexport'); ?>"><span class="fa fa-comment"></span></a>
      <?php } ?>
    <?php } else { ?>
      <?php if (!ThemedbCore::checkOption('product_favorites')) { ?>
        <a href="<?php echo ThemedbCore::getURL('register'); ?>" title="<?php _e('Add to Favorites', 'dealexport'); ?>" class="element-button secondary"><span class="fa fa-heart"></span></a>
      <?php } ?>
      <?php if (!ThemedbCore::checkOption('product_questions')) { ?>
        <a href="<?php echo ThemedbCore::getURL('register'); ?>" class="element-button square secondary" title="<?php _e('Ask a Question', 'dealexport'); ?>"><span class="fa fa-comment"></span></a>
      <?php } ?>
    <?php } ?>
  <?php } ?>
  <div class="site-popups hidden">
    <?php if (!ThemedbCore::checkOption('product_questions')) { ?>
      <div id="contact_form_<?php echo $product->id; ?>">
        <div class="site-popup medium">
          <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
            <div class="field-wrap">
              <input type="text" name="email" readonly="readonly" value="<?php echo esc_attr(ThemedbUser::$data['current']['email']); ?>" />
            </div>
            <div class="field-wrap">
              <textarea name="question" cols="30" rows="5" placeholder="<?php _e('Question', 'dealexport'); ?>"></textarea>
            </div>
            <a href="#" class="element-button element-submit primary"><?php _e('Send Question', 'dealexport'); ?></a>
            <input type="hidden" name="product_id" value="<?php echo $product->id; ?>" />
            <input type="hidden" name="shop_action" value="submit_question" />
            <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_shop" />
          </form>
        </div>
      </div>
    <?php } ?>
  </div>
  <!-- /popups -->
</div>