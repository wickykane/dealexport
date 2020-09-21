<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

global $post, $product, $woocommerce;
$shop_id = get_the_ID();
$image_arr = get_field('shop_images');
$video_arr = get_field('shop_videos', $shop_id);

$colorbox='';
$video_colorbox='video-colorbox';
if(get_option('woocommerce_enable_lightbox')=='yes') {
    $colorbox='element-colorbox';
}

if($image_arr || $video_arr) {
?>
<div class="item-gallery clearfix">
    <?php
    $loop=0;
    $columns=3;

    foreach($image_arr as $item){
        $classes=array();
        $image_data = $item['image'];
        $image_id = $image_data['id'];
        $image_title = esc_attr($image_data['title']);
        
        if($loop==0 || $loop % $columns==0) {
            $classes[]='first';
        }			

        if(($loop + 1)% $columns==0) {
            $classes[]='last';
        }			

        $image_url = wp_get_attachment_url( $image_id );
        if(!$image_url) {
            continue;
        }			
        $image_resize_link = generateCustomImageThumbnail($image_url);
        $image = $image_resize_link;
        $image_class = esc_attr(implode(' ', $classes));
        
        ?>
        <div class="thirdcol left">
            <div class="image-wrap shop-thumbnail">
                <?php echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<a href="%s" class="%s %s" title="%s" data-rel="gallery">%s</a>',
                                $image_url, $image_class, $colorbox, $image_title, $image), $image_id, $shop_id, $image_class); ?>
            </div>
        </div>
        <?php
        $loop++;
    }
    ?>
    
    <?php
    if($video_arr) {
        $vd_loop=0;
        $vd_columns=3;
    
        foreach($video_arr as $video_data){
            $classes=array();
    
            if($vd_loop==0 || $vd_loop % $vd_columns==0) {
                $classes[]='first';
            }			
    
            if(($vd_loop + 1)% $vd_columns==0) {
                $classes[]='last';
            }			
    
            $video_link = $video_data['url'];
            if(!$video_link) {
                continue;
            }			
            $video_id = get_video_id($video_link);
            $video_embeb_link = 'https://www.youtube.com/embed/'. $video_id .'?rel=0&showinfo=0&color=white&iv_load_policy=3';
            $id_video_iframe = '#iframe_'.$video_id;
            $dom_video_id = '#thumbnail_'.$video_id;
            $video_thumbnail = '<img width="180" height="180" src="http://i.ytimg.com/vi/' . $video_id . '/mqdefault.jpg" class="attachment-shop_thumbnail video-shop-thumbnail video-thumbnail" alt="">';

            $video_class=esc_attr(implode(' ', $classes));
            $video_title=esc_attr(get_the_title($video_data['id']));
            ?>
            <div class="thirdcol left">
                <div class="image-wrap">
                    <?php echo apply_filters('woocommerce_single_product_image_thumbnail_html',
                                                sprintf('<a href="%s" class="%s %s" title="%s" data-rel="gallery">%s</a>',
                                                $video_embeb_link, $video_class, $video_colorbox, $video_title, $video_thumbnail), $video_id, $shop_id, $video_class); ?>
                  </div>
            </div>
            <?php
            $vd_loop++;
        }
    }
    ?>
</div>
<?php } ?>