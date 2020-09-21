<?php
/*
Template Name: Shop Products
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('Shop Items', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('shop-products'); ?>
    <?php if(ThemedbCore::checkOption('shop_multiple')) { ?>
    <span class="secondary"><?php _e('This shop does not exist.', 'dealexport'); ?></span>
    <?php } else if(ThemedbShop::$data['status']!='publish') { ?>
    <span class="secondary"><?php _e('This shop is currently being reviewed.', 'dealexport'); ?></span>
    <?php } else if(empty(ThemedbShop::$data['products'])) { ?>
    <p class="secondary"><?php _e('No items created yet.', 'dealexport'); ?></p>
    <?php } else { ?>
    <table class="profile-table">
        <thead>
            <tr>
                <th><?php _e('Name', 'dealexport'); ?></th>
                <th><?php _e('Stock', 'dealexport'); ?></th>
                <th><?php _e('Price', 'dealexport'); ?></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach(ThemedbShop::$data['products'] as $ID) {
            $product=ThemedbWoo::getProduct($ID);
            ?>
            <tr>
                <td>
                    <a href="<?php echo ThemedbCore::getURL('shop-product', $product['ID']); ?>" <?php if($product['status']=='draft') { ?>class="secondary"<?php } ?>>
                        <?php 
                        if(empty($product['title'])) {
                            _e('Untitled', 'dealexport');
                        } else {
                            echo $product['title'];
                        }
                        ?>
                    </a>
                </td>
                <td><?php echo $product['stock']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td class="textright nobreak">
                    <a href="<?php echo ThemedbCore::getURL('shop-product', $product['ID']); ?>" title="<?php _e('Edit', 'dealexport'); ?>" class="element-button small square secondary">
                        <span class="fa fa-pencil"></span>
                    </a>&nbsp;
                    <a href="<?php echo get_permalink($product['ID']); ?>" target="_blank" title="<?php _e('View', 'dealexport'); ?>" class="element-button small square secondary">
                        <span class="fa fa-eye"></span>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <?php if(ThemedbShop::$data['status']=='publish') { ?>
    <a href="<?php echo ThemedbCore::getURL('shop-product'); ?>" class="element-button primary"><?php _e('Add Item', 'dealexport'); ?></a>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>