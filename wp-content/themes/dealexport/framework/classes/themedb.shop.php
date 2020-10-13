<?php
/**
 * Themedb Shop
 *
 * Handles shops data
 *
 * @class ThemedbShop
 * @author Themedb
 */
 
class ThemedbShop {



    /** @var array Contains module data. */
    public static $data;

    /**
    * Adds actions and filters
     *
     * @access public
     * @return void
     */
    public static function init() {
        
        //update actions
        add_action('wp', array(__CLASS__, 'update'), 3);
        add_action('wp_ajax_themedb_update_shop', array(__CLASS__, 'update'));
        add_action('pending_to_publish', array(__CLASS__, 'updateShop'));
        add_action('before_delete_post', array(__CLASS__, 'deleteShop'));
        add_action('pre_get_posts', array(__CLASS__, 'filterShops'));
        
        //update withdrawal
        add_action('save_post', array(__CLASS__, 'updateWithdrawal'));
        add_action('delete_post', array(__CLASS__, 'updateWithdrawal'));
        
        //update ratings
        add_action('comment_post', array(__CLASS__, 'updateRating'));
        add_action('wp_set_comment_status', array(__CLASS__, 'updateRating'));
        add_action('delete_comment', array(__CLASS__, 'updateRating'));
    }
    
    /**
    * Refreshes module data
     *
     * @access public    
     * @return void
     */
    public static function refresh($ID=0, $extended=false) {
        self::$data=self::getShop($ID, $extended);
    }
    
    /**
    * Updates module data
     *
     * @access public    
     * @return void
     */
    public static function update() {
        $data=$_POST;
        if(isset($_POST['data'])) {
            parse_str($_POST['data'], $data);
        }
        
        if(isset($data['shop_action']) && is_user_logged_in()) {
            $action=sanitize_title($data['shop_action']);
            $redirect=false;
            
            $ID=intval(themedb_value('shop_id', $data));
            $author=intval(get_post_field('post_author', $ID));
            $user=get_current_user_id();            
            
            if((empty($ID) || $user==$author) && !ThemedbCore::checkOption('shop_multiple')) {
                switch($action) {
                    case 'update_image':
                        self::updateImage($ID, themedb_array('shop_image', $_FILES));
                        $redirect=true;
                    break;
                    
                    case 'update_profile':
                        self::updateProfile($ID, $data);
                    break;
                    
                    case 'update_shipping':
                        self::updateShipping($ID, $data);
                    break;
                    
                    case 'remove_shop':                     
                        self::removeShop($ID);
                    break;
                }
            }
            
            switch($action) {
                case 'add_withdrawal':
                    self::addWithdrawal($data);
                break;
                
                case 'remove_withdrawal':
                    self::removeWithdrawal(themedb_value('withdrawal_id', $data));
                break;
                
                case 'submit_question':
                    self::submitQuestion($data);
                break;
                
                case 'submit_report':
                    self::submitReport($data);
                break;
            }
            
            if($redirect || empty(ThemedbInterface::$messages)) {
                wp_redirect(themedb_url());
                exit();
            }
        }
    }
    
    /**
    * Gets shop
     *
     * @access public
    * @param int $ID
    * @param bool $extended
     * @return array
     */
    public static function getShop($ID, $extended=false) {
        $shop=array();
        if(empty($ID)) {
            $shop=array(
                'ID' => '',
                'status' => 'draft',
                'author' => '',
                'profile' => array(
                    'title' => '',
                    'category' => '',
                    'content' => '',
                    'about' => '',
                    'policy' => '',
                ),
                'sales' => '',
                'admirers' => '',
                'rating' => '',
                'ratings' => '',
                'rate' => '',
                'revenue' => '',
                'products' => array(),
                'orders' => array(),    
                'handlers' => array(),
                'reviews' => array(),
                'withdrawals' => array(),
            );
        } else {
            $shop['ID']=$ID;
            $shop['status']=get_post_status($ID);
            
            $shop['author']=self::getAuthor($ID);
            $shop['profile']=self::getProfile($ID);         
            
            $shop['sales']=absint(ThemedbCore::getPostMeta($ID, 'sales'));
            $shop['admirers']=absint(ThemedbCore::getPostMeta($ID, 'admirers'));            
            
            $shop['rating']=absint(ThemedbCore::getPostMeta($ID, 'rating'));
            $shop['ratings']=absint(ThemedbCore::getPostMeta($ID, 'ratings'));
            
            if($extended) {
                $shop['orders']=ThemedbWoo::getOrders($shop['author']);
                $shop['withdrawals']=self::getWithdrawals($shop['author']);
                
                $shop['products']=ThemedbWoo::getProducts($shop['author'], array(
                    'post_status' => array('publish', 'draft'),
                ));
                
                $shop['reviews']=ThemedbWoo::getProducts($shop['author'], array(
                    'post_status' => 'pending',
                ));
            
                $shop['handlers']=count(ThemedbWoo::getOrders($shop['author'], array(
                    'post_status' => 'wc-processing',
                )));
                
                $shop['rate']=self::getRate($shop['author']);
                $shop['revenue']=round(floatval(ThemedbCore::getUserMeta($shop['author'], 'revenue')), 2);
            } else {
                $shop['products']=ThemedbWoo::getProducts($shop['author']);
            }
        }
        
        return $shop;
    }
    
    /**
    * Adds shop
     *
     * @access public
     * @return bool
     */
    public static function addShop() {
        $user=get_current_user_id();
        $args=array(
            'post_type' => 'shop',
            'post_status' => 'draft',
            'post_author' => $user,
            'post_title' => __('Untitled', 'dealexport'),
        );
        
        $shop=wp_insert_post($args);
        if(!empty($shop)) {
            ThemedbUser::$data['current']['shop']=$shop;
            return $shop;
        }
        
        return false;
    }
    
    /**
    * Updates shop status
     *
     * @access public
    * @param mixed $post
     * @return void
     */
    public static function updateShop($post) {
        if(isset($post) && in_array($post->post_type, array('shop', 'product', 'withdrawal'))) {
            $content=ThemedbCore::getOption('email_product_approved');
            if($post->post_type=='shop') {
                $content=ThemedbCore::getOption('email_shop_approved');
            } else if($post->post_type=='withdrawal') {
                $content=ThemedbCore::getOption('email_withdrawal_processed');
            }
            
            if(!empty($content)) {
                $user=get_userdata($post->post_author);
                $subject=__('Item Approval', 'dealexport');
                if($post->post_type=='shop') {
                    $subject=__('Shop Approval', 'dealexport');
                } else if($post->post_type=='withdrawal') {
                    $subject=__('Processed Withdrawal', 'dealexport');
                }
                
                $link='<a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a>';
                $keywords=array(
                    'username' => $user->user_login,
                    'shop' => $link,
                    'product' => $link,
                );
                
                if($post->post_type=='withdrawal') {
                    $method=themedb_value(ThemedbCore::getPostMeta($post->ID, 'method'), ThemedbCore::$components['forms']['withdrawal']['method']['options']);
                    $amount=ThemedbWoo::getPrice(ThemedbCore::getPostMeta($post->ID, 'amount'));
                    
                    $keywords=array_merge(array(
                        'method' => $method,
                        'amount' => $amount,
                    ), $keywords);
                }
                
                $content=themedb_keywords($content, $keywords);
                themedb_mail($user->user_email, $subject, $content);
            }
        }
    }
    
    /**
    * Removes shop
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function removeShop($ID) {
        $user=get_current_user_id();
        wp_update_post(array(
            'ID' => $ID,
            'post_status' => 'trash',
        ));
        
        $products=ThemedbWoo::getProducts($user, array(
            'post_status' => array('publish', 'pending', 'draft'),
        ));
        
        foreach($products as $product) {
            wp_update_post(array(
                'ID' => $product,
                'post_status' => 'trash',
            ));
        }
        
        wp_redirect(get_author_posts_url($user));
        exit();
    }
    
    /**
    * Deletes shop
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function deleteShop($ID) {
        global $post_type;
        
        if(!empty($ID) && in_array($post_type, array('shop', 'product'))) {
            $attachments=get_posts(array(
                'post_type' => 'attachment',
                'post_parent' => $ID,
                'posts_per_page' => -1,
                'fields' => 'ids',
            ));
            
            foreach($attachments as $attachment) {
                wp_delete_attachment($attachment);
            }
        }
    }
    
    /**
    * Renders shop options
     *
     * @access public
    * @param int $ID
     * @return string
     */
    public static function renderShop($ID) {
        $out='';
        
        $shop=self::getShop($ID, true);
        $profit=round(floatval(ThemedbCore::getUserMeta($shop['author'], 'profit')), 2);        
        $balance=round(floatval(ThemedbCore::getUserMeta($shop['author'], 'balance')), 2);
        
        $nickname=get_user_meta($shop['author'], 'nickname', true);
        $fields['author']=array(
            'label' => __('Author', 'dealexport'),
            'value' => '<a href="'.get_edit_user_link($shop['author']).'">'.$nickname.'</a>',
        );
        
        if(ThemedbWoo::isActive()) {
            $products=count($shop['products']);
            $fields['products']=array(
                'label' => __('Products', 'dealexport'),
                'value' => '<a href="'.admin_url('edit.php?post_type=product&author='.$shop['author']).'">'.$products.'</a>',
            );
            
            $orders=count($shop['orders']);
            $fields['orders']=array(
                'label' => __('Orders', 'dealexport'),
                'value' => '<a href="'.admin_url('edit.php?post_type=shop_order&author='.$shop['author']).'">'.$orders.'</a>',
            );
        }
        
        $fields['revenue']=array(
            'label' => __('Total Revenue', 'dealexport'),
            'value' => ThemedbWoo::getPrice($shop['revenue']),
        );
        
        $fields['profit']=array(
            'label' => __('Total Profit', 'dealexport'),
            'value' => ThemedbWoo::getPrice($profit),
        );
        
        $fields['balance']=array(
            'label' => __('Current Balance', 'dealexport'),
            'value' => ThemedbWoo::getPrice($balance),
        );
        
        $fields['rate']=array(
            'label' => __('Current Rate', 'dealexport'),
            'value' => $shop['rate'].'%',
        );
        
        foreach($fields as $field) {
            $out.='<tr><th><h4 class="themedb-meta-title">'.$field['label'].'</h4></th><td class="themedb-meta-value">'.$field['value'].'</td></tr>';
        }
        
        return $out;
    }
    
    /**
    * Filters shops query
     *
     * @access public
    * @param mixed $query
     * @return mixed
     */
    public static function filterShops($query) {
        if(!is_admin() && $query->is_main_query()) {
            if($query->is_tax('shop_category') || themedb_search('shop')) {
                $number=intval(ThemedbCore::getOption('shops_per_page', 6));
                $query->set('posts_per_page', $number);
            }
            
            if(themedb_search('shop')) {
                $meta=$query->get('meta_query');
                
                //category
                $category=intval(themedb_array('category', $_GET));
                if(!empty($category)) {
                    $query->set('tax_query', array(
                        array(
                            'taxonomy' => 'shop_category',
                            'terms' => $category,
                        ),
                    ));
                }
                
                //country
                $country=sanitize_text_field(themedb_array('country', $_GET));
                if(!empty($country)) {
                    $meta[]=array(
                        'key' => '_'.THEMEDB_PREFIX.'country',
                        'value' => $country,
                    );
                }
                
                //city
                $city=sanitize_text_field(themedb_array('city', $_GET));
                if(!empty($city)) {
                    $meta[]=array(
                        'key' => '_'.THEMEDB_PREFIX.'city',
                        'value' => $city,
                    );
                }
                
                $query->set('meta_query', $meta);
            } else if(themedb_search('post')) {
                $query->set('post_type', 'post');
            }
        }
        
        return $query;
    }
    
    /**
    * Gets shop author
     *
     * @access public
    * @param int $ID
     * @return int
     */
    public static function getAuthor($ID) {
        global $wpdb;
        
        $author=intval($wpdb->get_var($wpdb->prepare("
            SELECT post_author FROM {$wpdb->posts} 
            WHERE ID = %d 
        ", intval($ID))));
        
        return $author;
    }
    
    /**
    * Gets shop rate
     *
     * @access public
    * @param int $user
     * @return int
     */
    public static function getRate($user) {
        $rate_min=absint(ThemedbCore::getOption('shop_rate_min', 50));
        $rate_max=absint(ThemedbCore::getOption('shop_rate_max', 70));
        
        $rate=$rate_min;
        if($rate_max>$rate_min) {
            $rate=absint(ThemedbCore::getUserMeta($user, 'rate', $rate_min));
        }
        
        return $rate;
    }
    
    /**
    * Filters shop rate
     *
     * @access public
    * @param int $ID
    * @param int $rate
     * @return int
     */
    public static function filterRate($ID, $rate) {
        $default=absint(ThemedbCore::getPostMeta($ID, 'rate'));     
        if(!empty($default)) {
            $rate=$default;
        }
        
        return $rate;
    }
    
    /**
    * Updates shop image
     *
     * @access public
    * @param int $ID
    * @param mixed $file
     * @return void
     */
    public static function updateImage($ID, $file) {
        if(empty($ID)) {
            $ID=self::addShop();
        }
        
        ThemedbCore::updateImage($ID, $file);
        wp_redirect(ThemedbCore::getURL('shop-settings'));
        exit();
    }
    
    /**
    * Gets shop profile
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getProfile($ID) {
        $profile=array();
        
        $profile['title']=get_the_title($ID);
        if($profile['title']==__('Untitled', 'dealexport')) {
            $profile['title']='';
        }
        
        $profile['category']=0;
        $categories=get_the_terms($ID, 'shop_category');
        if(is_array($categories) && !empty($categories)) {
            $category=reset($categories);
            $profile['category']=$category->term_id;
        }
        
        $profile['content']=get_post_field('post_content', $ID);
        $profile['about']=ThemedbCore::getPostMeta($ID, 'about');
        $profile['policy']=ThemedbCore::getPostMeta($ID, 'policy', ThemedbCore::getOption('shop_policy'));
        
        return $profile;
    }
    
    /**
    * Updates shop profile
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function updateProfile($ID, $data) {

        $redirect=false;
        if(empty($ID)) {
            $ID=self::addShop();
            $redirect=true;         
        }
        
        $args=array(
            'ID' => $ID,
        );
        
        //title
        $title=trim(themedb_value('title', $data));
        if(empty($title)) {
            ThemedbInterface::$messages[]=__('Shop name field is required', 'dealexport');
        } else {
            $args['post_title']=$title;
        }
        
        //category
        if(themedb_taxonomy('shop_category')) {
            $category=intval(themedb_value('category', $data));
            
            if(empty($category)) {
                ThemedbInterface::$messages[]=__('Shop category field is required', 'dealexport');
            } else {
                $term=get_term($category, 'shop_category');
                
                if(empty($term)) {
                    ThemedbInterface::$messages[]=__('This shop category does not exist', 'dealexport');
                } else {
                    wp_set_object_terms($ID, $term->name, 'shop_category');
                }
            }
        }
        
        //content
        $content=trim(themedb_value('content', $data));
        if(empty($content)) {
            ThemedbInterface::$messages[]=__('Shop description field is required', 'dealexport');
        } else {
            $args['post_content']=wp_kses($content, array(
                'strong' => array(),
                'em' => array(),
                'a' => array(
                    'href' => array(),
                    'title' => array(),
                    'target' => array(),
                ),
                'p' => array(),
                'br' => array(),
            ));
        }
        
        ThemedbCore::updatePostMeta($ID, 'about', themedb_value('about', $data));
        ThemedbCore::updatePostMeta($ID, 'policy', themedb_value('policy', $data));
        
        if(empty(ThemedbInterface::$messages)) {
            $status=get_post_status($ID);
            if($status=='draft') {
                $args['post_status']='pending';
                if(ThemedbCore::checkOption('shop_approve')) {
                    $args['post_status']='publish';
                }
                
                $redirect=true;
            } else {
                ThemedbInterface::$messages[]=__('Shop has been successfully saved', 'dealexport');
                $_POST['success']=true;
            }
        }
        
        //update post
        wp_update_post($args);
        
        if($redirect && empty(ThemedbInterface::$messages)) {
            wp_redirect(ThemedbCore::getURL('shop-settings'));
            exit();
        }
    }
    
    /**
    * Gets shop withdrawals
     *
     * @access public
    * @param int $user
    * @param array $args
     * @return array
     */
    public static function getWithdrawals($user, $args=array()) {
        $withdrawals=get_posts(array_merge(array(
            'post_type' => 'withdrawal',
            'post_status' => 'pending',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'author' => $user,
        ), $args));
        
        return $withdrawals;
    }
    
    /**
    * Gets shop withdrawal
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getWithdrawal($ID) {
        $post=get_post($ID);
        $data=get_post_meta($ID);
        
        $withdrawal['ID']=$ID;
        $withdrawal['date']=$post->post_date;
        $withdrawal['amount']=abs(floatval(themedb_value('_'.THEMEDB_PREFIX.'amount', $data)));
        
        $method=themedb_value('_'.THEMEDB_PREFIX.'method', $data);
        $withdrawal['method']=array(
            'name' => $method,
            'label' => themedb_value($method, ThemedbCore::$components['forms']['withdrawal']['method']['options']),
        );
        
        if(isset(ThemedbCore::$components['forms']['withdrawal'][$method])) {
            foreach(ThemedbCore::$components['forms']['withdrawal'][$method] as $field) {
                $withdrawal[$field['name']]=themedb_value('_'.THEMEDB_PREFIX.$field['name'], $data);
            }
        }
        
        return $withdrawal;
    }
    
    /**
    * Adds shop withdrawal
     *
     * @access public
    * @param array $data
     * @return void
     */
    public static function addWithdrawal($data) {
        $user=get_current_user_id();
        self::updateBalance($user);
        
        $args=array(
            'post_type' => 'withdrawal',
            'post_status' => 'pending',
            'post_author' => $user,
        );
        
        $amount=ThemedbWoo::formatPrice(themedb_value('amount', $data), false);
        if(empty($amount)) {
            ThemedbInterface::$messages[]=__('"Amount" field is required', 'dealexport');
        } else {
            $balance=round(floatval(ThemedbCore::getUserMeta($user, 'balance')), 2);
            if($amount>$balance) {
                ThemedbInterface::$messages[]=__('Amount is larger than balance', 'dealexport');
            }
            
            $minimum=intval(ThemedbCore::getOption('withdrawal_min', 50));
            if($amount<$minimum) {
                ThemedbInterface::$messages[]=__('Amount is too small for withdrawal', 'dealexport');
            }
        }       
        
        $method=sanitize_title(themedb_value('method', $data));
        if(!isset(ThemedbCore::$components['forms']['withdrawal'][$method])) {
            ThemedbInterface::$messages[]=__('"Method" field is required', 'dealexport');
        }
        
        $recipient=array();
        if(isset(ThemedbCore::$components['forms']['withdrawal'][$method])) {
            foreach(ThemedbCore::$components['forms']['withdrawal'][$method] as $field) {
                $value=trim(sanitize_text_field(themedb_value($field['name'], $data)));
                
                if($field['type']=='select') {
                    $value=themedb_value($value, $field['options']);
                } else if($field['type']=='select_country') {
                    $value=themedb_value($value, ThemedbCore::$components['countries']);
                }
                
                if(empty($value)) {
                    ThemedbInterface::$messages[]='"'.$field['label'].'" '.__('field is required', 'dealexport');
                } else if($field['type']=='email' && !sanitize_email($value)) {
                    ThemedbInterface::$messages[]=__('Email address is invalid', 'dealexport');
                }
                
                $recipient[$field['name']]=$value;
            }
        }
        
        if(empty(ThemedbInterface::$messages)) {
            $withdrawal=wp_insert_post($args);
            if(!empty($withdrawal)) {
            
                //title
                wp_update_post(array(
                    'ID' => $withdrawal,
                    'post_title' => '#'.$withdrawal,
                ));
                
                //amount            
                ThemedbCore::updatePostMeta($withdrawal, 'amount', $amount);                
                
                //method                        
                ThemedbCore::updatePostMeta($withdrawal, 'method', $method);
                
                //recipient
                foreach(ThemedbCore::$components['forms']['withdrawal'][$method] as $field) {
                    ThemedbCore::updatePostMeta($withdrawal, $field['name'], $recipient[$field['name']]);
                }
                
                self::updateBalance($user);
            }
        }
    }
    
    /**
    * Updates shop withdrawal
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function updateWithdrawal($ID) {
        global $post;
        
        if(isset($post) && $post->post_type=='withdrawal') {
            self::updateBalance($post->post_author);
        }
    }
    
    /**
    * Removes shop withdrawal
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function removeWithdrawal($ID) {
        $user=get_current_user_id();
        
        wp_delete_post($ID, true);
        self::updateBalance($user);
    }
    
    /**
    * Renders withdrawal options
     *
     * @access public
    * @param int $ID
     * @return string
     */
    public static function renderWithdrawal($ID) {
        $out='';
        
        $author=self::getAuthor($ID);
        $withdrawal=self::getWithdrawal($ID);
        $nickname=get_user_meta($author, 'nickname', true);
        $fields['author']=array(
            'label' => __('Author', 'dealexport'),
            'value' => '<a href="'.get_edit_user_link($author).'">'.$nickname.'</a>',
        );
        
        $fields['date']=array(
            'label' => __('Date', 'dealexport'),
            'value' => date('Y/m/d', strtotime($withdrawal['date'])),
        );
        
        $fields['amount']=array(
            'label' => __('Amount', 'dealexport'),
            'value' => ThemedbWoo::getPrice($withdrawal['amount']),
        );
        
        $fields['method']=array(
            'label' => __('Method', 'dealexport'),
            'value' => $withdrawal['method']['label'],
        );
        
        if(isset(ThemedbCore::$components['forms']['withdrawal'][$withdrawal['method']['name']])) {
            foreach(ThemedbCore::$components['forms']['withdrawal'][$withdrawal['method']['name']] as $field) {
                $fields[$field['name']]=array(
                    'label' => $field['label'],
                    'value' => $withdrawal[$field['name']],
                );
            }
        }
        
        foreach($fields as $field) {
            $out.='<tr><th><h4 class="themedb-meta-title">'.$field['label'].'</h4></th><td class="themedb-meta-value">'.$field['value'].'</td></tr>';
        }
        
        return $out;
    }
    
    /**
    * Gets shipping settings
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getShipping($ID) {
        $shipping=ThemedbCore::getPostMeta($ID, 'shipping');
        
        if(ThemedbCore::checkOption('shop_shipping') || empty($shipping) || !is_array($shipping)) {
            $shipping=array(
                'free_shipping' => array(),
                'flat_rate' => array(),
                'international_delivery' => array(),
                'local_delivery' => array(),
                'local_pickup' => array(),
            );
        }
        
        return $shipping;
    }
    
    /**
    * Updates shipping settings
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function updateShipping($ID, $data) {
        $shipping=array();
        $methods=ThemedbWoo::getShippingMethods();
        $defaults=array(
            'free_shipping', 
            'flat_rate',
            'international_delivery',
            'local_delivery',
            'local_pickup',
        );
        
        foreach($defaults as $default) {
            if(isset($methods[$default])) {
                $shipping[$default]['enabled']=sanitize_title(themedb_value($default.'_enabled', $data));
                $shipping[$default]['availability']=sanitize_title(themedb_value($default.'_availability', $data));
                
                $countries=themedb_array($default.'_countries', $data);
                if(is_array($countries)) {
                    foreach($countries as &$country) {
                        if(is_array($country) && !empty($country)) {
                            $country=reset($country);
                        }
                    }
                }
                
                $shipping[$default]['countries']=$countries;                
                if($default=='free_shipping') {
                    $shipping[$default]['min_amount']=ThemedbWoo::formatPrice(themedb_value($default.'_min_amount', $data), false);
                } else if($default=='flat_rate') {
                    $shipping[$default]['default_cost']=ThemedbWoo::formatPrice(themedb_value($default.'_default_cost', $data), false);
                    
                    $costs=themedb_array($default.'_cost', $data);
                    if(is_array($costs)) {
                        foreach($costs as &$cost) {
                            $cost=ThemedbWoo::formatPrice($cost, false);
                        }
                    }                   
                    
                    $classes=themedb_array($default.'_class', $data);
                    $shipping[$default]['costs']=array();
                    
                    if(is_array($classes)) {
                        $classes=array_map('sanitize_title', $classes);
                        foreach($classes as $index => $class) {
                            if(isset($costs[$index]) && !empty($costs[$index])) {
                                $shipping[$default]['costs'][$class]=$costs[$index];
                            }
                        }
                    }
                } else if(in_array($default, array('international_delivery', 'local_delivery'))) {
                    $shipping[$default]['cost']=ThemedbWoo::formatPrice(themedb_value($default.'_cost', $data), false);
                }
            }
        }
        
        ThemedbCore::updatePostMeta($ID, 'shipping', $shipping);
        ThemedbInterface::$messages[]=__('Changes have been successfully saved', 'dealexport');
        $_POST['success']=true;
    }
    
    /**
    * Updates shop balance
     *
     * @access public
    * @param int $user
    * @param array $data
     * @return void
     */
    public static function updateBalance($user, $data=array()) {
        $shop=ThemedbUser::getShop($user);
        
        //values
        $revenue=0;
        $profit=0;
        $balance=0;
        $sales=0;
        
        //rates
        $rate_min=absint(ThemedbCore::getOption('shop_rate_min', 50));
        $rate_max=absint(ThemedbCore::getOption('shop_rate_max', 70));
        $rate_amount=absint(ThemedbCore::getOption('shop_rate_amount', 1000));
        
        if(isset($data['order'])) {
            $rate=$rate_min;
            if($rate_max>$rate_min) {
                $rate=absint(ThemedbCore::getUserMeta($user, 'rate', $rate_min));               
            }
            
            $rate=self::filterRate($shop, $rate);
            ThemedbCore::updatePostMeta($data['order'], 'rate', $rate);
        }
        
        //orders
        $orders=ThemedbWoo::getOrders($user, array(
            'post_status' => 'wc-completed',
        ));
        
        foreach($orders as $order) {
            $object=wc_get_order($order);
            $rate=absint(ThemedbCore::getPostMeta($order, 'rate', $rate_min));
            $total=$object->get_total()-$object->get_total_refunded();
            $amount=$total*$rate/100;
            
            $revenue=$revenue+$total;
            $profit=$profit+$amount;
            
            if($object->payment_method!='paypal-adaptive-payments') {
                $balance=$balance+$amount;
            }
            
            $sales=$sales+$object->get_item_count();
        }
        
        //referrals
        $rate=absint(ThemedbCore::getOption('shop_rate_referral', '30'));
        $referrals=ThemedbWoo::getReferrals($user, array(
            'post_status' => 'wc-completed',
        ));

        foreach($referrals as $referral) {
            $object=wc_get_order($referral);
            $total=$object->get_total()-$object->get_total_refunded();
            $amount=$total*$rate/100;
            
            $profit=$profit+$amount;
            $balance=$balance+$amount;
        }
        
        //withdrawals
        $withdrawals=self::getWithdrawals($user, array(
            'post_status' => array('pending', 'publish'),
        ));
        
        foreach($withdrawals as $withdrawal) {
            $amount=abs(floatval(ThemedbCore::getPostMeta($withdrawal, 'amount')));
            $balance=$balance-$amount;
        }
        
        //rate      
        if($rate_max>$rate_min) {
            $rate=absint($rate_min+$revenue/($rate_amount/($rate_max-$rate_min)));
            ThemedbCore::updateUserMeta($user, 'rate', $rate);
        }
        
        ThemedbCore::updateUserMeta($user, 'revenue', $revenue);
        ThemedbCore::updateUserMeta($user, 'profit', $profit);
        ThemedbCore::updateUserMeta($user, 'balance', $balance);        
        
        ThemedbCore::updatePostMeta($shop, 'sales', $sales);
    }
    
    /**
    * Updates shop rating
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function updateRating($ID) {
        $rating=get_comment_meta($ID, 'rating', true);
        if(!empty($rating)) {
            $comment=get_comment($ID);
            $user=get_post_field('post_author', $comment->comment_post_ID);
            $shop=ThemedbUser::getShop($user);          
            $rating=ThemedbWoo::getRating($user);           
            
            ThemedbCore::updatePostMeta($shop, 'rating', $rating['rating']);
            ThemedbCore::updatePostMeta($shop, 'ratings', $rating['ratings']);
        }
    }
    
    /**
    * Submits shop question
     *
     * @access public
    * @param array $data
     * @return void
     */
    public static function submitQuestion($data) {
        
        $type='product';
        if(isset($data['shop_id'])) {
            $type='shop';
        }
        
        $ID=intval(themedb_value($type.'_id', $data));
        if(!empty($ID)) {
            $question=sanitize_text_field(themedb_value('question', $data));
            if(empty($question)) {
                ThemedbInterface::$messages[]='"'.__('Question', 'dealexport').'" '.__('field is required', 'dealexport');
            }
            
            if(empty(ThemedbInterface::$messages)) {
                $user=get_userdata(get_current_user_id());
                $author=get_userdata(self::getAuthor($ID));
                
                $subject=__('Item Question', 'dealexport');
                $content=ThemedbCore::getOption('email_product_question', 'Sender: %user%<br />Item: %product%<br />Question: %question%');             
                if($type=='shop') {
                    $subject=__('Shop Question', 'dealexport');
                    $content=ThemedbCore::getOption('email_shop_question', 'Sender: %user%<br />Shop: %shop%<br />Question: %question%');
                }
                
                $link='<a href="'.get_permalink($ID).'">'.get_the_title($ID).'</a>';
                $keywords=array(
                    'user' => '<a href="'.get_author_posts_url($user->ID).'">'.$user->user_login.'</a>',
                    'shop' => $link,
                    'product' => $link,
                    'question' => wpautop($question),
                );
                
                $content=themedb_keywords($content, $keywords);
                themedb_mail($author->user_email, $subject, $content, $user->user_email);
                
                ThemedbInterface::$messages[]=__('Question has been successfully sent', 'dealexport');
                ThemedbInterface::renderMessages(true);
            } else {
                ThemedbInterface::renderMessages();
            }
        }
        
        die();
    }
    
    /**
    * Submits shop report
     *
     * @access public
    * @param array $data
     * @return void
     */
    public static function submitReport($data) {
        $shop=intval(themedb_value('shop_id', $data));
        
        if(!empty($shop)) {
            $reason=sanitize_text_field(themedb_value('reason', $data));
            if(empty($reason)) {
                ThemedbInterface::$messages[]='"'.__('Reason', 'dealexport').'" '.__('field is required', 'dealexport');
            }
            
            if(empty(ThemedbInterface::$messages)) {
                $subject=__('Shop Report', 'dealexport');
                $content=ThemedbCore::getOption('email_shop_report', 'Sender: %user%<br />Shop: %shop%<br />Reason: %reason%');
                $user=get_userdata(get_current_user_id());
                
                $keywords=array(
                    'user' => '<a href="'.get_author_posts_url($user->ID).'">'.$user->user_login.'</a>',
                    'shop' => '<a href="'.get_permalink($shop).'">'.get_the_title($shop).'</a>',
                    'reason' => wpautop($reason),
                );
                
                $content=themedb_keywords($content, $keywords);
                themedb_mail(get_option('admin_email'), $subject, $content, $user->user_email);
                
                ThemedbInterface::$messages[]=__('Report has been successfully sent', 'dealexport');
                ThemedbInterface::renderMessages(true);
            } else {
                ThemedbInterface::renderMessages();
            }
        }
        
        die();
    }
}