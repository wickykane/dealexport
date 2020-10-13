<?php
/**
 * Themedb Facebook
 *
 * Handles Facebook data
 *
 * @class ThemedbFacebook
 * @author Themedb
 */
 
class ThemedbFacebook {

    /** @var array Contains module data. */
    public static $data;

    /**
    * Adds actions and filters
     *
     * @access public
     * @return void
     */
    public static function init() {	
        if(self::isActive()) {
            //load API
            add_action('wp_footer', array(__CLASS__,'loadAPI'));
            
            //render page
            add_action('init', array(__CLASS__,'renderPage'));
            
            //login user
            add_filter('init', array(__CLASS__,'loginUser'), 90);
            
            //logout user
            add_action('wp_logout', array(__CLASS__,'logoutUser'));
        }
    }
    
    /**
    * Loads Facebook API
     *
     * @access public
    * @param bool $logout
     * @return void
     */
    public static function loadAPI($logout=false) {
        $out='<div id="fb-root"></div>
        <script type="text/javascript">
        window.fbAsyncInit = function() {
        FB.init({			
        appId      : "'.ThemedbCore::getOption('user_facebook_id').'",
        channelUrl : "'.home_url('?facebook_channel=1').'",
        status     : true,
        cookie     : true,
        xfbml      : true,
        oauth	   : true
        });';

        if($logout) {
            $out.='FB.getLoginStatus(function(response) {
            if (response.status === "connected") {
            FB.logout(function(response) {
            window.location.href="'.home_url().'";
            });
            } else {
            window.location.href="'.home_url().'";
            }
            });';
        }

        $out.='};
        (function(d){
        var js, id = "facebook-jssdk"; if (d.getElementById(id)) {return;}
        js = d.createElement("script"); js.id = id; js.async = true;
        js.src = "//connect.facebook.net/'.self::getLocale().'/all.js";
        d.getElementsByTagName("head")[0].appendChild(js);
        }(document));
        </script>';
        
        echo $out;
    }
    
    /**
    * Renders Facebook page
     *
     * @access public
     * @return void
     */
    public static function renderPage() {
        if (isset($_GET['facebook_channel'])) {
            $limit=60*60*24*365;
            header('Pragma: public');
            header('Cache-Control: max-age='.$limit);
            header('Expires: '.gmdate('D, d M Y H:i:s', current_time('timestamp')+$limit).' GMT');
            echo '<script src="//connect.facebook.net/'.self::getLocale().'/all.js"></script>';
            exit;
        }
    }
    
    /**
    * Logins Facebook user
     *
     * @access public
     * @return void
     */
    public static function loginUser() {
        if(isset($_GET['facebook_login']) && !is_user_logged_in() && isset($_COOKIE['fbsr_'.ThemedbCore::getOption('user_facebook_id')])) {
            $cookie=self::decodeCookie();
            
            if(isset($cookie['user_id'])) {
                $profile=self::getProfile($cookie['user_id'], array(
                    'fields' => 'first_name,last_name,email',
                    'code' => $cookie['code'],
                ));
                
                if(isset($profile['email'])) {
                    $user=get_user_by('email', $profile['email']);
                        
                    if($user!==false) {
                        wp_set_auth_cookie($user->ID, true);
                        wp_redirect(get_author_posts_url($user->ID));				
                        exit();
                    } else {
                        if(isset($profile['first_name'])) {
                            $profile['username']=$profile['first_name'];
                        } else if(isset($profile['last_name'])) {
                            $profile['username']=$profile['last_name'];
                        }
                        
                        $profile['username']=sanitize_user($profile['username']);
                        while(username_exists($profile['username'])) {
                            $profile['username'].=rand(0,9);
                        }
                        
                        $user=wp_create_user($profile['username'], wp_generate_password(10), $profile['email']);
                        if(!is_wp_error($user)) {
                            wp_new_user_notification($user);
                            add_user_meta($user, 'facebook_id', $profile['id'], true);
                            add_user_meta($user, 'facebook_set', 'true', true);
                            self::updateImage($profile['id'], $user);
                        
                            if(isset($profile['first_name'])) {
                                update_user_meta($user, 'first_name', $profile['first_name']);
                            }
                            
                            if(isset($profile['last_name'])) {
                                update_user_meta($user, 'last_name', $profile['last_name']);
                            }
                            
                            wp_set_auth_cookie($user, true);
                            wp_redirect(get_author_posts_url($user));
                        } else {
                            self::logoutUser();
                        }

                        exit();
                    }
                }
            }
        }
    }
    
    /**
    * Logouts Facebook user
     *
     * @access public
     * @return void
     */
    public static function logoutUser() {
        if(isset($_COOKIE['fbsr_'.ThemedbCore::getOption('user_facebook_id')])) {
            $domain = '.'.parse_url(home_url('/'), PHP_URL_HOST);
            setcookie('fbsr_'.ThemedbCore::getOption('user_facebook_id'), ' ', current_time('timestamp')-31536000, '/', $domain);
            
            $out='<html><head></head><body>';
            ob_start();
            self::loadAPI(true);
            $out.=ob_get_contents();
            ob_end_clean();
            $out.='</body></html>';
            
            echo $out;
            exit();
        }
    }
    
    /**
    * Updates plugin user
     *
     * @access public
    * @param int $user
     * @return void
     */
    public static function updateUser($user) {
        delete_user_meta($user, 'facebook_set');
    }
    
    /**
    * Logouts Facebook profile
     *
     * @access public
    * @param int $ID
    * @param array $fields
     * @return mixed
     */
    public static function getProfile($ID, $fields=array()) {
        if (!empty($fields['code'])) {
            $request='https://graph.facebook.com/oauth/access_token?client_id='.ThemedbCore::getOption('user_facebook_id').'&redirect_uri=&client_secret='.ThemedbCore::getOption('user_facebook_secret').'&code='.$fields['code'];	
            $response=wp_remote_get($request, array('sslverify' => false));
            
            if (!is_wp_error($response) && wp_remote_retrieve_response_code($response)==200) {
                parse_str($response['body'], $response);
                $fields['access_token']=$response['access_token'];
                $fields['appsecret_proof']=hash_hmac('sha256', $response['access_token'], ThemedbCore::getOption('facebook_secret'));
            } else {
                return false;
            }
        }
        
        $url='https://graph.facebook.com/'.$ID.'?'.http_build_query($fields);
        $response=wp_remote_get($url, $fields);
        
        if (!is_wp_error($response) && $response) {
            $response=json_decode($response['body'], true);
            return $response;
        }
        
        return false;
    }
    
    /**
    * Decode Facebook cookie
     *
     * @access public
     * @return array
     */
    public static function decodeCookie() {
        $cookie = array();		
        if(list($encoded_sign, $payload)=explode('.', $_COOKIE['fbsr_'.ThemedbCore::getOption('user_facebook_id')], 2)){
            $sign=base64_decode(strtr($encoded_sign, '-_', '+/')); 
            if (hash_hmac('sha256', $payload, ThemedbCore::getOption('user_facebook_secret'), true)==$sign){
                $cookie=json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
            }
        }
        
        return $cookie;
    }
    
    /**
    * Gets Facebook locale
     *
     * @access public
     * @return string
     */
    public static function getLocale() {
        $locale = get_locale();
        $locales = array(
            'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_PI', 'en_UD', 'ck_US', 'en_US', 'es_LA', 'es_CL', 'es_CO', 'es_ES', 'es_MX',
            'es_VE', 'fb_FI', 'fi_FI', 'fr_FR', 'gl_ES', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'pl_PL', 'pt_BR', 'pt_PT',
            'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'fb_LT', 'af_ZA', 'sq_AL', 'hy_AM',
            'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'eo_EO', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN',
            'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'la_VA', 'lv_LV', 'li_NL', 'lt_LT', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT',
            'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'rm_CH', 'sa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'tt_RU', 'te_IN', 'ml_IN', 'uk_UA',
            'uz_UZ', 'vi_VN', 'xh_ZA', 'zu_ZA', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'sy_SY', 'yi_DE', 'gn_PY', 'qu_PE', 'ay_BO',
            'se_NO', 'ps_AF', 'tl_ST',
        );
        
        $locale = str_replace('-', '_', $locale);
        if(strlen($locale)==2) {
            $locale = strtolower($locale).'_'.strtoupper($locale);
        }
        
        if (!in_array($locale, $locales)) {
            $locale='en_US';
        }
        
        return $locale;
    }
    
    /**
    * Updates Facebook image
     *
     * @access public
    * @param int $ID
    * @param int $user
     * @return void
     */
    public static function updateImage($ID, $user) {
        require_once(ABSPATH.'wp-admin/includes/image.php');
        
        $attachment=array('ID' => 0);
        $url='https://graph.facebook.com/'.intval($ID).'/picture?type=large';
        $image=@file_get_contents($url);
        
        if($image!==false && !empty($image)) {
            $uploads=wp_upload_dir();
            $filename=wp_unique_filename($uploads['path'], 'image-1.jpg');
            $filepath=$uploads['path'].'/'.$filename;
            
            $contents=file_put_contents($filepath, $image);
            if($contents!==false) {
            
                //upload image
                $attachment=array(
                    'guid' => $uploads['url'].'/'.$filename,
                    'post_mime_type' => 'image/jpg',
                    'post_title' => sanitize_title(current(explode('.', $filename))),
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'post_author' => $user,
                );
                
                //add image
                $attachment['ID']=wp_insert_attachment($attachment, $attachment['guid'], 0);
                update_post_meta($attachment['ID'], '_wp_attached_file', substr($uploads['subdir'], 1).'/'.$filename);
                
                //add thumbnails
                $metadata=wp_generate_attachment_metadata($attachment['ID'], $filepath);
                wp_update_attachment_metadata($attachment['ID'], $metadata);				
            }
        }
        
        //update image
        if(isset($attachment['ID']) && $attachment['ID']!=0) {
            ThemedbCore::updateUserMeta($user, 'avatar', $attachment['ID']);
        }
    }
    
    /**
    * Checks plugin update
     *
     * @access public
    * @param int $user
     * @return bool
     */
    public static function isUpdated($user) {
        $set=get_user_meta($user, 'facebook_set', true);
        if(empty($set)) {
            return true;
        }
        
        return false;
    }
    
    /**
    * Checks plugin activity
     *
     * @access public
     * @return bool
     */
    public static function isActive() {
        if(ThemedbCore::checkOption('user_facebook')) {
            return true;
        }
        
        return false;
    }
}