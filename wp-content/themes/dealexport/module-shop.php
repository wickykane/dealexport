<div class="widget sidebar-widget">
    <div class="widget-title">
        <h4><?php _e('Shop', 'dealexport'); ?></h4>
    </div>
    <?php if(ThemedbShop::$data['status']!='publish') { ?>
    <span class="secondary"><?php _e('No shop created yet.', 'dealexport'); ?></span>
    <?php } else { ?>
    <div class="shop-author clearfix">		
        <div class="author-image">
            <div class="image-wrap">
                <a href="<?php echo get_permalink(ThemedbShop::$data['ID']); ?>">
                    <?php echo ThemedbCore::getImage(ThemedbShop::$data['ID'], 150, THEME_URI.'images/shop.png'); ?>
                </a>
            </div>									
        </div>
        <div class="author-details">
            <h4 class="author-name">
                <a href="<?php echo get_permalink(ThemedbShop::$data['ID']); ?>"><?php echo ThemedbShop::$data['profile']['title']; ?></a>
            </h4>
            <div class="shop-attributes">
                <ul>
                    <?php if(!ThemedbCore::checkOption('shop_sales')) { ?>
                    <li>
                        <span class="fa fa-tags"></span>
                        <span><?php echo sprintf(_n('%d Sale', '%d Sales', ThemedbShop::$data['sales'], 'dealexport'), ThemedbShop::$data['sales']);?></span>
                    </li>
                    <?php } ?>
                    <?php if(!ThemedbCore::checkOption('shop_favorites')) { ?>
                    <li>
                        <span class="fa fa-heart"></span>
                        <span><?php echo sprintf(_n('%d Admirer', '%d Admirers', ThemedbShop::$data['admirers'], 'dealexport'), ThemedbShop::$data['admirers']);?></span>
                    </li>
                    <?php } ?>
                </ul>										
            </div>
        </div>
    </div>
    <?php } ?>
</div>