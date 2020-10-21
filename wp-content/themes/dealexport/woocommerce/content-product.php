<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

if(empty($woocommerce_loop['columns'])) {
    $woocommerce_loop['columns']=apply_filters('loop_shop_columns', 3);
}

if(empty($woocommerce_loop['loop'])) {
    $woocommerce_loop['loop']=0;
}

$width='four';
if($woocommerce_loop['columns']==4) {
    $width='three';
}

if($woocommerce_loop['columns']==5) {
    $width='two';
}
    
$shop=ThemedbUser::getShop($post->post_author);
if(!$product || !$product->is_visible()) {
    return;
}

if(!isset($woocommerce_loop['view'])) {
    $woocommerce_loop['view']='grid';
}

$woocommerce_loop['loop']++;
if($woocommerce_loop['view']=='grid') {
?>
<div class="column <?php echo $width; ?>col <?php if($woocommerce_loop['loop']%$woocommerce_loop['columns']==0) { ?>last<?php } ?>">    
    <div class="item-preview">
        <div class="item-image">
            <?php 
            /**
             * Hook: woocommerce_before_shop_loop_item.
             *
             * @hooked woocommerce_template_loop_product_link_open - 10
             */
            do_action('woocommerce_before_shop_loop_item'); 
            ?>
            <div class="image-wrap">
                <a href="<?php the_permalink(); ?>">
                    <?php 
                        echo generateCustomImageThumbnail(wp_get_attachment_url(get_post_thumbnail_id($product->id)), 600, 600);
                    ?>
                </a>
            </div>
            <?php 
            /**
             * Hook: woocommerce_before_shop_loop_item_title.
             *
             * @hooked woocommerce_show_product_loop_sale_flash - 10
             * @hooked woocommerce_template_loop_product_thumbnail - 10
             */
            do_action('woocommerce_before_shop_loop_item_title'); 
            ?>

            <?php 
            /**
             * DISABLED
             * Hook: woocommerce_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_product_title - 10
             */
            //do_action( 'woocommerce_shop_loop_item_title' );
            ?>

        </div>
        <div class="item-details">          
            <h3 class="item-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php if(!empty($shop)) { ?>
            <div class="author-name"><a href="<?php echo get_permalink($shop); ?>"><?php echo get_the_title($shop); ?></a></div>
            <?php } ?>
        </div>
        <footer class="item-footer clearfix">
            <?php 
            /**
             * Hook: woocommerce_after_shop_loop_item_title.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title'); 
            ?>
            <?php 
            if(ThemedbUser::isMember($post->post_author)) {
                /**
                 * Hook: woocommerce_after_shop_loop_item.
                 *
                 * @hooked woocommerce_template_loop_product_link_close - 5
                 * @hooked woocommerce_template_loop_add_to_cart - 10
                 */
                do_action('woocommerce_after_shop_loop_item'); 
            }
            ?>
        </footer>
    </div>
</div>
<?php } else { ?>
<div class="item-full clearfix">
    <div class="column fourcol">
        <div class="item-preview">
            <div class="item-image">
                <div class="image-wrap">
                    <a href="<?php the_permalink(); ?>"><?php woocommerce_template_loop_product_thumbnail(); ?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="column eightcol last">
        <div class="element-title">
            <h1 itemprop="name" class="product_title entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <?php woocommerce_template_single_rating(); ?>
        </div>
        <?php 
        if(ThemedbUser::isMember($post->post_author)) {
            woocommerce_template_single_add_to_cart(); 
        }
        ?>
        <div class="item-details">
            <?php the_excerpt(); ?>
        </div>
    </div>
</div>
<?php } ?>