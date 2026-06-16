<?php
/**
 * Central asset registration for Responsive Tabs Elementor widgets.
 *
 * @package ResponsiveTabsForElementor
 */

namespace ResponsiveTabsForElementor;

defined('ABSPATH') || exit;

/**
 * Registers shared scripts/styles once and picks the correct frontend handler per Elementor version.
 */
class Responsive_Tabs_Assets
{

  const LEGACY_ELEMENTOR_VERSION = '3.5.0';

  /**
   * @var bool
   */
  private static $tabs_script_registered = false;

  /**
   * @var bool
   */
  private static $portfolio_script_registered = false;

  /**
   * Elementor 3.5+ exposes element settings to frontend handlers via elementorModules.
   *
   * @return bool
   */
  public static function uses_modern_handler()
  {
    return defined('ELEMENTOR_VERSION')
      && version_compare(ELEMENTOR_VERSION, self::LEGACY_ELEMENTOR_VERSION, '>=');
  }

  /**
   * @return bool
   */
  public static function is_legacy_elementor()
  {
    return !self::uses_modern_handler();
  }

  /**
   * Swiper bundle for Parallax Tabs (and any widget that needs it).
   */
  public static function register_swiper()
  {
    $plugin_file = RESPONSIVE_TABS_FOR_ELEMENTOR;
    $version     = defined('RESPONSIVE_TABS_VERSION') ? RESPONSIVE_TABS_VERSION : '11.0.1';

    if (!wp_style_is('swiper', 'registered')) {
      wp_register_style(
        'swiper',
        plugins_url('/assets/libs/swiper-bundle.min.css', $plugin_file),
        array(),
        $version
      );
    }

    if (!wp_script_is('swiper', 'registered')) {
      wp_register_script(
        'swiper',
        plugins_url('/assets/libs/swiper-bundle.min.js', $plugin_file),
        array(),
        $version,
        true
      );
    }
  }

  /**
   * Register the shared responsive-tabs frontend handler (idempotent).
   *
   * @param string $direction_suffix Empty string or '-rtl'.
   */
  public static function register_tabs_handler($direction_suffix = '')
  {
    if (self::$tabs_script_registered) {
      return;
    }

    self::$tabs_script_registered = true;

    $plugin_file = RESPONSIVE_TABS_FOR_ELEMENTOR;
    $version     = defined('RESPONSIVE_TABS_VERSION') ? RESPONSIVE_TABS_VERSION : '11.0.1';
    $deps        = array('jquery');

    if (self::uses_modern_handler()) {
      self::register_swiper();
      $deps[]      = 'swiper';
      $deps[]      = 'elementor-frontend-modules';
      $deps[]      = 'elementor-frontend';
      $handler_url = plugins_url(
        '/assets/js/responsive-tabs-widget-handler' . $direction_suffix . '.min.js',
        $plugin_file
      );
    } else {
      $deps[]      = 'elementor-frontend';
      $handler_url = plugins_url(
        '/assets/js/responsive-tabs-widget-old-elementor-handler' . $direction_suffix . '.min.js',
        $plugin_file
      );
    }

    wp_register_script(
      'responsive-tabs',
      $handler_url,
      $deps,
      $version,
      true
    );
  }

  /**
   * Register portfolio tabs frontend handler (idempotent).
   */
  public static function register_portfolio_handler()
  {
    if (self::$portfolio_script_registered) {
      return;
    }

    self::$portfolio_script_registered = true;

    $plugin_file = RESPONSIVE_TABS_FOR_ELEMENTOR;
    $version     = defined('RESPONSIVE_TABS_VERSION') ? RESPONSIVE_TABS_VERSION : '11.0.1';
    $deps        = array('jquery');

    if (self::uses_modern_handler()) {
      $deps[]      = 'elementor-frontend-modules';
      $deps[]      = 'elementor-frontend';
      $handler_url = plugins_url(
        '/assets/js/responsive-portfolio-tabs-widget-handler.min.js',
        $plugin_file
      );
    } else {
      $deps[]      = 'elementor-frontend';
      $handler_url = plugins_url(
        '/assets/js/responsive-portfolio-tabs-widget-old-elementor-handler.min.js',
        $plugin_file
      );
    }

    wp_register_script(
      'responsive-portfolio-tabs',
      $handler_url,
      $deps,
      $version,
      true
    );
  }
}
