<?php
/**
 * Responsive_Parallax_Tabs class.
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
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * ResponsiveParallaxTabs widget class.
 *
 * @since 9.3.0
 */
class Responsive_Parallax_Tabs extends Widget_Base
{
  /**
   * ResponsiveParallaxTabs constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('swiper', plugins_url('/assets/css/swiper-bundle.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);
    wp_register_style('parallax-tabs', plugins_url('/assets/css/responsive-parallax-tabs.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);
    wp_register_script('swiper', plugins_url('/assets/js/swiper-bundle.min.js', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION, true);


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
    return 'responsive-parallax-tabs';
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
    return __('Parallax Tabs', 'responsive-tabs-for-elementor');
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
    return 'icon-parallax-tabs';
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
    return ['responsive_tabs'];
  }

  /**
   * Enqueue styles.
   */
  public function get_style_depends()
  {
    $styles = ['swiper', 'parallax-tabs'];

    return $styles;
  }

  public function get_script_depends()
  {
    $scripts = ['swiper', 'responsive-tabs'];

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
      'parallax_background_image_left'  => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'parallax_background_image_right' => [
        'url' => Utils::get_placeholder_image_src(),
      ],
      'parallax_title'                  => __('Title', 'responsive-tabs-for-elementor'),
      'parallax_subtitle'               => __('Subtitle', 'responsive-tabs-for-elementor'),
      'parallax_content'                => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'responsive-tabs-for-elementor'),
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

    $repeater = new Repeater();

    $repeater->start_controls_tabs('parallax_background_images');

    $repeater->start_controls_tab(
      'parallax_background_left',
      [
        'label' => esc_html__('Left Image', 'responsive-tabs-for-elementor'),
      ]
    );

    $repeater->add_control(
      'parallax_background_image_left',
      [
        'label'   => __('Choose Image', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::MEDIA,
        'default' => [
          'url' => Utils::get_placeholder_image_src(),
        ],
        'ai'      => [
          'active' => false,
        ],
      ]
    );

    $repeater->end_controls_tab();

    $repeater->start_controls_tab(
      'parallax_background_right',
      [
        'label' => esc_html__('Right Image', 'responsive-tabs-for-elementor'),
      ]
    );

    $repeater->add_control(
      'parallax_background_image_right',
      [
        'label'   => __('Choose Image', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::MEDIA,
        'default' => [
          'url' => Utils::get_placeholder_image_src(),
        ],
        'ai'      => [
          'active' => false,
        ],
      ]
    );

    $repeater->end_controls_tab();
    $repeater->end_controls_tabs();

    $repeater->add_control(
      'parallax_title',
      [
        'label'       => esc_html__('Title', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::TEXTAREA,
        'dynamic'     => [
          'active' => true,
        ],
        'placeholder' => esc_html__('Enter your title', 'responsive-tabs-for-elementor'),
        'default'     => esc_html__('Title', 'responsive-tabs-for-elementor'),
        'separator'   => 'before',
      ]
    );

    $repeater->add_control(
      'parallax_link',
      [
        'label'   => esc_html__('Link', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'default' => [
          'url' => '',
        ],
      ]
    );

    $repeater->add_control(
      'parallax_size',
      [
        'label'     => esc_html__('Size', 'elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
          'default' => esc_html__('Default', 'responsive-tabs-for-elementor'),
          'small'   => esc_html__('Small', 'responsive-tabs-for-elementor'),
          'medium'  => esc_html__('Medium', 'responsive-tabs-for-elementor'),
          'large'   => esc_html__('Large', 'responsive-tabs-for-elementor'),
          'xl'      => esc_html__('XL', 'responsive-tabs-for-elementor'),
          'xxl'     => esc_html__('XXL', 'responsive-tabs-for-elementor'),
        ],
        'default'   => 'default',
        'condition' => [
          'parallax_size!' => 'default',
        ],
      ]
    );

    $repeater->add_control(
      'parallax_header_size',
      [
        'label'   => esc_html__('HTML Tag', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::SELECT,
        'options' => [
          'h1'   => 'H1',
          'h2'   => 'H2',
          'h3'   => 'H3',
          'h4'   => 'H4',
          'h5'   => 'H5',
          'h6'   => 'H6',
          'div'  => 'div',
          'span' => 'span',
          'p'    => 'p',
        ],
        'default' => 'h2',
      ]
    );

    $repeater->add_control(
      'parallax_subtitle',
      [
        'label'       => esc_html__('Subtitle', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::TEXTAREA,
        'dynamic'     => [
          'active' => true,
        ],
        'placeholder' => esc_html__('Enter your title', 'responsive-tabs-for-elementor'),
        'default'     => esc_html__('Subtitle', 'responsive-tabs-for-elementor'),
        'separator'   => 'before',
      ]
    );

    $repeater->add_control(
      'parallax_subtitle_link',
      [
        'label'   => esc_html__('Link', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::URL,
        'dynamic' => [
          'active' => true,
        ],
        'default' => [
          'url' => '',
        ],
      ]
    );

    $repeater->add_control(
      'parallax_subtitle_size',
      [
        'label'     => esc_html__('Size', 'elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
          'default' => esc_html__('Default', 'responsive-tabs-for-elementor'),
          'small'   => esc_html__('Small', 'responsive-tabs-for-elementor'),
          'medium'  => esc_html__('Medium', 'responsive-tabs-for-elementor'),
          'large'   => esc_html__('Large', 'responsive-tabs-for-elementor'),
          'xl'      => esc_html__('XL', 'responsive-tabs-for-elementor'),
          'xxl'     => esc_html__('XXL', 'responsive-tabs-for-elementor'),
        ],
        'default'   => 'default',
        'condition' => [
          'parallax_subtitle_size!' => 'default',
        ],
      ]
    );

    $repeater->add_control(
      'parallax_subtitle_header_size',
      [
        'label'   => esc_html__('HTML Tag', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::SELECT,
        'options' => [
          'h1'   => 'H1',
          'h2'   => 'H2',
          'h3'   => 'H3',
          'h4'   => 'H4',
          'h5'   => 'H5',
          'h6'   => 'H6',
          'div'  => 'div',
          'span' => 'span',
          'p'    => 'p',
        ],
        'default' => 'p',
      ]
    );

    $repeater->add_control(
      'parallax_content',
      [
        'label'     => __('Content', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::WYSIWYG,
        'default'   => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'responsive-tabs-for-elementor'),
        'rows'      => 20,
        'dynamic'   => [
          'active' => true,
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'parallax_tab',
      [
        'label'       => __('Parallax Tabs', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ parallax_title }}}',
        'default'     => [$this->get_default_tab(), $this->get_default_tab(), $this->get_default_tab()],
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

    $this->add_responsive_control(
      'direction',
      [
        'label'              => esc_html__('Direction', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'vertical',
        'options'            => [
          'vertical'   => esc_html__('Vertical', 'responsive-tabs-for-elementor'),
          'horizontal' => esc_html__('Horizontal', 'responsive-tabs-for-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'parallax_loop',
      [
        'label'              => esc_html__('Loop', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'parallax_mousewheel',
      [
        'label'              => esc_html__('Mousewheel', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'parallax_grabcursor',
      [
        'label'              => esc_html__('Grab Cursor', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'autoplay',
      [
        'label'              => esc_html__('Autoplay', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'no',
        'options'            => [
          'yes' => esc_html__('Yes', 'responsive-tabs-for-elementor'),
          'no'  => esc_html__('No', 'responsive-tabs-for-elementor'),
        ],
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'autoplay_speed',
      [
        'label'              => esc_html__('Autoplay speed', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::NUMBER,
        'default'            => 5000,
        'frontend_available' => true,
      ]
    );

    $this->add_control(
      'navigation',
      [
        'label'              => esc_html__('Navigation', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SELECT,
        'default'            => 'dots',
        'options'            => [
          'dots' => esc_html__('Dots', 'responsive-tabs-for-elementor'),
          'none' => esc_html__('None', 'responsive-tabs-for-elementor'),
        ],
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

    $this->add_responsive_control(
      'parallax_row_position',
      [
        'label'              => esc_html__('Position', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::CHOOSE,
        'options'            => [
          'row-reverse'    => [
            'title' => esc_html__('Row-Reverse', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'row'            => [
            'title' => esc_html__('Row', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-end',
          ],
          'column-reverse' => [
            'title' => esc_html__('Column-Reverse', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-v-align-top',
          ],
          'column'         => [
            'title' => esc_html__('Column', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-v-align-bottom',
          ],
        ],
        'frontend_available' => true,
        'selectors'          => [
          '{{WRAPPER}} .parallax-tab .swiper-slide' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'parallax_width',
      [
        'label'      => esc_html__('Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => '%',
          'size' => '100'
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__image' => 'width: {{SIZE}}{{UNIT}}',
        ],
        'condition'  => [
          'parallax_row_position' => ['column-reverse', 'column'],
        ],
      ]
    );

    $this->add_responsive_control(
      'parallax_height',
      [
        'label'      => esc_html__('Height', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'default'    => [
          'unit' => 'vh',
        ],
        'size_units' => ['px', '%', 'em', 'rem', 'vh', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab' => 'height: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->end_controls_section();

    // Title styles Section
    $this->start_controls_section(
      'title_styles_section',
      [
        'label' => esc_html__('Title Section Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'enable_title_section',
      [
        'label'              => esc_html__('Show Title', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_responsive_control(
      'title_section_margin',
      [
        'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator'  => 'before',
        'condition'  => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'title_section_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition'  => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'title_section_color',
      [
        'label'     => esc_html__('Title Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__title *' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'      => 'title_section_typography',
        'label'     => esc_html__('Title Typography', 'responsive-tabs-for-elementor'),
        'selector'  => '{{WRAPPER}} .parallax-tab .parallax-tab__title *',
        'condition' => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'title_section_align',
      [
        'label'     => esc_html__('Title Alignment', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'   => [
            'title' => esc_html__('Left', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-center',
          ],
          'right'  => [
            'title' => esc_html__('Right', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'left',
        'selectors' => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__title *' => 'text-align: {{VALUE}}',
        ],
        'condition' => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'title_section__width',
      [
        'label'      => esc_html__('Title Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'custom'],
        'default'    => [
          'unit' => '%',
        ],
        'range'      => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__title' => 'width: {{SIZE}}{{UNIT}}',
        ],
        'condition'  => [
          'enable_title_section' => 'yes',
        ],
      ]
    );

    $this->end_controls_section();

    // Subtitle styles Section
    $this->start_controls_section(
      'subtitle_styles_section',
      [
        'label' => esc_html__('Subtitle Section Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'enable_subtitle_section',
      [
        'label'              => esc_html__('Show Subtitle', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_responsive_control(
      'subtitle_section_margin',
      [
        'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator'  => 'before',
        'condition'  => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'subtitle_section_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition'  => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'subtitle_section_color',
      [
        'label'     => esc_html__('Subtitle Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle *' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'      => 'subtitle_section_typography',
        'label'     => esc_html__('Subtitle Typography', 'responsive-tabs-for-elementor'),
        'selector'  => '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle *',
        'condition' => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'subtitle_section_align',
      [
        'label'     => esc_html__('Subtitle Alignment', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'   => [
            'title' => esc_html__('Left', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'center' => [
            'title' => esc_html__('Center', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-center',
          ],
          'right'  => [
            'title' => esc_html__('Right', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
        ],
        'default'   => 'right',
        'selectors' => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle *' => 'text-align: {{VALUE}}',
        ],
        'condition' => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'subtitle_section__width',
      [
        'label'      => esc_html__('Subtitle Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'custom'],
        'default'    => [
          'unit' => '%',
        ],
        'range'      => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__subtitle' => 'width: {{SIZE}}{{UNIT}}',
        ],
        'condition'  => [
          'enable_subtitle_section' => 'yes',
        ],
      ]
    );

    $this->end_controls_section();

    // Content Styles Section
    $this->start_controls_section(
      'content_styles_section',
      [
        'label' => esc_html__('Content Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_control(
      'enable_content_section',
      [
        'label'              => esc_html__('Show Content', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::SWITCHER,
        'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
        'label_off'          => __('No', 'responsive-tabs-for-elementor'),
        'return_value'       => 'yes',
        'default'            => 'yes',
        'frontend_available' => true,
      ]
    );

    $this->add_responsive_control(
      'content_section_margin',
      [
        'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'separator'  => 'before',
        'condition'  => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'content_section_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition'  => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'content_color',
      [
        'label'     => esc_html__('Content Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab .parallax-tab__description *' => 'color: {{VALUE}}',
        ],
        'condition' => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'      => 'content_typography',
        'label'     => esc_html__('Content Typography', 'responsive-tabs-for-elementor'),
        'selector'  => '{{WRAPPER}} .parallax-tab .parallax-tab__description *',
        'condition' => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'content_section_align',
      [
        'label'     => esc_html__('Content Alignment', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'    => [
            'title' => esc_html__('Left', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-left',
          ],
          'center'  => [
            'title' => esc_html__('Center', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-center',
          ],
          'right'   => [
            'title' => esc_html__('Right', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-right',
          ],
          'justify' => [
            'title' => esc_html__('Justify', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-text-align-justify',
          ],
        ],
        'default'   => 'left',
        'selectors' => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__description *' => 'text-align: {{VALUE}}',
        ],
        'condition' => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->add_responsive_control(
      'content_section__width',
      [
        'label'      => esc_html__('Content Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'custom'],
        'default'    => [
          'unit' => '%',
        ],
        'range'      => [
          '%' => [
            'min' => 0,
            'max' => 100,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab .parallax-tab__description' => 'max-width: {{SIZE}}{{UNIT}}',
        ],
        'condition'  => [
          'enable_content_section' => 'yes',
        ],
      ]
    );

    $this->end_controls_section();

    // Overlay And Filter Styles Section
    $this->start_controls_section(
      'overlay_styles_section',
      [
        'label' => esc_html__('Overlay And Filter Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->start_controls_tabs('filter_background_images');

    $this->start_controls_tab(
      'filter_background_left',
      [
        'label' => esc_html__('Left Filter', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'filter_background_left_color',
      [
        'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab .parallax-tab__image_left .parallax-tab__filter' => 'background: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'filter_background_right',
      [
        'label' => esc_html__('Right Filter', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'filter_background_right_color',
      [
        'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab .parallax-tab__image_right .parallax-tab__filter' => 'background: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->start_controls_tabs('overlay_background_images',
      [
        'separator' => 'before',
      ]
    );

    $this->start_controls_tab(
      'overlay_background_left',
      [
        'label' => esc_html__('Left Overlay', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'overlay_background_left_color',
      [
        'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab .parallax-tab__image_inner.parallax-tab__image_left' => 'background-color: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'overlay_background_right',
      [
        'label' => esc_html__('Right Overlay', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'overlay_background_right_color',
      [
        'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab .parallax-tab__image_inner.parallax-tab__image_right' => 'background-color: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->end_controls_section();

    // Pagination Styles Section
    $this->start_controls_section(
      'pagination_styles_section',
      [
        'label' => esc_html__('Pagination Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'pagination_margin',
      [
        'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab__pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition'  => [
          'direction' => 'horizontal',
        ],
      ]
    );

    $this->add_responsive_control(
      'pagination_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab__pagination' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition'  => [
          'direction' => 'horizontal',
        ],
      ]
    );

    $this->add_responsive_control(
      'pagination_align',
      [
        'label'     => esc_html__('Alignment', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'left'   => [
            'title' => esc_html__('Left', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'center' => [
            'title' => esc_html__('Center', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-shrink',
          ],
          'right'  => [
            'title' => esc_html__('Right', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-end',
          ],
        ],
        'default'   => 'center',
        'selectors' => [
          '{{WRAPPER}} .parallax-tab__pagination' => 'text-align: {{VALUE}}',
        ],
        'condition' => [
          'direction' => 'horizontal',
        ],
        'separator' => 'after',
      ]
    );

    $this->add_responsive_control(
      'pagination_size',
      [
        'label'      => esc_html__('Dots Size', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab__pagination .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'pagination_active_size',
      [
        'label'      => esc_html__('Active Dot Size', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'range'      => [
          'px' => [
            'min' => 5,
            'max' => 30,
          ],
        ],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab__pagination .swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'pagination_color',
      [
        'label'     => esc_html__('Dots Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}}  .parallax-tab__pagination .swiper-pagination-bullet' => 'background: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_control(
      'pagination_hover_color',
      [
        'label'     => esc_html__('Dots Hover Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .parallax-tab__pagination .swiper-pagination-bullet:hover' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_control(
      'pagination_active_color',
      [
        'label'     => esc_html__('Active Dot Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .parallax-tab__pagination .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'pagination_border_radius',
      [
        'label'      => esc_html__('Border Radius Dots', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .parallax-tab__pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->end_controls_section();
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
          'class'                                => ['tabs-params'],
          'data-loop-responsivetabs'             => esc_attr($settings['parallax_loop']),
          'data-mousewheel-responsivetabs'       => esc_attr($settings['parallax_mousewheel']),
          'data-grabcursor-responsivetabs'       => esc_attr($settings['parallax_grabcursor']),
          'data-navigation-responsivetabs'       => esc_attr($settings['navigation']),
          'data-autoplay-responsivetabs'         => esc_attr($settings['autoplay']),
          'data-autoplayspeed-responsivetabs'    => esc_attr($settings['autoplay_speed']),
          'data-direction-responsivetabs'        => esc_attr($settings['direction']),
          'data-direction-responsivetabs-tablet' => esc_attr($settings['direction_tablet']),
          'data-direction-responsivetabs-mobile' => esc_attr($settings['direction_mobile']),
        ]
      );
    }

    if ($settings['parallax_tab']) {
      if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
        <div <?php echo $this->get_render_attribute_string('responsive_tabs'); ?>></div>
      <?php } ?>

      <section class="swiperTabs parallax-tab">
        <div class="swiper-wrapper parallax-tab__container">
          <?php foreach ($settings['parallax_tab'] as $parallax_items) { ?>
            <div class="swiper-slide">
              <div class="parallax-tab__image">
                <div class="parallax-tab__image_inner parallax-tab__image_left"
                     style="background-image: url('<?php echo esc_url($parallax_items['parallax_background_image_left']['url']); ?>');">
                  <?php if ($settings['enable_title_section'] === 'yes') { ?>
                    <div class="parallax-tab__title">
                      <?php if (!empty($parallax_items['parallax_size'])) {
                        $this->add_render_attribute('parallax_title', 'class', 'elementor-size-' . $parallax_items['parallax_size']);
                      } else {
                        $this->add_render_attribute('parallax_title', 'class', 'elementor-size-default');
                      }

                      $this->add_inline_editing_attributes('parallax_title');

                      $title = $parallax_items['parallax_title'];

                      if (!empty($parallax_items['parallax_link']['url'])) {
                        $this->add_link_attributes('url', $parallax_items['parallax_link']);

                        $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
                      }

                      $parallax_title = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($parallax_items['parallax_header_size']), $this->get_render_attribute_string('parallax_title'), $title);

                      echo wp_kses_post($parallax_title); ?>
                    </div>
                  <?php }

                  if ($settings['enable_subtitle_section'] === 'yes') { ?>
                    <div class="parallax-tab__subtitle">
                      <?php if (!empty($parallax_items['parallax_subtitle_size'])) {
                        $this->add_render_attribute('parallax_subtitle', 'class', 'elementor-size-' . $parallax_items['parallax_subtitle_size']);
                      } else {
                        $this->add_render_attribute('parallax_subtitle', 'class', 'elementor-size-default');
                      }

                      $this->add_inline_editing_attributes('parallax_subtitle');

                      $subtitle = $parallax_items['parallax_subtitle'];

                      if (!empty($parallax_items['parallax_subtitle_link']['url'])) {
                        $this->add_link_attributes('url', $parallax_items['parallax_subtitle_link']);

                        $subtitle = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $subtitle);
                      }

                      $parallax_subtitle = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($parallax_items['parallax_subtitle_header_size']), $this->get_render_attribute_string('parallax_subtitle'), $subtitle);

                      echo wp_kses_post($parallax_subtitle); ?>
                    </div>
                  <?php } ?>

                  <div class="parallax-tab__filter"></div>
                </div>
              </div>
              <div class="parallax-tab__image">
                <div class="parallax-tab__image_inner parallax-tab__image_right"
                     style="background-image: url('<?php echo esc_url($parallax_items['parallax_background_image_right']['url']); ?>');">
                  <?php if ($settings['enable_content_section'] === 'yes') { ?>
                    <div class="parallax-tab__description">
                      <?php echo wp_kses_post($parallax_items['parallax_content']); ?>
                    </div>
                  <?php } ?>

                  <div class="parallax-tab__filter"></div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="parallax-tab__pagination swiper-pagination"></div>
      </section>

    <?php } ?>
  <?php }
}
