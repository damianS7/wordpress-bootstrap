<?php
// Creating the widget
class Widget_TOP10 extends WP_Widget {
    public function __construct() {
        parent::__construct(
 
        // Base ID of your widget
        'Widget_TOP10',
        
        // Widget name will appear in UI
        __('Widget_TOP10', 'wpb_widget_domain'),
        
        // Widget description
        array( 'description' => __('Top 10 videos on views', 'wpb_widget_domain'), )
        );
    }
 
    // Creating widget front-end
 
    public function widget($args, $instance) {
        // This is where you run the code and display the output
        include_once('widget_top10.template.php');
    }
} // Class wpb_widget ends here