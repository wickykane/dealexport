<?php
$speed=intval(ThemedbCore::getOption('slider_speed', '100'));
$pause=intval(ThemedbCore::getOption('slider_pause', '0'));
$query=new WP_Query(array(
    'post_type' =>'slide',
    'showposts' => -1,
    'orderby' => 'menu_order',
    'order' => 'ASC',
));


if($query->have_posts()) {
?>

<div class="slider-wrap">
    <div class="element-slider header-slider" data-effect="slide" data-pause="<?php echo $pause; ?>" data-speed="<?php echo $speed; ?>">
        <ul>
            <?php 
            while($query->have_posts()) { 
            $query->the_post();

            //Background
            //$slide_img_id = get_post_meta( get_the_ID(), 'slide_image', true );
            $slide_img_id = get_post_meta( get_the_ID(), 'slide_background', true );
            $slide_img_url = wp_get_attachment_image_src($slide_img_id, 'full')[0];

            //Type
            $slide_type = get_post_meta( get_the_ID(), 'slide_type', true );


            //Skin
            $slide_skin = get_post_meta( get_the_ID(), 'slide_skin', true );

            //Supplier
            $slide_supplier = get_post_meta( get_the_ID(), 'slide_supplier', true );

            //Title
            $slide_title = get_post_meta( get_the_ID(), 'slide_title', true );

            //Color
            $slide_color = get_post_meta( get_the_ID(), 'slide_color', true );

            //Button
            $slide_btn_text = get_post_meta( get_the_ID(), 'slide_button_text', true );
            $slide_btn_url = get_post_meta( get_the_ID(), 'slide_button_url', true );

            //Alignment
            $slide_alignment = get_post_meta( get_the_ID(), 'slide_alignment', true );

            //Price
            $slide_sale_price = get_post_meta( get_the_ID(), 'slide_sale_price', true );

            switch ($slide_alignment) {
            	case 'Left':
            		$slide_alignment_class = "align-items--left";
            		break;
            	case 'Right':
            		$slide_alignment_class = "align-items--right";
            		break;
            	case 'Center':
            		$slide_alignment_class = "align-items--center";
            		break;
            	default:
            		$slide_alignment_class = "other";
            		break;
            }

            // switch ($slide_type) {
            // 	case 'Product':
            // 		// $slide_product_img_id = get_post_meta( get_the_ID(), 'slide_product_image', true );
            // 		// $slide_product_img_url = wp_get_attachment_image_src($slide_product_img_id, 'full')[0];
            // 		break;
            // 	case 'Deal':
            // 		break;
            // 	default:
            // 		# code...
            // 		break;
            // }

            ?>

            <li>
                <div class="slide-content display--flex align-items--center <?php echo $slide_skin ?>" data-value="<?php echo $slide_type; ?>" style="
                                              	  background: url(<?php echo $slide_img_url;?>);
                                                  background-size: cover;
                                                  background-position: center center;">
                    <?php //the_content(); ?>

                    <div class="slide-inner-content-wrapper display--flex <?php echo $slide_alignment_class ?>">
                    	<h4  style="color: <?php echo $slide_color; ?>"><?php echo $slide_supplier; ?> <span></span></h4>
                    	<h2  style="color: <?php echo $slide_color; ?>"><?php echo $slide_title; ?></h2>
                    	<div class="slide-inner-bottom-wrapper">
                    		<a class="slide-btn" href="<?php echo $slide_btn_url; ?>" style="color: <?php echo $slide_color; ?>"><?php echo $slide_btn_text; ?><span></span></a>
                            <?php if($slide_sale_price) { ?>
                    		<span style="color: <?php echo $slide_color; ?>" class="slide-sale-price">Price: <span class="price"><?php echo $slide_sale_price ?></span></span>
                            <?php } ?>
                    	</div>
                    </div>
                </div>							
            </li>
            <?php } ?>
        </ul>
    </div>
</div>
<!-- /slider -->
<?php } ?>