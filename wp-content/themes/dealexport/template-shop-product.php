<?php
/*
Template Name: Shop Product
*/
?>
<?php get_header(); ?>
<?php get_sidebar('profile-left'); ?>
<div class="column fivecol">
    <div class="element-title indented">
        <?php if(empty(ThemedbWoo::$data['product']) || ThemedbWoo::$data['product']['status']!='draft') { ?>
        <h1><?php _e('Edit Item', 'dealexport'); ?></h1>
        <?php } else { ?>
        <h1><?php _e('Add Item', 'dealexport'); ?></h1>
        <?php } ?>
    </div>
    <?php ThemedbInterface::renderTemplateContent('shop-product'); ?>
    <?php if(ThemedbCore::checkOption('shop_multiple')) { ?>
    <span class="secondary"><?php _e('This shop does not exist.', 'dealexport'); ?></span>
    <?php } else if(themedb_status(ThemedbUser::$data['current']['shop'])!='publish') { ?>
    <span class="secondary"><?php _e('This shop is currently being reviewed.', 'dealexport'); ?></span>
    <?php } else if(empty(ThemedbWoo::$data['product']) || (!empty(ThemedbWoo::$data['product']['ID']) && ThemedbWoo::$data['product']['author']!=ThemedbUser::$data['current']['ID'])) { ?>
    <span class="secondary"><?php _e('This item does not exist.', 'dealexport'); ?></span>
    <?php } else if(ThemedbWoo::$data['product']['status']=='pending') { ?>
    <span class="secondary"><?php _e('This item is currently being reviewed.', 'dealexport'); ?></span>
    <?php } else { ?>
    <form action="" enctype="multipart/form-data" method="POST">
        <input type="file" id="product_image" name="product_image" class="element-upload shifted" />
        <input type="hidden" name="product_id" value="<?php echo ThemedbWoo::$data['product']['ID']; ?>" />
        <input type="hidden" name="woo_action" value="add_image" />
    </form>
    <?php foreach(ThemedbWoo::$data['product']['images'] as $image) { ?>
    <form id="image_<?php echo $image; ?>" action="" method="POST">
        <input type="hidden" name="image_id" value="<?php echo $image; ?>" />
        <input type="hidden" name="product_id" value="<?php echo ThemedbWoo::$data['product']['ID']; ?>" />
        <input type="hidden" name="woo_action" value="remove_image" />
    </form>
    <?php } ?>
    <?php if(!empty(ThemedbWoo::$data['product']['ID'])) { ?>
    <form action="" enctype="multipart/form-data" method="POST" id="product_form_<?php echo ThemedbWoo::$data['product']['ID']; ?>" class="site-form element-autosave" data-default="product_form">
    <?php } else { ?>
    <form action="" enctype="multipart/form-data" method="POST" id="product_form" class="site-form element-autosave">
    <?php } ?>
        <div class="message">
            <?php ThemedbInterface::renderMessages(themedb_value('success', $_POST, false)); ?>
        </div>
        <table class="profile-fields">
            <tbody>
                <tr>
                    <th><?php _e('Name', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="title" value="<?php echo esc_attr(ThemedbWoo::$data['product']['title']); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Images', 'dealexport'); ?></th>
                    <td>
                        <div class="element-gallery">
                            <label for="product_image" class="element-button secondary small square" title="<?php _e('Add Image', 'dealexport'); ?>">
                                <span class="fa fa-plus"></span>
                            </label>
                            <?php foreach(ThemedbWoo::$data['product']['images'] as $image) { ?>
                            <a href="#image_<?php echo $image; ?>" title="<?php _e('Remove Image', 'dealexport'); ?>" class="gallery-image element-submit">
                                <div class="image-border none">
                                    <img src="<?php echo themedb_resize(wp_get_attachment_url($image), 150, 150); ?>" class="fullwidth" alt="" />
                                </div>
                            </a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php if(ThemedbCore::getOption('product_type', 'all')=='all') { ?>
                <tr>
                    <th><?php _e('Type', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'type',
                                'type' => 'select',
                                'options' => array(
                                    'physical' => __('Physical', 'dealexport'),
                                    'virtual' => __('Virtual', 'dealexport'),
                                ),
                                'attributes' => array(
                                    'class' => 'element-trigger',
                                ),
                                'value' => ThemedbWoo::$data['product']['type'],
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(themedb_taxonomy('product_cat')) { ?>
                <tr>
                    <th><?php _e('Category', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'category',
                                'type' => 'select_category',
                                'taxonomy' => 'product_cat',
                                'value' => ThemedbWoo::$data['product']['category'],
                                'wrap' => false,				
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(!ThemedbCore::checkOption('product_tags')) { ?>
                <tr>
                    <th><?php _e('Tags', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="tags" value="<?php echo esc_attr(ThemedbWoo::$data['product']['tags']); ?>" />
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(!ThemedbCore::checkOption('product_price') && ThemedbWoo::$data['product']['form']!='variable') { ?>
                <tr>
                    <th><?php _e('Regular Price', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="regular_price" value="<?php echo ThemedbWoo::formatPrice(ThemedbWoo::$data['product']['regular_price']); ?>" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Sale Price', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="sale_price" value="<?php echo ThemedbWoo::formatPrice(ThemedbWoo::$data['product']['sale_price']); ?>" />
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(in_array(ThemedbCore::getOption('product_type', 'all'), array('all', 'physical'))) { ?>
                <?php if(themedb_taxonomy('product_shipping_class') && ThemedbWoo::isShipping()) { ?>
                <tr class="trigger-type-physical">
                    <th><?php _e('Shipping Class', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'shipping_class',
                                'type' => 'select_category',
                                'taxonomy' => 'product_shipping_class',
                                'value' => ThemedbWoo::$data['product']['shipping_class'],
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(ThemedbWoo::$data['product']['form']!='variable') { ?>
                <tr class="trigger-type-physical">
                    <th><?php _e('Stock', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="stock" value="<?php echo esc_attr(ThemedbWoo::$data['product']['stock']); ?>" />
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php } ?>
                <?php if(in_array(ThemedbCore::getOption('product_type', 'all'), array('all', 'virtual'))) { ?>
                <tr class="trigger-type-virtual">
                    <th><?php _e('File', 'dealexport'); ?></th>
                    <td>
                        <div class="element-gallery">
                            <span class="left"><?php echo ThemedbWoo::$data['product']['file']; ?></span>
                            <label for="product_file" class="element-button secondary small square" title="<?php _e('Upload File', 'dealexport'); ?>">
                                <span class="fa fa-upload"></span>
                            </label>
                            <input type="file" id="product_file" name="file" class="element-file shifted" />
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php 
                if(!ThemedbCore::checkOption('product_attributes')) {
                    $attributes=ThemedbWoo::getAttributes();
                    foreach($attributes as $attribute) {
                    $value=themedb_value($attribute['name'], ThemedbWoo::$data['product']['attributes']);
                    ?>
                    <tr>
                        <th><?php echo $attribute['label']; ?></th>
                        <td>
                            <?php if($attribute['type']=='select') { ?>
                            <div class="element-select">
                                <span></span>
                                <?php 
                                echo ThemedbInterface::renderOption(array(
                                    'id' => $attribute['name'],
                                    'type' => 'select_category',
                                    'taxonomy' => $attribute['name'],
                                    'value' => $value,
                                    'wrap' => false,				
                                ));
                                ?>
                            </div>
                            <?php } else { ?>
                            <div class="field-wrap">
                                <input type="text" name="<?php echo esc_attr($attribute['name']); ?>" value="<?php echo esc_attr($value); ?>" />
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php 
                    }
                }
                ?>
                <?php
                if(!ThemedbCore::checkOption('product_variations') && in_array(ThemedbCore::getOption('product_type', 'all'), array('all', 'physical'))) {
                    $options=ThemedbWoo::getOptions(ThemedbWoo::$data['product']['ID']);
                    ?>
                    <tr class="trigger-type-physical">
                        <th><?php _e('Attributes', 'dealexport'); ?></th>
                        <td>
                            <div class="element-options" id="attribute">
                                <?php 
                                $index=0;
                                foreach($options as $option) {
                                $index++;
                                ?>
                                <div class="option">
                                    <a href="#<?php echo $index; ?>" title="<?php _e('Edit Attribute', 'dealexport'); ?>"><?php echo $option['name']; ?></a>
                                    <a href="#<?php echo $index; ?>" class="element-remove" title="<?php _e('Remove Attribute', 'dealexport'); ?>">
                                        <span class="fa fa-times"></span>
                                    </a>
                                </div>
                                <?php } ?>
                                <a href="#add" class="element-button element-clone secondary small square" title="<?php _e('Add Attribute', 'dealexport'); ?>">
                                    <span class="fa fa-plus"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="option-attribute-add hidden">
                        <td colspan="2">
                            <div class="option-wrap clearfix">
                                <div class="fivecol column">
                                    <div class="field-wrap">
                                        <input type="text" name="option_names[]" value="" placeholder="<?php _e('Name', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="sevencol column last">
                                    <div class="field-wrap">
                                        <input type="text" name="option_values[]" value="" placeholder="<?php _e('Options (comma separated)', 'dealexport'); ?>" />
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    $index=0;
                    foreach($options as $option) {
                    $index++;
                    ?>
                    <tr class="option-attribute-<?php echo $index; ?> hidden">
                        <td colspan="2">
                            <div class="option-wrap clearfix">
                                <div class="fivecol column">
                                    <div class="field-wrap">
                                        <input type="text" name="option_names[]" value="<?php echo $option['name']; ?>" placeholder="<?php _e('Name', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="sevencol column last">
                                    <div class="field-wrap">
                                        <input type="text" name="option_values[]" value="<?php echo $option['value']; ?>" placeholder="<?php _e('Options (comma separated)', 'dealexport'); ?>" />
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php 
                    }
                    $variations=ThemedbWoo::getVariations(ThemedbWoo::$data['product']['ID']);
                    ?>
                    <tr class="trigger-type-physical">
                        <th><?php _e('Variations', 'dealexport'); ?></th>
                        <td>
                            <div class="element-options" id="variation">
                                <?php foreach($variations as $index => $variation) { ?>
                                <div class="option">
                                    <a href="#<?php echo $variation->ID; ?>" title="<?php _e('Edit Variation', 'dealexport'); ?>"><?php echo sprintf(__('Variation #%s', 'dealexport'), $index+1); ?></a>
                                    <a href="#<?php echo $variation->ID; ?>" class="element-remove" title="<?php _e('Remove Variation', 'dealexport'); ?>">
                                        <span class="fa fa-times"></span>
                                    </a>
                                </div>
                                <?php } ?>
                                <a href="#add" class="element-button element-clone secondary small square" title="<?php _e('Add Variation', 'dealexport'); ?>">
                                    <span class="fa fa-plus"></span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="option-variation-add hidden">
                        <td colspan="2">
                            <div class="option-wrap clearfix">
                                <?php foreach($options as $name => $option) { ?>
                                <div class="element-select">
                                    <span></span>
                                    <select name="variation_<?php echo $name; ?>s[]">
                                        <option value=""><?php echo $option['name']; ?></option>
                                        <?php
                                        $items=explode(',', $option['value']);
                                        foreach($items as $item) {
                                        $item=trim($item);
                                        ?>
                                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="fourcol column">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_stocks[]" value="" placeholder="<?php _e('Stock', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="fourcol column">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_regular_prices[]" value="" placeholder="<?php _e('Regular Price', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="fourcol column last">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_sale_prices[]" value="" placeholder="<?php _e('Sale Price', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <input type="hidden" name="variation_ids[]" value="" />
                            </div>
                        </td>
                    </tr>
                    <?php foreach($variations as $variation) { ?>
                    <tr class="option-variation-<?php echo $variation->ID; ?> hidden">
                        <td colspan="2">
                            <div class="option-wrap clearfix">
                                <?php foreach($options as $name => $option) { ?>
                                <div class="element-select">
                                    <span></span>
                                    <select name="variation_<?php echo $name; ?>s[]">
                                        <option value=""><?php echo $option['name']; ?></option>
                                        <?php
                                        $value=get_post_meta($variation->ID, 'attribute_'.$name, true);
                                        $items=explode(',', $option['value']);
                                        foreach($items as $item) {
                                        $item=trim($item);
                                        ?>
                                        <option value="<?php echo $item; ?>" <?php if($item==$value) { ?>selected="selected"<?php } ?>><?php echo $item; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php } ?>
                                <div class="fourcol column">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_stocks[]" value="<?php echo intval($variation->_stock); ?>" placeholder="<?php _e('Stock', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="fourcol column">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_regular_prices[]" value="<?php echo ThemedbWoo::formatPrice($variation->_regular_price); ?>" placeholder="<?php _e('Regular Price', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <div class="fourcol column last">
                                    <div class="field-wrap">
                                        <input type="text" name="variation_sale_prices[]" value="<?php echo ThemedbWoo::formatPrice($variation->_sale_price); ?>" placeholder="<?php _e('Sale Price', 'dealexport'); ?>" />
                                    </div>
                                </div>
                                <input type="hidden" name="variation_ids[]" value="<?php echo $variation->ID; ?>" />
                            </div>
                        </td>
                    </tr>
                    <?php 
                    }
                }
                ?>
            </tbody>
        </table>
        <div class="profile-description">
            <?php ThemedbInterface::renderEditor('content', ThemedbWoo::$data['product']['content']); ?>
        </div>
        <?php if(ThemedbWoo::$data['product']['status']=='draft') { ?>
            <?php if(ThemedbCore::checkOption('product_approve')) { ?>
            <a href="#" class="element-button element-submit primary"><?php _e('Save Changes', 'dealexport'); ?></a>
            <?php } else { ?>
            <a href="#" class="element-button element-submit primary"><?php _e('Submit for Review', 'dealexport'); ?></a>
            <?php } ?>
        <?php } else { ?>
        <a href="#" class="element-button element-submit primary"><?php _e('Save Changes', 'dealexport'); ?></a>		
        <a href="<?php echo get_permalink(ThemedbWoo::$data['product']['ID']); ?>" target="_blank" title="<?php _e('View', 'dealexport'); ?>" class="element-button secondary square">
            <span class="fa fa-eye"></span>
        </a>
        <a href="#product_form" title="<?php _e('Remove', 'dealexport'); ?>" class="element-button element-colorbox secondary square">
            <span class="fa fa-times"></span>
        </a>
        <?php } ?>
        <input type="hidden" name="product_id" value="<?php echo ThemedbWoo::$data['product']['ID']; ?>" />
        <input type="hidden" name="woo_action" value="update_product" />
    </form>
    <div class="site-popups hidden">
        <div id="product_form">
            <div class="site-popup small">
                <form class="site-form" method="POST" action="">
                    <p><?php _e('Are you sure you want to permanently remove this item?', 'dealexport'); ?></p>
                    <a href="#" class="element-button element-submit primary"><?php _e('Remove Item', 'dealexport'); ?></a>
                    <input type="hidden" name="product_id" value="<?php echo ThemedbWoo::$data['product']['ID']; ?>" />
                    <input type="hidden" name="woo_action" value="remove_product" />
                </form>
            </div>
        </div>
    </div>
    <!-- /popups -->
    <?php } ?>
</div>
<?php get_sidebar('profile-right'); ?>
<?php get_footer(); ?>