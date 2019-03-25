<?php

/**
 * @package My Second Plugin
 * @version 1.0.0
 */
/*
Plugin Name: Second Plugin
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Sample plugin to modify admin area, send ajax request with/without user permissions and modify the options table
Author: Ari
Version: 1.0.0
Author URI: http://philosophyanddesign.com
 */

/**
 * Adding basic action via Class
 *
 * Add content to admin
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference/admin_footer
 */
class SecondPlugin
{
    protected static $instance = null;

    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('admin_footer', array($this, 'my_admin_footer_function'));
        add_action('admin_footer', array($this, 'my_admin_add_js'));
        // requires permissions
        add_action('admin_footer', array($this, 'my_action_javascript'));
        add_action('wp_ajax_my_action_private', array($this, 'my_action_private'));
        add_action('wp_ajax_nopriv_my_action_private', array($this, 'my_action_private'));
        // does not require permissions
        add_action('wp_ajax_my_action', array($this, 'my_action'));
        add_action('wp_ajax_nopriv_my_action', array($this, 'my_action'));
        // get option
        add_action('wp_ajax_get_option', array($this, 'get_option'));
        add_action('wp_ajax_nopriv_get_option', array($this, 'get_option'));
        add_action('wp_ajax_set_option', array($this, 'set_option'));
    }

    public function my_admin_footer_function()
    {
        echo '<p>This will be inserted at the bottom of admin page!--coutesy of Second Plugin</p>';
    }

    public function my_admin_add_js()
    {
        echo '
        <script>alert("This will trigger an alert on the admin page.--coutesy of Second Plugin")</script>';
    }

    public function my_action_javascript()
    {?>
        <p>Last Descriptions: <?php echo $this->lastDescription; ?></p>
        <button style="margin-left: 160px; margin-bottom: 50px;" onclick="getOption()">Get Option</button>
        <button style="margin-left: 160px; margin-bottom: 50px;" onclick="setOption()">Set Option</button>
      <script type="text/javascript" >
      jQuery(document).ready(function($) {

        var data = {
          'action': 'my_action_private',
          'whatever': 1234
        };

        console.log('ajaxurl: ', ajaxurl);

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
          alert('Got this from the server after ajax: ' + response);
        });
      });
      function getOption() {

        var data = {
            'action': 'get_option',
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
        alert('Got this from the server after ajax: ' + JSON.stringify(response));
        });
    }
      function setOption() {

        var data = {
            'action': 'set_option',
            'text': `Just another WordPress site!!!!`
        };


        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
        alert('Got this from the server after ajax: ' + JSON.stringify(response));
        });
    }
      </script> <?php
}

    public function my_action_private()
    {
        if (current_user_can('manage_options')) {
            global $wpdb; // this is how you get access to the database

            $whatever = intval($_POST['whatever']);

            $whatever += 10;

            echo $whatever;

            wp_die(); // this is required to terminate immediately and return a proper response
        }
    }

    public function my_action()
    {
        global $wpdb; // this is how you get access to the database

        $whatever = $_REQUEST['action'];
        echo $whatever;
        wp_die('>>success!'); // this is required to terminate immediately and return a proper response
    }

    /**
     * Send JSON response
     * @see https://codex.wordpress.org/Function_Reference/wp_send_json
     * @see [get_option](https://developer.wordpress.org/reference/functions/get_option/)
     * @see [update_option](https://developer.wordpress.org/reference/functions/update_option/)
     */
    public function get_option()
    {
        $opts = get_option('blogdescription', false);

        $return = array(
            'current' => $opts,
        );

        wp_send_json($return);

        wp_die('>>success!'); // this is required to terminate immediately and return a proper response
    }

    public function set_option()
    {
        $text = $_REQUEST['text'];
        $update = update_option('blogdescription', $text);

        $return = array(
            'new' => $text,
            'updated' => $update,
        );

        wp_send_json($return);

        wp_die('>>success!'); // this is required to terminate immediately and return a proper response
    }
}

SecondPlugin::get_instance();
