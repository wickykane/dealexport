<?php
/**
 * Removes slashes
 *
 * @param string $string
 * @return string
 */
function themedb_stripslashes($string) {
    if(!is_array($string)) {
        return stripslashes(stripslashes($string));
    }
    
    return $string;	
}

/**
 * Gets page number
 *
 * @return int
 */
function themedb_paged() {
    $paged=get_query_var('paged')?get_query_var('paged'):1;
    $paged=(get_query_var('page'))?get_query_var('page'):$paged;
    
    return $paged;
}

/**
 * Checks search page
 *
 * @param string $type
 * @return bool
 */
function themedb_search($type) {
    if(isset($_GET['s']) && ((isset($_GET['post_type']) && $_GET['post_type']==$type) || (!isset($_GET['post_type']) && $type=='post'))) {
        return true;
    }
    
    return false;
}

/**
 * Gets array value
 *
 * @param string $key
 * @param array $array
 * @param string $default
 * @return mixed
 */
function themedb_value($key, $array, $default='') {
    $value='';
    
    if(isset($array[$key])) {
        if(is_array($array[$key])) {
            $value=reset($array[$key]);
        } else {
            $value=$array[$key];
        }
    } else if ($default!='') {
        $value=$default;
    }
    
    return $value;
}

/**
 * Gets array item
 *
 * @param string $key
 * @param array $array
 * @param string $default
 * @return mixed
 */
function themedb_array($key, $array, $default='') {
    $value='';
    
    if(isset($array[$key])) {
        $value=$array[$key];
    } else if ($default!='') {
        $value=$default;
    }
    
    return $value;
}

/**
 * 
 * @param array $array
 * @param array $keys
 * @return array:
 */
function themedb_array_except($array, $keys){
    return array_diff_key($array, array_flip((array) $keys));   
}
/**
 * Gets period name
 *
 * @param int $period
 * @return string
 */
function themedb_period($period) {	
    switch($period) {
        case 7: 
            $period=__('week', 'dealexport');
        break;
        
        case 31: 
            $period=__('month', 'dealexport');
        break;
        
        case 365: 
            $period=__('year', 'dealexport');
        break;
        
        default:
            $period=round($period/31).' '.__('months', 'dealexport');
        break;
    }
    
    return $period;
}

/**
 * Implodes array or value
 *
 * @param string $value
 * @param string $prefix
 * @return string
 */
function themedb_implode($value, $prefix='') {
    if(is_array($value)) {
        $value=array_map('sanitize_key', $value);
        $value=implode("', '".$prefix, $value);
    } else {
        $value=sanitize_key($value);
    }
    
    $value="'".$prefix.$value."'";	
    return $value;
}

/**
 * Gets current URL
 *
 * @param bool $private
 * @return string
 */
function themedb_url($private=false, $default='') {
    $url=@(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!='on') ? 'http://'.$_SERVER['SERVER_NAME']:'https://'.$_SERVER['SERVER_NAME'];
    $url.=$_SERVER['REQUEST_URI'];
    
    return $url;
}

/**
 * Gets file name
 *
 * @param string $url
 * @return string
 */
function themedb_filename($url) {
    $name=__('Untitled', 'dealexport');
    $parts=parse_url($url);
    
    if(isset($parts['path'])) {
        $name=basename($parts['path']);
    }
    
    return $name;
}

/**
 * Checks empty taxonomy
 *
 * @param string $name
 * @return bool
 */
function themedb_taxonomy($name) {
    $terms=get_terms($name, array(
        'fields' => 'count',
        'hide_empty' => false,
    ));
    
    if($terms!=0) {
        return true;
    }
    
    return false;
}

/**
 * Gets post status
 *
 * @param int $ID
 * @return string
 */
function themedb_status($ID) {
    $status='draft';
    if(!empty($ID)) {
        $status=get_post_status($ID);
    }
    
    return $status;
}

/**
 * Replaces string keywords
 *
 * @param string $string
 * @param array $keywords
 * @return string
 */
function themedb_keywords($string, $keywords) {
    foreach($keywords as $keyword => $value) {
        $string=str_replace('%'.$keyword.'%', $value, $string);
    }
    
    return $string;
}

/**
 * Sends encoded email
 *
 * @param string $recipient
 * @param string $subject
 * @param string $message
 * @param string $reply
 * @return bool
 */
function themedb_mail($recipient, $subject, $message, $reply='') {
    // TNH : wp better email will do this 
    /*$headers='MIME-Version: 1.0'.PHP_EOL;
    $headers.='Content-Type: text/html; charset=UTF-8'.PHP_EOL;
    $headers.='From: '.get_option('admin_email').PHP_EOL;
    
    if(!empty($reply)) {
        $headers.='Reply-To: '.$reply.PHP_EOL;
    }*/
    
    $subject='=?UTF-8?B?'.base64_encode($subject).'?=';	
    if(wp_mail($recipient, $subject, $message)) {
        return true;
    }
    
    return false;
}

/**
 * Sanitizes key
 *
 * @param string $string
 * @return string
 */
function themedb_sanitize_key($string) {
    $replacements=array(
        // Latin
        'Ã€' => 'A', 'Ã�' => 'A', 'Ã‚' => 'A', 'Ãƒ' => 'A', 'Ã„' => 'A', 'Ã…' => 'A', 'Ã†' => 'AE', 'Ã‡' => 'C', 
        'Ãˆ' => 'E', 'Ã‰' => 'E', 'ÃŠ' => 'E', 'Ã‹' => 'E', 'ÃŒ' => 'I', 'Ã�' => 'I', 'ÃŽ' => 'I', 'Ã�' => 'I', 
        'Ã�' => 'D', 'Ã‘' => 'N', 'Ã’' => 'O', 'Ã“' => 'O', 'Ã”' => 'O', 'Ã•' => 'O', 'Ã–' => 'O', 'Å�' => 'O', 
        'Ã˜' => 'O', 'Ã™' => 'U', 'Ãš' => 'U', 'Ã›' => 'U', 'Ãœ' => 'U', 'Å°' => 'U', 'Ã�' => 'Y', 'Ãž' => 'TH', 
        'ÃŸ' => 'ss', 
        'Ã ' => 'a', 'Ã¡' => 'a', 'Ã¢' => 'a', 'Ã£' => 'a', 'Ã¤' => 'a', 'Ã¥' => 'a', 'Ã¦' => 'ae', 'Ã§' => 'c', 
        'Ã¨' => 'e', 'Ã©' => 'e', 'Ãª' => 'e', 'Ã«' => 'e', 'Ã¬' => 'i', 'Ã­' => 'i', 'Ã®' => 'i', 'Ã¯' => 'i', 
        'Ã°' => 'd', 'Ã±' => 'n', 'Ã²' => 'o', 'Ã³' => 'o', 'Ã´' => 'o', 'Ãµ' => 'o', 'Ã¶' => 'o', 'Å‘' => 'o', 
        'Ã¸' => 'o', 'Ã¹' => 'u', 'Ãº' => 'u', 'Ã»' => 'u', 'Ã¼' => 'u', 'Å±' => 'u', 'Ã½' => 'y', 'Ã¾' => 'th', 
        'Ã¿' => 'y',
 
        // Greek
        'Î‘' => 'A', 'Î’' => 'B', 'Î“' => 'G', 'Î”' => 'D', 'Î•' => 'E', 'Î–' => 'Z', 'Î—' => 'H', 'Î˜' => '8',
        'Î™' => 'I', 'Îš' => 'K', 'Î›' => 'L', 'Îœ' => 'M', 'Î�' => 'N', 'Îž' => '3', 'ÎŸ' => 'O', 'Î ' => 'P',
        'Î¡' => 'R', 'Î£' => 'S', 'Î¤' => 'T', 'Î¥' => 'Y', 'Î¦' => 'F', 'Î§' => 'X', 'Î¨' => 'PS', 'Î©' => 'W',
        'Î†' => 'A', 'Îˆ' => 'E', 'ÎŠ' => 'I', 'ÎŒ' => 'O', 'ÎŽ' => 'Y', 'Î‰' => 'H', 'Î�' => 'W', 'Îª' => 'I',
        'Î«' => 'Y',
        'Î±' => 'a', 'Î²' => 'b', 'Î³' => 'g', 'Î´' => 'd', 'Îµ' => 'e', 'Î¶' => 'z', 'Î·' => 'h', 'Î¸' => '8',
        'Î¹' => 'i', 'Îº' => 'k', 'Î»' => 'l', 'Î¼' => 'm', 'Î½' => 'n', 'Î¾' => '3', 'Î¿' => 'o', 'Ï€' => 'p',
        'Ï�' => 'r', 'Ïƒ' => 's', 'Ï„' => 't', 'Ï…' => 'y', 'Ï†' => 'f', 'Ï‡' => 'x', 'Ïˆ' => 'ps', 'Ï‰' => 'w',
        'Î¬' => 'a', 'Î­' => 'e', 'Î¯' => 'i', 'ÏŒ' => 'o', 'Ï�' => 'y', 'Î®' => 'h', 'ÏŽ' => 'w', 'Ï‚' => 's',
        'ÏŠ' => 'i', 'Î°' => 'y', 'Ï‹' => 'y', 'Î�' => 'i',
 
        // Turkish
        'Åž' => 'S', 'Ä°' => 'I', 'Ã‡' => 'C', 'Ãœ' => 'U', 'Ã–' => 'O', 'Äž' => 'G',
        'ÅŸ' => 's', 'Ä±' => 'i', 'Ã§' => 'c', 'Ã¼' => 'u', 'Ã¶' => 'o', 'ÄŸ' => 'g', 
 
        // Russian
        'Ð�' => 'A', 'Ð‘' => 'B', 'Ð’' => 'V', 'Ð“' => 'G', 'Ð”' => 'D', 'Ð•' => 'E', 'Ð�' => 'Yo', 'Ð–' => 'Zh',
        'Ð—' => 'Z', 'Ð˜' => 'I', 'Ð™' => 'J', 'Ðš' => 'K', 'Ð›' => 'L', 'Ðœ' => 'M', 'Ð�' => 'N', 'Ðž' => 'O',
        'ÐŸ' => 'P', 'Ð ' => 'R', 'Ð¡' => 'S', 'Ð¢' => 'T', 'Ð£' => 'U', 'Ð¤' => 'F', 'Ð¥' => 'H', 'Ð¦' => 'C',
        'Ð§' => 'Ch', 'Ð¨' => 'Sh', 'Ð©' => 'Sh', 'Ðª' => '', 'Ð«' => 'Y', 'Ð¬' => '', 'Ð­' => 'E', 'Ð®' => 'Yu',
        'Ð¯' => 'Ya',
        'Ð°' => 'a', 'Ð±' => 'b', 'Ð²' => 'v', 'Ð³' => 'g', 'Ð´' => 'd', 'Ðµ' => 'e', 'Ñ‘' => 'yo', 'Ð¶' => 'zh',
        'Ð·' => 'z', 'Ð¸' => 'i', 'Ð¹' => 'j', 'Ðº' => 'k', 'Ð»' => 'l', 'Ð¼' => 'm', 'Ð½' => 'n', 'Ð¾' => 'o',
        'Ð¿' => 'p', 'Ñ€' => 'r', 'Ñ�' => 's', 'Ñ‚' => 't', 'Ñƒ' => 'u', 'Ñ„' => 'f', 'Ñ…' => 'h', 'Ñ†' => 'c',
        'Ñ‡' => 'ch', 'Ñˆ' => 'sh', 'Ñ‰' => 'sh', 'ÑŠ' => '', 'Ñ‹' => 'y', 'ÑŒ' => '', 'Ñ�' => 'e', 'ÑŽ' => 'yu',
        'Ñ�' => 'ya',
 
        // Ukrainian
        'Ð„' => 'Ye', 'Ð†' => 'I', 'Ð‡' => 'Yi', 'Ò�' => 'G',
        'Ñ”' => 'ye', 'Ñ–' => 'i', 'Ñ—' => 'yi', 'Ò‘' => 'g',
 
        // Czech
        'ÄŒ' => 'C', 'ÄŽ' => 'D', 'Äš' => 'E', 'Å‡' => 'N', 'Å˜' => 'R', 'Å ' => 'S', 'Å¤' => 'T', 'Å®' => 'U', 
        'Å½' => 'Z', 
        'Ä�' => 'c', 'Ä�' => 'd', 'Ä›' => 'e', 'Åˆ' => 'n', 'Å™' => 'r', 'Å¡' => 's', 'Å¥' => 't', 'Å¯' => 'u',
        'Å¾' => 'z', 
 
        // Polish
        'Ä„' => 'A', 'Ä†' => 'C', 'Ä˜' => 'e', 'Å�' => 'L', 'Åƒ' => 'N', 'Ã“' => 'o', 'Åš' => 'S', 'Å¹' => 'Z', 
        'Å»' => 'Z', 
        'Ä…' => 'a', 'Ä‡' => 'c', 'Ä™' => 'e', 'Å‚' => 'l', 'Å„' => 'n', 'Ã³' => 'o', 'Å›' => 's', 'Åº' => 'z',
        'Å¼' => 'z',
 
        // Latvian
        'Ä€' => 'A', 'ÄŒ' => 'C', 'Ä’' => 'E', 'Ä¢' => 'G', 'Äª' => 'i', 'Ä¶' => 'k', 'Ä»' => 'L', 'Å…' => 'N', 
        'Å ' => 'S', 'Åª' => 'u', 'Å½' => 'Z',
        'Ä�' => 'a', 'Ä�' => 'c', 'Ä“' => 'e', 'Ä£' => 'g', 'Ä«' => 'i', 'Ä·' => 'k', 'Ä¼' => 'l', 'Å†' => 'n',
        'Å¡' => 's', 'Å«' => 'u', 'Å¾' => 'z'
    );	
    
    $string=str_replace(array_keys($replacements), $replacements, $string);
    $string=preg_replace('/\s+/', '-', $string);
    $string=preg_replace('!\-+!', '-', $string);
    $filtered=$string;
    
    $string=preg_replace('/[^A-Za-z0-9-]/', '', $string);
    $string=strtolower($string);
    $string=trim($string, '-');
    
    if(empty($string) || $string[0]=='-') {
        $string='a'.md5($filtered);
    }
    
    return $string;
}

/**
 * check url exist
 */

function checkUrlExits($file_link){
    $file_headers = @get_headers($file_link);
    if($file_headers[0] == "HTTP/1.0 404 Not Found") {
        return  false;
    }
    return true;
}

/**
 * Resize image
 *
 * @param string $url
 * @param int $width
 * @param int $height
 * @return array
 */
function themedb_resize($url, $width, $height) {
    add_filter('image_resize_dimensions', 'themedb_scale', 10, 6);

    $upload_info=wp_upload_dir();
    $upload_dir=$upload_info['basedir'];
    $upload_url=$upload_info['baseurl'];
    
    //check prefix
    $http_prefix='http://';
    $https_prefix='https://';
    
    if(!strncmp($url, $https_prefix, strlen($https_prefix))){
        $upload_url=str_replace($http_prefix, $https_prefix, $upload_url);
    } else if (!strncmp($url, $http_prefix, strlen($http_prefix))){
        $upload_url=str_replace($https_prefix, $http_prefix, $upload_url);		
    }	

    //check URL
    if (strpos($url, $upload_url)===false) {
        return false;
    }

    //define path
    $rel_path=str_replace($upload_url, '', $url);
    $img_path=$upload_dir.$rel_path;

    //check file
    if (!file_exists($img_path) or !getimagesize($img_path)) {
        return false;
    }

    //get file info
    $info=pathinfo($img_path);
    $ext=$info['extension'];
    list($orig_w, $orig_h)=getimagesize($img_path);

    //get image size
    $dims=image_resize_dimensions($orig_w, $orig_h, $width, $height, false);
    $dst_w=$dims[4];
    $dst_h=$dims[5];

    //resize image
    if((($height===null && $orig_w==$width) xor ($width===null && $orig_h==$height)) xor ($height==$orig_h && $width==$orig_w)) {
        $img_url=$url;
        $dst_w=$orig_w;
        $dst_h=$orig_h;
    } else {
        $suffix=$dst_w.'x'.$dst_h;
        $dst_rel_path=str_replace('.'.$ext, '', $rel_path);
        $destfilename=$upload_dir.$dst_rel_path.'-'.$suffix.'.'.$ext;

        if(!$dims) {
            return false;
        } else if(file_exists($destfilename) && getimagesize($destfilename) && empty($_FILES)) {
            $img_url=$upload_url.$dst_rel_path.'-'.$suffix.'.'.$ext;
        } else {
            if (function_exists('wp_get_image_editor')) {
                $editor=wp_get_image_editor($img_path);
                if (is_wp_error($editor) || is_wp_error($editor->resize($width, $height, false))) {
                    return false;
                }

                $resized_file=$editor->save();

                if (!is_wp_error($resized_file)) {
                    $resized_rel_path=str_replace($upload_dir, '', $resized_file['path']);
                    
                    $img_url=$upload_url.$resized_rel_path.'?'.time();
                } else {
                    return false;
                }
            } else {
                $resized_img_path=image_resize($img_path, $width, $height, false);
                
                if (!is_wp_error($resized_img_path)) {
                    $resized_rel_path=str_replace($upload_dir, '', $resized_img_path);
                    $img_url=$upload_url.$resized_rel_path;
                } else {
                    return false;
                }
            }
        }
    }

    remove_filter('image_resize_dimensions', 'themedb_scale');
    return $img_url;
}

/**
 * Scale image
 *
 * @param string $default
 * @param int $orig_w
 * @param int $orig_h
 * @param int $dest_w
 * @param int $dest_h
 * @param bool $crop
 * @return array
 */
function themedb_scale($default, $orig_w, $orig_h, $dest_w, $dest_h, $crop) {
    if ( $crop ) {
        // crop the largest possible portion of the original image that we can size to $dest_w x $dest_h
	    $aspect_ratio=$orig_w/$orig_h;
	    $new_w=$dest_w;
	    $new_h=$dest_h;
	
	    if (!$new_w) {
	        $new_w=intval($new_h*$aspect_ratio);
	    }
	
	    if (!$new_h) {
	        $new_h=intval($new_w/$aspect_ratio);
	    }
	
	    $size_ratio=max($new_w/$orig_w, $new_h/$orig_h);
	    $crop_w=round($new_w/$size_ratio);
	    $crop_h=round($new_h/$size_ratio);
	
	    $s_x=floor(($orig_w-$crop_w)/2);
	    // TNH remove default scale for height : $s_y=floor(($orig_h-$crop_h)/2);
	    $s_y = 0; // [[ formerly ]] ==> floor( ($orig_h - $crop_h) / 2 );
    } else { 
        // don't crop, just resize using $dest_w x $dest_h as a maximum bounding box
        $crop_w = $orig_w;
        $crop_h = $orig_h;
        
        $s_x = 0;
        $s_y = 0;
        
        list( $new_w, $new_h ) = wp_constrain_dimensions( $orig_w, $orig_h, $dest_w, $dest_h );
    }
    
    if ( $new_w >= $orig_w && $new_h >= $orig_h )
        return false;
    
    // the return array matches the parameters to imagecopyresampled()
    // int dst_x, int dst_y, int src_x, int src_y, int dst_w, int dst_h, int src_w, int src_h
    
    $scale=array(0, 0, (int)$s_x, (int)$s_y, (int)$new_w, (int)$new_h, (int)$crop_w, (int)$crop_h);

    return $scale;
}

/**
 * 
 */
remove_action('woocomerce_pagination', 'woocomerce_pagination', 10);
function woocomerce_pagination() {
    wp_pagenavi();
}
add_action('woocomerce_pagination', 'woocomerce_pagination', 10);
// wp_get_attachment_url(get_post_thumbnail_id($product->id));

function generateCustomImageThumbnail($url,$width = 300, $heigth = 300,  $type = 2,$default_img = 'images/product.png') {
	if($url != false  && checkUrlExits($url)){
		$image_resize_link = resize_image($url, $width, $heigth, $type);
		if ($image_resize_link == NULL) {
			$pathinfo = pathinfo($url);
			$image_resize_link = $pathinfo['dirname'] . '/' . $pathinfo['filename'] . '-dex_resize'.'-'.$width. '-'.$heigth. '.' . $pathinfo['extension'];
		}
		return '<img src="'.$image_resize_link.'" alt="" />';
	}
	return '<img src="'.THEME_URI . $default_img.'" alt="" />';
}