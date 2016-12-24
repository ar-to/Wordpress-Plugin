<?php
/**
* Plugin Name: Basic Plugin
* Plugin URI: https://github.com/ar-to/WordPress-Theme
* Description: A custom plugin to accompany the basic theme.
* Version: 1.0
* Author: Ar-to
* Author URI: http://philosophyanddesign.com
**/

/*add logo code to wordpress login - this to modify the FORCE LOGIN plugin */
function my_login_logo() {
    echo '<style type="text/css">
           .login h1 a { background-image: url('.get_stylesheet_directory_uri().'/images/logo.gif) !important;
        }
    </style>';
}
add_action('login_head','my_login_logo');
/* end logo code */
?>
