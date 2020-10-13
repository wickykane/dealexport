<?php get_header('shop'); ?> <!-- Mark: load header-shop.php to load the heading image for the shop -->
<div class="woocommerce">
    <?php	
    $woocommerce_loop['single']=true;
    $woocommerce_loop['columns']=4;	
    $products=array_merge(ThemedbShop::$data['products'], array(0));
    $limit=intval(themedb_value('limit', $_GET, ThemedbCore::getOption('products_per_page', 9)));
    $order=ThemedbWoo::getSorting();
    
    query_posts(array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'paged' => themedb_paged(),
        'posts_per_page' => $limit,
        'post__in' => $products,
        'orderby' => 'menu_order',
        'order' => 'ASC',
        'meta_key' => $order['meta_key'],
    ));
    
    $layout='full';
    $shop=$post->ID;
    
    ThemedbWoo::getTemplate('archive-product-shop.php');
    ?>
</div>
<?php get_footer(); ?>