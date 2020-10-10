<?php
/*
Template Name: Profile Address
*/
?>
<?php get_header(); ?>
<div class="mt-3">
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Address', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile-address'); ?>
    <?php if(!ThemedbWoo::isActive() || ThemedbCore::checkOption('profile_address')) { ?>
    <span class="secondary"><?php _e('There are no fields in this form.', 'dealexport'); ?></span>
    <?php } else { ?>
    <form action="" method="POST" class="site-form">
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <?php foreach(ThemedbCore::$components['forms']['address'] as $field) { ?>
                <tr>
                    <th><?php echo $field['label']; ?></th>
                    <td>
                        <?php if(in_array($field['type'], array('select', 'select_country'))) { ?>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => $field['name'],
                                'type' => $field['type'],
                                'options' => themedb_array('options', $field),
                                'value' => esc_attr(ThemedbUser::$data['current']['profile']['billing_country']),
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                        <?php } else { ?>
                        <div class="field-wrap">
                            <input type="text" name="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr(ThemedbUser::$data['current']['profile'][$field['name']]); ?>" />
                        </div>
                        <?php } ?>
                    </td>							
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="#" class="element-button element-submit btn-my-account"><?php _e('Save Changes', 'dealexport'); ?></a>
        <input type="hidden" name="user_action" value="update_profile" />
    </form>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
</div>
<?php get_footer(); ?>