<?php

/**
 * @package My First Plugin
 * @version 1.0.0
 */
/*
Plugin Name: First Plugin
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is the first test plugin
Author: Ari
Version: 1.0.0
Author URI: http://philosophyanddesign.com
 */

/**
 * Adding basic action via function call
 * @see https://www.wpbeaverbuilder.com/creating-wordpress-plugin-easier-think/
 */
add_action('the_content', 'my_thank_you_text');

function my_thank_you_text($content)
{
    return $content .= '<p>Thank you for reading!</p>';
}

/**
 * Adding basic action via Class
 * Calling class via a static method
 */
class FirstPlugin
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
        add_action('the_content', array($this, 'more_text'));
    }

    public function more_text($content)
    {
        // do stuff here...
        return $content .= '<p>Thank you for reading more!!</p>';
    }
}

FirstPlugin::get_instance();
