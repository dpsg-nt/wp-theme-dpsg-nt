<?php
function child_theme_styles() {
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
}
add_action('wp_enqueue_scripts', 'child_theme_styles');

require_once('configuration.php');

require_once('lib/mime-types.php');
require_once('lib/google-analytics.php');

require_once('shortcodes/google-calendar.php');
require_once('shortcodes/stufen-banner.php');
require_once('shortcodes/leader-overview.php');
