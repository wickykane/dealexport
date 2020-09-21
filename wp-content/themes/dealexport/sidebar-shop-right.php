<div class="widget sidebar-widget" style="margin-top: 2em;">
    <div class="widget-title">
        <h4><?php _e('Owner', 'dealexport'); ?></h4>
    </div>
    <div class="widget-content">
        <?php $author = ThemedbUser::getUser(ThemedbShop::$data['author'], true); ?>
        <div class="shop-author small clearfix">
            <div class="author-image">
                <div class="image-wrap">
                    <a href="<?php echo esc_url($author['links']['profile']['url']); ?>">
                        <?php echo get_avatar($author['ID'], 150); ?>	
                    </a>
                </div>
            </div>
            <div class="author-details">
                <h4 class="author-name">
                    <a href="<?php echo esc_url($author['links']['profile']['url']); ?>">
                        <?php echo $author['profile']['full_name']; ?>
                    </a>
                </h4>
                <?php if (!empty($author['profile']['location']) && !ThemedbCore::checkOption('profile_location')) { ?>
                    <div class="shop-attributes">
                        <ul>
                            <li>
                                <span class="fa fa-map-marker"></span>
                                <span><?php echo $author['profile']['location']; ?></span>
                            </li>
                        </ul>										
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php 
// disbale policy and about content
if(false) {?>
<?php if (!empty(ThemedbShop::$data['profile']['about']) || !empty(ThemedbShop::$data['profile']['policy'])) { ?>
    <div class="site-popups hidden">
        <div id="about_page">
            <div class="site-popup">
                <?php echo apply_filters('the_content', ThemedbShop::$data['profile']['about']); ?>
            </div>
        </div>
        <div id="policy_page">
            <div class="site-popup">
                <?php echo apply_filters('the_content', ThemedbShop::$data['profile']['policy']); ?>
            </div>
        </div>
    </div>
    <!-- /popups -->
    <div class="widget sidebar-widget">
        <div class="widget-title">
            <h4><?php _e('Pages', 'dealexport'); ?></h4>
        </div>
        <ul>
            <?php if (!empty(ThemedbShop::$data['profile']['about'])) { ?>
                <li><a href="#about_page" class="element-colorbox"><?php _e('About Shop', 'dealexport'); ?></a></li>
            <?php } ?>
            <?php if (!empty(ThemedbShop::$data['profile']['policy'])) { ?>
                <li><a href="#policy_page" class="element-colorbox"><?php _e('Shop Policies', 'dealexport'); ?></a></li>
            <?php } ?>
        </ul>		
    </div>
<?php } ?>
<?php }?>
<div class="widget sidebar-widget">
    <div class="widget-title">
        <h4><?php _e('Files', 'dealexport'); ?></h4>
    </div>
    <ul>
        <?php
        $shop_id = $GLOBALS['post']->ID;
        $shop_file_arr = get_field('shop_file', $shop_id);

        if (!empty($shop_file_arr)):
            foreach ($shop_file_arr as $shop_file_data) {
                $file_url = $shop_file_data['file']['url'];
                $file_name = $shop_file_data['file']['title'];
                ?>
                <li>
                    <a href="<?php echo $file_url; ?>" target="blank"><?php echo $file_name; ?></a>
                </li>
                <?php
            }
        endif;
        ?>
    </ul>		
</div>
<?php ThemedbSidebar::renderSidebar('shop'); ?>