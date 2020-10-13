<?php
/*
@version 3.0.0
*/

if(!defined('ABSPATH')) {
    exit;
}

global $product, $post;

$parent_product_post=$post;

do_action('woocommerce_before_add_to_cart_form'); 
?>
<form class="cart" method="post" enctype='multipart/form-data'>
    <table cellspacing="0" class="group_table">
        <tbody>
            <?php
                foreach($grouped_products as $product_id){
                    $product=wc_get_product($product_id);
                    $post=$product->post;
                    setup_postdata($post);
                    ?>
                    <tr>
                        <td>
                            <?php if($product->is_sold_individually() || ! $product->is_purchasable()) { ?>
                                <?php woocommerce_template_loop_add_to_cart(); ?>
                            <?php } else { ?>
                                <?php
                                    $quantites_required=true;
                                    woocommerce_quantity_input(array('input_name'=> 'quantity['.$product_id.']', 'input_value'=> '0'));
                                ?>
                            <?php } ?>
                        </td>
                        <td class="label">
                            <label for="product-<?php echo $product_id; ?>">
                                <?php echo $product->is_visible() ? '<a href="'.get_permalink().'">'.get_the_title().'</a>' : get_the_title(); ?>
                            </label>
                        </td>
                        <?php do_action('woocommerce_grouped_product_list_before_price', $product); ?>
                        <td class="price">
                            <?php
                                echo $product->get_price_html();

                                if($availability=$product->get_availability()){
                                    $availability_html=empty($availability['availability'])? '' : '<p class="stock '.esc_attr($availability['class']). '">'.esc_html($availability['availability']). '</p>';
                                    echo apply_filters('woocommerce_stock_html', $availability_html, $availability['availability'], $product);
                                }
                            ?>
                        </td>
                    </tr>
                    <?php
                }

                $post=$parent_product_post;
                $product=wc_get_product($parent_product_post->ID);
                setup_postdata($parent_product_post);
            ?>
        </tbody>
    </table>
    <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->id); ?>" />
    <?php if($quantites_required) { ?>
    <div class="item-options clearfix">
        <?php do_action('woocommerce_before_add_to_cart_button'); ?>
        <a href="#" class="element-button element-submit primary"><?php echo $product->single_add_to_cart_text(); ?></a>
        <?php do_action('woocommerce_after_add_to_cart_button'); ?>
    <?php } ?>
    </div>
</form>
<?php do_action('woocommerce_after_add_to_cart_form'); ?>