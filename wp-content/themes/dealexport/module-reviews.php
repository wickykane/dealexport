<div class="widget widget-slider sidebar-widget">
    <div class="widget-title">
        <h4><?php _e('Reviewed Items', 'dealexport'); ?></h4>
    </div>
    <ul>
        <?php foreach(ThemedbShop::$data['reviews'] as $ID) { ?>
        <li><?php echo get_the_title($ID); ?></li>
        <?php } ?>
    </ul>
</div>