<?php
/**
 * Responsive_Accordion_With_Counter class.
 *
 * @category   Class
 * @package    ResponsiveTabsForElementor
 * @subpackage WordPress
 * @author     UAPP GROUP
 * @copyright  2024 UAPP GROUP
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      9.3.0
 * php version 7.4.1
 */

namespace ResponsiveTabsForElementor\Widgets;

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * AccordionWithCounter widget class.
 *
 * @since 9.3.0
 */
class Responsive_Accordion_With_Counter extends Widget_Base
{
  /**
   * AccordionWithCounter constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('responsive-accordion-with-counter', plugins_url('/assets/css/responsive-accordion-with-counter.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);

    if (!function_exists('get_plugin_data')) {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] >= "3.5.0") {
      wp_register_script('responsive-tabs', plugins_url('/assets/js/responsive-tabs-widget-handler.min.js', RESPONSIVE_TABS_FOR_ELEMENTOR), ['elementor-frontend'], RESPONSIVE_TABS_VERSION, true);
    } else {
      wp_register_script('responsive-tabs', plugins_url('/assets/js/responsive-tabs-widget-old-elementor-handler.min.js', RESPONSIVE_TABS_FOR_ELEMENTOR), ['elementor-frontend'], RESPONSIVE_TABS_VERSION, true);
    }
  }

  /**
   * Retrieve the widget name.
   *
   * @return string Widget name.
   * @since  9.3.0
   *
   * @access public
   *
   */
  public function get_name()
  {
    return 'responsive-accordion-with-counter';
  }

  /**
   * Retrieve the widget title.
   *
   * @return string Widget title.
   * @since  9.3.0
   *
   * @access public
   *
   */
  public function get_title()
  {
    return __('Accordion With Counter', 'responsive-tabs-for-elementor');
  }

  /**
   * Retrieve the widget icon.
   *
   * @return string Widget icon.
   * @since  9.3.0
   *
   * @access public
   *
   */
  public function get_icon()
  {
    return 'icon-accordion-with-counter';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * Used to determine where to display the widget in the editor.
   *
   * Note that currently Elementor supports only one category.
   * When multiple categories passed, Elementor uses the first one.
   *
   * @return array Widget categories.
   * @since  9.3.0
   *
   * @access public
   *
   */
  public function get_categories()
  {
    return ['responsive_accordions'];
  }

  /**
   * Enqueue styles.
   */
  public function get_style_depends()
  {
    $styles = ['responsive-accordion-with-counter'];

    return $styles;
  }

  public function get_script_depends()
  {
    $scripts = ['responsive-tabs'];

    return $scripts;
  }

  /**
   * Get default tab.
   *
   * @return array Default tab.
   * @since  9.3.0
   *
   * @access protected
   *
   */
  protected function get_default_tab()
  {
    return [
      'tab_name'    => __('Lorem ipsum', 'responsive-tabs-for-elementor'),
      'tab_content' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'responsive-tabs-for-elementor</p>'),
    ];
  }

  /**
   * Get default tab.
   *
   * @return array Default tab.
   * @since  9.3.0
   *
   * @access protected
   *
   */
  protected function get_default_template_with_image_tab()
  {
    return [
      'accordion_name'         => __('Title', 'responsive-tabs-for-elementor'),
      'accordion_name_content' => __('Title', 'responsive-tabs-for-elementor'),
      'accordion_content'      => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'responsive-tabs-for-elementor</p>'),
    ];
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since  9.3.0
   *
   * @access protected
   */
  protected function _register_controls()
  {
    // Content Section
    $this->start_controls_section(
      'section_content',
      [
        'label' => __('Content', 'responsive-tabs-for-elementor'),
      ]
    );

    // Content Default Accordion
    $repeater      = new Repeater();
    $default_items = $this->get_default_tab();

    get_repeater_accordion_with_counter($this, $repeater, $default_items);

    // Content Templates Accordion With Image
    $accordion                         = new Repeater();
    $default_items_template_with_image = $this->get_default_template_with_image_tab();

    get_repeater_template_accordion_with_counter_image($this, $accordion, $default_items_template_with_image);

    $this->end_controls_section();

    // Accordion Templates Section
    $this->start_controls_section(
      'section_accordion_templates',
      [
        'label' => esc_html__('Accordion Templates', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_responsive_control(
      'accordion_templates',
      [
        'label'              => esc_html__('Accordion Templates', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SELECT,
        'options'            => [
          ''  => esc_html__('Default', 'responsive-tabs-for-elementor'),
          '1' => esc_html__('Accordion With Image', 'responsive-tabs-for-elementor'),
        ],
        'frontend_available' => true,
      ]
    );
    $this->end_controls_section();

    // Additional Options Section
    $this->start_controls_section(
      'section_additional_options',
      [
        'label' => esc_html__('Additional Options', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'accordion_enable_name_content',
      [
        'label'        => __('Show Name Content', 'responsive-tabs-for-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'responsive-tabs-for-elementor'),
        'label_off'    => __('Hide', 'responsive-tabs-for-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'accordion_counter',
      [
        'label'              => esc_html__('Show Counter', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Show', 'responsive-tabs-for-elementor'),
        'label_off'          => __('Hide', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'accordion_divider',
      [
        'label'              => esc_html__('Show Divider', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Show', 'responsive-tabs-for-elementor'),
        'label_off'          => __('Hide', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'accordion_direction',
      [
        'label'              => esc_html__('Direction', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('On', 'responsive-tabs-for-elementor'),
        'label_off'          => __('Off', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );
    $this->end_controls_section();

    // General styles Section
    $this->start_controls_section(
      'general_styles_section',
      [
        'label' => esc_html__('General Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // General Styles Default Accordion
    get_general_style_accordion_with_counter($this);

    // General Styles Templates Accordion With Image
    get_general_style_template_accordion_with_counter_image($this);

    $this->end_controls_section();

    // Tab styles Section
    $this->start_controls_section(
      'tabs_styles_section',
      [
        'label' => esc_html__('Tabs Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Tab Styles Default Accordion
    get_tab_style_accordion_with_counter($this);

    // Tab Styles Templates Accordion With Image
    get_tab_style_template_accordion_with_counter_image($this);

    $this->end_controls_section();

    // Counter And Divider Styles Section
    $this->start_controls_section(
      'counter_divider_styles_section',
      [
        'label' => esc_html__('Counter/Divider Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Counter And Divider Styles Default Accordion
    get_counter_divider_style_accordion_with_counter($this);

    // Counter And Divider Styles Templates Accordion With Image
    get_counter_divider_style_template_accordion_with_counter_image($this);

    $this->end_controls_section();

    // Content Styles Section
    $this->start_controls_section(
      'content_styles_section',
      [
        'label' => esc_html__('Content Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    // Content Styles Default Accordion
    get_content_style_accordion_with_counter($this);

    // Content Styles Templates Accordion With Image
    get_content_style_template_accordion_with_counter_image($this);

    $this->end_controls_section();

    // Images style Section
    get_images_section_template_accordion_with_counter_image($this);
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since  9.3.0
   *
   * @access protected
   */
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") {
      $this->add_render_attribute(
        'responsive_tabs',
        [
          'class'                         => ['accordion-params'],
          'data-direction-responsivetabs' => esc_attr($settings['accordion_direction']),
          'data-templates-responsivetabs' => esc_attr($settings['accordion_templates']),
        ]
      );

      $attributes = $this->get_render_attribute_string('responsive_tabs');
    }

    if ($settings['tab']) {
      get_default_accordion_template($settings, $attributes);
    } elseif ($settings['accordion']) {
      get_accordion_with_counter_image_template($settings, $attributes);
    }
  }
}
