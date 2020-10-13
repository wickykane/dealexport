<?php
/*
Template Name: Profile Earnings
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <h1><?php _e('My Earnings', 'dealexport'); ?></h1>
    </div>
    <?php ThemedbInterface::renderTemplateContent('profile-earnings'); ?>
    <?php if(ThemedbCore::checkOption('shop_multiple') && ThemedbCore::checkOption('shop_referrals')) { ?>
    <span class="secondary"><?php _e('This page does not exist.', 'dealexport'); ?></span>
    <?php 
    } else {
    
    ThemedbShop::refresh(ThemedbUser::$data['current']['shop'], true);	
    $withdrawals=ThemedbShop::$data['withdrawals'];
    if(empty(ThemedbUser::$data['current']['shop'])) {
        $withdrawals=ThemedbShop::getWithdrawals(ThemedbUser::$data['current']['ID']);
    }
    
    if(!empty($withdrawals)) {
    ?>
    <table class="profile-table">
        <thead>
            <tr>				
                <th><?php _e('Date', 'dealexport'); ?></th>
                <th><?php _e('Method', 'dealexport'); ?></th>
                <th><?php _e('Amount', 'dealexport'); ?></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($withdrawals as $ID) {
            $withdrawal=ThemedbShop::getWithdrawal($ID);
            ?>
            <tr>
                <td><?php echo date_i18n(get_option('date_format'), strtotime($withdrawal['date'])); ?></td>
                <td>
                    <?php _e('via', 'dealexport'); ?>
                    <?php echo $withdrawal['method']['label']; ?>
                    <?php _e('to', 'dealexport'); ?>
                    <?php 
                    $recipient=array();
                    foreach(ThemedbCore::$components['forms']['withdrawal'][$withdrawal['method']['name']] as $field) { 
                        $recipient[]=$withdrawal[$field['name']];
                    }
                    echo implode(', ', $recipient);
                    ?>
                </td>
                <td><?php echo ThemedbWoo::getPrice($withdrawal['amount']); ?></td>
                <td class="textright">
                    <form action="" method="POST">
                        <a href="#" title="<?php _e('Remove', 'dealexport'); ?>" class="element-button element-submit small square secondary">
                            <span class="fa fa-times"></span>
                        </a>
                        <input type="hidden" name="withdrawal_id" value="<?php echo $withdrawal['ID']; ?>" />
                        <input type="hidden" name="shop_action" value="remove_withdrawal" />
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <form action="" method="POST" class="site-form">
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <?php if(!ThemedbCore::checkOption('shop_multiple') && ThemedbShop::$data['status']=='publish') { ?>
                <tr>
                    <th><?php _e('Total Revenue', 'dealexport'); ?></th>
                    <td><?php echo ThemedbWoo::getPrice(ThemedbShop::$data['revenue']); ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th><?php _e('Total Profit', 'dealexport'); ?></th>
                    <td><?php echo ThemedbWoo::getPrice(ThemedbUser::$data['current']['profit']); ?></td>
                </tr>
                <tr>
                    <th><?php _e('Current Balance', 'dealexport'); ?></th>
                    <td><?php echo ThemedbWoo::getPrice(ThemedbUser::$data['current']['balance']); ?></td>
                </tr>
                <?php if(!ThemedbCore::checkOption('shop_multiple') && ThemedbShop::$data['status']=='publish') { ?>
                <tr>
                    <th><?php _e('Current Rate', 'dealexport'); ?></th>				
                    <td><?php echo ThemedbShop::filterRate(ThemedbShop::$data['ID'], ThemedbShop::$data['rate']); ?>%</td>
                </tr>
                <?php 
                }
                
                $methods=array_flip(ThemedbCore::getOption('withdrawal_methods', array('paypal', 'skrill', 'swift')));
                $gateways=ThemedbWoo::getPaymentMethods();
                
                if(count($gateways)>1 || !isset($gateways['paypal-adaptive-payments'])) {
                    foreach(ThemedbCore::$components['forms']['withdrawal'] as $name => $field) {
                        if(is_array(reset($field))) {
                            if(isset($methods[$name])) {
                                foreach($field as $key => $child) {
                                ?>
                                <tr class="trigger-method-<?php echo $name; ?>">
                                    <th><?php echo $child['label']; ?></th>
                                    <td>
                                        <?php if(in_array($child['type'], array('select', 'select_country'))) { ?>
                                        <div class="element-select">
                                            <span></span>
                                            <?php 
                                            echo ThemedbInterface::renderOption(array(
                                                'id' => $child['name'],
                                                'type' => $child['type'],
                                                'options' => themedb_array('options', $child),
                                                'value' => themedb_value($child['name'], $_POST),
                                                'wrap' => false,
                                            ));
                                            ?>
                                        </div>
                                        <?php } else { ?>
                                        <div class="field-wrap">
                                            <input type="text" name="<?php echo esc_attr($child['name']); ?>" value="<?php echo esc_attr(themedb_value($child['name'], $_POST)); ?>" />
                                        </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php 
                                }
                            }
                        } else {
                        ?>
                        <tr>
                            <th><?php echo $field['label']; ?></th>
                            <td>
                                <?php if(in_array($field['type'], array('select', 'select_country'))) { ?>
                                <div class="element-select">
                                    <span></span>
                                    <?php 
                                    echo ThemedbInterface::renderOption(array(
                                        'id' => $field['name'],
                                        'type' => $field['type'],
                                        'options' => array_intersect_key(themedb_array('options', $field), $methods),
                                        'value' => themedb_value($field['name'], $_POST),
                                        'wrap' => false,
                                        'attributes' => array(
                                            'class' => 'element-trigger',
                                        ),
                                    ));
                                    ?>
                                </div>
                                <?php } else { ?>
                                <div class="field-wrap">
                                    <input type="text" name="<?php echo esc_attr($field['name']); ?>" value="<?php echo esc_attr(themedb_value($field['name'], $_POST)); ?>" />
                                </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>				
                    <?php 
                    }
                }
                ?>
            </tbody>
        </table>
        <?php if(count($gateways)>1 || !isset($gateways['paypal-adaptive-payments'])) { ?>
        <a href="#" class="element-button element-submit primary"><?php _e('Submit Request', 'dealexport'); ?></a>
        <input type="hidden" name="shop_action" value="add_withdrawal" />
        <?php } ?>
    </form>
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>