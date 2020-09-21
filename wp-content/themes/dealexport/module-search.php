<div class="shop-search clearfix">
    <form action="<?php echo SITE_URL; ?>" method="GET" class="site-form">
        <table>
            <tbody>
                <tr>
                    <th><?php _e('Keywords', 'dealexport'); ?></th>
                    <td>
                        <div class="field-wrap">
                            <input type="text" name="s" value="<?php the_search_query(); ?>" />
                        </div>
                    </td>
                </tr>
                <?php if(themedb_taxonomy('shop_category')) { ?>
                <tr>
                    <th><?php _e('Category', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'category',
                                'type' => 'select_category',
                                'taxonomy' => 'shop_category',
                                'value' => esc_attr(themedb_array('category', $_GET)),
                                'wrap' => false,				
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
                <?php if(!ThemedbCore::checkOption('profile_location')) { ?>
                <tr>
                    <th><?php _e('Country', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'country',
                                'type' => 'select_country',
                                'attributes' => array('class' => 'countries-list'),
                                'value' => esc_attr(themedb_array('country', $_GET)),
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('City', 'dealexport'); ?></th>
                    <td>
                        <div class="element-select">
                            <span></span>
                            <?php 
                            echo ThemedbInterface::renderOption(array(
                                'id' => 'city',
                                'type' => 'select_city',
                                'attributes' => array(
                                    'class' => 'element-filter',
                                    'data-filter' => 'countries-list',
                                ),
                                'value' => esc_attr(themedb_array('city', $_GET)),
                                'wrap' => false,
                            ));
                            ?>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="#" class="element-button element-submit primary"><?php _e('Search', 'dealexport'); ?></a>
        <input type="hidden" name="post_type" value="shop" />
    </form>
</div>