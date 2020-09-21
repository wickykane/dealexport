<?php ThemedbShop::refresh($post->ID); ?>
<?php $owner = ThemedbUser::getUser(ThemedbShop::$data['author']); ?>
<div class="shop-preview">
    <div class="shop-images clearfix">
        <?php if (count(ThemedbShop::$data['products']) == 1) { ?>
            <?php $product = reset(ThemedbShop::$data['products']); ?>
            <div class="item-image fullwidth">
                <div class="image-wrap">
                    <a href="<?php echo get_permalink($product); ?>" title="<?php echo get_the_title($product); ?>">
                        <?php echo generateCustomImageThumbnail(wp_get_attachment_url(get_post_thumbnail_id($product)));?>
                    </a>
                </div>
            </div>
        <?php } else { ?>
            <?php
            $count_rand = 4;
            if (count(ThemedbShop::$data['products']) < 4 && count(ThemedbShop::$data['products']) > 1) {
                $count_rand = count(ThemedbShop::$data['products']);
            } elseif (count(ThemedbShop::$data['products']) < 1) {
                $count_rand = 1;
            }
            if (!empty(ThemedbShop::$data['products'])):
                $product_random_arr = array_rand(ThemedbShop::$data['products'], $count_rand);
            endif;
            ?>

            <?php
            if (!empty($product_random_arr)):
                foreach ($product_random_arr as $index) {
                    ?>
                    <div class="item-image">
                        <div class="image-wrap shop-thumbnail">                
                            <?php if (isset(ThemedbShop::$data['products'][$index])) { ?>
                                <a href="<?php echo get_permalink(ThemedbShop::$data['products'][$index]); ?>" title="<?php echo get_the_title(ThemedbShop::$data['products'][$index]); ?>">
                                    <?php echo generateCustomImageThumbnail(wp_get_attachment_url(get_post_thumbnail_id(ThemedbShop::$data['products'][$index])));?>
                                </a>
                            <?php } else { ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo THEME_URI . 'images/product.png'; ?>" alt="" />
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            endif;
            ?>
        <?php } ?>
    </div>
    <footer class="shop-footer">
        <div class="shop-author clearfix">
            <div class="author-image">
                <div class="image-wrap">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo generateCustomImageThumbnail(wp_get_attachment_url(get_post_thumbnail_id(ThemedbShop::$data['ID'])),300,300,2,'images/shop.png');?>
                    </a>
                </div>									
            </div>
            <div class="author-details">
                <h3 class="author-name">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>
                <div class="shop-attributes">
                    <ul>						
                        <li>
                            <?php if (!empty($owner['profile']['location']) && !ThemedbCore::checkOption('profile_location')) { ?>
                                <span class="fa fa-map-marker"></span>
                                <span><?php echo $owner['profile']['location']; ?></span>
                            <?php } else if (!ThemedbCore::checkOption('shop_favorites')) { ?>
                                <span class="fa fa-heart"></span>
                                <span><?php echo sprintf(_n('%d Admirer', '%d Admirers', ThemedbShop::$data['admirers'], 'dealexport'), ThemedbShop::$data['admirers']); ?></span>
                            <?php } else if (!ThemedbCore::checkOption('shop_sales')) { ?>
                                <span class="fa fa-tags"></span>
                                <span><?php echo sprintf(_n('%d Sale', '%d Sales', ThemedbShop::$data['sales'], 'dealexport'), ThemedbShop::$data['sales']); ?></span>
                            <?php } ?>
                        </li>						
                    </ul>
                </div>
                <?php if (!ThemedbCore::checkOption('shop_rating')) { ?>
                    <div class="shop-rating" title="<?php echo sprintf(_n('%d Rating', '%d Ratings', ThemedbShop::$data['ratings'], 'dealexport'), ThemedbShop::$data['ratings']); ?>">
                        <div class="element-rating" data-score="<?php echo ThemedbShop::$data['rating']; ?>"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </footer>
</div>