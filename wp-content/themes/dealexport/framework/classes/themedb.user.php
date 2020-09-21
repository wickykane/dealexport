<?php
/**
 * Themedb User
 *
 * Handles users data
 *
 * @class ThemedbUser
 * @author Themedb
 */
 
class ThemedbUser {

    /** @var array Contains module data. */
    public static $data;

    /**
    * Adds actions and filters
     *
     * @access public
     * @return void
     */
    public static function init() {
    
        //refresh module data
        add_action('wp', array(__CLASS__, 'refresh'), 2);
        
        //update user actions
        add_action('wp', array(__CLASS__, 'updateUser'), 1);
        add_action('wp_ajax_themedb_update_user', array(__CLASS__, 'updateUser'));
        add_action('wp_ajax_nopriv_themedb_update_user', array(__CLASS__, 'updateUser'));
        add_action('template_redirect', array(__CLASS__, 'activateUser'));
        
        //membership actions
        add_filter('save_post',  array(__CLASS__, 'updateMembership'));
        add_action('template_redirect', array(__CLASS__, 'filterMembership'));
        add_action('save_post', array(__CLASS__, 'triggerMembership'));
        add_action('delete_post', array(__CLASS__, 'triggerMembership'));
        
        //add avatar filter
        add_filter('get_avatar', array(__CLASS__, 'getAvatar'), 10, 5);
        
        //render admin profile
        add_filter('show_user_profile', array(__CLASS__,'renderAdminProfile'));
        add_filter('edit_user_profile', array(__CLASS__,'renderAdminProfile'));
        
        //update admin profile
        add_action('edit_user_profile_update', array(__CLASS__,'updateAdminProfile'));
        add_action('personal_options_update', array(__CLASS__,'updateAdminProfile'));
        
        //render admin toolbar
        add_filter('show_admin_bar', array(__CLASS__,'renderToolbar'));
    }
    
    /**
    * Refreshes module data
     *
     * @access public	 
     * @return void
     */
    public static function refresh() {
        $ID=get_current_user_id();
        self::$data['current']=self::getUser($ID, true);

        $user=0;
        if($var=get_query_var('author')) {
            $user=intval($var);
        }
        
        if($user!=0) {
            self::$data['active']=self::getUser($user, true);
        } else {
            self::$data['active']=self::$data['current'];
        }
    }
    
    /**
    * Updates user
     *
     * @access public	 
     * @return void
     */
    public static function updateUser() {		
        
        $data=$_POST;
        if(isset($_POST['data'])) {
            parse_str($_POST['data'], $data);
        }
        
        if(isset($data['user_action'])) {
            $action=sanitize_title($data['user_action']);
            $ID=get_current_user_id();
            $redirect=false;

            if(!empty($ID)) {
                switch($action) {
                    case 'update_avatar':
                        self::updateAvatar($ID, themedb_array('user_avatar', $_FILES));
                        $redirect=true;
                    break;
                    
                    case 'update_profile':
                        self::updateProfile($ID, $data);
                    break;
                    
                    case 'update_settings':
                        self::updateSettings($ID, $data);
                    break;
                    
                    case 'add_membership':
                        self::addMembership($ID, themedb_array('membership_id', $data));
                    break;
                    
                    case 'add_relation':
                        self::addRelation($ID, $data);
                    break;
                    
                    case 'remove_relation':
                        self::removeRelation($ID, $data);
                    break;
                    
                    case 'submit_message':
                        self::submitMessage($ID, $data);
                    break;
                }
            }
            
            switch($action) {			
                case 'register_user':
                    self::registerUser($data);
                break;
                
                case 'login_user':
                    self::loginUser($data);
                break;
                
                case 'reset_user':
                    self::resetUser($data);
                break;
            }
            
            if($redirect || empty(ThemedbInterface::$messages)) {
                wp_redirect(themedb_url());
                exit();
            }
        }
    }
    
    /**
    * Gets user
     *
     * @access public
    * @param int $ID
    * @param bool $extended
     * @return array
     */
    public static function getUser($ID, $extended=false) {
        $data=get_userdata($ID);
        if($data!=false) {
            $user['login']=$data->user_login;
            $user['email']=$data->user_email;
            $user['date']=$data->user_registered;
        }
    
        $user['ID']=$ID;
        $user['profile']=self::getProfile($ID);
        $user['settings']=self::getSettings($ID);
        
        $user['shop']=self::getShop($ID);
        $user['favorites']=array_reverse(ThemedbCore::getUserRelations($ID, 0, 'product'));
        $user['shops']=ThemedbCore::getUserRelations($ID, 0, 'shop');
        $user['updates']=ThemedbWoo::getRelations($user['shops']);
        $user['clicks']=intval(ThemedbCore::getUserMeta($ID, 'clicks'));
        $user['profit']=round(floatval(ThemedbCore::getUserMeta($ID, 'profit')), 2);		
        $user['balance']=round(floatval(ThemedbCore::getUserMeta($ID, 'balance')), 2);
        
        if($extended) {
            $user['links']=self::getLinks($ID, array(
                'shops' => !ThemedbCore::checkOption('shop_multiple'),
                'shop' => themedb_status($user['shop'])=='publish',
                'referrals' => !ThemedbCore::checkOption('shop_referrals'),
                'woocommerce' => ThemedbWoo::isActive(),
                'address' => !ThemedbCore::checkOption('profile_address'),
                'links' => !ThemedbCore::checkOption('profile_links'),
                'shipping' => !ThemedbCore::checkOption('shop_shipping') && ThemedbWoo::isShipping(),
                'membership' => ThemedbCore::checkOption('membership_free'),
            ));
        }
        
        return $user;
    }
    
    /**
    * Gets user profile
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getProfile($ID) {
        $profile=array();
        $data=get_user_meta($ID);

        foreach(ThemedbCore::$components['forms'] as $fields) {
            foreach($fields as $field) {
                if(!is_array(reset($field))) {
                    if(!isset($field['prefix']) || $field['prefix']) {
                        $profile[$field['name']]=themedb_value('_'.THEMEDB_PREFIX.$field['name'], $data);
                    } else {
                        $profile[$field['name']]=themedb_value($field['name'], $data);
                    }
                }
            }
        }
        
        //get name
        $profile['nickname']=themedb_value('nickname', $data);
        $profile['description']=themedb_value('description', $data);
        
        if(empty($profile['first_name'])) {
            $profile['first_name']=$profile['nickname'];
            $profile['last_name']='';
            $profile['full_name']=$profile['first_name'];
        } else {
            $profile['last_name']=themedb_value('last_name', $data);
            $profile['full_name']=trim($profile['first_name'].' '.$profile['last_name']);
        }
        
        //get location
        $profile['location']=$profile['billing_city'];
        if(!empty($profile['billing_country'])) {
            if(!empty($profile['location'])) {
                $profile['location'].=', ';
            }
            
            $profile['location'].=themedb_value($profile['billing_country'], ThemedbCore::$components['countries']);
        }
        
        //get fields
        if(ThemedbForm::isActive('profile')) {
            foreach(ThemedbForm::$data['profile']['fields'] as $field) {
                $name=themedb_sanitize_key($field['name']);
                if(!isset($profile[$name])) {
                    $profile[$name]='';					
                    if(isset($data['_'.THEMEDB_PREFIX.$name][0])) {
                        $profile[$name]=$data['_'.THEMEDB_PREFIX.$name][0];
                    }
                }
            }
        }
        
        return $profile;
    }
    
    /**
    * Updates user profile
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function updateProfile($ID, $data) {
    
        $shop=self::getShop($ID);
        if(!empty($shop)) {
            if(isset($data['billing_country'])) {
                $country=trim(sanitize_text_field($data['billing_country']));
                ThemedbCore::updatePostMeta($shop, 'country', $country);
            }
            
            if(isset($data['billing_city'])) {
                $city=trim(sanitize_text_field($data['billing_city']));
                $city=ucwords(strtolower($city));
                
                ThemedbCore::updatePostMeta($shop, 'city', $city);
            }
        }
        
        foreach(ThemedbCore::$components['forms'] as $form=>$fields) {
            if($form=='profile' && ThemedbForm::isActive('profile')) {
                $customs=ThemedbForm::$data['profile']['fields'];
                foreach($customs as &$custom) {
                    $custom['name']=themedb_sanitize_key($custom['name']);
                }
                
                $fields=array_merge($fields, $customs);
            }
            
            foreach($fields as $field) {
                if(isset($field['name']) && isset($data[$field['name']])) {
                    $name=$field['name'];
                    $alias=themedb_value('alias', $field);
                    $type=themedb_value('type', $field);
                    $value=$data[$name];
                    
                    if($type=='text') {
                        $value=trim(sanitize_text_field($value));
                    } else if($type=='number') {
                        $value=intval($value);
                    }
                    
                    if($name=='billing_city') {
                        $value=ucwords(strtolower($value));
                    }
                    
                    if(isset($field['required']) && $field['required'] && ($value=='' || ($type=='select' && $value=='0'))) {
                        ThemedbInterface::$messages[]='"'.$field['label'].'" '.__('field is required', 'dealexport');
                    } else {
                        if(!isset($field['prefix']) || $field['prefix']) {
                            ThemedbCore::updateUserMeta($ID, $name, $value);
                        } else {
                            update_user_meta($ID, $name, $value);							
                            if(!empty($alias)) {
                                update_user_meta($ID, $alias, $value);
                            }
                        }
                    }
                }
            }
        }
        
        if(isset($data['description'])) {
            $data['description']=trim($data['description']);
            $data['description']=wp_kses($data['description'], array(
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

            update_user_meta($ID, 'description', $data['description']);
        }
        
        if(empty(ThemedbInterface::$messages)) {
            ThemedbInterface::$messages[]=__('Profile has been successfully saved', 'dealexport');
            $_POST['success']=true;
        }
    }
    
    /**
    * Filters default avatar
     *
     * @access public
    * @param string $avatar
    * @param int $user_id
    * @param int $size
    * @param string $default
    * @param string $alt
     * @return string
     */
    public static function getAvatar($avatar, $user, $size, $default, $alt) {
        if(isset($user->user_id)) {
            $user=$user->user_id;
        }
        
        $avatar_id=ThemedbCore::getUserMeta($user, 'avatar');
        $default=wp_get_attachment_url($avatar_id);
        $image=THEME_URI.'images/avatar.png';
        
        if($default!==false) {
            $thumbnail=themedb_resize($default, $size, $size);
            if(!empty($thumbnail)) {
                $image=$thumbnail;
            }
        }
        
        $out='<img src="'.$image.'" class="avatar" width="'.$size.'" alt="'.$alt.'" />';
        return $out;
    }
    
    /**
    * Updates user avatar
     *
     * @access public
    * @param int $ID
    * @param array $file
     * @return void
     */
    public static function updateAvatar($ID, $file) {		
        $avatar=intval(ThemedbCore::getUserMeta($ID, 'avatar'));
        $attachment=ThemedbCore::addFile($file);
        wp_delete_attachment($avatar, true);
        
        if(isset($attachment['ID']) && $attachment['ID']!=0) {
            ThemedbCore::updateUserMeta($ID, 'avatar', $attachment['ID']);
        }
    }
    
    /**
    * Gets user settings
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getSettings($ID) {
        $settings['notices']=ThemedbCore::getUserMeta($ID, 'notices', '1');
        
        return $settings;
    }
    
    /**
    * Updates user settings
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function updateSettings($ID, $data) {
        $current=get_user_by('id', $ID);
        $facebook=ThemedbFacebook::isUpdated($ID);
        $required=false;
        
        $user=array(
            'ID' => $ID,
        );
        
        //password
        $new_password=trim(themedb_value('new_password', $data));
        if(!empty($new_password)) {
            $confirm_password=trim(themedb_value('confirm_password', $data));
            $user['user_pass']=$new_password;
            $required=true;
            
            if(strlen($new_password)<4) {
                ThemedbInterface::$messages[]=__('Password must be at least 4 characters long', 'dealexport');
            } else if(strlen($new_password)>16) {
                ThemedbInterface::$messages[]=__('Password must be not more than 16 characters long', 'dealexport');
            } else if(preg_match("/^([a-zA-Z0-9@#-_$%^&+=!?]{1,20})$/", $new_password)==0) {
                ThemedbInterface::$messages[]=__('Password contains invalid characters', 'dealexport');
            } else if($new_password!=$confirm_password) {
                ThemedbInterface::$messages[]=__('Passwords do not match', 'dealexport');
            }
        }
        
        //email
        $email=trim(themedb_value('email', $data));
        if($email!=$current->user_email) {
            $user['user_email']=$email;
            $required=true;
            
            if(!is_email($email)) {
                ThemedbInterface::$messages[]=__('Email address is invalid', 'dealexport');
            }
        }
        
        //notices
        $notices=themedb_value('notices', $data);
        ThemedbCore::updateUserMeta($ID, 'notices', $notices);
        
        $current_password=trim(themedb_value('current_password', $data));
        if($required && $facebook && !wp_check_password($current_password, $current->user_pass, $current->ID)) {
            ThemedbInterface::$messages[]=__('Current password is incorrect', 'dealexport');
        }
        
        if(empty(ThemedbInterface::$messages)) {
            wp_update_user($user);			
            if(isset($user['user_email'])) {
                update_user_meta($ID, 'billing_email', $user['user_email']);
            }
            
            if(isset($user['user_pass']) && !$facebook) {
                ThemedbFacebook::updateUser($ID);
            }
            
            ThemedbInterface::$messages[]=__('Settings have been successfully saved', 'dealexport');
            $_POST['success']=true;
        }
    }
    
    /**
    * Updates user membership
     *
    * @param int $ID
     * @access public
     * @return void
     */
    public static function updateMembership($ID) {
        if(current_user_can('edit_posts') && isset($_POST['post_type']) && $_POST['post_type']=='membership') {
            if(isset($_POST['add_user']) && isset($_POST['add_user_id'])) {
                self::addMembership(intval($_POST['add_user_id']), $ID, false);
            } else if(isset($_POST['remove_user']) && isset($_POST['remove_user_id'])) {
                self::removeMembership(intval($_POST['remove_user_id']));
            }
        }
    }
    
    /**
    * Adds user membership
     *
     * @access public
    * @param int $ID
    * @param int $membership
    * @param bool $checkout
     * @return void
     */
    public static function addMembership($ID, $membership, $checkout=true) {
        $membership=intval($membership);
        
        if($checkout && ThemedbWoo::isActive()) {
            $product=intval(ThemedbCore::getPostMeta($membership, 'product'));
            if($product!=0) {
                ThemedbWoo::checkoutProduct($product);
            }
        } else {
            if($membership==0) {
                $period=0;
            } else {
                $period=absint(ThemedbCore::getPostMeta($membership, 'period'));							
            }
            
            $date=$period*86400+current_time('timestamp');
            if($period==0) {
                $date=0;
            }
            
            ThemedbCore::updateUserMeta($ID, 'membership', strval($membership));
            ThemedbCore::updateUserMeta($ID, 'membership_date', strval($date));
        }
        
        self::countMembership($ID);
    }
    
    /**
    * Removes user membership
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function removeMembership($ID) {
        self::addMembership($ID, 0, false);
        self::countMembership($ID);
    }
    
    /**
    * Gets user membership
     *
     * @access public
    * @param int $ID
     * @return array
     */
    public static function getMembership($ID) {	
        $membership=array();
        
        $membership['ID']=ThemedbCore::getUserMeta($ID, 'membership');
        if($membership['ID']!=='') {
            $membership['ID']=intval($membership['ID']);
        }
        
        $membership['title']=get_the_title($membership['ID']);
        if(empty($membership['ID'])) {
            $membership['title']=__('Free', 'dealexport');
        }
        
        $date=intval(ThemedbCore::getUserMeta($ID, 'membership_date'));
        $membership['date']=date(get_option('date_format'), $date);
        if($date<current_time('timestamp')) {
            $membership['date']='&ndash;';
        }
        
        $membership['products']=absint(ThemedbCore::getPostMeta($membership['ID'], 'products'));
        if($membership['ID']===0) {
            $membership['products']=0;			
        } else if($membership['ID']==='') {
            $membership['products']=absint(ThemedbCore::getOption('membership_products'));
        }
        
        if($membership['products']<0) {
            $membership['products']=0;
        }
        
        return $membership;
    }
    
    /**
    * Filters user membership
     *
     * @access public
     * @return void
     */
    public static function filterMembership() {
        if(ThemedbCore::checkOption('membership_free') && is_user_logged_in()) {
            $user=get_current_user_id();
            $shop=self::getShop($user);
            
            if(!empty($shop)) {
                $membership=ThemedbCore::getUserMeta($user, 'membership');
                if($membership!=='') {
                    $membership=intval($membership);
                }
                
                if($membership!==0) {
                    $date=ThemedbCore::getUserMeta($user, 'membership_date');
                    if($date==='') {
                        $period=absint(ThemedbCore::getOption('membership_period', 31));
                        $date=$period*86400+current_time('timestamp');
                        if($period==0) {
                            $date=0;
                        }
                        
                        ThemedbCore::updateUserMeta($user, 'membership_date', strval($date));
                    }
                    
                    $date=intval($date);
                    if($date<current_time('timestamp') && $date!=0) {
                        self::removeMembership($user);
                    }
                }
            }
        }
    }
    
    /**
    * Triggers user membership
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function triggerMembership($ID) {
        global $post;
        
        if(isset($post) && $post->post_type=='product') {
            self::countMembership($post->post_author);
        }
    }
    
    /**
    * Counts user membership
     *
     * @access public
    * @param int $ID
     * @return void
     */
    public static function countMembership($ID) {
        global $wpdb;
        
        $results=$wpdb->get_results($wpdb->prepare("
            SELECT COUNT(ID) AS products FROM ".$wpdb->posts." 
            WHERE post_type = 'product' 
            AND  post_status NOT IN('trash') 
            AND post_author = %d", $ID));
        
        $results=wp_list_pluck($results, 'products');
        $products=intval(reset($results));
        
        $membership=ThemedbCore::getUserMeta($ID, 'membership');
        if($membership!=='') {
            $membership=intval($membership);
        }
        
        if($membership===0) {
            $limit=0;
        } else if($membership==='') {
            $limit=absint(ThemedbCore::getOption('membership_products'));
        } else {			
            $limit=absint(ThemedbCore::getPostMeta($membership, 'products'));
        }
        
        if($products>$limit) {
            ThemedbCore::updateUserMeta($ID, 'hidden', 1);
        } else {
            ThemedbCore::updateUserMeta($ID, 'hidden', 0);
        }
    }
    
    /**
    * Checks user membership
     *
     * @access public
    * @param int $ID
     * @return bool
     */
    public static function isMember($ID) {
        if(ThemedbCore::checkOption('membership_free')) {
            $hidden=intval(ThemedbCore::getUserMeta($ID, 'hidden'));
            if($hidden==1) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
    * Gets membership period
     *
     * @access public
    * @param int $membership
     * @return string
     */
    public static function getPeriod($membership) {
        $price='';
        
        $product=intval(ThemedbCore::getPostMeta($membership, 'product'));
        if(!empty($product)) {
            $period=intval(ThemedbCore::getPostMeta($membership, 'period'));
            $price=ThemedbWoo::getPeriod($product, $period);
        }
        
        return $price;
    }
    
    /**
    * Adds user relation
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function addRelation($ID, $data) {
        $relation=themedb_value('relation_id', $data);
        $type=themedb_value('relation_type', $data);
        
        if(in_array($type, array('shop', 'product'))) {
            ThemedbCore::addUserRelation($ID, $relation, $type);
            
            if($type=='shop') {
                $relations=count(ThemedbCore::getUserRelations(0, $relation, 'shop'));
                ThemedbCore::updatePostMeta($relation, 'admirers', $relations);
            }
        }
        
        die();
    }
    
    /**
    * Removes user relation
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function removeRelation($ID, $data) {
        $relation=themedb_value('relation_id', $data);
        $type=themedb_value('relation_type', $data);
        
        if(in_array($type, array('shop', 'product'))) {
            ThemedbCore::removeUserRelation($ID, $relation, $type);
            
            if($type=='shop') {
                $relations=count(ThemedbCore::getUserRelations(0, $relation, 'shop'));
                ThemedbCore::updatePostMeta($relation, 'admirers', $relations);
            }
        }
        
        die();
    }
    
    /**
    * Gets user shop
     *
     * @access public
    * @param int $ID
     * @return int
     */
    public static function getShop($ID) {
        global $wpdb;
        
        $shop=intval($wpdb->get_var($wpdb->prepare("
            SELECT ID FROM {$wpdb->posts} 
            WHERE post_type = 'shop' 
            AND post_status IN ('publish', 'pending', 'draft') 
            AND post_author = %d 
        ", intval($ID))));
        
        return $shop;
    }
    
    /**
    * Gets user links
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return array
     */
    // check role here
    public static function getLinks($ID, $data=array()) {
        
        // TNH add check user role
        $shop_accepted_role = array('shop_manager');
        
        $links=array(
            'profile' => array(
                'name' => __('My Profile', 'dealexport'),
                'url' => get_author_posts_url($ID),
                'child' => array(
                    'address' => array(
                        'name' => __('Address', 'dealexport'),
                        'url' => ThemedbCore::getURL('profile-address'),
                        'visible' => $data['woocommerce'] && $data['address'],
                    ),
                    'links' => array(
                        'name' => __('Links', 'dealexport'),
                        'url' => '#', //ThemedbCore::getURL('profile-links'),
                        'visible' => $data['links'],
                    ),
                ),
            ),
            'orders' => array(
                'name' => __('My Orders', 'dealexport'),
                'url' => '#', //get_permalink(get_option('woocommerce_myaccount_page_id')),
                'visible' => self::check_user_role($shop_accepted_role) &&  $data['woocommerce'],
            ),
            'settings' => array(
                'name' => __('My Settings', 'dealexport'),
                'url' => ThemedbCore::getURL('profile-settings'),
            ),
            'referrals' => array(
                'name' => __('My Referrals', 'dealexport'),
                'url' => '#', //ThemedbCore::getURL('profile-referrals'),
                'visible' => self::check_user_role($shop_accepted_role) && $data['woocommerce'] && $data['referrals'],
            ),
            'shop' => array(
                'name' => __('My Shop', 'dealexport'),
                'url' => '#', //ThemedbCore::getURL('shop-settings'),
                'visible' => (self::check_user_role($shop_accepted_role) && $data['shops']),
                'child' => array(
                    'products' => array(
                        'name' => __('Items', 'dealexport'),
                        'url' => '#', //ThemedbCore::getURL('shop-products'),
                        'visible' => $data['shop'] && $data['woocommerce'],
                    ),		
                    'orders' => array(
                        'name' => __('Orders', 'dealexport'),
                        'url' => '#', //ThemedbCore::getURL('shop-orders'),
                        'visible' => $data['shop'] && $data['woocommerce'],
                    ),
                    
                    'shipping' => array(
                        'name' => __('Shipping', 'dealexport'),
                        'url' => '#', //ThemedbCore::getURL('shop-shipping'),
                        'visible' => $data['shop'] && $data['woocommerce'] && $data['shipping'],
                    ),
                    
                    'membership' => array(
                        'name' => __('Membership', 'dealexport'),
                        'url' => '#', //ThemedbCore::getURL('shop-membership'),
                        'visible' => $data['shop'] && $data['membership'],
                    ),
                ),
            ),
            'earnings' => array(
                'name' => __('My Earnings', 'dealexport'),
                'url' => '#', //ThemedbCore::getURL('profile-earnings'),
                'visible' => self::check_user_role($shop_accepted_role) && (($data['shop'] && $data['shops']) || $data['referrals']) && $data['woocommerce'],
            ),
        );
        
        //custom links
        if(get_query_var('shop-product')) {
            $links['shop']['child']['products']['current']=true;
        }
        
        if(get_query_var('shop-order')) {
            $links['shop']['child']['orders']['current']=true;
        }
        
        //default links
        $current=themedb_url();
        foreach($links as $link_key => &$link) {
            if(isset($link['visible']) && !$link['visible']) {
                unset($links[$link_key]);
            } else {
                $link['current']=false;
                if(in_array($current, array($link['url'], $link['url'].'/'))) {
                    $link['current']=true;
                }
                
                if(isset($link['child'])) {
                    foreach($link['child'] as $child_key => &$child) {
                        if(isset($child['visible']) && !$child['visible']) {
                            unset($link['child'][$child_key]);
                        } else {
                            if(!isset($child['current'])) {
                                $child['current']=false;
                                if(in_array($current, array($child['url'], $child['url'].'/'))) {
                                    $child['current']=true;
                                }
                            }
                            
                            if($child['current']) {
                                $link['current']=true;
                            }
                        }
                    }
                }
            }
        }
        
        return $links;
    }
    
    /**
    * Registers user
     *
     * @access public
     * @param array $data
     * @return void
     */
    public static function registerUser($data) {
        if(ThemedbCore::checkOption('user_captcha')) {
            session_start();
            if(isset($data['captcha']) && isset($_SESSION['captcha'])) {
                $posted_code=md5($data['captcha']);
                $session_code=$_SESSION['captcha'];
                
                if($session_code!=$posted_code) {
                    ThemedbInterface::$messages[]=__('Verification code is incorrect', 'dealexport');
                }
            } else {
                ThemedbInterface::$messages[]=__('Verification code is empty', 'dealexport');
            }
        }
        
        if(empty($data['user_email']) || empty($data['user_login']) || empty($data['user_password']) ||
                empty($data['user_password_repeat']) || empty($data['first_name']) || empty($data['last_name']) ||
                empty($data['role'])) {
            ThemedbInterface::$messages[]=__('Please fill in all fields', 'dealexport');
        } else {
            if(!is_email($data['user_email'])) {
                ThemedbInterface::$messages[]=__('Invalid email address', 'dealexport');
            } else if(email_exists($data['user_email'])) {;
                ThemedbInterface::$messages[]=__('This email is already in use', 'dealexport');
            }
            
            if(!validate_username($data['user_login']) || is_email($data['user_login']) || preg_match('/\s/', $data['user_login'])) {
                ThemedbInterface::$messages[]=__('Invalid character used in username', 'dealexport');
            } else	if(username_exists($data['user_login'])) {
                ThemedbInterface::$messages[]=__('This username is already taken', 'dealexport');
            }
            
            if(strlen($data['user_password'])<4) {
                ThemedbInterface::$messages[]=__('Password must be at least 4 characters long', 'dealexport');
            } else if(strlen($data['user_password'])>16) {
                ThemedbInterface::$messages[]=__('Password must be not more than 16 characters long', 'dealexport');
            } else if(preg_match("/^([a-zA-Z0-9@#-_$%^&+=!?]{1,20})$/", $data['user_password'])==0) {
                ThemedbInterface::$messages[]=__('Password contains invalid characters', 'dealexport');
            } else if($data['user_password']!=$data['user_password_repeat']) {
                ThemedbInterface::$messages[]=__('Passwords do not match', 'dealexport');
            }
            
            if($data['role'] == 'shop_manager'){
                if(empty($data['name_of_supplier']) || $data['shop_categories'] == 0 || empty($data['shop_country']) ||
                   empty($data['shop_region']) ) {
                    ThemedbInterface::$messages[]=__('Please fill in all fields for shop', 'dealexport');
                }
            }
        }
        
        if(empty(ThemedbInterface::$messages)){
            $userId= self::dp_create_user($data);

            // Send mail to user
            $subject_user_mail = $subject=__('User registration complete', 'dealexport');
            $content_user_mail = self::get_email_template('register-email-template', $userId);
            themedb_mail($data['user_email'], $subject_user_mail, $content_user_mailtent);
            
            // Generate mail send to administrator
            $keywords=array(
                'username' => $data['user_login'],
                'password' => $data['user_password'],
                'userrole' => $data['role'],
                'usermail' => $data['user_email']
            );
            
            if(ThemedbCore::checkOption('user_activation')) {
                ThemedbInterface::$messages[]=__('Registration complete! Please wait for administrator validate your account', 'dealexport');
                $subject=__('Account Confirmation : new user registration complete with role '.$data['role'], 'dealexport');
                $activation_key=md5(uniqid(rand(), 1));
                
                $user=new WP_User($userId);
                $user->remove_role(get_option('default_role'));
                $user->add_role('inactive');
                ThemedbCore::updateUserMeta($user->ID, 'activation_key', $activation_key);

                $link=ThemedbCore::getURL('register');
                if(intval(substr($link, -1))==1) {
                    $link.='&';
                } else {
                    $link.='?';
                }
                
                $keywords['link']=$link.'activate='.urlencode($activation_key).'&user='.$user->ID;
                
                $content = self::get_email_template('admin-account-cofirmation-template', $userId);
                
                $shopInfo = '';
                if($data[role] == 'shop_manager'){
                    $shopInfo = '<li>Shop name: '.$data['name_of_supplier'].'</li>';
                    $shopInfo .= '<li>Shop category:  '.$data['shop_categories'].'</li>';
                    $shopInfo .= '<li>Shop country: '.$data['shop_country'].'</li>';
                    $shopInfo .= '<li>Shop region: '.$data['region'].'</li>';
                }
                $keywords['shopinfo'] = $shopInfo;
                
            } else {
                $object=new WP_User($user);
                $object->remove_role(get_option('default_role'));
                $object->add_role('customer');
                
                wp_signon($data, false);
                $subject=__('Registration Complete', 'dealexport');
                ThemedbInterface::$messages[]='<a href="'.get_author_posts_url($user).'" class="redirect"></a>';
            }
            
            $content=themedb_keywords($content, $keywords);
            themedb_mail(get_option('admin_email'), $subject, $content);
            ThemedbInterface::renderMessages(true);
        } else {
            ThemedbInterface::renderMessages();
        }
                    
        die();
    }
    
    /**
    * Logins user
     *
     * @access public
    * @param array $data
     * @return void
     */
    public static function loginUser($data) {
        $data['remember']=true;		
        $user=wp_signon($data, false);
        
        if(is_wp_error($user) || empty($data['user_login']) || empty($data['user_password'])){
            ThemedbInterface::$messages[]=__('Incorrect username or password', 'dealexport');
        } else {
            $role=array_shift($user->roles);
            if($role=='inactive') {
                ThemedbInterface::$messages[]=__('This account is not activated', 'dealexport');
            }
        }
        
        if(empty(ThemedbInterface::$messages)) {
            ThemedbInterface::$messages[]='<a href="'.get_author_posts_url($user->ID).'" class="redirect"></a>';
        } else {
            wp_logout();
        }
            
        ThemedbInterface::renderMessages();
        die();
    }
    
    /**
    * Activates user
     *
     * @access public
     * @return void
     */
    public static function activateUser() {
        if(isset($_GET['activate']) && isset($_GET['user']) && intval($_GET['user'])!=0) {
            $users=get_users(array(
                'meta_key' => '_'.THEMEDB_PREFIX.'activation_key',
                'meta_value' => sanitize_text_field($_GET['activate']),
                'include' => intval($_GET['user']),
            ));
            
            if(!empty($users)) {
                $user=reset($users);
                $user=new WP_User($user->ID);
                $user->remove_role('inactive');
                $user->add_role('subscriber');
                // TNH : Disable clear cookie 
                // wp_set_auth_cookie($user->ID, true);
                ThemedbCore::updateUserMeta($user->ID, 'activation_key', '');				
                
                wp_redirect(get_author_posts_url($user->ID));
                exit();
            }
        }
    }
    
    /**
    * Resets password
     *
     * @access public
    * @param array $data
     * @return void
     */
    public static function resetUser($data) {
        global $wpdb, $wp_hasher;
        
        $success=false;		
        if(email_exists(sanitize_email($data['user_email']))) {
            $user=get_user_by('email', sanitize_email($data['user_email']));
            do_action('lostpassword_post');
            
            $login=$user->user_login;
            $email=$user->user_email;
            
            do_action('retrieve_password', $login);
            $allow=apply_filters('allow_password_reset', true, $user->ID);
            
            if(!$allow || is_wp_error($allow)) {
                ThemedbInterface::$messages[]=__('Password recovery not allowed', 'dealexport');
            } else {
                $key=wp_generate_password(20, false);
                do_action('retrieve_password_key', $login, $key);
                
                if(empty($wp_hasher)){
                    require_once ABSPATH.'wp-includes/class-phpass.php';
                    $wp_hasher=new PasswordHash(8, true);
                }

                $hashed=time().':'.$wp_hasher->HashPassword($key);
                $wpdb->update($wpdb->users, array('user_activation_key' => $hashed), array('user_login' => $login), array('%s'), array('%s'));
                
                $link=network_site_url('wp-login.php?action=rp&key='.$key.'&login='.rawurlencode($login), 'login');				
                $content=ThemedbCore::getOption('email_password', 'Hi, %username%! To reset your password, visit the following link: %link%.');
                $keywords=array(
                    'username' => $user->user_login,
                    'link' => $link,
                );
                
                $content=themedb_keywords($content, $keywords);
                if(themedb_mail($email, __('Password Recovery', 'dealexport'), $content)) {
                    ThemedbInterface::$messages[]=__('Password reset link is sent', 'dealexport');
                    $success=true;
                } else {
                    ThemedbInterface::$messages[]=__('Error sending email', 'dealexport');
                }
            }
        } else {
            ThemedbInterface::$messages[]=__('Invalid email address', 'dealexport');		
        }
        
        ThemedbInterface::renderMessages($success);	
        die();
    }
    
    /**
    * Submits user message
     *
     * @access public
    * @param int $ID
    * @param array $data
     * @return void
     */
    public static function submitMessage($ID, $data) {
        $user=intval(themedb_value('user_id', $data));
        
        if(!empty($user)) {
            $message=sanitize_text_field(themedb_value('message', $data));
            if(empty($message)) {
                ThemedbInterface::$messages[]='"'.__('Message', 'dealexport').'" '.__('field is required', 'dealexport');
            }
            
            if(empty(ThemedbInterface::$messages)) {
                $subject=__('New Message', 'dealexport');
                $content=ThemedbCore::getOption('email_message', 'Sender: %user%<br />Message: %message%');
                
                $receiver=get_userdata($user);
                $sender=get_userdata($ID);				
                
                $keywords=array(
                    'user' => '<a href="'.get_author_posts_url($sender->ID).'">'.$sender->user_login.'</a>',
                    'message' => wpautop($message),
                );
                
                $content=themedb_keywords($content, $keywords);
                themedb_mail($receiver->user_email, $subject, $content, $sender->user_email);
                
                ThemedbInterface::$messages[]=__('Message has been successfully sent', 'dealexport');
                ThemedbInterface::renderMessages(true);
            } else {
                ThemedbInterface::renderMessages();
            }
        }
        
        die();
    }
    
    /**
    * Renders admin profile
     *
     * @access public
    * @param mixed $user
     * @return void
     */
    public static function renderAdminProfile($user) {
        $profile=self::getProfile($user->ID);
        $out='<table class="form-table themedb-profile"><tbody>';
        
        if(current_user_can('edit_users')) {
            $out.='<tr><th><label for="avatar">'.__('Profile Photo', 'academy').'</label></th>';
            $out.='<td><div class="themedb-image-uploader">';
            $out.=get_avatar($user->ID);
            $out.=ThemedbInterface::renderOption(array(
                'id' => 'avatar',
                'type' => 'uploader',
                'value' => '',
                'wrap' => false,				
            ));
            $out.='</div></td></tr>';
        }
        
        ob_start();
        ThemedbForm::renderData('profile', array(
            'edit' => true,
            'placeholder' => false,
            'before_title' => '<tr><th><label>',
            'after_title' => '</label></th>',
            'before_content' => '<td>',
            'after_content' => '</td></tr>',
        ), $profile);
        $out.=ob_get_contents();
        ob_end_clean();
        
        $out.='<tr><th><label>'.__('Profile Text', 'academy').'</label></th><td>';		
        ob_start();
        ThemedbInterface::renderEditor('description', themedb_array('description', $profile));
        $out.=ob_get_contents();
        ob_end_clean();
        $out.='</td></tr>';
        
        $out.='</tbody></table>';		
        echo $out;
    }
    
    /**
    * Updates admin profile
     *
     * @access public
    * @param mixed $user
     * @return void
     */
    public static function updateAdminProfile($user) {
        global $wpdb;
        self::updateProfile($user, $_POST);
        
        if(current_user_can('edit_users') && isset($_POST['avatar']) && !empty($_POST['avatar'])) {
            $query="SELECT ID FROM ".$wpdb->posts." WHERE guid = '".esc_url($_POST['avatar'])."'";
            $avatar=$wpdb->get_var($query);
            
            if(!empty($avatar)) {
                ThemedbCore::updateUserMeta($user, 'avatar', $avatar);
            }
        }
    }
    
    /**
    * Renders user toolbar
     *
     * @access public
     * @return bool
     */
    public static function renderToolbar() {
        if(current_user_can('publish_posts') && get_user_option('show_admin_bar_front', get_current_user_id())!='false') {
            return true;
        }
        
        return false;
    }
    
    /**
    * Checks profile page
     *
     * @access public
     * @return bool
     */
    public static function isProfile() {
        if(is_user_logged_in() && self::$data['active']['ID']==self::$data['current']['ID']) {
            return true;
        }
        
        return false;
    }
    
    /**
    * Checks shop page
     *
     * @access public
     * @return bool
     */
    public static function isShop() {
        if(isset(self::$data['current']['links']['shop']) && self::$data['current']['links']['shop']['current']) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Custom create user
     * @param Object userdata $data
     * @return int|WP_Error The new user's ID.
     */
    public static function dp_create_user($data) {
        $user_login = wp_slash( $data['user_login'] );
        $user_email = wp_slash( $data['user_email']);
        $user_pass = $data['user_password'];
        $first_name = $data['first_name'];
        $last_name = $data['last_name'];
        $role = $data['role'];
        
        $userdata = compact('user_login', 'user_email', 'user_pass', 'first_name', 'last_name','role');
        return wp_insert_user($userdata);
    }
    
    /**
     * Get email template return email content
     * @param string $email_type
     * @param int $user_id
     * @return string
     */
    public static function get_email_template($email_type, $user_id) {
        // set content type to html
        add_filter( 'wp_mail_content_type', 'wpmail_content_type' );
        
        // get the preview email content
        switch ($email_type){
            case 'register-email-template':
                // user
                $user = new WP_User( $user_id );
                $userEmail = stripslashes( $user->user_email );
                $siteUrl = get_site_url();
                
                // admin email
                $content  = "A new user has been created"."\r\n\r\n";
                $content .= 'Email: '.$userEmail."\r\n";
            break;
        };
        
        ob_start();
        include '/email_templates/' . $email_type .'.php';
        
        $content .= ob_get_contents();
        ob_end_clean();
        
        //replace all <br>
        $content = strip_tags($content, '<br />');
        
        // remove html content type
        remove_filter ( 'wp_mail_content_type', 'wpmail_content_type' );
        
        return $content;
    }
    
    /**
     * wpmail_content_type
     * allow html emails
     * @return string
     */
    public function wpmail_content_type() {
        return 'text/html';
    }
    
    /**
     * 
     * @param array $arr_accept_role
     * @return boolean
     */
    public static function check_user_role ($arr_accept_role) {
        $current_user = wp_get_current_user();
        
        if ( empty( $current_user ) )
            return false;
        
        return (count(array_intersect($arr_accept_role, $current_user->roles)) > 0 )? true : false;
    }
    
}