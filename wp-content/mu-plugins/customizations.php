<?php 
/**
 * Plugin Name: Custom Functions
 * Description: Theme & Plugin customizations and overrides.
 * Author: Duc
 */


/**********************************
  * Protect direct access
***********************************/
 if( ! defined( 'CUSTOM_HACK_MSG' ) ) define( 'CUSTOM_HACK_MSG', __( 'Sorry ! You made a mistake !', 'customization' ) );
 if ( ! defined( 'ABSPATH' ) ) die( PLUGIN_HACK_MSG );



/**********************************
  * Defining constants
***********************************/
 if( ! defined( 'CUSTOM_PLUGIN_DIR' ) ) define( 'CUSTOM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
 if( ! defined( 'CUSTOM_PLUGIN_URI' ) ) define( 'CUSTOM_PLUGIN_URI', plugins_url( '', __FILE__ ) );


add_action( 'wp_enqueue_scripts', 'child_scripts', 99 );
function child_scripts() {
   	//wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Fira+Sans:500,600,700,800,900|Raleway:400,400i,500,500i,600,700,800', false );
   	wp_enqueue_style( 'leaflet-css', 'https://unpkg.com/leaflet@1.3.3/dist/leaflet.css', false );
    wp_enqueue_script( 'magnific-popup-script', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js', array('jquery'), true );
   	//wp_enqueue_script( 'main-script', get_stylesheet_directory_uri() . '/js/main.js', array('jquery'), true );

   //  if(is_page(10)){
   //    wp_enqueue_style( 'leaflet-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.35.1/mapbox-gl.css', false );
   //  	wp_enqueue_script( 'leaflet-js', 'https://unpkg.com/leaflet@1.3.3/dist/leaflet.js', array('jquery'), true );
   // 		wp_enqueue_script( 'turf-js', 'https://npmcdn.com/@turf/turf/turf.min.js', array('jquery'), true );
   //    wp_enqueue_script( 'mapbox-gl-js', 'https://api.tiles.mapbox.com/mapbox-gl-js/v0.35.1/mapbox-gl.js', array('jquery'), true );
   //    wp_enqueue_script( 'leaflet-mapbox-gl', get_stylesheet_directory_uri() . '/js/leaflet-mapbox-gl.js', array('jquery'), true );

   // 		wp_enqueue_script( 'map-script', get_stylesheet_directory_uri() . '/js/map-script.js', array('jquery'), true );
	  // } 
    wp_dequeue_script('parent_theme_script_handle');
}







function remove_default_image_sizes( $sizes ) {
  
  /* Default WordPress */
  unset( $sizes[ 'thumbnail' ]);       // Remove Thumbnail (150 x 150 hard cropped)
  unset( $sizes[ 'medium' ]);          // Remove Medium resolution (300 x 300 max height 300px)
  unset( $sizes[ 'medium_large' ]);    // Remove Medium Large (added in WP 4.4) resolution (768 x 0 infinite height)
  unset( $sizes[ 'large' ]);           // Remove Large resolution (1024 x 1024 max height 1024px)
  
  return $sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'remove_default_image_sizes' );


/**********************************
  * SVG Enable
***********************************/
/*** Enable SVG upload ***/
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');



/****************************** 
 Disable XML-RPC
— This setting is highly recommended if Jetpack, the WordPress mobile app, pingbacks, and other services that use XML-RPC are not used.
*******************************/
add_filter('xmlrpc_enabled', '__return_false');


/******************************  
  Disable RSS Feeds 
— disables RSS if you using WordPress for website only, not for blog.
*******************************/

function wpb_disable_feed() {
    wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">Home Page</a>!') );
}
 
add_action('do_feed', 'wpb_disable_feed', 1);
add_action('do_feed_rdf', 'wpb_disable_feed', 1);
add_action('do_feed_rss', 'wpb_disable_feed', 1);
add_action('do_feed_rss2', 'wpb_disable_feed', 1);
add_action('do_feed_atom', 'wpb_disable_feed', 1);
add_action('do_feed_rss2_comments', 'wpb_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpb_disable_feed', 1);
