<?php
class ThemedbSearch extends WP_Widget {

    //Widget Setup
    function __construct() {
        $widget_ops=array('classname' => 'widget_themedb_search', 'description' => __('Shows shop search form.', 'dealexport'));
        parent::__construct('widget_themedb_search', __('Shop Search', 'dealexport'), $widget_ops);
        $this->alt_option_name='widget_themedb_search';
    }

    //Widget view
    function widget( $args, $instance ) {
        extract($args, EXTR_SKIP);
        $instance=wp_parse_args( (array)$instance, array(
            'title'=>__('Shop Search', 'dealexport'),
        ));
        
        $out=$before_widget;
        
        $title=apply_filters( 'widget_title', empty($instance['title'])?__('Shop Search', 'dealexport'):$instance['title'], $instance, $this->id_base);
        $out.=$before_title.$title.$after_title;
        
        ob_start();
        get_template_part('module', 'search');
        $out.=ob_get_contents();
        ob_end_clean();				
        
        $out.=$after_widget;
        
        echo $out;
    }

    //Update widget
    function update( $new_instance, $old_instance ) {
        $instance=$old_instance;
        $instance['title']=sanitize_text_field($new_instance['title']);
        
        return $instance;
    }
    
    //Widget form
    function form( $instance ) {
        $instance=wp_parse_args( (array)$instance, array(
            'title'=>__('Shop Search', 'dealexport'),
        ));
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'dealexport'); ?>:</label>
            <input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
        </p>
    <?php
    }
}