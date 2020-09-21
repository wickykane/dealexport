<?php
/*
Template Name: Profile
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Profile', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile'); ?>
    <form action="" method="POST" class="site-form">
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <?php 
                foreach(ThemedbCore::$components['forms']['profile'] as $field) {
                
                if(in_array($field['name'], array('first_name', 'last_name')) && ThemedbCore::checkOption('profile_name')) {
                    continue;
                }
                
                if(in_array($field['name'], array('billing_country', 'billing_city')) && ThemedbCore::checkOption('profile_location')) {
                    continue;
                }
                ?>
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
                <?php ThemedbForm::renderData('profile', array(
                    'edit' => true,
                    'placeholder' => false,
                    'before_title' => '<tr><th>',
                    'after_title' => '</th>',
                    'before_content' => '<td>',
                    'after_content' => '</td></tr>',
                ), ThemedbUser::$data['current']['profile']); ?>
            </tbody>
        </table>
        <div class="profile-editor">
            <?php ThemedbInterface::renderEditor('description', ThemedbUser::$data['current']['profile']['description']); ?>
        </div>
        <a href="#" class="element-button element-submit btn-my-account"><?php _e('Save Changes', 'dealexport'); ?></a>
        <input type="hidden" name="user_action" value="update_profile" />
    </form>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>