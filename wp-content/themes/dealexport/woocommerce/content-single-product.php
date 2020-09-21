<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

global $product;

if(ThemedbUser::isMember($post->post_author)) {

do_action('woocommerce_before_single_product');
if (post_password_required()) {
    echo get_the_password_form();
    return;
}

$product_other_info = get_field('product_other_info', $post->id);
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <aside class="column fivecol">
        <?php		
        do_action('woocommerce_before_single_product_summary');
        
        ?>
        <?php
        
        $shop=ThemedbUser::getShop($post->post_author);		
        if(!empty($shop)) {
            ThemedbShop::refresh($shop);
            get_template_part('module', 'shop');
        }
        
        ThemedbSidebar::renderSidebar('product');
        ?>
    </aside>
    <div class="item-full column sixcol last">
        <?php do_action('woocommerce_single_product_summary'); ?>
    </div>

    
    
    <?php 
    /**
      * Render product tab
      */
    
    if($product_other_info){?>
    <div class="product-other-info column twelvecol">
    <?php 
        $tab_shortcode = '[vc_tta_tabs el_class="shop_tab"]';
        if (!empty($product_other_info)):
            foreach ($product_other_info as $index=>$tab) {
                $tab_shortcode .= '[vc_tta_section title="'.$tab['product_tab_title'].'" tab_id="tab-'.$post->ID.'-'.$index.'"]';
                $tab_shortcode .= $tab['product_tab_content'];
                $tab_shortcode .= '[/vc_tta_section]';
            }
            $tab_shortcode .= '[/vc_tta_tabs]';
        endif;
        echo do_shortcode($tab_shortcode);
    ?>  
     </div>
     <?php }?>
    <?php  $show=false;
        ob_start();?>
    <div class="item-full column eightcol last" style="margin-top: 1.5em;">
            <div class="element-title">
                <h1 class="product_title entry-title"><?php _e('Additional Field', 'dealexport'); ?></h1>
            </div>
            <div class="item-details">
                <div class="item-attributes">
                    <ul style="list-style: none;">
                        <?php 
                        if($product->enable_dimensions_display()) {
                            if($product->has_weight()) {
                            $show=true;
                            ?>
                            <li class="clearfix">
                                <div class="halfcol left"><?php _e('Weight', 'dealexport'); ?></div>
                                <div class="halfcol right"><?php echo $product->get_weight().' '.esc_attr(get_option('woocommerce_weight_unit')); ?></div>
                            </li>
                            <?php
                            }
                            if($product->has_dimensions()) {
                            $show=true;
                            ?>
                            <li class="clearfix">
                                <div class="halfcol left"><?php _e('Dimensions', 'dealexport'); ?></div>
                                <div class="halfcol right"><?php echo $product->get_dimensions(); ?></div>
                            </li>
                            <?php
                            }
                        }
                        
                        foreach($product->get_attributes() as $attribute) {
                        if(empty($attribute['is_visible']) || ($attribute['is_taxonomy'] && !taxonomy_exists($attribute['name']))) {
                            continue;
                        } else {
                            $show=true;
                        }
                        ?>
                        <li class="clearfix">
                            <div class="halfcol left"><?php echo wc_attribute_label($attribute['name']); ?></div>
                            <div class="halfcol right">
                            <?php
                            if($attribute['is_taxonomy']) {
                                $values=wc_get_product_terms($product->id, $attribute['name'], array('fields' => 'names'));
                                echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);
                            } else {
                                $values=array_map('trim', explode(WC_DELIMITER, $attribute['value']));
                                echo apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values);
                            }
                            ?>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                </div>							
            </div>
    </div>
    <?php if($show) {
            echo ob_get_clean();
        } else {
            ob_end_clean();
        }?>
    <div class="clear"></div>
    <?php do_action('woocommerce_after_single_product_summary'); ?>
    <meta itemprop="url" content="<?php the_permalink(); ?>" />
</div>
<?php do_action('woocommerce_after_single_product'); ?>
<?php } else { ?>
<h3><?php _e('This product is hidden because of the membership limit.','dealexport'); ?></h3>
<p><?php _e('Sorry, it is hidden because of the membership limit, upgrade or try removing a few products.','dealexport'); ?></p>
<?php } ?>