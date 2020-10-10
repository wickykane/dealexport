<?php
/*
Template Name: Profile Settings
*/
?>
<?php get_header(); ?>
<div class="mt-3">
  <?php get_sidebar('profile-left'); ?>
  <div class="column fivecol">
    <div class="element-title indented">
      <h1><?php _e('My Settings', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile-settings'); ?>
    <form action="" method="POST" class="site-form">
      <div class="message">
        <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
      </div>
      <table class="profile-fields">
        <tbody>
          <tr>
            <th><?php _e('Notifications', 'dealexport'); ?></th>
            <td>
              <div class="element-select">
                <span></span>
                <?php
                echo ThemedbInterface::renderOption(array(
                  'id' => 'notices',
                  'type' => 'select',
                  'value' => esc_attr(ThemedbUser::$data['current']['settings']['notices']),
                  'options' => array(
                    '1' => __('Enabled', 'dealexport'),
                    '0' => __('Disabled', 'dealexport'),
                  ),
                  'wrap' => false,
                ));
                ?>
              </div>
            </td>
          </tr>
          <tr>
            <th><?php _e('Email Address', 'dealexport'); ?></th>
            <td>
              <div class="field-wrap">
                <input type="text" name="email" value="<?php echo esc_attr(ThemedbUser::$data['current']['email']); ?>" />
              </div>
            </td>
          </tr>
          <tr>
            <th><?php _e('New Password', 'dealexport'); ?></th>
            <td>
              <div class="field-wrap">
                <input type="password" name="new_password" value="" />
              </div>
            </td>
          </tr>
          <tr>
            <th><?php _e('Confirm Password', 'dealexport'); ?></th>
            <td>
              <div class="field-wrap">
                <input type="password" name="confirm_password" value="" />
              </div>
            </td>
          </tr>
          <?php if (ThemedbFacebook::isUpdated(ThemedbUser::$data['current']['ID'])) { ?>
            <tr>
              <th><?php _e('Current Password', 'dealexport'); ?></th>
              <td>
                <div class="field-wrap">
                  <input type="password" name="current_password" value="" />
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
      <a href="#" class="element-button element-submit btn-my-account"><?php _e('Save Changes', 'dealexport'); ?></a>
      <input type="hidden" name="user_action" value="update_settings" />
    </form>
  </div>
  <?php get_sidebar('profile-right'); ?>
</div>
<?php get_footer(); ?>