<?php

/*
  Plugin Name: Newsletter - Addons Manager
  xPlugin URI: http://www.thenewsletterplugin.com/documentation/extensions-extension
  Description: Manages all premium and free Newsletter addons directly from your blog
  Version: 1.1.3
  Author: The Newsletter Team
  Author URI: http://www.thenewsletterplugin.com
  Disclaimer: Use at your own risk. No warranty expressed or implied is provided.
 */

add_action('newsletter_loaded', function ($version) {
    if ($version < '6.5.4') {
        add_action('admin_notices', function () {
            echo '<div class="notice notice-error"><p>Newsletter plugin upgrade required for Addons Manager.</p></div>';
        });
    } else {
        include __DIR__ . '/plugin.php';
        new NewsletterExtensions('1.1.3');
    }
});

//register_deactivation_hook(__FILE__, function () {
//    wp_clear_scheduled_hook('newsletter_mailgun_bounce');
//});
