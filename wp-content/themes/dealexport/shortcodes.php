<?php
//Columns
add_shortcode('one_sixth', 'themedb_one_sixth');
function themedb_one_sixth($atts, $content = null) {
   return '<div class="twocol column">'.do_shortcode($content).'</div>';
}

add_shortcode('one_sixth_last', 'themedb_one_sixth_last');
function themedb_one_sixth_last($atts, $content = null) {
   return '<div class="twocol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('one_fourth', 'themedb_one_fourth');
function themedb_one_fourth($atts, $content = null) {
   return '<div class="threecol column">'.do_shortcode($content).'</div>';
}

add_shortcode('one_fourth_last', 'themedb_one_fourth_last');
function themedb_one_fourth_last($atts, $content = null) {
   return '<div class="threecol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('one_third', 'themedb_one_third');
function themedb_one_third($atts, $content = null) {
   return '<div class="fourcol column">'.do_shortcode($content).'</div>';
}

add_shortcode('one_third_last', 'themedb_one_third_last');
function themedb_one_third_last($atts, $content = null) {
   return '<div class="fourcol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('five_twelfths', 'themedb_five_twelfths');
function themedb_five_twelfths($atts, $content = null) {
   return '<div class="fivecol column">'.do_shortcode($content).'</div>';
}

add_shortcode('five_twelfths_last', 'themedb_five_twelfths_last');
function themedb_five_twelfths_last($atts, $content = null) {
   return '<div class="fivecol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('one_half', 'themedb_one_half');
function themedb_one_half($atts, $content = null) {
   return '<div class="sixcol column">'.do_shortcode($content).'</div>';
}

add_shortcode('one_half_last', 'themedb_one_half_last');
function themedb_one_half_last($atts, $content = null) {
   return '<div class="sixcol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('seven_twelfths', 'themedb_seven_twelfths');
function themedb_seven_twelfths($atts, $content = null) {
   return '<div class="sevencol column">'.do_shortcode($content).'</div>';
}

add_shortcode('seven_twelfths_last', 'themedb_seven_twelfths_last');
function themedb_seven_twelfths_last($atts, $content = null) {
   return '<div class="sevencol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('two_thirds', 'themedb_two_thirds');
function themedb_two_thirds($atts, $content = null) {
   return '<div class="eightcol column">'.do_shortcode($content).'</div>';
}

add_shortcode('two_thirds_last', 'themedb_two_thirds_last');
function themedb_two_thirds_last($atts, $content = null) {
   return '<div class="eightcol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

add_shortcode('three_fourths', 'themedb_three_fourths');
function themedb_three_fourths($atts, $content = null) {
   return '<div class="ninecol column">'.do_shortcode($content).'</div>';
}

add_shortcode('three_fourths_last', 'themedb_three_fourths_last');
function themedb_three_fourths_last($atts, $content = null) {
   return '<div class="ninecol column last">'.do_shortcode($content).'</div><div class="clear"></div>';
}

//Button
add_shortcode('button','themedb_button');
function themedb_button($atts, $content=null) {	
    extract(shortcode_atts(array(
        'url' => '#',
        'target' => 'self',
        'color' => '',
        'size' => '',
    ), $atts));
    
    $out='<a href="'.$url.'" target="_'.$target.'" class="element-button '.$size.' '.$color.'">'.do_shortcode($content).'</a>';
    return $out;
}

//Section
add_shortcode('section', 'themedb_section');
function themedb_section($atts, $content=null) {
    extract(shortcode_atts(array(
        'background' => '',
    ), $atts));
    
    $style='';
    if(!empty($background)) {
        $style='background:url('.$background.');';
    }

    $out='</section></div><div class="section-wrap" style="'.$style.'"><section class="site-content container">';
    $out.=do_shortcode($content);
    $out.='</section></div><div class="content-wrap"><section class="site-content container">';
    
    return $out;
}

//Shops
add_shortcode('shops', 'themedb_shops');
function themedb_shops($atts, $content=null) {
    extract(shortcode_atts(array(
        'number' => '3',
        'columns' => '3',
        'order' => 'rand',
        'category' => '0',
        'ids' => '0',
    ), $atts));
    
    if($order=='random') {
        $order='rand';
    }
    
    $columns=intval($columns);
    $width='three';
    $counter=0;	
    
    switch($columns) {
        case '1': $width='twelve'; break;
        case '2': $width='six'; break;
        case '3': $width='four'; break;
        case '6': $width='two'; break;
        case '5': $width='two'; break;
    }	
    
    $args=array(
        'post_type' => 'shop',
        'showposts' => $number,	
        'orderby' => $order,
        'order' => 'DESC',
    );
    
    if(!empty($ids)) {
        $ids=explode(',', $ids);
        $ids=array_map('intval', $ids);
        $args['post__in']=$ids;
    }
    
    if(!empty($category)) {
        $args['tax_query'][]=array(
            'taxonomy' => 'shop_category',
            'terms' => $category,
            'field' => 'term_id',
        );
    }
        
    if(in_array($order, array('rating', 'sales', 'admirers'))) {
        $args['orderby']='meta_value_num';
        $args['meta_key']='_'.THEMEDB_PREFIX.$order;
    } else if($order=='title') {
        $args['order']='ASC';
    }
    
    $query=new WP_Query($args);

    $out='<div class="shops-wrap clearfix">';
    while($query->have_posts()){
        $query->the_post();	
        $counter++;
        
        $class='';
        if($counter==$columns) {
            $class='last';
        }
        
        $out.='<div class="column '.$width.'col '.$class.'">';		
        ob_start();
        get_template_part('content', 'shop');
        $out.=ob_get_contents();
        ob_end_clean();
        $out.='</div>';
        
        if($counter==$columns) {
            $out.='<div class="clear"></div>';
            $counter=0;						
        }
    }
    $out.='</div><div class="clear"></div>';
    
    wp_reset_query();
    return $out;
}

//Testimonials
add_shortcode('testimonials', 'themedb_testimonials');
function themedb_testimonials($atts, $content=null) {
    extract(shortcode_atts(array(
        'number' => '4',
        'order' => 'date',
        'category' => '0',
        'pause' => '0',
        'speed' => '900',
    ), $atts));
    
    if($order=='random') {
        $order='rand';
    }
    
    $args=array(
        'post_type' => 'testimonial',
        'showposts' => $number,
        'orderby' => $order,
    );
    
    if(!empty($category)) {
        $args['tax_query'][]=array(
            'taxonomy' => 'testimonial_category',
            'terms' => $category,
            'field' => 'slug',
        );
    }
        
    $query=new WP_Query($args);	
    
    $out='<div class="testimonials-slider element-slider" data-pause="'.$pause.'" data-speed="'.$speed.'"><ul>';
    while($query->have_posts()){
        $query->the_post();
        
        ob_start();
        the_content();
        $content=ob_get_contents();
        ob_end_clean();
        
        $content=str_replace('<p>', '<h1>', $content);
        $content=str_replace('</p>', '</h1>', $content);
        $GLOBALS['content']=$content;
        
        $out.='<li>';
        ob_start();
        get_template_part('content', 'testimonial');
        $out.=ob_get_contents();
        ob_end_clean();
        $out.='</li>';
    }
    $out.='</ul></div>';	
    
    wp_reset_query();
    return $out;
}

//Title
add_shortcode('title', 'themedb_title');
function themedb_title($atts, $content=null) {
    extract(shortcode_atts(array(
        'indent' => '',
        'align' => 'center',
    ), $atts));
    
    $style='';
    if(!empty($indent)) {
        $style='margin-top:'.$indent.'em;';
        $style.='margin-bottom:'.$indent.'em;';
    }
    if(!empty($align)){
        $style.='text-align:'.$align.';';
    }
    
    $out='<div class="element-title" style="'.$style.'"><h1>'.do_shortcode($content).'</h1></div>';
    return $out;
}

//Users
add_shortcode('users','themedb_users');
function themedb_users( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'number' => '3',
        'columns' => '3',
        'order' => 'date',
        'role' => '',
        'ids' => '',
    ), $atts));
    
    $orderby='registered';
    $orderdir='ASC';
    switch($order) {
        case 'activity':
            $orderby='post_count';
            $orderdir='DESC';
        break;
        
        case 'name':
            $orderby='display_name';
        break;
        
        case 'date':
            $orderby='registered';
            $orderdir='DESC';
        break;
    }
    
    $columns=intval($columns);
    $width='three';
    $counter=0;	
    
    switch($columns) {
        case '1': $width='twelve'; break;
        case '2': $width='six'; break;
        case '3': $width='four'; break;
    }
    
    $args=array(
        'number' => intval($number),
        'orderby' => $orderby,
        'order' => $orderdir,
    );
    
    if(!empty($id)) {
        $ids=explode(',', $id);
        $ids=array_map('intval', $ids);
        $args['include']=$ids;		
    }
    
    if(!empty($role)) {
        $args['role']=$role;
    }
    
    $users=get_users($args);
    
    $out='<div class="profiles-wrap">';
    foreach($users as $user) {
        $GLOBALS['user']=$user;
        $counter++;
        
        $class='';
        if($counter==$columns) {
            $class='last';
        }
        
        $out.='<div class="column '.$width.'col '.$class.'">';
        ob_start();
        get_template_part('content', 'profile');
        $out.=ob_get_contents();
        ob_end_clean();
        $out.='</div>';
        
        if($counter==$columns) {
            $out.='<div class="clear"></div>';
            $counter=0;						
        }
    }
    $out.='<div class="clear"></div></div>';
    
    return $out;
}

add_shortcode('div_section', 'themedb_div_section');
function themedb_div_section($atts, $content = null) {
    extract(shortcode_atts(array(
    'img_url' => '',       // img url
    'text_content' => '',  //text content of section
    'target_div_id' => '#', //div id
    'section_position' => '',
    'id' => 0,
    ), $atts));
    $content =  '<div class="fourcol column '.$section_position.'" id="div_section_'.$id.'"><div class="nav-step">
                      <div class="box">
                          <div class="logo">
                              <img class="alignleft" src="'.$img_url.'" alt=""/>
                          </div>
                          <div class="title long">'.$text_content.'</div>
                      </div>
                 </div></div>';
    $content .= '<script>
                jQuery(document).ready(function($) { 
                    $("#div_section_'.$id.'").click(function() {
                        $("html, body").animate({
                            scrollTop: ($("#'.$target_div_id.'").offset().top - 100)
                        }, 1000);
                    });
                  });
            </script>';
    return $content;
}


//Services
add_shortcode('services', 'themedb_services');
function themedb_services($atts, $content=null) {
	
	$atts = shortcode_atts( array(
			'columns' => '4',
			'orderby' => 'title',
			'order'   => 'rand',
			'ids'     => '',
			'skus'    => ''
	), $atts );
	
	$tax_query = array(
			array(
					'taxonomy' => 'product_custome_type',
					'field' => 'slug',
					'terms' => 'service',
			));
	
	$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => -1,
			'meta_query'          => WC()->query->get_meta_query(),
			'tax_query' => $tax_query
	);
	
	if ( ! empty( $atts['skus'] ) ) {
		$query_args['meta_query'][] = array(
				'key'     => '_sku',
				'value'   => array_map( 'trim', explode( ',', $atts['skus'] ) ),
				'compare' => 'IN'
		);
	}
	
	if ( ! empty( $atts['ids'] ) ) {
		$query_args['post__in'] = array_map( 'trim', explode( ',', $atts['ids'] ) );
	}
	global $woocommerce_loop;
	
	$products                    = new WP_Query( $query_args);
	$columns                     = absint( $atts['columns'] );
	$woocommerce_loop['columns'] = $columns;
	$loop_name = 'products';
	
	ob_start();
	
	if ( $products->have_posts() ) : ?>

		<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

	<?php endif;

	woocommerce_reset_loop();
	wp_reset_postdata();

	return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}

//Custom products
add_shortcode('cus_products', 'themedb_services');
function themedb_services($atts, $content=null) {
	
	$atts = shortcode_atts( array(
			'number' => '5',
                        'columns' => '5',
			'orderby' => 'rand',
			'order'   => '',
	), $atts );
	
	$query_args = array(
			'post_type'           => 'product',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
			'orderby'             => $atts['orderby'],
			'order'               => $atts['order'],
			'posts_per_page'      => $atts['number'],
	);
	
	global $woocommerce_loop;
	
	$products                    = new WP_Query( $query_args);
	$columns                     = absint( $atts['columns'] );
	$woocommerce_loop['columns'] = $columns;
	$loop_name = 'products';
	
	ob_start();
	
	if ( $products->have_posts() ) : ?>

		<?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

		<?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

	<?php endif;

	woocommerce_reset_loop();
	wp_reset_postdata();

	return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
}