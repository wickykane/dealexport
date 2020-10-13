<?php
/*
 * 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    if ( function_exists( 'custom_breadcrumbs' ) ) custom_breadcrumbs();
?>



<ul class="dropdown-wrapper">
    <?php // Add Display mode
        $display_terms = array(
            [
                'name' => '[:en]By Type Of Service Provider[:fr]Par type de prestataires[:vi]Theo Loại Hình Nhà Cung Cấp[:]',
                'slug' => 'type-of-service-provider'
            ],
            [
                'name' => '[:en]By Company[:fr]Par entreprises[:vi]Theo Công Ty[:]',
                'slug' => 'company'
            ],
            [
                'name' => '[:en]By Service[:fr]Par services[:vi]Theo Dịch Vụ[:]',
                'slug' => 'service'
            ]
        );
    ?>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown"><?php _e('[:en]Display Mode[:fr]Mode d\'affichage[:vi]Chế độ hiển thị[:]', 'dealexport') ?><i class="icon-arrow"></i></a>
      <ul class="dropdown-menu">
       <?php
            foreach ($display_terms as $display_term) {
//                echo '<li><a href="#" data-value=' . $display_term[slug] . '/> ' . $display_term[name] . '</a></li>';
                ?>

                <li><a href="#" data-value="<?php echo $display_term[slug] ?>"><?php echo _e($display_term[name]) ?></a></li>
                <?php
            }
       ?> 
      </ul>
    </li>

    <?php // Add Country & Region
    $country_data = de_get_product_country();
    $country_data_json = json_encode($country_data);
    $region_data = array();
    if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL) {
        $country_id = $_GET['country-filter'];
        $region_data = de_get_list_region_by_country_id($country_id);
    }
    $region_data_json = json_encode($region_data);
    ?>
    <li class="dropdown">
        <a href="#" data-toggle="dropdown"><?php _e('[:en]Choose Country[:fr]Pays[:vi]Chọn quốc gia[:]', 'dealexport') ?><i class="icon-arrow"></i></a>
        <ul class="dropdown-menu filter-list">
            <form id="location-filter" action="<?php echo get_permalink(get_page_by_path('service')); ?>" method="get">
                <li>
                    <select class="country-filter" name="country-filter">
                        <option value=""><?php _e('[:en]All countries[:fr]Tous pays[:vi]Tất cả[:]', 'dealexport'); ?></option>
                    </select>
                    <!--<input id="country-filter-value" type="hidden" name="country-filter-value" value="">-->
                </li>
                <li class="display--none">
                    <select class="region-filter" name="region-filter">
                        <option value=""><?php _e('[:en]All Regions[:fr]All Regions[:vi]Tất cả khu vực[:]', 'dealexport'); ?></option>
                    </select>
                    <!--<input id="region-filter-value" type="hidden" name="region-filter-value" value="">-->
                </li>
                <div class="criterion-filter"><?php _e('[:en]Region[:fr]Région[:vi]Khu vực[:]', 'dealexport'); ?></div>
                <ul data-taxonomy="product_country_region" class="region-menu filter-list"><li><i><?php _e('[:en]Please select the region[:fr]Merci de sélectionner la région[:vi]Vui lòng chọn khu vực[:]', 'dealexport'); ?></i></li></ul>
                <?php if (isset($_GET['product-cat']) && $_GET['product-cat']): ?>
                    <input type="hidden" name="product-cat" value="<?php echo $_GET['product-cat']; ?>">
                <?php endif; ?>
                <div class="clearfix">
                    <button id="location-filter-submit" class="right display--none"
                            value="Submit"><?php _e('Submit', 'dealexport'); ?></button>
                </div>
            </form>
        </ul>
    </li>

    <?php // Add Level of expertise
        $level_terms = get_terms('level_of_expertise'); 
    ?>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown"><?php _e('[:en]Level of Expertise[:fr]Niveau d\'expertise[:vi]Mức độ chuyên gia[:]', 'dealexport') ?><i class="icon-arrow"></i></a>
      <ul data-taxonomy="level_of_expertise" class="dropdown-menu filter-list">
       <?php
            foreach ($level_terms as $level_term) {
                echo '<li><input class="filter-term" type="checkbox" name="' . $level_term -> slug . '" value="' . $level_term -> slug . '" /><label>' . $level_term -> name . '</label></li>';
            }
       ?> 
      </ul>
    </li>

    <?php // Add Level of Development (previous name: International Development Stage)
        $stage_terms = get_terms('level_of_development');
    ?>
    <li class="dropdown">
      <a href="#" data-toggle="dropdown"><?php _e('[:en]Level of Development[:fr]Niveau de développement[:vi]Mức độ phát triển[:]', 'dealexport') ?><i class="icon-arrow"></i></a>
      <ul data-taxonomy="international_development_stage" class="dropdown-menu filter-list">
       <?php
            foreach ($stage_terms as $stage_term) {
                echo '<li><input class="filter-term" type="checkbox" name="' . $stage_term -> slug . '" value="' . $stage_term -> slug . '" /><label>' . $stage_term -> name . '</label></li>';
            }
       ?> 
      </ul>
    </li>


    <?php // Add Service Provider (previous name: Type of Industry)
        $industry_terms = get_terms('type_of_industry');
    ?>
    <li class="dropdown">
        <a href="#" data-toggle="dropdown"><?php _e('[:en]Service Provider[:fr]Prestataires[:vi]Loại hình nhà cung cấp[:]', 'dealexport') ?><i class="icon-arrow"></i></a>
        <ul data-taxonomy="type_of_industry" class="dropdown-menu filter-list">
            <?php
            foreach ($industry_terms as $industry_term) {
                echo '<li><input class="filter-term" type="checkbox" name="' . $industry_term -> slug . '" value="' . $industry_term -> slug . '" /><label>' . $industry_term -> name . '</label></li>';
            }
            ?> 
        </ul>
    </li>


    <?php // Add Category
    $i = 0;
    $product_cat_arr = de_get_product_categories();

    // remove some categories that have count == 0
    foreach($product_cat_arr as $key => $product_cat) {
        if( $product_cat->count == 0 ) {
            unset($product_cat_arr[$key]);
        }
    }
    ?>
    <li class="dropdown">
        <a href="#" data-toggle="dropdown"><?php _e('Categories', 'dealexport') ?><i class="icon-arrow"></i></a>
        <ul data-taxonomy="product_cat" class="dropdown-menu filter-list">
            <?php //print_r($product_cat_arr) ?>

            <?php
            foreach ($product_cat_arr as $cat_parent) {
                $product_cat_id = $cat_parent->term_id;
                $product_cat_name = $cat_parent->name;
                $product_cat_slug = $cat_parent->slug;
                $product_cat_count = amagumo_count_posts_for_exporter_by_slug($product_cat_slug);
                if( $product_cat_count > 0 ) {
                    ?>

                    <?php   if ($cat_parent->parent == 0) { ?>
                        <li>
                        <input class="filter-term" type="checkbox" name="<?php echo $product_cat_slug ?>" value="<?php echo $product_cat_slug ?>">
                        <label><?php echo $product_cat_name ?> <span class="count">(<?php echo amagumo_count_posts_for_exporter_by_slug($product_cat_slug); ?>)</span></label>
                        <?php
                        $terms_children = get_term_children($product_cat_id, 'product_cat');
                        if(!empty($terms_children)) { ?>
                            <ul data-taxonomy="product_cat" class="filter-list sub">
                                <?php
                                foreach ($terms_children as $product_cat_child_id) {
                                    $product_cat_child = get_term_by('id', $product_cat_child_id, 'product_cat');
                                    $product_cat_child_name = $product_cat_child->name;
                                    $product_cat_child_slug = $product_cat_child->slug;
                                    $product_cat_child_count = amagumo_count_posts_for_exporter_by_slug($product_cat_child_slug); // Mark: count the items of the given slug which is either 'product-for-exporter' or 'service-for-exporter'
                                    if( $product_cat_child_count > 0 ) {
                                        echo '<li><input class="filter-term" type="checkbox" name="' . $product_cat_child_slug . '" value="' . $product_cat_child_slug . '" /><label>' . $product_cat_child_name .'<span class="count"> ('. $product_cat_child_count . ')</span>' .'</label></li>';
                                    }
                                }
                                ?>
                            </ul>
                            </li>
                            <?php
                        }
                        print_r($term_children);
                        ?>
                    <?php   }  ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </li>

    <?php // Add Product Custome Type - hidden key
    $custome_types = get_terms('product_custome_type');
    ?>
    <li class="dropdown" style="display: none;">
        <a href="#" data-toggle="dropdown"><?php _e('Product custome type', 'dealexport') ?><i class="icon-arrow"></i></a>
        <ul data-taxonomy="product_custome_type" class="dropdown-menu filter-list">
            <?php
            foreach ($custome_types as $type) {
                switch ($type->slug) {
                    case 'product-for-exporter':
                        echo '<li><input class="filter-term" type="checkbox" checked disabled readonly name="' . $type -> slug . '" value="' . $type -> slug . '" /><label>' . $type -> name . '</label></li>';
                        break;
                    case 'service-for-exporter':
                        echo '<li><input class="filter-term" type="checkbox" checked disabled readonly name="' . $type -> slug . '" value="' . $type -> slug . '" /><label>' . $type -> name . '</label></li>';
                        break;
                    default:
                        echo '<li><input class="filter-term" type="checkbox" disabled readonly name="' . $type -> slug . '" value="' . $type -> slug . '" /><label>' . $type -> name . '</label></li>';
                        break;
                }
            }
            ?>
        </ul>
    </li>

<!--    <li class="dropdown display--none">-->
<!--        <a href="#" data-toggle="dropdown">--><?php //_e('Categories', 'dealexport') ?><!--<i class="icon-arrow"></i></a>-->
<!--        <ul class="dropdown-menu filter-list">-->
<!--            --><?php //if (!empty($product_cat_arr)): ?>
<!--                --><?php
//                $service_term_id = get_term_by('slug', 'service', 'product_custome_type')->term_id;
//                foreach ($product_cat_arr as $product_cat_data) {
//                    $product_cat_id = $product_cat_data->term_id;
//                    $product_cat_name = $product_cat_data->name;
//                    if (!isset($_GET['country-filter']) || ($_GET['country-filter'] == NULL && $_GET['region-filter'] == NULL)) {
//                        $product_cat_items_count = de_count_item_in_category_with_filter('', $product_cat_id, 'product', TRUE, $service_term_id);
//                    } else {
//                        if ($_GET['region-filter'] == NULL) {
//                            $location_filter_to_count = $_GET['country-filter'];
//                        } else {
//                            $location_filter_to_count = $_GET['region-filter'];
//                        }
//                        $product_cat_items_count = de_count_item_in_category_with_filter($location_filter_to_count, $product_cat_id, 'product', TRUE, $service_term_id);
//                    }
//                    $service_cat_url = get_permalink(get_page_by_path('service')) . (isset($_GET['country-filter']) ? '?country-filter=' . $_GET['country-filter'] : '?') . (isset($_GET['region-filter']) ? '&region-filter=' . $_GET['region-filter'] : '') . '&product-cat=' . $product_cat_id;
//                    if (!$product_cat_data->parent) {
//                        ?>
<!--                        --><?php //if ($product_cat_items_count > 0): ?>
<!--                            <li class="cat-item">-->
<!--                            <a href="--><?php //echo $service_cat_url; ?><!--">--><?php //echo $product_cat_name; ?><!--</a>-->
<!--                            <span class="count">(--><?php //echo $product_cat_items_count; ?><!--)</span>-->
<!--                            --><?php //$i++; ?>
<!--                        --><?php //endif; ?>
<!--                        --><?php //echo hierarchical_category_tree($product_cat_data, "product_cat", "product-cat", "product", TRUE, $service_term_id); ?>
<!--                        --><?php //if ($product_cat_items_count > 0): ?>
<!--                            </li>-->
<!--                        --><?php //endif; ?>
<!--                        --><?php
//                    }
//                }
//                ?>
<!--            --><?php //endif; ?>
<!--        </ul>-->
<!--    </li>-->
</ul>


<script>
(function($){

    $( document ).ready(function() {init();});

    function init() {

        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        console.log(ajaxurl);
        var country_data = <?php echo $country_data_json; ?>;
        var region_data = <?php echo $region_data_json; ?>;
        var country_selected = <?php echo json_encode($_GET['country-filter']); ?>;
        var region_selected = <?php echo json_encode($_GET['region-filter']); ?>;
        $(".country-filter").select2({
            data: country_data,
        }).val(country_selected).trigger('change');
        $(".region-filter").select2({
            data: region_data,
        }).val(region_selected).trigger('change');

        // document.querySelector('body').addEventListener('click', filterService);
    }

})(jQuery);

    jQuery(document).ready(function () {

        //if (jQuery('.product-child-categorie').parent().next() !== null) {
        //jQuery('.product-child-categorie').parent().next().remove();
        //}

        // init the display mode selector
        jQuery("li.display-mode:first-of-type").css('background-color', 'var(--color-main)');
        jQuery("li.display-mode:first-of-type").css('color', 'white');

        // onClick of display mode selector
        jQuery("li.display-mode").click(function () {
            console.log(jQuery(this).index()); // for dev
            console.log(jQuery(this).attr("name")); // for dev

            jQuery("li.display-mode").css('background-color', 'transparent');
            jQuery("li.display-mode").css('color', 'black');

            jQuery(this).css('background-color', 'var(--color-main)'); // TODO: this needs better CSS
            jQuery(this).css('color', 'white')
            displayMode(jQuery(this).attr('name'));
        });
        
        function displayMode(mode) {
            switch (mode) {
                case 'company':
                    // code goes here
                    alert('Triggered: Change mode to view by ' + mode + '. Developing...'); // TODO: develop display mode
                    break;
                case 'service':
                    //code goes here
                    alert('Triggered: Change mode to view by ' + mode + '. Developing...'); // TODO: develop display mode
                    break;
                default:
                    // code goes here
                    // reserved for display mode type-of-service-provider
                    alert('Triggered: Change mode to view by ' + mode + '. Developing...'); // TODO: develop display mode
            }
        }
    });
</script>