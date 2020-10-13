<?php

function cut_character_string($number = 0, $string = '', $etc = '...') {
    $str = '';
    if (mb_strlen($string, 'utf8') > $number) {
        $last_space = strrpos(substr(strip_tags($string), 0, $number), ' ');
        $str = substr(strip_tags($string), 0, $last_space) . $etc;
    } else {
        $str = $string;
    }
    return $str;
}

function cut_character_word($number = 0, $string = '', $etc = '...') {

    $string = explode(' ', $string);
    $str = '';
    $i = 0;

    foreach ($string as $key => $value) {

        if ($i == $number) {
            return $str . $etc;
        } else {
            $str.= $value . ' ';
        }
        $i++;
    }
    return $str;
}

function subval_sort($arr, $subkey, $type) {
    foreach ($arr as $k => $v) {
        $b[$k] = $v[$subkey];
    }
    if ($type == 'asc') {
        asort($b);
    } else {
        arsort($b);
    }
    foreach ($b as $key => $val) {
        $c[] = $arr[$key];
    }
    return $c;
}

function remove_p($string) {
    $text = str_replace('<p>', '', $string);
    $text_s = str_replace('</p>', '', $text);
    return $text_s;
}

function page_navi_ajax($max_page = '', $page_custom = '', $posts_per_page_custom = '', $link = '') {
    global $wpdb, $wp_query;
    if (empty($page_custom)) {
        $paged = intval(get_query_var('paged'));
    } else {
        $paged = $page_custom;
    }

    if (empty($posts_per_page_custom)) {
        $posts_per_page = intval(get_query_var('posts_per_page'));
    } else {
        $posts_per_page = $posts_per_page_custom;
    }



    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    } else {
        $max_page = ceil($max_page / $posts_per_page);
    }

    if (empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 10;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }

    /* if ($start_page >= 2 && $pages_to_show < $max_page) {
      $first_page_text = "First";
      echo '<a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a>';
      }
      previous_posts_link('&laquo;');
     */
    echo '<ul class="pager">';
    /*
      if($paged >1) {
      echo '<li><a href="'.get_pagenum_link($paged-1).'">&lt;</a></li>';
      }
     */
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($end_page > 1) {
            if ($i == $paged) {
                echo '<li class="active"><a href="' . $link . '/' . $i . '" >' . $i . '</a></li>';
            } else {
                echo '<li><a href="' . $link . '/' . $i . '" >' . $i . '</a></li>';
            }
        }
    }
    /*
      if($max_page > 1 && $paged < $max_page) {
      echo '<li><a href="'.get_pagenum_link($paged+1).'">&gt;</a></li>';
      } */
    echo '</ul>';
}

function wp_page_nextpage_ajax($paged = '', $max_page = '', $nextpage = '&gt;', $link = '') {
    global $wpdb, $wp_query;
    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    }
    if (empty($paged)) {
        $paged = intval(get_query_var('paged'));
    }

    if ($paged != "" && $paged < $max_page) {
        $pagingString = '<a href="' . $link . '/' . ($paged + 1) . '" class="next" rel="' . ($paged + 1) . '">' . $nextpage . '</a>' . "\n";
    }
    return $pagingString;
}

function wp_page_prevpage_ajax($paged = '', $max_page = '', $prevpage = '&lt;', $link = '') {
    global $wpdb, $wp_query;
    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    }

    if (empty($paged)) {
        $paged = intval(get_query_var('paged'));
    }
    if ($max_page > 1 && $paged > 1) {
        $pagingString = '<a href="' . $link . '/' . ($paged - 1) . '" class="prev" rel="' . ($paged - 1) . '">' . $prevpage . '</a>';
    }
    return $pagingString;
}

//------------------------------------------------------------- end ajax-------------------------

function page_navi($max_page = '', $page_custom = '', $before = '', $after = '') {
    global $wpdb, $wp_query;
    if (empty($page_custom)) {
        $paged = intval(get_query_var('paged'));
    } else {
        $paged = $page_custom;
    }


    $posts_per_page = intval(get_query_var('posts_per_page'));

    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    } else {
        $max_page = ceil($max_page / $posts_per_page);
    }

    if (empty($paged) || $paged == 0) {
        $paged = 1;
    }
    $pages_to_show = 10;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;
    if ($start_page <= 0) {
        $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if (($end_page - $start_page) != $pages_to_show_minus_1) {
        $end_page = $start_page + $pages_to_show_minus_1;
    }
    if ($end_page > $max_page) {
        $start_page = $max_page - $pages_to_show_minus_1;
        $end_page = $max_page;
    }
    if ($start_page <= 0) {
        $start_page = 1;
    }

    /* if ($start_page >= 2 && $pages_to_show < $max_page) {
      $first_page_text = "First";
      echo '<a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a>';
      }
      previous_posts_link('&laquo;');
     */
    echo '<ul class="pager">';
    /*
      if($paged >1) {
      echo '<li><a href="'.get_pagenum_link($paged-1).'">&lt;</a></li>';
      }
     */
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($end_page > 1) {
            if ($i == $paged) {
                echo '<li class="active"><a href="' . get_pagenum_link($i) . '" >' . $i . '</a></li>';
            } else {
                echo '<li><a href="' . get_pagenum_link($i) . '">' . $i . '</a></li>';
            }
        }
    }
    /*
      if($max_page > 1 && $paged < $max_page) {
      echo '<li><a href="'.get_pagenum_link($paged+1).'">&gt;</a></li>';
      } */
    echo '</ul>';
}

function wp_page_nextpage($paged = '', $max_page = '', $nextpage = '&gt;') {
    global $wpdb, $wp_query;
    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    }
    if (empty($paged)) {
        $paged = intval(get_query_var('paged'));
    }

    if ($paged != "" && $paged < $max_page) {
        $uncategory = explode('uncategorized', $_SERVER['REQUEST_URI']);
        $category = get_queried_object();
//        if(empty($uncategory[1])) {
//        
//            $pagingString = '<a href="http://www'.$_SERVER['["HTTP_HOST"]'].'/' . $category->slug . '/'.($paged+1).'" class="next" rel="'.($paged + 1).'">' . $nextpage . '</a>' . "\n";
//        
//		} else {
//			
//            $pagingString = '<a href="' . get_pagenum_link($paged + 1) . '" class="next" rel="'.($paged + 1).'">' . $nextpage . '</a>' . "\n";
//        }
        $pagingString = '<a href="' . get_pagenum_link($paged + 1) . '" class="next" rel="' . ($paged + 1) . '">' . $nextpage . '</a>' . "\n";
    }
    return $pagingString;
}

function wp_page_prevpage($paged = '', $max_page = '', $prevpage = '&lt;') {
    global $wpdb, $wp_query;
    if (empty($max_page)) {
        $max_page = $wp_query->max_num_pages;
    }

    if (empty($paged)) {
        $paged = intval(get_query_var('paged'));
    }
    if ($max_page > 1 && $paged > 1) {

        $uncategory = explode('uncategorized', $_SERVER['REQUEST_URI']);
        if (empty($uncategory[1])) {
            $pagingString = '<a href="http://www' . $_SERVER['["HTTP_HOST"]'] . '/' . $uncategory[0] . '/' . ($paged - 1) . '" class="next" rel="' . ($paged + 1) . '">' . $prevpage . '</a>' . "\n";
        } else {
            $pagingString = '<a href="' . get_pagenum_link($paged - 1) . '" class="prev" rel="' . ($paged - 1) . '">' . $prevpage . '</a>';
        }

        $pagingString = '<a href="' . get_pagenum_link($paged - 1) . '" class="prev" rel="' . ($paged - 1) . '">' . $prevpage . '</a>';
    }
    return $pagingString;
}

function resize_image($source_image, $destination_width, $destination_height, $type = 0) {
    ini_set("gd.jpeg_ignore_warning", 1);
	//	ini_set('display_errors', 1);
    // $type (1=crop to fit, 2=letterbox)
    $urlsource = pathinfo($source_image);
    $full = full_url();
    $imag_o = substr($urlsource['dirname'], strpos($urlsource['dirname'], 'wp-content'));
    $imag = str_replace('/', '\\', $imag_o);
    $img_will_create = getcwd() . DIRECTORY_SEPARATOR . $imag . DIRECTORY_SEPARATOR . $urlsource['filename'] . '-dex_resize' .'-'.$destination_width. '-'.$destination_height.'.' . $urlsource['extension'];
    $sourimg = getcwd() . DIRECTORY_SEPARATOR . $imag_o . DIRECTORY_SEPARATOR . $urlsource['filename'] . '.' . $urlsource['extension'];
    if (file_exists($img_will_create)) {
        return null;
    }
    if (file_exists($sourimg)) {
        list($source_width, $source_height, $image_type) = getimagesize($sourimg);

//    list($source_width, $source_height, $image_type) = getimagesize($source_image);
        $source_ratio = $source_width / $source_height;
        $destination_ratio = $destination_width / $destination_height;
        if ($type == 1) {
            // crop to fit
            if ($source_ratio > $destination_ratio) {
                // source has a wider ratio
                $temp_width = (int) ($source_height * $destination_ratio);
                $temp_height = $source_height;
                $source_x = (int) (($source_width - $temp_width) / 2);
                $source_y = 0;
            } else {
                // source has a taller ratio
                $temp_width = $source_width;
                $temp_height = (int) ($source_width / $destination_ratio);
                $source_x = 0;
                $source_y = (int) (($source_height - $temp_height) / 2);
            }
            $destination_x = 0;
            $destination_y = 0;
            $source_width = $temp_width;
            $source_height = $temp_height;
            $new_destination_width = $destination_width;
            $new_destination_height = $destination_height;
        } else {
            // letterbox
            if ($source_ratio < $destination_ratio) {
                // source has a taller ratio
                $temp_width = (int) ($destination_height * $source_ratio);
                $temp_height = $destination_height;
                $destination_x = (int) (($destination_width - $temp_width) / 2);
                $destination_y = 0;
            } else {
                // source has a wider ratio
                $temp_width = $destination_width;
                $temp_height = (int) ($destination_width / $source_ratio);
                $destination_x = 0;
                $destination_y = (int) (($destination_height - $temp_height) / 2);
            }
            $source_x = 0;
            $source_y = 0;
            $new_destination_width = $temp_width;
            $new_destination_height = $temp_height;
        }
        $destination_image = imagecreatetruecolor($destination_width, $destination_height);
        $white = imagecolorallocate($destination_image, 255, 255, 255);
        if ($type > 1) {
            imagefill($destination_image, 0, 0, $white);
        }

        switch ($image_type):
            case 1:
                $imageTmp = imagecreatefromgif($sourimg);
                break;
            case 2:
                $imageTmp = imagecreatefromjpeg($sourimg);
                break;
            case 3:
                $imageTmp = imagecreatefrompng($sourimg);
                break;
            default:
                throw new Exception("invalid image");
                break;
        endswitch;
//    $imageTmp = imagecreatefromjpeg($source_image);
        imagecopyresampled($destination_image, $imageTmp, $destination_x, $destination_y, $source_x, $source_y, $new_destination_width, $new_destination_height, $source_width, $source_height);

        $urlsource = pathinfo($source_image);
        $full = full_url();
//    $imag = substr($urlsource['dirname'], strpos($full, $urlsource['dirname'])+strlen($full));
        $imag_o = substr($urlsource['dirname'], strpos($urlsource['dirname'], 'wp-content'));
        $imag = str_replace('/', '\\', $imag_o);
        $sourimg = getcwd() . DIRECTORY_SEPARATOR . $imag_o . DIRECTORY_SEPARATOR . $urlsource['filename'] . '-dex_resize'.'-'.$destination_width. '-'.$destination_height. '.' . $urlsource['extension'];

        switch ($image_type):
            case 1:
                imagegif($destination_image, $sourimg);
                break;
            case 2:
                imagejpeg($destination_image, $sourimg);
                break;
            case 3:
                imagepng($destination_image, $sourimg);
                break;
            default:
                throw new Exception("invalid image");
                break;
        endswitch;
        $temparr = str_replace($urlsource['filename'] . '.' . $urlsource['extension'], $urlsource['filename'] . '-dex_resize' .'-'.$destination_width. '-'.$destination_height. '.' . $urlsource['extension'], $urlsource);
        
        $tempstr = $temparr['dirname'] . DIRECTORY_SEPARATOR . $temparr['basename'];
        $tempstr = str_replace('\\', '/', $tempstr);
        return str_replace(getcwd() . '/', full_url(), $tempstr);
    }
}

function full_url() {
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . '/';
}

function output_file($file, $name, $mime_type = '') {
    /*
      This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
     */

    //Check the file premission
    if (!is_readable($file))
        die('File not found or inaccessible!');

    $size = filesize($file);
    $name = rawurldecode($name);

    /* Figure out the MIME type | Check in array */
    $known_mime_types = array(
        "pdf" => "application/pdf",
        "txt" => "text/plain",
        "html" => "text/html",
        "htm" => "text/html",
        "exe" => "application/octet-stream",
        "zip" => "application/zip",
        "doc" => "application/msword",
        "xls" => "application/vnd.ms-excel",
        "ppt" => "application/vnd.ms-powerpoint",
        "gif" => "image/gif",
        "png" => "image/png",
        "jpeg" => "image/jpg",
        "jpg" => "image/jpg",
        "php" => "text/plain"
    );

    if ($mime_type == '') {
        $file_extension = strtolower(substr(strrchr($file, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
    };

    //turn off output buffering to decrease cpu usage
    @ob_end_clean();

    // required for IE, otherwise Content-Disposition may be ignored
    if (ini_get('zlib.output_compression'))
        ini_set('zlib.output_compression', 'Off');

    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header("Content-Transfer-Encoding: binary");
    header('Accept-Ranges: bytes');

    /* The three lines below basically make the 
      download non-cacheable */
    header("Cache-control: private");
    header('Pragma: private');
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    // multipart-download and download resuming support
    if (isset($_SERVER['HTTP_RANGE'])) {
        list($a, $range) = explode("=", $_SERVER['HTTP_RANGE'], 2);
        list($range) = explode(",", $range, 2);
        list($range, $range_end) = explode("-", $range);
        $range = intval($range);
        if (!$range_end) {
            $range_end = $size - 1;
        } else {
            $range_end = intval($range_end);
        }
        /*
          ------------------------------------------------------------------------------------------------------
          //This application is developed by www.webinfopedia.com
          //visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
          ------------------------------------------------------------------------------------------------------
         */
        $new_length = $range_end - $range + 1;
        header("HTTP/1.1 206 Partial Content");
        header("Content-Length: $new_length");
        header("Content-Range: bytes $range-$range_end/$size");
    } else {
        $new_length = $size;
        header("Content-Length: " . $size);
    }

    /* Will output the file itself */
    $chunksize = 1 * (1024 * 1024); //you may want to change this
    $bytes_send = 0;
    if ($file = fopen($file, 'r')) {
        if (isset($_SERVER['HTTP_RANGE']))
            fseek($file, $range);

        while (!feof($file) &&
        (!connection_aborted()) &&
        ($bytes_send < $new_length)
        ) {
            $buffer = fread($file, $chunksize);
            print($buffer); //echo($buffer); // can also possible
            flush();
            $bytes_send += strlen($buffer);
        }
        fclose($file);
    } else
    //If no permissiion
        die('Error - can not open file.');
    //die
    die();
}

function resize($img, $w, $h, $newfilename) {


    //Check if GD extension is loaded
    if (!extension_loaded('gd') && !extension_loaded('gd2')) {
        trigger_error("GD is not loaded", E_USER_WARNING);
        return false;
    }

    //Get Image size info
    $imgInfo = getimagesize($img);
    //var_dump($imgInfo);
    switch ($imgInfo[2]) {
        case 1: $im = imagecreatefromgif($img);
            break;
        case 2: $im = imagecreatefromjpeg($img);
            break;
        case 3: $im = imagecreatefrompng($img);
            break;
        default: trigger_error('Unsupported filetype!', E_USER_WARNING);
            break;
    }

    //If image dimension is smaller, do not resize
    if ($imgInfo[0] <= $w && $imgInfo[1] <= $h) {
        $nHeight = $imgInfo[1];
        $nWidth = $imgInfo[0];
    } else {
        //yeah, resize it, but keep it proportional
        if ($w / $imgInfo[0] > $h / $imgInfo[1]) {
            $nWidth = $w;
            $nHeight = $imgInfo[1] * ($w / $imgInfo[0]);
        } else {
            $nWidth = $imgInfo[0] * ($h / $imgInfo[1]);
            $nHeight = $h;
        }
    }
//    $nWidth = round($nWidth);
//    $nHeight = round($nHeight);
    // if (($imgInfo[0] <= $w) && ($imgInfo[1] <= $h)) { return $image; } //no resizing needed
    //try max width first...
    $ratio = $w / $imgInfo[0];
    $nWidth = $w;
    $nHeight = $imgInfo[1] * $ratio;

    //if that didn't work
    if ($nHeight > $h) {
        $ratio = $h / $imgInfo[1];
        $nHeight = $h;
        $nWidth = $imgInfo[0] * $ratio;
    }


    $newImg = imagecreatetruecolor($nWidth, $nHeight);

    /* Check if this image is PNG or GIF, then set if Transparent */
    if (($imgInfo[2] == 1) OR ( $imgInfo[2] == 3)) {
        imagealphablending($newImg, false);
        imagesavealpha($newImg, true);
        $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
        imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
    }
    imagecopyresampled($newImg, $im, 0 - ($nWidth - $w) / 2, 0 - ($nHeight - $h) / 2, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);

    //Generate the file, and rename it to $newfilename
    switch ($imgInfo[2]) {
        case 1: imagegif($newImg, $newfilename);
            break;
        case 2: imagejpeg($newImg, $newfilename);
            break;
        case 3: imagepng($newImg, $newfilename);
            break;
        default: trigger_error('Failed resize image!', E_USER_WARNING);
            break;
    }

    return $newfilename;
}

//Truncate Strings 
function truncate($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
    if ($considerHtml) {
        // if the plain text is shorter than the maximum length, return the whole text
        if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        // splits all html-tags to scanable lines
        preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
        $total_length = strlen($ending);
        $open_tags = array();
        $truncate = '';
        foreach ($lines as $line_matchings) {
            // if there is any html-tag in this line, handle it and add it (uncounted) to the output
            if (!empty($line_matchings[1])) {
                // if it's an "empty element" with or without xhtml-conform closing slash
                if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
                    // do nothing
                    // if tag is a closing tag
                } else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
                    // delete tag from $open_tags list
                    $pos = array_search($tag_matchings[1], $open_tags);
                    if ($pos !== false) {
                        unset($open_tags[$pos]);
                    }
                    // if tag is an opening tag
                } else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
                    // add tag to the beginning of $open_tags list
                    array_unshift($open_tags, strtolower($tag_matchings[1]));
                }
                // add html-tag to $truncate'd text
                $truncate .= $line_matchings[1];
            }
            // calculate the length of the plain text part of the line; handle entities as one character
            $content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
            if ($total_length + $content_length > $length) {
                // the number of characters which are left
                $left = $length - $total_length;
                $entities_length = 0;
                // search for html entities
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
                    // calculate the real length of all entities in the legal range
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entities_length <= $left) {
                            $left--;
                            $entities_length += strlen($entity[0]);
                        } else {
                            // no more characters left
                            break;
                        }
                    }
                }
                $truncate .= substr($line_matchings[2], 0, $left + $entities_length);
                // maximum lenght is reached, so get off the loop
                break;
            } else {
                $truncate .= $line_matchings[2];
                $total_length += $content_length;
            }
            // if the maximum length is reached, get off the loop
            if ($total_length >= $length) {
                break;
            }
        }
    } else {
        if (strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = substr($text, 0, $length - strlen($ending));
        }
    }
    // if the words shouldn't be cut in the middle...
    if (!$exact) {
        // ...search the last occurance of a space...
        $spacepos = strrpos($truncate, ' ');
        if (isset($spacepos)) {
            // ...and cut the text in this position
            $truncate = substr($truncate, 0, $spacepos);
        }
    }
    // add the defined ending to the text
    $truncate .= $ending;
    if ($considerHtml) {
        // close all unclosed html-tags
        foreach ($open_tags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }
    return $truncate;
}
