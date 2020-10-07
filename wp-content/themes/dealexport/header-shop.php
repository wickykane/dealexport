<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="<?php echo THEME_URI; ?>js/html5.js"></script>
        <![endif]-->

        <?php wp_head(); ?>
    </head>
    <body <?php body_class(); ?>>
        <div class="site-wrap">
            <div class="header-wrap clearfix">
                <!-- Top header -->
                <div class="top-header">
                    <div class="site-toolbar container">
                        <nav class="right language-menu">
                            <?php wp_nav_menu(array('theme_location' => 'top_menu'
                                                    ,'menu' => 61
                                                    ,'menu_class' => 'ui-beacon-nav ui-beacon'
                                                    ,'link_after' => '<i class="ui-beacon-hollow-arrow"><em></em><b></b></i>'
                                                    ,'walker' => new db_Walker_Nav_Menu())); ?>
                        </nav>


                            <?php if (is_user_logged_in()) { ?>
                            <span class='user-name right clearfix' >
                                <?php $user = wp_get_current_user(); ?>
                            </span>
                        <?php } else {?>
                               
                        <?php } ?>
                        <nav class="right">
                            <?php wp_nav_menu(array('theme_location' => 'top_menu'
                                                    ,'menu_class' => 'ui-beacon-nav ui-beacon'
                                                    ,'link_after' => '<i class="ui-beacon-hollow-arrow"><em></em><b></b></i>'
                                                    ,'walker' => new db_Walker_Nav_Menu())); ?>
                        </nav>
                        <!-- /top menu -->
                    </div>
                </div>
                <header class="site-header container">
                    <div class="header-logo">
                         <?php //wp_nav_menu(array('theme_location' => 'feature_menu','menu_class' => 'ui-beacon-nav ui-beacon'// ,'link_before' => '<i class="ui-beacon-hollow-arrow"><em></em><b></b></i>','walker' => new db_Walker_Nav_Menu())); ?>

                        <a href="<?php echo SITE_URL; ?>" rel="home">
                            <img src="<?php echo ThemedbCore::getOption('site_logo', THEME_URI . 'images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" />
                        </a> 

                    </div>
                    <!-- /logo -->
                
                    <!-- /options -->
                </header>
                <!-- /header -->
                <div class="main-header">
                    <div class="header-search-container">
                            <form role="search" method="GET" action="https://dealexport.amagumolabs.io/">
                                <div class="header-search-close"><a class="header-search-close-link" href="#"><svg viewBox="0 0  24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 11.293l10.293-10.293.707.707-10.293 10.293 10.293 10.293-.707.707-10.293-10.293-10.293 10.293-.707-.707 10.293-10.293-10.293-10.293.707-.707 10.293 10.293z"/></svg></a></div>
                                <div class="dropdownOver header-search-dropdown">
                                    <span class="label">FIRST</span>
                                    <ul class="filter_taxonomy">
                                        <li data-label="All" class="holder">All</li>
                                        <li data-value="product">PRODUCTS</li>
                                        <li data-value="suppliers">SUPPLIERS</li>
                                        <li data-value="deals">DEALS</li>
                                    </ul>
                                </div>
                                <input class="header-search-input" type="text" value="" name="s">
                                <input type="hidden" name="post_type" value="product">
                                 <div class="header-search-start"><a class="header-search-start-link" href="#"><svg viewBox="0 0  24 24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z"></path></svg></a></div>
                                
                            </form>
                    </div>
                    <div class="site-toolbar container">
                        <div class="icon-nav">
                            <a class="icon-nav-item search-item" href="#" title="<?php _e('Search', 'dealexport'); ?>"><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z"/></svg></a>
                            <a class="icon-nav-item cart-item" href="<?php echo ThemedbWoo::$woocommerce->cart->get_cart_url(); ?>" title="<?php _e('Shopping cart', 'dealexport'); ?>"><svg xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M13.5 21c-.276 0-.5-.224-.5-.5s.224-.5.5-.5.5.224.5.5-.224.5-.5.5m0-2c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5m-6 2c-.276 0-.5-.224-.5-.5s.224-.5.5-.5.5.224.5.5-.224.5-.5.5m0-2c-.828 0-1.5.672-1.5 1.5s.672 1.5 1.5 1.5 1.5-.672 1.5-1.5-.672-1.5-1.5-1.5m16.5-16h-2.964l-3.642 15h-13.321l-4.073-13.003h19.522l.728-2.997h3.75v1zm-22.581 2.997l3.393 11.003h11.794l2.674-11.003h-17.861z"/></svg> <span><?php echo ThemedbWoo::$woocommerce->cart->get_cart_total(); ?></span>
                            <span class="cart-item-count"><?php echo count( ThemedbWoo::$woocommerce->cart->get_cart() );?></span>
                        </a>
                        </div>
                        <nav class="header-menu element-menu">
                            <?php wp_nav_menu(array('theme_location' => 'main_menu', 'container_class' => 'menu')); ?>
                        </nav>
                        
                        <div class="select-menu element-select redirect medium">
                            <span></span>
                            <?php ThemedbInterface::renderDropdownMenu('main_menu'); ?>
                        </div>
                        <!-- /menu -->
                        <?php if (ThemedbWoo::isActive()) { ?>
                            <div class="header-cart right">
                                <a href="<?php echo ThemedbWoo::$woocommerce->cart->get_cart_url(); ?>" class="cart-amount">
                                    <span class="fa fa-shopping-cart"></span>
                                    <?php echo ThemedbWoo::$woocommerce->cart->get_cart_total(); ?>
                                </a>
                                <div class="cart-quantity"><?php echo ThemedbWoo::$woocommerce->cart->cart_contents_count; ?></div>
                            </div>
                            <!-- /cart -->
                        <?php } ?>
                        
                        <div class="header-search right display--none">
                            <form role="search" method="GET" action="<?php echo SITE_URL;       ?>">
                                <input type="text" value="<?php the_search_query();       ?>" name="s" />
                        <?php if(ThemedbWoo::isActive()) { ?>
                                <input type="hidden" name="post_type" value="product">
                        <?php } ?>
                            </form>
                            <span class="fa fa-search"></span>
                        </div>
                        <!-- /search -->

                        <?php 
                            if (is_user_logged_in()) {
                                $user = wp_get_current_user();
                                $user_name = sprintf(__( '[:en]Hello [:fr]Bonjour [:vi]Xin chào [:]<strong>%1$s</strong>', 'woocommerce' ), $user->display_name);
                                echo '<ul id="nav-menu-member" class="user-nav ui-beacon-nav ui-beacon "><li><a class="sponsorBtn" href="https://dealexport.amagumolabs.io/recommendation/">' . __("[:en]Refer[:fr]Recommander[:vi]Khuyến khích[:]", "dealexport") . '</a></li><li class="divider"><span class="item-split"></span></li><li id="nav-menu-item-user" class="ui-beacon-item ui-beacon-drop"><svg class="user_icon" data-name="mk-moon-user-4" data-cacheid="icon-5bf7a9166cf66" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 64c52.935 0 96 43.065 96 96s-43.065 96-96 96-96-43.065-96-96 43.065-96 96-96m0-32c-70.692 0-128 57.308-128 128s57.308 128 128 128 128-57.308 128-128-57.308-128-128-128zm128 320c52.935 0 96 43.065 96 96h-448c0-52.935 43.065-96 96-96h256m0-32h-256c-70.692 0-128 57.309-128 128v32h512v-32c0-70.691-57.308-128-128-128z"></path></svg><a class="ui-beacon-item-link">'.$user_name.'</a><ul class="ui-beacon-subs"><li id="nav-menu-item-349" class="ui-beacon-sub"><a href="'.ThemedbUser::$data['current']['links']['profile']['url'].'" class="user-link ui-beacon-sub-link">'. __('My Account', 'dealexport') .'</a><a href="'.wp_logout_url(SITE_URL).'" class="user-link ui-beacon-sub-link">'. __('Sign Out', 'dealexport') .'</a></li></ul></li></ul>';
                         	}  else {  ?>
                        	 <span id="nav-menu-guest"  class='user-name right clearfix' >
                        	 	<a class="sponsorBtn lastBtn" href="#"><?php _e('[:en]Refer[:fr]Recommander[:vi]Khuyến khích[:]', 'dealexport'); ?></a>
                        	 	<span class="item-split"></span>
                                <a href="#login_form" class="element-colorbox signInBtn"><?php _e('[:en]Sign In[:fr]Se connecter[:vi]Đăng nhập[:]', 'dealexport'); ?></a>
                              
                            <?php //if (get_option('users_can_register')) { ?>
                                <!-- <span class="item-split"></span>
                                <a href="<?php //echo ThemedbCore::getURL('register'); ?>" class="registerBtn"><?php //_e('Register', 'dealexport'); ?></a> -->
                            <?php //} ?>

                            <!-- popups -->                  
                            <div class="site-popups hidden">
                                <div id="login_form">
                                    <div class="site-popup small">
                                        <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
                                            <div class="field-wrap">
                                                <input type="text" name="user_login" value="" placeholder="<?php _e('Username', 'dealexport'); ?>" />
                                            </div>
                                            <div class="field-wrap">
                                                <input type="password" name="user_password" value="" placeholder="<?php _e('Password', 'dealexport'); ?>" />
                                            </div>
                                            <a href="#" class="element-button element-submit"><?php _e('[:en]Sign In[:fr]Se connecter[:vi]Đăng nhập[:]', 'dealexport'); ?></a>
                                            <?php if (ThemedbFacebook::isActive()) { ?>
                                                <a href="<?php echo home_url('?facebook_login=1'); ?>" class="element-button element-facebook square facebook" title="<?php _e('Sign in with Facebook', 'dealexport'); ?>"><span class="fa fa-facebook"></span></a>
                                            <?php } ?>
                                            <a href="#password_form" class="element-button element-colorbox square" title="<?php _e('Password Recovery', 'dealexport'); ?>"><span class="fa fa-life-ring"></span></a>
                                            <input type="hidden" name="user_action" value="login_user" />
                                            <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
                                            <input type="submit" class="hidden" value="" />
                                        </form>
                                    </div>
                                </div>
                                <div id="password_form">
                                    <div class="site-popup small">
                                        <form class="site-form element-form" method="POST" action="<?php echo AJAX_URL; ?>">
                                            <div class="field-wrap">
                                                <input type="text" name="user_email" value="" placeholder="<?php _e('Email', 'dealexport'); ?>" />
                                            </div>
                                            <a href="#" class="element-button element-submit primary"><?php _e('Reset Password', 'dealexport'); ?></a>
                                            <input type="hidden" name="user_action" value="reset_user" />
                                            <input type="hidden" name="action" class="action" value="<?php echo THEMEDB_PREFIX; ?>update_user" />
                                            <input type="submit" class="hidden" value="" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /popups -->
                            </span>
                       <?php } ?>
                       		<div class="nav-aboutus-wrapper">
                       			<a class="nav-aboutus-link" href="#"><?php echo _e('[:en]About us[:fr]À propos de nous[:vi]Về chúng tôi[:]') ?></a>
                       		</div>

                    </div>


                </div>
                <!-- /toolbar -->
                <?php if (is_front_page() && is_page()) { ?>
                    <?php get_template_part('module', 'slider'); ?>
                <?php } else if (is_singular('shop')) { ?>
                    <div class="featured-wrap">
                        <div class="shop-heading-image"><img src="<?php the_field('shop_heading_image'); ?>"></div>
                        <section class="site-featured container clearfix">
                            <?php get_template_part('template', 'shop'); ?>
                        </section>
                    </div>
                    <!-- /featured -->
                <?php } else { ?>
                    <!-- Disable Site title -->
                    <!-- <div class="site-title">
                        <div class="container">
                            <span><?php //ThemedbInterface::renderPageTitle(); ?></span>
                        </div>
                    </div> -->
                    <!-- /title -->
                <?php } ?>
            </div>
            <div class="content-wrap">
        <section class="site-content container">