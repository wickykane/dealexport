<?php
/*
  Template Name: Shops
 */

get_header();

$layout = ThemedbCore::getOption('shops_layout', 'right');

//TODO = set number of shop per row
$columns = 4;
if ($layout != 'full') {
    $columns = 3;
}

//TODO = set width for each of shop-preview
$width = 'four';
if ($columns == 2) {
    $width = 'three';
}

if ($layout == 'left') {
    ?>
    <aside class="sidebar column threecol">
        <?php //ThemedbSidebar::renderSidebar('shops', true); 
        include_once 'shop-filter.php'; ?>
    </aside>
    <div class="column ninecol last">
<?php } else if ($layout == 'right') { ?>
    <div class="column eightcol">
<?php } else { ?>
    <div class="fullcol">
<?php } ?>
<?php
echo category_description();
if (is_page()) {
    query_posts(array(
        'post_type' => 'shop',
        'paged' => themedb_paged(),
        'posts_per_page' => ThemedbCore::getOption('shops_per_page', 12),
        'orderby' => 'title',
        'order' => 'ASC'
    ));
    if (((isset($_GET['country-filter']) && $_GET['country-filter'] != NULL) || (isset($_GET['region-filter']) && $_GET['region-filter'] != NULL)) && !isset($_GET['shop-cat'])) {
        if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL && (!isset($_GET['region-filter']) || $_GET['region-filter'] == NULL)) {
            $term_filter = $_GET['country-filter'];
        } else {
            $term_filter = $_GET['region-filter'];
        }
        query_posts(array(
            'post_type' => 'shop',
            'paged' => themedb_paged(),
            'posts_per_page' => ThemedbCore::getOption('shops_per_page', 12),
            'tax_query' => array(
                array(
                    'taxonomy' => 'shop_country_region',
                    'field' => 'id',
                    'terms' => $term_filter
                )
            ),
            'orderby' => 'title',
            'order' => 'ASC'
        ));
    } elseif ((!isset($_GET['country-filter']) || $_GET['country-filter'] == NULL) && (isset($_GET['shop-cat']) && $_GET['shop-cat'] != NULL)) {
        $term_filter = $_GET['shop-cat'];
        query_posts(array(
            'post_type' => 'shop',
            'paged' => themedb_paged(),
            'posts_per_page' => ThemedbCore::getOption('shops_per_page', 12),
            'tax_query' => array(
                array(
                    'taxonomy' => 'shop_category',
                    'field' => 'id',
                    'terms' => $term_filter
                )
            ),
            'orderby' => 'title',
            'order' => 'ASC'
        ));
    } elseif (isset($_GET['country-filter']) && isset($_GET['region-filter']) && isset($_GET['shop-cat'])) {
        if (isset($_GET['country-filter']) && $_GET['country-filter'] != NULL && (!isset($_GET['region-filter']) || $_GET['region-filter'] == NULL)) {
            $location_term_filter = $_GET['country-filter'];
        } else {
            $location_term_filter = $_GET['region-filter'];
        }
        $cat_term_filter = $_GET['shop-cat'];
        $tax_query = array();
        $tax_query[] = array(
            'taxonomy' => 'shop_country_region',
            'field' => 'id',
            'terms' => $location_term_filter,
        );
        $tax_query[] = array(
            'taxonomy' => 'shop_category',
            'field' => 'id',
            'terms' => $cat_term_filter,
        );
        if (!empty($tax_query)) {
            $tax_query['relation'] = 'AND'; // you can also use 'OR' here
            query_posts(array(
                'post_type' => 'shop',
                'paged' => themedb_paged(),
                'posts_per_page' => ThemedbCore::getOption('shops_per_page', 12),
                'tax_query' => $tax_query,
                'orderby' => 'title',
                'order' => 'ASC'
            ));
        }
    }
}

if (have_posts()) {
    ?>
    <div class="shops-wrap clearfix">
        <?php
        $counter = 0;
        while (have_posts()) {
            the_post();
            $counter++;
            ?>
            <div class="column <?php echo $width; ?>col <?php echo $counter == $columns ? 'last' : ''; ?>">
                <?php get_template_part('content', 'shop'); ?>
            </div>
            <?php
            if ($counter == $columns) {
                $counter = 0;
                echo '<div class="clear"></div>';
            }
        }
        ?>
    </div>
<?php } else { ?>
    <h3><?php _e('No shops found. Try a different search?', 'dealexport'); ?></h3>
    <p><?php _e('Sorry, no shops matched your search. Try again with some different keywords.', 'dealexport'); ?></p>
<?php } ?>
<?php ThemedbInterface::renderPagination(); ?>
    </div>

    <!--include shop filter-->
    <aside class="sidebar column fourcol">
        <?php ?>
    </aside>
    <!--end include shop filter-->

<?php if ($layout == 'right') { ?>
    <aside class="sidebar column fourcol last">
        <?php ThemedbSidebar::renderSidebar('shops', true); ?>
    </aside>
<?php } ?>
<?php get_footer(); ?>