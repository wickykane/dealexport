<?php
/*
Template Name: Profile Referrals
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Referrals', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile-referrals'); ?>
    <?php if(ThemedbCore::checkOption('shop_referrals') || !ThemedbWoo::isActive()) { ?>
    <span class="secondary"><?php _e('This page does not exist.', 'dealexport'); ?></span>
    <?php } else { ?>
        <form action="" method="POST" class="site-form">
            <table class="profile-fields">
                <tbody>
                    <tr>
                        <th><?php _e('Referral Link', 'dealexport'); ?></th>
                        <td>
                            <div class="field-wrap">
                                <input type="text" name="link" class="element-copy" readonly="readonly" value="<?php echo home_url('?ref='.ThemedbUser::$data['current']['login']); ?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Current Rate', 'dealexport'); ?></th>
                        <td><?php echo ThemedbCore::getOption('shop_rate_referral', '30'); ?>%</td>
                    </tr>
                    <tr>
                        <th><?php _e('Clickthroughs', 'dealexport'); ?></th>
                        <td><?php echo ThemedbUser::$data['current']['clicks']; ?></td>
                    </tr>
                </tbody>
            </table>
        </form>
        <?php
        $orders=ThemedbWoo::getReferrals(ThemedbUser::$data['current']['ID']);
        if(empty($orders)) {
        ?>
        <span class="secondary"><?php _e('No orders made yet.', 'dealexport'); ?></span>
        <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>&#8470;</th>
                    <th><?php _e('Date', 'dealexport'); ?></th>
                    <th><?php _e('Status', 'dealexport'); ?></th>
                    <th><?php _e('Total', 'dealexport'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach($orders as $ID) {
                $order=ThemedbWoo::getOrder($ID);
                ?>
                <tr>
                    <td><?php echo $order['number']; ?></td>
                    <td>
                        <time datetime="<?php echo date('Y-m-d', strtotime($order['date'])); ?>" title="<?php echo esc_attr(strtotime($order['date'])); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($order['date'])); ?></time>
                    </td>
                    <td><?php echo $order['condition']; ?></td>
                    <td><?php echo $order['total']; ?></td>
                </tr>
                <?php 
                }
                ?>
            </tbody>
        </table>
        <?php } ?>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>