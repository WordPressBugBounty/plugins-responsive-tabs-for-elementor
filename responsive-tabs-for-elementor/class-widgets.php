<?php
/**
 * Widgets class.
 *
 * @category   Class
 * @package    ResponsiveTabsForElementor
 * @subpackage WordPress
 * @author
 * @copyright
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      11.0.1
 * php version 7.4.1
 */

namespace ResponsiveTabsForElementor;

// Security Note: Blocks direct access to the plugin PHP files.
use Elementor\Plugin;

defined('ABSPATH') || die();

/**
 * Class Plugin
 *
 * Main Plugin class
 *
 * @since 11.0.1
 */
class Widgets
{
  /**
   * @var bool
   */
  private static $widgets_registered = false;

  /**
   * Instance
   *
   * @since  11.0.1
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $instance = null;

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @return Plugin An instance of the class.
   * @since  11.0.1
   * @access public
   *
   */
  public static function instance()
  {
    if (is_null(self::$instance)) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  /**
   * Include Widgets files
   *
   * Load widgets files
   *
   * @since  11.0.1
   * @access private
   */
  private function include_widgets_files()
  {
    require_once 'widgets/class-responsive-tabs-with-icons.php';
    require_once 'widgets/class-responsive-tabs-with-small-images.php';
    require_once 'widgets/class-responsive-tabs-with-big-image.php';
    require_once 'widgets/class-responsive-accordion.php';
    require_once 'widgets/class-responsive-simple-tabs-with-icons.php';
    require_once 'widgets/class-responsive-vertical-accordion.php';
    require_once 'widgets/class-responsive-testimonials-tabs.php';
    require_once 'widgets/class-responsive-accordion-with-counter.php';
    require_once 'widgets/class-responsive-faq-accordion.php';
    require_once 'widgets/class-responsive-parallax-tabs.php';
    require_once 'widgets/hover-image-reveal-tabs/class-hover-image-reveal-tabs.php';
    require_once 'widgets/class-responsive-portfolio-tabs.php';
  }

  /**
   * Include Widgets Templates files
   *
   * Load widgets templates files
   *
   * @since  11.0.1
   * @access private
   */
  private function include_widgets_templates_files()
  {
    require_once('widgets-templates/accordion-with-counter/default.php');
    require_once('widgets-templates/accordion-with-counter/accordion-with-counter-and-image.php');
  }

  /**
   * Include Widgets Templates controls
   *
   * Load widgets templates controls
   *
   * @since  11.0.1
   * @access private
   */
  private function include_widgets_templates_controls()
  {
    require_once('widgets-templates/accordion-with-counter/control-elements/controls-accordion-with-counter.php');
    require_once('widgets-templates/accordion-with-counter/control-elements/controls-template-accordion-with-counter-and-image.php');
    require_once('widgets/hover-image-reveal-tabs/controls/hover-image-reveal-tabs-controls.php');
  }

  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since  11.0.1
   * @access public
   */
  public function register_widgets($widgets_manager = null)
  {
    if (self::$widgets_registered) {
      return;
    }

    self::$widgets_registered = true;

    // It's now safe to include Widgets files.
    $this->include_widgets_files();

    // It's now safe to include Widgets Templates.
    $this->include_widgets_templates_files();

    // It's now safe to include Widgets Controls.
    $this->include_widgets_templates_controls();

    if (null === $widgets_manager) {
      $widgets_manager = Plugin::instance()->widgets_manager;
    }

    $this->register_widget($widgets_manager, new Widgets\Responsive_Tabs_With_Icons());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Tabs_With_Small_Images());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Tabs_With_Big_Image());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Accordion());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Simple_Tabs_With_Icons());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Vertical_Accordion());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Testimonials_Tabs());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Accordion_With_Counter());
    $this->register_widget($widgets_manager, new Widgets\Responsive_FAQ_Accordion());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Parallax_Tabs());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Hover_Image_Reveal_Tabs());
    $this->register_widget($widgets_manager, new Widgets\Responsive_Portfolio_Tabs());
  }

  /**
   * Register a single widget with Elementor 3.5+ or legacy API.
   *
   * @param \Elementor\Widgets_Manager $widgets_manager Widgets manager instance.
   * @param \Elementor\Widget_Base     $widget          Widget instance.
   */
  private function register_widget($widgets_manager, $widget)
  {
    if (method_exists($widgets_manager, 'register')) {
      $widgets_manager->register($widget);
      return;
    }

    $widgets_manager->register_widget_type($widget);
  }


  /**
   *  Plugin class constructor
   *
   * Register plugin action hooks and filters
   *
   * @since  11.0.1
   * @access public
   */
  public function __construct()
  {
    // Elementor 3.5+ (plugin minimum is 3.10.0).
    add_action('elementor/widgets/register', [$this, 'register_widgets']);
  }
}

// Instantiate the Widgets class.
Widgets::instance();
