<?php
/*
Template Name: Registration
*/
?>
<?php get_header(); ?>

<?php if (get_option('users_can_register')) { ?>
    <?php
    if ($_GET['require']) {
        ThemedbInterface::$messages[] = __('Please registration to view our site', 'dealexport');
        ThemedbInterface::renderMessages();
    }
    ?>
    <div class="column eightcol mt-3">
        <div class="element-title">
            <h1><?php _e('Register', 'dealexport'); ?></h1>
        </div>
        <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
            <div class="column sixcol">
                <div class="field-wrap">
                    <input type="text" name="user_login" placeholder="<?php _e('Username', 'dealexport'); ?>">
                </div>

                <div class="field-wrap">
                    <input type="text" name="first_name" placeholder="<?php _e('First Name', 'dealexport'); ?>">
                </div>

                <div class="field-wrap">
                    <input type="text" name="last_name" placeholder="<?php _e('Last Name', 'dealexport'); ?>">
                </div>

            </div>
            <div class="column sixcol last">
                <div class="field-wrap">
                    <input type="text" name="user_email" placeholder="<?php _e('Email', 'dealexport'); ?>">
                </div>

                <div class="field-wrap">
                    <input type="password" name="user_password" placeholder="<?php _e('Password', 'dealexport'); ?>">
                </div>

                <div class="field-wrap">
                    <input type="password" name="user_password_repeat" placeholder="<?php _e('Repeat Password', 'dealexport'); ?>">
                </div>

            </div>

            <div class="column sixcol last" style="display: none;">
                <div class="field-wrap" style="padding-right: 0px !important">
                    <div class="element-select">
                        <span></span>
                        <?php
                        echo ThemedbInterface::renderOption(array(
                            'id' => 'role',
                            'type' => 'select_user_role',
                            'options' => themedb_array('options', $user_roles),
                            'value' => 'author',
                            'attributes' => array(
                                'class' => 'element-trigger',
                            ),
                            'wrap' => false,
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class='trigger-role-shop_manager'>
                <div class="column sixcol">
                    <div class="field-wrap">
                        <input type="text" name="name_of_supplier" placeholder="<?php _e('Name of supllier', 'dealexport'); ?>">
                    </div>
                </div>
                <div class="column sixcol last">
                    <div class="field-wrap" style="padding-right: 0px !important">
                        <?php
                        echo ThemedbInterface::renderOption(array(
                            'id' => 'shop_categories',
                            'type' => 'select_shop_categories',
                            'options' => themedb_array('options', ''),
                            'value' => '',
                            'wrap' => false,
                        ));
                        ?>
                    </div>
                </div>
                <div class="column sixcol">
                    <div class="field-wrap">
                        <div class="element-select">
                            <span></span>
                            <?php
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'shop_country',
                                'type' => 'select_country',
                                'options' => themedb_array('options', $field),
                                'value' => esc_attr(ThemedbUser::$data['current']['profile']['billing_country']),
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="column sixcol last">
                    <div class="field-wrap">
                        <input type="text" name="shop_region" placeholder="<?php _e('Region', 'dealexport'); ?>">
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <?php if (ThemedbCore::checkOption('user_captcha')) { ?>
                <div class="element-captcha">
                    <img src="<?php echo THEMEDB_URI; ?>assets/images/captcha/captcha.php" alt="" />
                    <input style="width: 100px;" type="text" name="captcha" id="captcha" size="6" value="" />
                </div>
                <div class="clear"></div>
            <?php } ?>
            <a href="#" class="element-button element-submit"><?php _e('Register', 'dealexport'); ?></a>
            <input type="hidden" name="user_action" value="register_user" />
            <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
            <input type="submit" class="hidden" value="" />
        </form>
    </div>
<?php } else { ?>
    <div class="aligncenter mt-3">
        <strong> <?php _e('[:en]Please sign in if you want to see the products in our website[:fr]Veuillez vous connecter si vous souhaitez voir les produits sur notre site Web[:vi]
Vui lòng đăng nhập nếu bạn muốn xem các sản phẩm trong trang web của chúng tôi[:]', 'dealexport'); ?></strong>
    </div>
<?php } ?>

<!-- TODO TNH remove sign in div -->
<!-- <div class="column fourcol last">
    <div class="element-title">
        <h1><?php// _e('Sign In', 'dealexport'); ?></h1>
    </div>
    <form class="site-form element-form" method="POST" action="<?php //echo AJAX_URL; 
                                                                ?>">
        <div class="field-wrap">
            <input type="text" name="user_login" value="" placeholder="<?php// _e('Username', 'dealexport'); ?>">
        </div>
        <div class="field-wrap">
            <input type="password" name="user_password" value="" placeholder="<?php// _e('Password', 'dealexport'); ?>">
        </div>
        <a href="#" class="element-button element-submit"><?php//_e('Sign In', 'dealexport'); ?></a>
        <?php// if(ThemedbFacebook::isActive()) { ?>
        <a href="<?php //echo home_url('?facebook_login=1'); 
                    ?>" class="element-button element-facebook square facebook" title="<?php// _e('Sign in with Facebook', 'dealexport'); ?>"><span class="fa fa-facebook"></span></a>
        <?php //} 
        ?>
        <a href="#password_form" class="element-button element-colorbox square" title="<?php// _e('Password Recovery', 'dealexport'); ?>"><span class="fa fa-life-ring"></span></a>
        <input type="hidden" name="user_action" value="login_user" />
        <input type="hidden" name="action" class="action" value="<?php// echo THEMEDB_PREFIX; ?>update_user" />
        <input type="submit" class="hidden" value="" />
    </form>
</div>-->
<div class="clear"></div>
<?php ThemedbInterface::renderTemplateContent('register'); ?>
<?php get_footer(); ?>