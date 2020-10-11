<?php
/*
@version 3.0.0
*/

if (!defined('ABSPATH')) {
  exit;
}
?>
<section class="checkout-billing-section checkout-section">
  <h5 class="title section-title mod-edit active">
    <div><span class="section-order">1</span><?php _e('Personal Information', 'dealexport'); ?></div>
    <span class="section-edit fa fa-pencil"></span>
  </h5>
  <div class="woocommerce-billing-fields section-content content active">
    <?php global $current_user;
    wp_get_current_user();
    if (is_user_logged_in()) { ?>
      <div>
        <div class="billing-user">
          <div>
            <?php _e('Connecté en tant que ', 'dealexport'); ?>
            <?php printf('<a href="%s">%s</a>', get_author_posts_url($current_user->ID), $current_user->user_login); ?>
          </div>
          <div>
            <?php _e("Ce n'est pas vous ?", 'dealexport'); ?>
            <?php printf('<a class="billing-logout-btn" href="%s">%s</a>', wp_logout_url(wc_get_page_permalink('shop')), __('Se déconnecter', 'dealexport')); ?>
          </div>
          <div class="logout-instruction"><?php _e('Si vous vous déconnectez maintenant, votre panier sera vidé.', 'dealexport'); ?></div>
        </div>
        <div class="billing-user-form">
          <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>
          <?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
            <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
          <?php endforeach; ?>
          <button style="width: 150px; float: right; margin-bottom: 1rem;" class="update-billing-profile-btn button cart-page-summary-footer-button alt">Enregistrer</button>
          <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
        </div>
      </div>
    <?php } else { ?>
      <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>
      <?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
        <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
      <?php endforeach; ?>
      <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>

      <?php if (!is_user_logged_in() && $checkout->enable_signup) : ?>
        <?php if ($checkout->enable_guest_checkout) : ?>
          <p class="form-row form-row-wide create-account">
            <input class="input-checkbox" id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked', false))), true) ?> type="checkbox" name="createaccount" value="1" /> <label for="createaccount" class="checkbox"><?php _e('Create an account?', 'dealexport'); ?></label>
          </p>
        <?php endif; ?>
        <?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>
        <?php if (!empty($checkout->checkout_fields['account'])) : ?>
          <div class="create-account">
            <p><?php _e('Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'dealexport'); ?></p>
            <?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>
              <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
            <?php endforeach; ?>
            <div class="clear"></div>
          </div>
        <?php endif; ?>
        <?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
    <?php endif;
    } ?>
  </div>
</section>