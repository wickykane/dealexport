<?php



if ( ! class_exists( 'dealexport_child' ) ) {
    class dealexport_child
    {
        public function __construct()
        {
           add_action( 'wp_enqueue_scripts', array($this, 'dealexport_assets'), 90 );
        }

        /**
		 * Enqueue Theme stylesheet & scripts
		 */
		function dealexport_assets() 
		{
            // Parent theme assets
            wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );

		    // Theme assets
			wp_enqueue_style( 'dealexport-child-stylesheet', get_stylesheet_directory_uri() . '/dist/css/bundle.css', array(), '1.0.0', 'all' );
			wp_enqueue_script( 'dealexport-child-scripts', get_stylesheet_directory_uri() . '/dist/js/bundle.js', array('jquery'), '1.0.0', true );
		    
		    // Magnific Popup 1.1.0
		    //wp_enqueue_script( 'magnific-popup-scripts', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js', array('jquery'), true );
		    
		    // Slick 1.8.1 
		    // wp_enqueue_style( 'slick-stylesheet', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css', false );
		    // wp_enqueue_script( 'slick-scripts', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', array('jquery'), true );
		}
    }

}

$dealexport_child = new dealexport_child;