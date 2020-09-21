<?php 
if(get_query_var('shop_category') || themedb_search('shop')) {
    get_template_part('template', 'shops');
} else {
    get_template_part('template', 'posts');
}
?>