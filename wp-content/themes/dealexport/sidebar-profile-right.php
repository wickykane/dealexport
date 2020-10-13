<aside class="column fourcol last">	
    <?php
    ThemedbShop::refresh(ThemedbUser::$data['active']['shop'], true);
    if(!ThemedbCore::checkOption('shop_multiple') && ThemedbShop::$data['status']=='publish') {
        get_template_part('module', 'shop');
    }
    
    if(!empty(ThemedbShop::$data['reviews'])) {
        get_template_part('module', 'reviews');
    }
    
    if(!ThemedbCore::checkOption('product_favorites')) {
        get_template_part('module', 'favorites');
    }
    
    if(ThemedbUser::isProfile() && !ThemedbCore::checkOption('shop_favorites')) {
        get_template_part('module', 'updates');
    } 
    
    if(!ThemedbCore::checkOption('shop_multiple') && ThemedbShop::$data['status']!='publish') {
        get_template_part('module', 'shop');
    }
    
    ThemedbSidebar::renderSidebar('profile');
    ?>
</aside>