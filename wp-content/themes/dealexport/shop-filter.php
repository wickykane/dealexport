<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$country_data = de_get_shop_country();
$country_data_json = json_encode($country_data);
$region_data = array();
if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL) {
    $country_id = $_GET['country-filter'];
    $region_data = de_get_shop_list_region_by_country_id($country_id);
}
$region_data_json = json_encode($region_data);
?>
<div class="widget sidebar-widget widget_categories">
    <div class="widget-title">
        <h4><?php _e('Choose Country', 'dealexport'); ?></h4>
    </div>
    <form id="location-filter" action="<?php echo get_permalink(get_page_by_path('shops')); ?>" method="get">
        <p>
            <select class="country-filter" name="country-filter">
                <option value=""><?php _e('All Country', 'dealexport'); ?></option>
            </select>
        </p>
        <p>
            <select class="region-filter" name="region-filter">
                <option value=""><?php _e('All Region', 'dealexport'); ?></option>
            </select>
        </p>
        <?php if (isset($_GET['shop-cat']) && $_GET['shop-cat']): ?>
            <input type="hidden" name="shop-cat" value="<?php echo $_GET['shop-cat']; ?>">
        <?php endif; ?>
        <div class="clearfix">
            <button id="location-filter-submit" class="right"
                    value="Submit"><?php _e('Submit', 'dealexport'); ?></button>
        </div>
    </form>
</div>
<?php
$i = 0;
$shop_cat_arr = de_get_shop_categories();
if (!empty($shop_cat_arr)):
    ?>
    <div class="widget sidebar-widget woocommerce widget_product_categories">
        <div class="widget-title">
            <h4><?php _e('Categories', 'dealexport') ?></h4>
        </div>
        <ul class="product-categories">
            <?php
            $service_term_id = get_term_by('slug', 'service', 'product_custome_type')->term_id;
            foreach ($shop_cat_arr as $shop_cat_data) {
                $shop_cat_id = $shop_cat_data->term_id;
                $shop_cat_name = $shop_cat_data->name;
                if (!isset($_GET['country-filter']) || ($_GET['country-filter'] == NULL && $_GET['region-filter'] == NULL)) {
                    $shop_cat_items_count = $shop_cat_data->count;
                } else {
                    if ($_GET['region-filter'] == NULL) {
                        $location_filter_to_count = $_GET['country-filter'];
                    } else {
                        $location_filter_to_count = $_GET['region-filter'];
                    }
                    $shop_cat_items_count = de_count_item_in_category_with_filter($location_filter_to_count, $shop_cat_id, 'shop');
                }
                $shop_cat_url = get_permalink(get_page_by_path('shops')) . (isset($_GET['country-filter']) ? '?country-filter=' . $_GET['country-filter'] : '?') . (isset($_GET['region-filter']) ? '&region-filter=' . $_GET['region-filter'] : '') . '&shop-cat=' . $shop_cat_id;
                if (!$shop_cat_data->parent) {
                    ?>
                    <?php if ($shop_cat_items_count > 0): ?>
                        <li class="cat-item" style="border-bottom: none; padding-bottom: 0;<?php echo $i > 0 ? 'border-top:1px dotted #d6d6d6; padding-top: .5em' : '' ?>">
                        <a href="<?php echo $shop_cat_url; ?>"><?php echo $shop_cat_name; ?></a>
                        <span class="count">(<?php echo $shop_cat_items_count; ?>)</span>
                        <?php $i++; ?>
                    <?php endif; ?>
                    <?php echo hierarchical_category_tree($shop_cat_data, "shop_category", "shop-cat", "shop", FALSE, $service_term_id); ?>
                    <?php if ($shop_cat_items_count > 0): ?>
                        </li>
                    <?php endif; ?>
                <?php } ?>
            <?php } ?>
        </ul>
    </div>
<?php endif; ?>
<script>
    jQuery(document).ready(function () {
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        var country_data = <?php echo $country_data_json; ?>;
        var region_data = <?php echo $region_data_json; ?>;
        var country_selected = <?php echo json_encode($_GET['country-filter']); ?>;
        var region_selected = <?php echo json_encode($_GET['region-filter']); ?>;
        jQuery(".country-filter").select2({
            data: country_data,
        }).val(country_selected).trigger('change');
        jQuery(".region-filter").select2({
            data: region_data,
        }).val(region_selected).trigger('change');

        jQuery(".country-filter").on('select2:select', function (e) {
            var selected_country_id = e.params.data.id;
            jQuery.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: {action: "de_get_shop_list_region_of_country", country_id: selected_country_id}
            }).done(function (response) {
                jQuery(".region-filter").html('<option value=""><?php _e('All Region', 'dealexport'); ?></option>').select2({data: response});
            });
        });
    });
</script>