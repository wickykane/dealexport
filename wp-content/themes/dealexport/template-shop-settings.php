<?php
/*
Template Name: Shop
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Shop', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('shop-settings'); ?>
    <?php if(ThemedbCore::checkOption('shop_multiple')) { ?>
    <span class="secondary"><?php _e('This shop does not exist.', 'dealexport'); ?></span>
    <?php } else if(ThemedbShop::$data['status']=='pending') { ?>
    <span class="secondary"><?php _e('This shop is currently being reviewed.', 'dealexport'); ?></span>
    <?php } else { ?>
    <?php if(!empty(ThemedbShop::$data['ID'])) { ?>
    <form action="" method="POST" id="shop_form_<?php echo ThemedbShop::$data['ID']; ?>" class="site-form element-autosave" data-default="shop_form">
    <?php } else { ?>
    <form action="" method="POST" id="shop_form" class="site-form element-autosave">
    <?php } ?>
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <tr>
                    <th><?php _e('Name', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="title" value="<?php echo esc_attr(ThemedbShop::$data['profile']['title']); ?>" />
                        </div>
                    </td>
                </tr>
                <?php if(themedb_taxonomy('shop_category')) { ?>
                <tr>
                    <th><?php _e('Category', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'category',
                                'type' => 'select_category',
                                'taxonomy' => 'shop_category',
                                'value' => ThemedbShop::$data['profile']['category'],
                                'wrap' => false,				
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="profile-editor">
            <h5><?php _e('Description', 'dealexport'); ?></h5>
            <?php ThemedbInterface::renderEditor('content', ThemedbShop::$data['profile']['content']); ?>
        </div>
        <div class="profile-editor">
            <h5><?php _e('About', 'dealexport'); ?></h5>
            <?php ThemedbInterface::renderEditor('about', ThemedbShop::$data['profile']['about']); ?>
        </div>
        <div class="profile-editor">
            <h5><?php _e('Policies', 'dealexport'); ?></h5>
            <?php ThemedbInterface::renderEditor('policy', ThemedbShop::$data['profile']['policy']); ?>
        </div>
        <?php if(ThemedbShop::$data['status']=='draft') { ?>
            <?php if(ThemedbCore::checkOption('shop_approve')) { ?>
            <a href="#" class="element-button element-submit primary"><?php _e('Save Changes', 'dealexport'); ?></a>
            <?php } else { ?>
            <a href="#" class="element-button element-submit primary"><?php _e('Submit for Review', 'dealexport'); ?></a>
            <?php } ?>		
        <?php } else { ?>
        <a href="#" class="element-button element-submit primary"><?php _e('Save Changes', 'dealexport'); ?></a>
        <a href="<?php echo get_permalink(ThemedbShop::$data['ID']); ?>" target="_blank" title="<?php _e('View', 'dealexport'); ?>" class="element-button square secondary">
            <span class="fa fa-eye"></span>
        </a>
        <a href="#remove_form" title="<?php _e('Remove', 'dealexport'); ?>" class="element-button element-colorbox secondary square">
            <span class="fa fa-times"></span>
        </a>
        <?php } ?>
        <input type="hidden" name="shop_id" value="<?php echo ThemedbShop::$data['ID']; ?>" />
        <input type="hidden" name="shop_action" value="update_profile" />
    </form>
    <div class="site-popups hidden">
        <div id="remove_form">
            <div class="site-popup small">
                <form class="site-form" method="POST" action="">
                    <p><?php _e('Are you sure you want to permanently remove this shop?', 'dealexport'); ?></p>
                    <a href="#" class="element-button element-submit primary"><?php _e('Remove Shop', 'dealexport'); ?></a>
                    <input type="hidden" name="shop_id" value="<?php echo ThemedbShop::$data['ID']; ?>" />
                    <input type="hidden" name="shop_action" value="remove_shop" />
                </form>
            </div>
        </div>
    </div>
    <!-- /popups -->
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>