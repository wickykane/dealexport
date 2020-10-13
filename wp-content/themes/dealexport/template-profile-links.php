<?php
/*
Template Name: Profile Links
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Links', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile-links'); ?>
    <?php if(ThemedbCore::checkOption('profile_links')) { ?>
    <span class="secondary"><?php _e('There are no fields in this form.', 'dealexport'); ?></span>
    <?php } else { ?>
    <form action="" method="POST" class="site-form">
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <?php foreach(ThemedbCore::$components['forms']['links'] as $field) { ?>
                <tr>							
                    <th><?php echo $field['label']; ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_url(esc_attr(ThemedbUser::$data['current']['profile'][$field['name']])); ?>" />
                        </div>
                    </td>							
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="#" class="element-button element-submit primary"><?php _e('Save Changes', 'dealexport'); ?></a>
        <input type="hidden" name="user_action" value="update_profile" />
    </form>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>