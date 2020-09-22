<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}
?>
<?php if(get_option('users_can_register')) { ?>
<div class="column eightcol">
    <div class="element-title">
        <h1><?php _e('Register', 'dealexport'); ?></h1>
    </div>
    <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
        <div class="column sixcol">
            <div class="field-wrap">
                <input type="text" name="user_login" placeholder="<?php _e('Username', 'dealexport'); ?>">
            </div>
        </div>
        <div class="column sixcol last">
            <div class="field-wrap">
                <input type="text" name="user_email" placeholder="<?php _e('Email', 'dealexport'); ?>">
            </div>
        </div>
        <div class="clear"></div>
        <div class="column sixcol">
            <div class="field-wrap">
                <input type="password" name="user_password" placeholder="<?php _e('Password', 'dealexport'); ?>">
            </div>
        </div>
        <div class="column sixcol last">
            <div class="field-wrap">
                <input type="password" name="user_password_repeat" placeholder="<?php _e('Repeat Password', 'dealexport'); ?>">
            </div>
        </div>		
        <a href="#" class="element-button element-submit primary"><?php _e('Register', 'dealexport'); ?></a>
        <input type="hidden" name="user_action" value="register_user" />
        <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
    </form>
</div>
<?php } ?>
<div class="column fourcol last">
    <div class="element-title">
        <h1><?php _e('[:en]Sign In[:fr]Se connecter[:vi]Đăng nhập[:]', 'dealexport'); ?></h1>
    </div>
    <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
        <div class="field-wrap">
            <input type="text" name="user_login" value="" placeholder="<?php _e('Username', 'dealexport'); ?>">
        </div>
        <div class="field-wrap">
            <input type="password" name="user_password" value="" placeholder="<?php _e('Password', 'dealexport'); ?>">
        </div>
        <a href="#" class="element-button element-submit"><?php _e('[:en]Sign In[:fr]Se connecter[:vi]Đăng nhập[:]', 'dealexport'); ?></a>
        <?php if(ThemedbFacebook::isActive()) { ?>
        <a href="<?php echo home_url('?facebook_login=1'); ?>" class="element-button element-facebook square facebook" title="<?php _e('Sign in with Facebook', 'dealexport'); ?>"><span class="fa fa-facebook"></span></a>
        <?php } ?>
        <a href="#password_form" class="element-button element-colorbox square" title="<?php _e('Password Recovery', 'dealexport'); ?>"><span class="fa fa-life-ring"></span></a>
        <input type="hidden" name="user_action" value="login_user" />
        <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
    </form>
</div>
<div class="clear"></div>
<?php ThemedbInterface::renderTemplateContent('register'); ?>