<?php
$file_path=explode('wp-content', __FILE__ );
$wp_path=$file_path[0];
require_once($wp_path.'/wp-load.php');
?>
<html>
<head>
    <style type="text/css">#TB_window {width:530px!important;}</style>
</head>
<body>
    <div class="themedb-shortcode">
        <form method="POST" action="" id="themedb_shortcode">
            <?php echo ThemedbShortcode::renderSettings(); ?>			
        </form>
    </div>
</body>
</html>