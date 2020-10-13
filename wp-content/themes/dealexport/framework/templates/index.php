<div class="themedb-page themedb-interface">
    <form name="	options" id="themedb_options" method="POST" action="<?php echo admin_url('admin-ajax.php'); ?>">
        <div class="themedb-header">
            <h1 class="themedb-page-title"><?php _e('Theme Options','dealexport'); ?></h1>
            <input type="submit" name="<?php echo THEMEDB_PREFIX; ?>save_options" value="<?php _e('Save Changes','dealexport'); ?>" class="themedb-button disabled themedb-save-button" />
        </div>
        <div class="themedb-content">
            <div class="themedb-menu">
                <?php ThemedbInterface::renderMenu(); ?>
            </div>
            <div class="themedb-sections">				
                <?php self::renderSections(); ?>				
            </div>
        </div>	
        <div class="themedb-footer">
            <input type="submit" name="<?php echo THEMEDB_PREFIX; ?>reset_options" value="<?php _e('Reset Options','dealexport'); ?>" class="themedb-button themedb-reset-button" />
            <input type="submit" name="<?php echo THEMEDB_PREFIX; ?>save_options" value="<?php _e('Save Changes','dealexport'); ?>" class="themedb-button disabled themedb-save-button" />
        </div>
        <div class="themedb-popup"></div>
    </form>
</div>
<?php if(isset($_GET['activated'])) { ?>
<iframe class="hidden" src="<?php echo admin_url('options-permalink.php'); ?>"></iframe>
<?php } ?>