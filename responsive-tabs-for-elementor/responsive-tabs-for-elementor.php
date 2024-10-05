<?php
/**
 * Responsive Tabs For Elementor WordPress Plugin
 *
 * @package ResponsiveTabsForElementor
 *
 * Plugin Name: Responsive Tabs For Elementor
 * Description: Responsive Tab Plugin for Elementor allows you to show multiple levels of tabs in accordion with text, images, ets.
 * Plugin URI:
 * Version:     9.3.0
 * Author:      UAPP GROUP
 * Author URI:  https://uapp.group/
 * Requires PHP: 7.4.1
 * Requires at least: 5.9
 * Text Domain: responsive-tabs-for-elementor
 */
define('RESPONSIVE_TABS_FOR_ELEMENTOR', __FILE__);

/**
 * Plugin Version
 *
 * @since 9.3.0
 * @var string The plugin version.
 */
define('RESPONSIVE_TABS_VERSION', '9.3.0');

/**
 * Include the Responsive_Tabs_For_Elementor class.
 */
require plugin_dir_path(RESPONSIVE_TABS_FOR_ELEMENTOR) . 'class-responsive-tabs-for-elementor.php';
