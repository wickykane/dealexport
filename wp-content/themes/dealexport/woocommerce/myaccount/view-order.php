<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
?>
<div>
  <?php // include(get_template_directory() .'/sidebar-profile-left.php'); 
  ?>
  <div class="column eightcol mt-3">
    <div class="mb-3">
      <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
        <?php _e('Back', 'dealexport') ?></a> </div> <div class="element-title">
          <h1><?php _e('View Order', 'dealexport'); ?></h1>
    </div>
    <?php wc_print_notices(); ?>
    <?php do_action('woocommerce_view_order', $order_id); ?>
  </div>
</div>