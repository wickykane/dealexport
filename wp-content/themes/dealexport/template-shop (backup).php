<?php the_post(); ?>
<?php ThemedbShop::refresh($post->ID); 
$shop_other_info = get_field('shop_other_info', $post->ID);
$authorId = ThemedbShop::$data["author"];
$userMeta = get_userdata($authorId);
?>
<div class="shop-heading-image"><img src="<?php the_field('shop_heading_image'); ?>"></div>
<div class="column threecol">
    <div class="shop-preview">
        <div class="shop-images single clearfix">
            <div class="image-wrap">
                <?php echo generateCustomImageThumbnail(wp_get_attachment_url(get_post_thumbnail_id(ThemedbShop::$data['ID'])),300,300,2,'images/shop.png');
                ?>
            </div>
            <?php include_once 'shop-thumbnails.php';?>
        </div>
        <?php if (!ThemedbCore::checkOption('shop_sales') || !ThemedbCore::checkOption('shop_favorites')) { ?>
            <footer class="shop-footer">
                <div class="shop-attributes">
                    <ul>
                        <?php if (!ThemedbCore::checkOption('shop_sales')) { ?>
                            <li>
                                <span class="fa fa-tags"></span>
                                <span><?php echo sprintf(_n('%d Sale', '%d Sales', ThemedbShop::$data['sales'], 'dealexport'), ThemedbShop::$data['sales']); ?></span>
                            </li>
                        <?php } ?>
                        <?php if (!ThemedbCore::checkOption('shop_favorites')) { ?>
                            <li>
                                <span class="fa fa-heart"></span>
                                <span><?php echo sprintf(_n('%d Admirer', '%d Admirers', ThemedbShop::$data['admirers'], 'dealexport'), ThemedbShop::$data['admirers']); ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </footer>
        <?php } ?>
    </div>
    <!-- TNN move shop sidebar to left -->
    <?php get_sidebar('shop-right'); ?>
</div>
<div class="column shop-main-content">
    <div class="shop-details widget wrapped">
        <div class="widget-content">
            <div class="social-icon"><span style="color: red">Under development...</span></div>
            <div class="element-title shop-title">
                <div class="role-title"><?php echo $userMeta->roles[0] ?></div>
                <h2><?php the_title(); ?></h2>
                <?php if (!ThemedbCore::checkOption('shop_rating')) { ?>
                    <div class="title-option right">
                        <div class="shop-rating" title="<?php echo sprintf(_n('%d Rating', '%d Ratings', ThemedbShop::$data['ratings'], 'dealexport'), ThemedbShop::$data['ratings']); ?>">
                            <div class="element-rating" data-score="<?php echo ThemedbShop::$data['rating']; ?>"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="shop-content">
                <?php
                the_content();
                $video_desc_url = get_field('video_description', $shop_id);
                if (strlen($video_desc_url)):
                    ?>
                    <center><iframe src="<?php echo $video_desc_url; ?>" width="300" height="200" frameborder="0" allowfullscreen="allowfullscreen"></iframe></center>
                <?php endif; ?>
            </div>

            <div class="shop-options clearfix">
                <?php if (is_user_logged_in()) { ?>
                    <form class="element-form" method="POST" action="<?php echo AJAX_URL; ?>">
                        <?php if (!ThemedbCore::checkOption('shop_favorites')) { ?>
                            <?php if (in_array(ThemedbShop::$data['ID'], ThemedbUser::$data['current']['shops'])) { ?>
                                <a href="#" class="element-button element-submit" data-title="<?php _e('Favorite', 'dealexport'); ?>"><?php _e('Unfavorite', 'dealexport'); ?></a>
                                <input type="hidden" name="user_action" class="toggle" value="remove_relation" data-value="add_relation" />
                            <?php } else { ?>
                                <a href="#" class="element-button element-submit active" data-title="<?php _e('Unfavorite', 'dealexport'); ?>"><?php _e('Favorite', 'dealexport'); ?></a>
                                <input type="hidden" name="user_action" class="toggle" value="add_relation" data-value="remove_relation" />
                            <?php } ?>
                        <?php } ?>
                        <?php if (!ThemedbCore::checkOption('shop_questions')) { ?>
                            <a href="#contact_form" class="element-button element-colorbox square secondary" title="<?php _e('Ask a Question', 'dealexport'); ?>"><span class="fa fa-comment"></span></a>
                        <?php } ?>
                        <?php if (!ThemedbCore::checkOption('shop_reports')) { ?>
                            <a href="#report_form" class="element-button element-colorbox square secondary" title="<?php _e('Send a Report', 'dealexport'); ?>"><span class="fa fa-flag"></span></a>
                        <?php } ?>
                        <!-- TNH add btn like -->
                        <a href="#contact_form" class="element-button element-colorbox square like-button aligncenter" title="<?php _e('Like', 'dealexport'); ?>" style="width: 132px;">
					        <span class="fa fa-heart large"></span>
					        <span class="like-text"><?php _e('Like', 'dealexport'); ?></span>
					    </a>
                        <!-- End btn like -->
                        <input type="hidden" name="relation_type" value="shop" />
                        <input type="hidden" name="relation_id" value="<?php echo ThemedbShop::$data['ID']; ?>" />					
                        <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
                    </form>
                    <div class="site-popups hidden">
                    <!-- TNH need to remove true in V2 -->
                        <?php if (!ThemedbCore::checkOption('shop_questions') || true) { ?>
                            <div id="contact_form">
                                <div class="site-popup medium">
                                    <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
                                        <div class="field-wrap">
                                            <input type="text" name="email" readonly="readonly" value="<?php echo ThemedbUser::$data['current']['email']; ?>" />
                                        </div>
                                        <div class="field-wrap">
                                            <textarea name="question" cols="30" rows="5" placeholder="<?php _e('Question', 'dealexport'); ?>"></textarea>
                                        </div>
                                        <a href="#" class="element-button element-submit send-question"><?php _e('Send Question', 'dealexport'); ?></a>				
                                        <input type="hidden" name="shop_id" value="<?php echo ThemedbShop::$data['ID']; ?>" />
                                        <input type="hidden" name="shop_action" value="submit_question" />
                                        <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_shop" />
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (!ThemedbCore::checkOption('shop_reports')) { ?>
                            <div id="report_form">
                                <div class="site-popup medium">
                                    <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
                                        <div class="message"></div>
                                        <div class="field-wrap">
                                            <input type="text" name="email" readonly="readonly" value="<?php echo esc_attr(ThemedbUser::$data['current']['email']); ?>" />
                                        </div>
                                        <div class="field-wrap">
                                            <textarea name="reason" cols="30" rows="5" placeholder="<?php _e('Reason', 'dealexport'); ?>"></textarea>
                                        </div>
                                        <a href="#" class="element-button element-submit primary"><?php _e('Send Report', 'dealexport'); ?></a>
                                        <input type="hidden" name="shop_id" value="<?php echo ThemedbShop::$data['ID']; ?>" />
                                        <input type="hidden" name="shop_action" value="submit_report" />
                                        <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_shop" />
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- /popups -->
                <?php } else { ?>
                    <?php if (!ThemedbCore::checkOption('shop_favorites')) { ?>
                        <a href="<?php echo ThemedbCore::getURL('register'); ?>" class="element-button active"><?php _e('Favorite', 'dealexport'); ?></a>
                    <?php } ?>
                    <?php if (!ThemedbCore::checkOption('shop_questions')) { ?>
                        <a href="<?php echo ThemedbCore::getURL('register'); ?>" class="element-button square secondary" title="<?php _e('Ask a Question', 'dealexport'); ?>"><span class="fa fa-comment"></span></a>
                    <?php } ?>
                    <?php if (!ThemedbCore::checkOption('shop_reports')) { ?>
                        <a href="<?php echo ThemedbCore::getURL('register'); ?>" class="element-button square secondary" title="<?php _e('Send a Report', 'dealexport'); ?>"><span class="fa fa-flag"></span></a>
                    <?php } ?>
                <?php } ?>				
            </div>

            <div class="divider--medium"></div>
            <div>

                
                <?php 

                    $tab_shortcode = '[vc_tta_tabs el_class="shop_tab"]';
                    if (!empty($shop_other_info)):
                        foreach ($shop_other_info as $index=>$tab) {
                            $tab_shortcode .= '[vc_tta_section title="'.$tab['shop_tab_title'].'" tab_id="tab-'.$post->ID.'-'.$index.'"]';
                            $tab_shortcode .= $tab['shop_tab_content'];
                            $tab_shortcode .= '[/vc_tta_section]';
                        }
                        $tab_shortcode .= '[/vc_tta_tabs]';
                    endif;
                    echo do_shortcode($tab_shortcode);
                ?>  

            </div>

        </div>
    </div>
    <?php if($shopOtherInfo){?>


            <div class="shop-other-info widget wrapped shop-sub-conten">
                <ul class='boxLinks'>
                <?php $i = 1; foreach($shopOtherInfo as $shopInfo) {?>
                    <li><a href="#item_<?php echo $i;?>" class="tab-title <?php echo ($i == 1)? 'active' : '' ?>"><?php echo $shopInfo['tab_title']; $i++?></a></li>
                <?php }?>
                </ul>
                <div class="items">
                <?php $j = 1; foreach($shopOtherInfo as $shopInfo) {?>
                    <div id="item_<?php echo $j?>" class='box <?php echo ($j == 1)? 'default' : '' ?>'> <?php echo $shopInfo['tab_desc'];$j++;?> </div>
                <?php }?>
                </div>
            </div>
    <?php }?>
</div>
<!-- 
<aside class="column threecol last">
    <?php // get_sidebar('shop-right'); ?>
</aside>
 -->
