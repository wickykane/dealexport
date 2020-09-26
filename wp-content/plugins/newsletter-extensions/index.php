<?php
/* @var $this NewsletterExtensions */

@include_once NEWSLETTER_INCLUDES_DIR . '/controls.php';
$controls = new NewsletterControls();

$extensions = $this->get_extensions_catalog();
$license_key = Newsletter::instance()->get_license_key();

$license_data = $this->get_license_data();


if ($controls->is_action('install')) {

    $extension = null;
    foreach ($extensions as $e) {
        if ($e->id == $_GET['id']) {
            $extension = $e;
            break;
        }
    }

    $id = $extension->id;
    $slug = $extension->slug;

    $source = 'http://www.thenewsletterplugin.com/wp-content/plugins/file-commerce-pro/get.php?f=' . $id .
            '&k=' . $license_key;

    if (!class_exists('Plugin_Upgrader', false)) {
        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    }

    $upgrader = new Plugin_Upgrader(new Automatic_Upgrader_Skin());

    $result = $upgrader->install($source);
    if (!$result || is_wp_error($result)) {
        $controls->errors = __('Error while installing', 'newsletter');
        if (is_wp_error($result)) {
            $controls->errors .= ': ' . $result->get_error_message();
        }
    } else {
        $result = activate_plugin($extension->wp_slug);
        if (is_wp_error($result)) {
            $controls->errors .= __('Error while activating:', 'newsletter') . " " . $result->get_error_message();
        } else {
            wp_clean_plugins_cache(false);
            $controls->js_redirect(admin_url('admin.php') . '?page=newsletter_extensions_index');
            //$controls->messages .= __('Installed and activated', 'newsletter');
            die();
        }
    }
    //wp_clean_plugins_cache(false);
    //wp_redirect(admin_url('admin.php') . '?page=newsletter_main_extensions');
    //die();
}

if ($controls->is_action('activate')) {
    $extension = null;
    foreach ($extensions as $e) {
        if ($e->id == $_GET['id']) {
            $extension = $e;
            break;
        }
    }
    $result = activate_plugin($extension->wp_slug);
    if (is_wp_error($result)) {
        $controls->errors .= __('Error while activating:', 'newsletter') . " " . $result->get_error_message();
    } else {
        wp_clean_plugins_cache(false);
        $controls->js_redirect(admin_url('admin.php') . '?page=newsletter_extensions_index');
        die();
    }
}

if ($controls->is_action('save')) {

    if (!empty($controls->data['contract_key'])) {
        $option = get_option('newsletter_main');
        $option['contract_key'] = $license_key;
        update_option('newsletter_main', $option);
        $license_data = Newsletter::instance()->get_license_data(true);
    }
}

if (is_wp_error($license_data)) {
    $controls->errors .= esc_html('[' . $license_data->get_error_code()) . '] - ' . esc_html($license_data->get_error_message());
} else {
    if ($license_data !== false) {
        if ($license_data->expire == 0) {
            $controls->messages = 'Your FREE license is valid';
        } elseif ($license_data->expire >= time()) {
            $controls->messages = 'Your license is valid and expires on ' . esc_html(date('Y-m-d', $license_data->expire));
        } else {
            $controls->errors = 'Your license is expired on ' . esc_html(date('Y-m-d', $license_data->expire));
        }
    }
}

$map = array();
if (!is_wp_error($license_data) && !empty($license_data->extensions) && is_array($license_data->extensions)) {
    foreach ($license_data->extensions as $item) {
        $map['' . $item->id] = $item;
    }
}

if (!$extensions) {
    $controls->errors .= '<br><br>Your blog cannot contact our addons catalog service. You can get the addons directly from your <a href="https://www.thenewsletterplugin.com/account" target="_blank">account page</a>.';
} else {
    foreach ($extensions AS $e) {
        $e->activate_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=activate&id=' . $e->id, 'save');
        $e->install_url = wp_nonce_url(admin_url('admin.php') . '?page=newsletter_extensions_index&act=install&id=' . $e->id, 'save');
        $e->is_installed = file_exists(WP_PLUGIN_DIR . "/" . $e->wp_slug);
        $e->is_active = is_plugin_active($e->wp_slug);

        if (isset($map['' . $e->id])) {
            $e->downloadable = $map['' . $e->id]->downloadable;
        } else {
            $e->downloadable = false;
        }
    }
}
?>

<style>
<?php readfile(__DIR__ . '/admin.css') ?>
</style>

<script>
    function tnp_register() {
        jQuery.post(ajaxurl, {
            action: "tnp_addons_register",
            _wpnonce: "<?php echo wp_create_nonce("register") ?>",
            email: document.getElementById("tnp-email").value
        }, function (data) {
            alert(data.message);
            if (data.reload)
                location.reload();

        });
    }
    function tnp_license() {
        jQuery.post(ajaxurl, {
            action: "tnp_addons_license",
            _wpnonce: "<?php echo wp_create_nonce("license") ?>",
            license_key: document.getElementById("tnp-license-key").value
        }, function (data) {
           
           
                location.reload();

        });
    }

</script>


<div class="wrap tnp-extensions-index" id="tnp-wrap">

    <?php include NEWSLETTER_DIR . '/tnp-header.php'; ?>




    <div id="tnp-body">

        <?php if (is_wp_error($license_data)) { ?>
            <!-- There is already a message on top of the page, but we should add more here -->
        <?php } else if ($license_data === false) { ?>
            <div id="tnp-promo" class="tnp-promo-create">
                <h1>Almost done. Get a free license key to install our free addons!</h1>

                <input id="tnp-email" type="email" name="email" value="<?php echo esc_attr($current_user->user_email) ?>" placeholder="Your email address">
    <!--                <input class="tnp-button" type="button" value="Create account" onclick="tnp_register()">-->
                <button class="tnp-button" onclick="tnp_register()">Create account  <i class="fas fa-arrow-right"></i></button>
                <br>
                <div class="tnp-notes">A free account will be created on <a href="https://www.thenewsletterplugin.com" target="_blank">thenewsletterplugin.com</a> and a free license key generated. See
                    the privacy policy and terms of use on our site.</div>
            </div>


            <div id="tnp-promo" class="tnp-promo-insert">
                <div class="tnp-promo-one-third">
                    <h2>Already have a license?</h2>
                </div>

                <div class="tnp-promo-two-third">
                    <input id="tnp-license-key" type="text" name="license" value="" placeholder="Your license key">
                    <button class="tnp-button" onclick="tnp_license()">Save</button>
                </div>
                <div class="tnp-promo-third-third">
                    <div class="tnp-notes">Tip: if you registered on <a href="https://www.thenewsletterplugin.com" target="_blank">thenewsletterplugin.com</a>
                        get it on <a href="https://www.thenewsletterplugin.com/account" target="_blank">your account</a>.
                    </div>
                </div>


            </div>
        <?php } else if ($license_data->expire == 0) { // Free license   ?>

            <h1>Are you enjoying our free addons?</h1>
            <h2><a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" target="_blank">Check out how to jump up to a pro level with our premium addons</a></h2>

        <?php } ?>

        <?php if ($extensions) { ?>


            <h3 class="tnp-section-title">Additional professional features</h3>
            <?php foreach ($extensions AS $e) { ?>

                <?php
                if ($e->type != "extension")
                    continue;

                $class = $e->free ? 'tnp-extension-free-box' : 'tnp-extension-premium-box';
                $class .= ' ' . $e->slug;
                ?>

                <div class="<?php echo $class ?>">
                    <?php if ($e->free) { ?>
                        <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                    <?php } ?>
                    <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>" alt="" /></div>
                    <h3><?php echo $e->title ?></h3>
                    <p><?php echo $e->description ?></p>

                    <div class="tnp-extension-premium-action">
                        <?php if ($e->is_installed) { ?>

                            <?php if ($e->is_active) { ?>
                                <span><i class="fas fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                            <?php } else { ?>
                                <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                    <i class="fas fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                </a>
                            <?php } ?>

                        <?php } else { ?>

                            <?php if ($e->downloadable) { ?>
                                <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                    <i class="fas fa-download" aria-hidden="true"></i> Install Now
                                </a>
                            <?php } else { ?>

                                <?php if ($e->free) { ?>

                                    <a href="#tnp-promo" class="tnp-extension-install">
                                        <i class="fas fa-download" aria-hidden="true"></i> Get a free license
                                    </a>
                                <?php } else { ?>
                                    <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                        <i class="fas fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                    </a>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>


                        <!--  
                        <?php if ($e->url) { ?>
                                                                                                                        <br><br>
                                                                                                                        <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                                                                                            View details
                                                                                                                        </a>
                        <?php } ?>
                        -->
                    </div>
                </div>
            <?php } ?>



            <h3 class="tnp-section-title">Integrations with 3rd party plugins</h3>
            <?php foreach ($extensions AS $e) { ?>
                <?php
                if ($e->type != "integration")
                    continue;

                $class = $e->free ? 'tnp-extension-free-box' : 'tnp-integration-box';
                $class .= ' ' . $e->slug;
                ?>
                <div class="<?php echo $class ?>">
                    <?php if ($e->free) { ?>
                        <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                    <?php } ?>
                    <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>" alt="" /></div>
                    <h3><?php echo $e->title ?></h3>
                    <p><?php echo $e->description ?></p>

                    <div class="tnp-extension-premium-action">
                        <?php if ($e->is_installed) { ?>

                            <?php if ($e->is_active) { ?>
                                <span><i class="fas fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                            <?php } else { ?>
                                <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                    <i class="fas fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                </a>
                            <?php } ?>

                        <?php } else { ?>

                            <?php if ($e->downloadable) { ?>
                                <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                    <i class="fas fa-download" aria-hidden="true"></i> Install Now
                                </a>
                            <?php } else { ?>

                                <?php if ($e->free) { ?>

                                    <a href="#tnp-promo" class="tnp-extension-install">
                                        <i class="fas fa-download" aria-hidden="true"></i> Get a free license
                                    </a>
                                <?php } else { ?>
                                    <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                        <i class="fas fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                    </a>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>


                        <!--  
                        <?php if ($e->url) { ?>
                                                                                                                        <br><br>
                                                                                                                        <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                                                                                            View details
                                                                                                                        </a>
                        <?php } ?>
                        -->
                    </div>
                </div>
            <?php } ?>



            <h3 class="tnp-section-title">Integrations with reliable mail delivery services</h3>
            <?php foreach ($extensions AS $e) { ?>

                <?php
                if ($e->type != "delivery")
                    continue;

                $class = $e->free ? 'tnp-extension-free-box' : 'tnp-integration-box';
                $class .= ' ' . $e->slug;
                ?>
                <div class="<?php echo $class ?>">
                    <?php if ($e->free) { ?>
                        <img class="tnp-extensions-free-badge" src="<?php echo plugins_url('newsletter') ?>/images/extension-free.png">
                    <?php } ?>
                    <div class="tnp-extensions-image"><img src="<?php echo $e->image ?>" alt="" /></div>
                    <h3><?php echo $e->title ?></h3>
                    <p><?php echo $e->description ?></p>

                    <div class="tnp-extension-premium-action">
                        <?php if ($e->is_installed) { ?>

                            <?php if ($e->is_active) { ?>
                                <span><i class="fas fa-check" aria-hidden="true"></i> <?php _e('Plugin active', 'newsletter') ?></span>
                            <?php } else { ?>
                                <a href="<?php echo $e->activate_url ?>" class="tnp-extension-activate">
                                    <i class="fas fa-power-off" aria-hidden="true"></i> <?php _e('Activate', 'newsletter') ?>
                                </a>
                            <?php } ?>

                        <?php } else { ?>

                            <?php if ($e->downloadable) { ?>
                                <a href="<?php echo $e->install_url ?>" class="tnp-extension-install">
                                    <i class="fas fa-download" aria-hidden="true"></i> Install Now
                                </a>
                            <?php } else { ?>

                                <?php if ($e->free) { ?>

                                    <a href="#tnp-promo" class="tnp-extension-install">
                                        <i class="fas fa-download" aria-hidden="true"></i> Get a free license
                                    </a>
                                <?php } else { ?>
                                    <a href="https://www.thenewsletterplugin.com/premium?utm_source=plugin&utm_medium=link&utm_campaign=extpanel" class="tnp-extension-buy" target="_blank">
                                        <i class="fas fa-shopping-cart" aria-hidden="true"></i> Buy Now
                                    </a>
                                <?php } ?>
                            <?php } ?>

                        <?php } ?>


                        <!--  
                        <?php if ($e->url) { ?>
                                                                                                                        <br><br>
                                                                                                                        <a href="<?php echo $e->url ?>" class="tnp-extension-details" target="_blank">
                                                                                                                            View details
                                                                                                                        </a>
                        <?php } ?>
                        -->
                    </div>
                </div>
            <?php } ?>


        <?php } else { ?>

            <p style="color: white;">No addons available. Could be a connection problem, try later.</p>

        <?php } ?>


        <p class="clear"></p>

    </div>

    <?php include NEWSLETTER_DIR . '/tnp-footer.php'; ?>

</div>
