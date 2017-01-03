<?php
/**
* Plugin Name: Basic Plugin
* Plugin URI: https://github.com/ar-to/WordPress-Theme
* Description: A custom plugin to accompany the basic theme.
* Version: 1.0
* Author: Ar-to
* Author URI: http://philosophyanddesign.com
**/

/*
include funciton files
*/
//include below not working
//include( plugin_dir_url(__FILE__) . 'includes/example_widget_two.php' );
/*add logo code to wordpress login - this to modify the FORCE LOGIN plugin */
function my_login_logo() {
    echo '<style type="text/css">
           .login h1 a { background-image: url('.get_stylesheet_directory_uri().'/images/logo.gif) !important;
        }
    </style>';
}
add_action('login_head','my_login_logo');
/* end logo code */
/**
 * Adds My_Widget_Example widget
 */
class My_Widget_Example extends WP_Widget {
  /**
  * To create the example widget all four methods will be
  * nested inside this single instance of the WP_Widget class.
  **/
  /**
   * Register widget with WordPress.
   */
    function __construct() {

        parent::__construct(
            'my-widget-id',  // Base ID
            'My Widget Name',   // Name
            array( 'description' => __( 'A Widget Description'), )//Args
        );
        add_action('admin_enqueue_scripts', array($this, 'mfc_assets'));
    }
    public function mfc_assets()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('mfc-media-upload', plugin_dir_url(__FILE__) . 'mfc-media-upload.js', array( 'jquery' )) ;
    wp_enqueue_style('thickbox');
}

        public function form( $instance )
        {

            $title = '';
            if( !empty( $instance['title'] ) ) {
                $title = $instance['title'];
            }

            $description = '';
            if( !empty( $instance['description'] ) ) {
                $description = $instance['description'];
            }

            $link_url = '';
            if( !empty( $instance['link_url'] ) ) {
                $link_url = $instance['link_url'];
            }

            $link_title = '';
            if( !empty( $instance['link_title'] ) ) {
                $link_title = $instance['link_title'];
            }
            $image = '';
            if(isset($instance['image']))
            {
                $image = $instance['image'];
            }

            ?>
            <p>
                <label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'description' ); ?>"><?php _e( 'Description:' ); ?></label>
                <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" ><?php echo esc_attr( $description ); ?></textarea>
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'link_url' ); ?>"><?php _e( 'Link URL:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_url' ); ?>" name="<?php echo $this->get_field_name( 'link_url' ); ?>" type="text" value="<?php echo esc_attr( $link_url ); ?>" />
            </p>

            <p>
                <label for="<?php echo $this->get_field_name( 'link_title' ); ?>"><?php _e( 'Link Title:' ); ?></label>
                <input class="widefat" id="<?php echo $this->get_field_id( 'link_title' ); ?>" name="<?php echo $this->get_field_name( 'link_title' ); ?>" type="text" value="<?php echo esc_attr( $link_title ); ?>" />
            </p>
            <p>
                <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image:' ); ?></label>
                <input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" />
                <input class="upload_image_button" type="button" value="Upload Image" />
            </p>

        <?php
        }

      public function update( $new_instance, $old_instance ) {
          return $new_instance;
      }
      public function widget( $args, $instance ) {
        // outputs the content of the widget

          echo $args['before_widget'];
          if ( ! empty( $instance['title'] ) ) {
          	echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
          }
          // Rest of the widget content
          ?>
          <p>
          <img src='<?php echo $instance['image'] ?>'>
          </p>
          <div class='mfc-description'>
          	<?php echo wpautop( esc_html( $instance['description'] ) ) ?>
          </div>

          <div class='mfc-link'>
          	<a href='<?php echo esc_url( $instance['link_url'] ) ?>'><?php echo esc_html( $instance['link_title'] ) ?></a>
          </div>
          <?php
          echo $args['after_widget'];

      }
  }
  add_action( 'widgets_init', function() {
      register_widget( 'My_Widget_Example' );
  });


  //another sample widget
  class jpen_Example_Widget extends WP_Widget {
    /**
    * To create the example widget all four methods will be
    * nested inside this single instance of the WP_Widget class.
    **/
    public function __construct() {
      $widget_options = array(
        'classname' => 'example_widget',
        'description' => 'This is an Example Widget',
      );
      parent::__construct( 'example_widget', 'Example Widget', $widget_options );
    }
    public function form( $instance ) {
      $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
      <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
        <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" />
      </p><?php
    }
  }
  add_action( 'widgets_init', function() {
      register_widget( 'jpen_Example_Widget' );
  });
?>
