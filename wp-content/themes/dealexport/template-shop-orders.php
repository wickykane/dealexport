<?php
/*
Template Name: Shop Orders
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('Shop Orders', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('shop-orders'); ?>
    <?php if(ThemedbCore::checkOption('shop_multiple')) { ?>
    <span class="secondary"><?php _e('This shop does not exist.', 'dealexport'); ?></span>
    <?php } else if(ThemedbShop::$data['status']!='publish') { ?>
    <span class="secondary"><?php _e('This shop is currently being reviewed.', 'dealexport'); ?></span>
    <?php } else if(empty(ThemedbShop::$data['orders'])) { ?>
    <span class="secondary"><?php _e('No orders received yet.', 'dealexport'); ?></span>	
    <?php } else { ?>
    <table>
        <thead>
            <tr>
                <th>&#8470;</th>
                <th><?php _e('Date', 'dealexport'); ?></th>
                <th><?php _e('Status', 'dealexport'); ?></th>
                <th><?php _e('Total', 'dealexport'); ?></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach(ThemedbShop::$data['orders'] as $ID) {
            $order=ThemedbWoo::getOrder($ID);
            ?>
            <tr>
                <td>
                    <a href="<?php echo ThemedbCore::getURL('shop-order', $order['ID']); ?>">
                        <?php echo $order['number']; ?>
                    </a>
                </td>
                <td>
                    <time datetime="<?php echo date('Y-m-d', strtotime($order['date'])); ?>" title="<?php echo esc_attr(strtotime($order['date'])); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($order['date'])); ?></time>
                </td>
                <td><?php echo $order['condition']; ?></td>
                <td><?php echo $order['total']; ?></td>
                <td class="textright">
                    <a href="<?php echo ThemedbCore::getURL('shop-order', $order['ID']); ?>" title="<?php _e('Edit', 'dealexport'); ?>" class="element-button small square secondary">
                        <span class="fa fa-pencil"></span>
                    </a>
                </td>
            </tr>
            <?php 
            }
            ?>
        </tbody>
    </table>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>