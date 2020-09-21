<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

$view=ThemedbCore::getOption('products_view', 'grid');
?>
<div class="items-view left">
    <form action="<?php echo themedb_url(); ?>" method="GET" class="woocommerce-ordering">
        <?php if($view=='grid') { ?>
        <a href="#view" title="<?php _e('Grid View', 'dealexport'); ?>" class="element-submit <?php if(themedb_value('view', $_GET, 'grid')=='grid') { ?>active<?php } ?>" data-value="grid"><span class="fa fa-th-large"></span></a>
        <a href="#view" title="<?php _e('List View', 'dealexport'); ?>" class="element-submit <?php if(themedb_value('view', $_GET)=='list') { ?>active<?php } ?>" data-value="list"><span class="fa fa-th-list"></span></a>
        <?php } else { ?>		
        <a href="#view" title="<?php _e('List View', 'dealexport'); ?>" class="element-submit <?php if(themedb_value('view', $_GET, 'list')=='list') { ?>active<?php } ?>" data-value="list"><span class="fa fa-th-list"></span></a>
        <a href="#view" title="<?php _e('Grid View', 'dealexport'); ?>" class="element-submit <?php if(themedb_value('view', $_GET)=='grid') { ?>active<?php } ?>" data-value="grid"><span class="fa fa-th-large"></span></a>
        <?php } ?>		
        <input type="hidden" name="view" id="view" value="<?php echo themedb_value('view', $_GET, $view); ?>" />
        <?php
        foreach($_GET as $key => $value) {
            if(!in_array($key, array('submit', 'view'))) {			
                if (is_array($value)) {
                    foreach($value as $item) {
                        echo '<input type="hidden" name="'.esc_attr($key).'[]" value="'.esc_attr($item).'" />';
                    }
                } else {
                    echo '<input type="hidden" name="'.esc_attr($key).'" value="'.esc_attr($value).'" />';
                }
            }
        }
        ?>
    </form>
</div>