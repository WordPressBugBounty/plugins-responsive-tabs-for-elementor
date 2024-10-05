<?php
/**
 * Responsive_FAQ_Accordion class.
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
 * ResponsiveFAQAccordion widget class.
 *
 * @since 9.3.0
 */
class Responsive_FAQ_Accordion extends Widget_Base
{
  /**
   * ResponsiveFAQAccordion constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('faq-accordion', plugins_url('/assets/css/faq-accordion.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);

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
    return 'responsive-faq-accordion';
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
    return __('FAQ Accordion', 'responsive-tabs-for-elementor');
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
    return 'icon-faq-accordion';
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
    $styles = ['faq-accordion'];

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
  protected function get_default_faq()
  {
    return [
      'faq_title'   => __('<p>Title</p>', 'responsive-tabs-for-elementor'),
      'faq_content' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'responsive-tabs-for-elementor'),
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

    $this->add_control(
      'faq_section_title_enable',
      [
        'label'        => __('Section Title', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'yes',
      ]
    );

    $this->add_control(
      'faq_section_title',
      [
        'label'       => esc_html__('Title', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::TEXTAREA,
        'dynamic'     => [
          'active' => true,
        ],
        'placeholder' => esc_html__('Enter your title', 'responsive-tabs-for-elementor'),
        'default'     => esc_html__('FAQ', 'responsive-tabs-for-elementor'),
        'condition'   => [
          'faq_section_title_enable' => 'yes',
        ],
        'separator'   => 'before',
      ]
    );

    $this->add_control(
      'faq_section_link',
      [
        'label'     => esc_html__('Link', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::URL,
        'dynamic'   => [
          'active' => true,
        ],
        'default'   => [
          'url' => '',
        ],
        'condition' => [
          'faq_section_title_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'faq_section_size',
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
          'size!'                    => 'default',
          'faq_section_title_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'faq_section_header_size',
      [
        'label'     => esc_html__('HTML Tag', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::SELECT,
        'options'   => [
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
        'default'   => 'h2',
        'condition' => [
          'faq_section_title_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'faq_section_icon_enable',
      [
        'label'        => __('Icons', 'testimonials-carousel-elementor'),
        'type'         => Controls_Manager::SWITCHER,
        'label_on'     => __('Show', 'testimonials-carousel-elementor'),
        'label_off'    => __('Hide', 'testimonials-carousel-elementor'),
        'return_value' => 'yes',
        'default'      => 'no',
        'separator'    => 'before',
      ]
    );

    $this->add_control(
      'faq_section_left_icon',
      [
        'label'       => __('Choose Left Icon', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-less-than',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'less-than',
          ],
        ],
        'condition'   => [
          'faq_section_icon_enable' => 'yes',
        ],
      ]
    );

    $this->add_control(
      'faq_section_right_icon',
      [
        'label'       => __('Choose Right Icon', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-greater-than',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'greater-than',
          ],
        ],
        'condition'   => [
          'faq_section_icon_enable' => 'yes',
        ],
      ]
    );

    $repeater = new Repeater();
    $repeater->add_control(
      'faq_title',
      [
        'label'              => __('Title', 'responsive-tabs-for-elementor'),
        'type'               => Controls_Manager::WYSIWYG,
        'default'            => __('<p>Title</p>', 'responsive-tabs-for-elementor'),
        'label_block'        => true,
        'frontend_available' => true,
        'dynamic'            => [
          'active' => true,
        ],
      ]
    );

    $repeater->add_control(
      'faq_content',
      [
        'label'   => __('Content', 'responsive-tabs-for-elementor'),
        'type'    => Controls_Manager::WYSIWYG,
        'default' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', 'responsive-tabs-for-elementor'),
        'rows'    => 20,
        'dynamic' => [
          'active' => true,
        ],
      ]
    );

    $this->add_control(
      'faq',
      [
        'label'       => __('Repeater', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::REPEATER,
        'fields'      => $repeater->get_controls(),
        'title_field' => '{{{ faq_title }}}',
        'default'     => [$this->get_default_faq(), $this->get_default_faq(), $this->get_default_faq()],
        'separator'   => 'before',
      ]
    );
    $this->end_controls_section();

    // Arrow Section
    $this->start_controls_section(
      'faq_arrow_section',
      [
        'label' => __('Arrow', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_control(
      'faq_icon_arrow',
      [
        'label'       => __('Choose Arrow Icon', 'responsive-tabs-for-elementor'),
        'type'        => Controls_Manager::ICONS,
        'default'     => [
          'value'   => 'fas fa-chevron-down',
          'library' => 'fa-solid',
        ],
        'recommended' => [
          'fa-solid' => [
            'arrow-down',
            'caret-down',
            'angle-down',
          ],
        ],
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
      'faq_accordion_margin',
      [
        'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'faq_accordion_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'           => 'background',
        'types'          => ['classic', 'gradient', 'video'],
        'fields_options' => [
          'background' => [
            'label' => 'Background',
          ],
        ],
        'selector'       => '{{WRAPPER}} .faq-accordion',
      ]
    );

    $this->add_responsive_control(
      'faq_section_space',
      [
        'label'     => esc_html__('Spacing', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 0,
            'max' => 140,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__wrapper' => 'gap: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'faq_section_width',
      [
        'label'      => esc_html__('Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__wrapper' => 'max-width: {{SIZE}}{{UNIT}}',
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
      'title_section_color',
      [
        'label'     => esc_html__('Title Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__title *' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'title_section_typography',
        'label'    => esc_html__('Title Typography', 'responsive-tabs-for-elementor'),
        'selector' => '{{WRAPPER}} .faq-accordion .faq-accordion__title *',
      ]
    );

    $this->add_control(
      'title_section_icon_size',
      [
        'label'      => esc_html__('Icon Size', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__title_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .faq-accordion .faq-accordion__title_icon svg' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'separator'  => 'before',
      ]
    );

    $this->add_control(
      'title_section_icon_color',
      [
        'label'     => esc_html__('Icon Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__title_icon'          => 'color: {{VALUE}}',
          '{{WRAPPER}} .faq-accordion .faq-accordion__title_icon i'        => 'color: {{VALUE}}',
          '{{WRAPPER}} .faq-accordion .faq-accordion__title_icon svg path' => 'fill: {{VALUE}}',
        ],
      ]
    );

    $this->end_controls_section();

    // Tab styles Section
    $this->start_controls_section(
      'tabs_styles_section',
      [
        'label' => esc_html__('Tabs Styles', 'responsive-tabs-for-elementor'),
        'tab'   => Controls_Manager::TAB_STYLE,
      ]
    );

    $this->add_responsive_control(
      'tabs_accordion_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'tabs_space',
      [
        'label'     => esc_html__('Spacing', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__wrapper-items' => 'gap: {{SIZE}}{{UNIT}}',
          '{{WRAPPER}} .faq-accordion .faq-accordion__item.opened'   => 'gap: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_responsive_control(
      'tab_name_position',
      [
        'label'     => esc_html__('Position', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::CHOOSE,
        'options'   => [
          'row'         => [
            'title' => esc_html__('Row', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-start',
          ],
          'row-reverse' => [
            'title' => esc_html__('Row-Reverse', 'responsive-tabs-for-elementor'),
            'icon'  => 'eicon-order-end',
          ],
        ],
        'default'   => 'row',
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title' => 'flex-direction: {{VALUE}}',
        ],
      ]
    );

    $this->add_control(
      'arrow_size',
      [
        'label'     => esc_html__('Arrow size', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::SLIDER,
        'range'     => [
          'px' => [
            'min' => 12,
            'max' => 60,
          ],
        ],
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title_icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title_icon svg' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'separator' => 'after',
      ]
    );

    $this->start_controls_tabs('tabs_style');

    $this->start_controls_tab(
      'tab_normal',
      [
        'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'           => 'tab_background',
        'types'          => ['classic', 'gradient', 'video'],
        'fields_options' => [
          'background' => [
            'label' => 'Background',
          ],
        ],
        'selector'       => '{{WRAPPER}} .faq-accordion__item .faq-accordion__item-title',
      ]
    );

    $this->add_control(
      'tab_name_color',
      [
        'label'     => esc_html__('Title Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title *' => 'color: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'tab_name_typography',
        'label'    => esc_html__('Title Typography', 'responsive-tabs-for-elementor'),
        'selector' => '{{WRAPPER}} .faq-accordion .faq-accordion__item-title *',
      ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
      'tab_active',
      [
        'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
      ]
    );

    $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'           => 'tab_background_active',
        'types'          => ['classic', 'gradient', 'video'],
        'fields_options' => [
          'background' => [
            'label' => 'Active Background',
          ],
        ],
        'selector'       => '{{WRAPPER}} .faq-accordion__item.opened .faq-accordion__item-title',
      ]
    );

    $this->add_control(
      'active_tab_name_color',
      [
        'label'     => esc_html__('Active Title Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item.opened .faq-accordion__item-title *'             => 'color: {{VALUE}}',
          '{{WRAPPER}} .faq-accordion .faq-accordion__item.opened .faq-accordion__item-title_icon svg path' => 'fill: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'active_tab_name_typography',
        'label'    => esc_html__('Active Title Typography', 'responsive-tabs-for-elementor'),
        'selector' => '{{WRAPPER}} .faq-accordion .faq-accordion__item.opened .faq-accordion__item-title *',
      ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'tab_border',
        'selector'  => '{{WRAPPER}} .faq-accordion .faq-accordion__item-title',
        'separator' => 'before',
      ]
    );

    $this->add_responsive_control(
      'tab_border_radius',
      [
        'label'      => esc_html__('Border Radius', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

    $this->add_responsive_control(
      'tabs_content_padding',
      [
        'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'tabs_content_width',
      [
        'label'      => esc_html__('Width', 'responsive-tabs-for-elementor'),
        'type'       => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
        'selectors'  => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-content' => 'max-width: {{SIZE}}{{UNIT}}',
        ],
      ]
    );

    $this->add_control(
      'tab_content_color',
      [
        'label'     => esc_html__('Content Color', 'responsive-tabs-for-elementor'),
        'type'      => Controls_Manager::COLOR,
        'selectors' => [
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-content *' => 'color: {{VALUE}}',
        ],
        'separator' => 'before',
      ]
    );

    $this->add_group_control(
      Group_Control_Typography::get_type(),
      [
        'name'     => 'content_typography',
        'label'    => esc_html__('Content Typography', 'responsive-tabs-for-elementor'),
        'selector' => '{{WRAPPER}} .faq-accordion .faq-accordion__item-content *',
      ]
    );

    $this->add_responsive_control(
      'tab_content_align',
      [
        'label'     => esc_html__('Alignment Content', 'responsive-tabs-for-elementor'),
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
          '{{WRAPPER}} .faq-accordion .faq-accordion__item-content' => 'text-align: {{VALUE}}',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'      => 'tab_normal_border',
        'selector'  => '{{WRAPPER}} .faq-accordion .faq-accordion__item-content',
        'separator' => 'before',
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

    if ($settings['faq']) {
      if (!empty($settings['faq_section_size'])) {
        $this->add_render_attribute('faq_section_title', 'class', 'elementor-size-' . $settings['faq_section_size']);
      } else {
        $this->add_render_attribute('faq_section_title', 'class', 'elementor-size-default');
      }

      $this->add_inline_editing_attributes('faq_section_title');

      $title = $settings['faq_section_title'];

      if (!empty($settings['faq_section_link']['url'])) {
        $this->add_link_attributes('url', $settings['faq_section_link']);

        $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
      }

      $faq_section_title = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['faq_section_header_size']), $this->get_render_attribute_string('faq_section_title'), $title);
      ?>
      <section class="faq-accordion">
        <div class="faq-accordion__wrapper">
          <?php if ($settings['faq_section_title_enable'] === 'yes') { ?>
            <div class="faq-accordion__wrapper-title">
              <?php if ($settings['faq_section_icon_enable'] === 'yes') { ?>
                <div class="faq-accordion__title_icon">
                  <?php Icons_Manager::render_icon($settings['faq_section_left_icon'], ['aria-hidden' => 'true']); ?>
                </div>
              <?php } ?>

              <div class="faq-accordion__title">
                <?php echo wp_kses_post($faq_section_title); ?>
              </div>

              <?php if ($settings['faq_section_icon_enable'] === 'yes') { ?>
                <div class="faq-accordion__title_icon">
                  <?php Icons_Manager::render_icon($settings['faq_section_right_icon'], ['aria-hidden' => 'true']); ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>

          <div class="faq-accordion__wrapper-items">
            <?php $counter = 1;

            foreach ($settings['faq'] as $item) { ?>
              <div class="faq-accordion__item <?php if ($counter === 1) { ?>opened<?php } ?>">
                <div class="faq-accordion__item-title">
                  <?php echo wp_kses_post($item['faq_title']) ?>

                  <div class="faq-accordion__item-title_icon">
                    <?php Icons_Manager::render_icon($settings['faq_icon_arrow'], ['aria-hidden' => 'true']); ?>
                  </div>
                </div>
                <div class="faq-accordion__item-content">
                  <?php echo wp_kses_post($item['faq_content']) ?>
                </div>
              </div>
              <?php $counter++;
            } ?>
          </div>
        </div>
      </section>
    <?php } ?>
  <?php }
}
