<?php
/**
 * Responsive_Portfolio_Tabs class.
 *
 * @category   Class
 * @package    ResponsiveTabsForElementor
 * @subpackage WordPress
 * @author     UAPP GROUP
 * @copyright  2026 UAPP GROUP
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      11.0.0
 * php version 7.4.1
 */

namespace ResponsiveTabsForElementor\Widgets;

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * Responsive Portfolio Tabs widget class.
 *
 * @since 11.0.0
 */
class Responsive_Portfolio_Tabs extends Widget_Base
{
  /**
   * Responsive_Portfolio_Tabs constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);

    wp_register_style('responsive-portfolio-tabs', plugins_url('/assets/css/responsive-portfolio-tabs.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);

    if (!function_exists('get_plugin_data')) {
      require_once(ABSPATH . 'wp-admin/includes/plugin.php');
    }

    if (get_plugin_data(ELEMENTOR__FILE__)['Version'] >= "3.5.0") {
      wp_register_script('responsive-portfolio-tabs', plugins_url('/assets/js/responsive-portfolio-tabs-widget-handler.min.js', RESPONSIVE_TABS_FOR_ELEMENTOR), ['jquery', 'elementor-frontend'], RESPONSIVE_TABS_VERSION, true);
    } else {
      wp_register_script('responsive-portfolio-tabs', plugins_url('/assets/js/responsive-portfolio-tabs-widget-old-elementor-handler.min.js', RESPONSIVE_TABS_FOR_ELEMENTOR), ['jquery', 'elementor-frontend'], RESPONSIVE_TABS_VERSION, true);
    }
  }

  /**
   * Retrieve the widget name.
   *
   * @return string Widget name.
   */
  public function get_name()
  {
    return 'responsive-portfolio-tabs';
  }

  /**
   * Retrieve the widget title.
   *
   * @return string Widget title.
   */
  public function get_title()
  {
    return __('Portfolio Tabs', 'responsive-tabs-for-elementor');
  }

  /**
   * Retrieve the widget icon.
   *
   * @return string Widget icon.
   */
  public function get_icon()
  {
    return 'icon-portfolio-tabs';
  }

  /**
   * Retrieve the list of categories the widget belongs to.
   *
   * @return array Widget categories.
   */
  public function get_categories()
  {
    return ['responsive_tabs'];
  }

  /**
   * Enqueue styles.
   *
   * @return array
   */
  public function get_style_depends()
  {
    return ['responsive-portfolio-tabs'];
  }

  /**
   * Enqueue scripts.
   *
   * @return array
   */
  public function get_script_depends()
  {
    return ['responsive-portfolio-tabs'];
  }

  /**
   * Get default item.
   *
   * @return array
   */
  protected function get_default_items()
  {
    return [
        [
            'portfolio_item_title'    => __('Sample 1', 'responsive-tabs-for-elementor'),
            'portfolio_item_category' => __('Website Design', 'responsive-tabs-for-elementor'),
            'portfolio_item_image'    => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ],
        [
            'portfolio_item_title'    => __('Sample 2', 'responsive-tabs-for-elementor'),
            'portfolio_item_category' => __('App Development', 'responsive-tabs-for-elementor'),
            'portfolio_item_image'    => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ],
        [
            'portfolio_item_title'    => __('Sample 3', 'responsive-tabs-for-elementor'),
            'portfolio_item_category' => __('Marketing', 'responsive-tabs-for-elementor'),
            'portfolio_item_image'    => [
                'url' => Utils::get_placeholder_image_src(),
            ],
        ],
    ];
  }

  /**
   * Normalize category slug.
   *
   * @param string $value Category name.
   *
   * @return string
   */
  protected function normalize_category_slug($value)
  {
    $value = wp_strip_all_tags($value);
    $value = strtolower($value);
    $value = sanitize_title($value);

    return !empty($value) ? $value : 'uncategorized';
  }

  /**
   * Register the widget controls.
   */
  protected function register_controls()
  {
    $this->start_controls_section(
        'section_content',
        [
            'label' => __('Content', 'responsive-tabs-for-elementor'),
        ]
    );

    $repeater = new Repeater();

    $repeater->add_control(
        'portfolio_item_title',
        [
            'label'       => esc_html__('Title', 'responsive-tabs-for-elementor'),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'default'     => esc_html__('Sample', 'responsive-tabs-for-elementor'),
            'label_block' => true,
        ]
    );

    $repeater->add_control(
        'portfolio_item_category',
        [
            'label'       => esc_html__('Category', 'responsive-tabs-for-elementor'),
            'type'        => Controls_Manager::TEXT,
            'dynamic'     => [
                'active' => true,
            ],
            'default'     => esc_html__('Website Design', 'responsive-tabs-for-elementor'),
            'label_block' => true,
            'description' => esc_html__('Items with the same category name will be grouped into one tab.', 'responsive-tabs-for-elementor'),
        ]
    );

    $repeater->add_control(
        'portfolio_item_image',
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

    $this->add_control(
        'portfolio_items',
        [
            'label'       => __('Portfolio Items', 'responsive-tabs-for-elementor'),
            'type'        => Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'title_field' => '{{{ portfolio_item_title }}} - {{{ portfolio_item_category }}}',
            'default'     => $this->get_default_items(),
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
        'show_all_tab',
        [
            'label'              => esc_html__('Show "All" Tab', 'responsive-tabs-for-elementor'),
            'type'               => Controls_Manager::SWITCHER,
            'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
            'label_off'          => __('No', 'responsive-tabs-for-elementor'),
            'return_value'       => 'yes',
            'default'            => 'yes',
            'frontend_available' => true,
        ]
    );

    $this->add_control(
        'all_tab_label',
        [
            'label'     => esc_html__('All Tab Label', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::TEXT,
            'default'   => esc_html__('All', 'responsive-tabs-for-elementor'),
            'condition' => [
                'show_all_tab' => 'yes',
            ],
        ]
    );

    $this->add_control(
        'overlay_category_click',
        [
            'label'              => esc_html__('Enable Category Click In Overlay', 'responsive-tabs-for-elementor'),
            'type'               => Controls_Manager::SWITCHER,
            'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
            'label_off'          => __('No', 'responsive-tabs-for-elementor'),
            'return_value'       => 'yes',
            'default'            => 'yes',
            'frontend_available' => true,
        ]
    );

    $this->add_control(
        'scroll_on_overlay_click',
        [
            'label'              => esc_html__('Scroll To Widget On Overlay Click', 'responsive-tabs-for-elementor'),
            'type'               => Controls_Manager::SWITCHER,
            'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
            'label_off'          => __('No', 'responsive-tabs-for-elementor'),
            'return_value'       => 'yes',
            'default'            => '',
            'frontend_available' => true,
            'condition'          => [
                'overlay_category_click' => 'yes',
            ],
        ]
    );

    $this->add_control(
        'mobile_overlay_visible',
        [
            'label'              => esc_html__('Overlay Always Visible On Mobile', 'responsive-tabs-for-elementor'),
            'type'               => Controls_Manager::SWITCHER,
            'label_on'           => __('Yes', 'responsive-tabs-for-elementor'),
            'label_off'          => __('No', 'responsive-tabs-for-elementor'),
            'return_value'       => 'yes',
            'default'            => '',
            'frontend_available' => true,
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_style_general',
        [
            'label' => esc_html__('General Styles', 'responsive-tabs-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'columns',
        [
            'label'          => esc_html__('Columns', 'responsive-tabs-for-elementor'),
            'type'           => Controls_Manager::SELECT,
            'default'        => '4',
            'tablet_default' => '3',
            'mobile_default' => '1',
            'options'        => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ],
            'selectors'      => [
                '{{WRAPPER}} .responsive-portfolio-tabs__grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));',
            ],
        ]
    );

    $this->add_responsive_control(
        'grid_gap',
        [
            'label'      => esc_html__('Grid Gap', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'default'    => [
                'unit' => 'px',
                'size' => 16,
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'image_width',
        [
            'label'      => esc_html__('Image Width', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh', '%'],
            'default'    => [
                'unit' => 'px',
                'size' => 250,
            ],
            'range'      => [
                'px' => [
                    'min' => 0,
                    'max' => 300,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__item' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'image_height',
        [
            'label'      => esc_html__('Image Height', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'vh'],
            'default'    => [
                'unit' => 'px',
                'size' => 250,
            ],
            'range'      => [
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__image' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'item_border_radius',
        [
            'label'      => esc_html__('Item Border Radius', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__item-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_style_tabs',
        [
            'label' => esc_html__('Tabs Styles', 'responsive-tabs-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_responsive_control(
        'tabs_gap',
        [
            'label'      => esc_html__('Gap', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'default'    => [
                'unit' => 'px',
                'size' => 12,
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__nav' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'tabs_margin_bottom',
        [
            'label'      => esc_html__('Bottom Spacing', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'default'    => [
                'unit' => 'px',
                'size' => 24,
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__nav' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'tab_padding',
        [
            'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => 'tab_typography',
            'selector' => '{{WRAPPER}} .responsive-portfolio-tabs__tab',
        ]
    );

    $this->start_controls_tabs('tabs_style_status');

    $this->start_controls_tab(
        'normal_tabs_style_status',
        [
            'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
        ]
    );

    $this->add_control(
        'tab_color',
        [
            'label'     => esc_html__('Text Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'tab_border_color',
        [
            'label'     => esc_html__('Border Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'tab_background',
        [
            'label'     => esc_html__('Background', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'background: {{VALUE}};',
            ],
        ]
    );

    $this->end_controls_tab();

    $this->start_controls_tab(
        'active_and_hover_tabs_style_status',
        [
            'label' => esc_html__('Active/Hover', 'responsive-tabs-for-elementor'),
        ]
    );

    $this->add_control(
        'tab_active_color',
        [
            'label'     => esc_html__('Text Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#00e1ff',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab:hover, {{WRAPPER}} .responsive-portfolio-tabs__tab.is-active' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'tab_active_border_color',
        [
            'label'     => esc_html__('Border Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#00e1ff',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab:hover, {{WRAPPER}} .responsive-portfolio-tabs__tab.is-active' => 'border-color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'tab_active_background',
        [
            'label'     => esc_html__('Background', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab:hover, {{WRAPPER}} .responsive-portfolio-tabs__tab.is-active' => 'background: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'tab_border_width',
        [
            'label'      => esc_html__('Border Width', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px'],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; border-style: solid;',
            ],
        ]
    );

    $this->add_control(
        'tab_border_radius',
        [
            'label'      => esc_html__('Border Radius', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->end_controls_tab();
    $this->end_controls_tabs();

    $this->end_controls_section();

    $this->start_controls_section(
        'section_style_overlay',
        [
            'label' => esc_html__('Overlay Styles', 'responsive-tabs-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'overlay_background',
        [
            'label'     => esc_html__('Background', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => 'rgba(0,0,0,0.5)',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay' => 'background: {{VALUE}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'overlay_padding',
        [
            'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $this->add_responsive_control(
        'overlay_gap',
        [
            'label'      => esc_html__('Gap', 'responsive-tabs-for-elementor'),
            'type'       => Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'default'    => [
                'unit' => 'px',
                'size' => 12,
            ],
            'selectors'  => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $this->add_control(
        'overlay_transition_duration',
        [
            'label'       => esc_html__('Transition Duration (ms)', 'responsive-tabs-for-elementor'),
            'type'        => Controls_Manager::NUMBER,
            'default'     => 400,
            'min'         => 0,
            'max'         => 5000,
            'step'        => 50,
            'render_type' => 'template',
            'selectors'   => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay' => 'transition-duration: {{VALUE}}ms;',
            ],
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_style_title',
        [
            'label' => esc_html__('Title Styles', 'responsive-tabs-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'title_color',
        [
            'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__title' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => 'title_typography',
            'selector' => '{{WRAPPER}} .responsive-portfolio-tabs__title',
        ]
    );

    $this->end_controls_section();

    $this->start_controls_section(
        'section_style_category',
        [
            'label' => esc_html__('Overlay Category Styles', 'responsive-tabs-for-elementor'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]
    );

    $this->add_control(
        'category_color',
        [
            'label'     => esc_html__('Category Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay-link' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_control(
        'category_hover_color',
        [
            'label'     => esc_html__('Category Hover Color', 'responsive-tabs-for-elementor'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '#00e1ff',
            'selectors' => [
                '{{WRAPPER}} .responsive-portfolio-tabs__overlay-link:hover, {{WRAPPER}} .responsive-portfolio-tabs__overlay-link:focus-visible' => 'color: {{VALUE}};',
            ],
        ]
    );

    $this->add_group_control(
        Group_Control_Typography::get_type(),
        [
            'name'     => 'category_typography',
            'selector' => '{{WRAPPER}} .responsive-portfolio-tabs__overlay-link',
        ]
    );

    $this->end_controls_section();
  }

  /**
   * Render the widget output on the frontend.
   */
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    if (empty($settings['portfolio_items']) || !is_array($settings['portfolio_items'])) {
      return;
    }

    $show_all_tab           = !empty($settings['show_all_tab']) && 'yes' === $settings['show_all_tab'];
    $all_tab_label          = !empty($settings['all_tab_label']) ? $settings['all_tab_label'] : esc_html__('All', 'responsive-tabs-for-elementor');
    $overlay_category_click = !empty($settings['overlay_category_click']) && 'yes' === $settings['overlay_category_click'];
    $scroll_on_overlay      = !empty($settings['scroll_on_overlay_click']) && 'yes' === $settings['scroll_on_overlay_click'];
    $mobile_overlay_visible = !empty($settings['mobile_overlay_visible']) && 'yes' === $settings['mobile_overlay_visible'];

    $tabs  = [];
    $items = [];

    foreach ($settings['portfolio_items'] as $item) {
      $title    = !empty($item['portfolio_item_title']) ? $item['portfolio_item_title'] : esc_html__('Sample', 'responsive-tabs-for-elementor');
      $category = !empty($item['portfolio_item_category']) ? $item['portfolio_item_category'] : esc_html__('Uncategorized', 'responsive-tabs-for-elementor');
      $image    = !empty($item['portfolio_item_image']['url']) ? $item['portfolio_item_image']['url'] : '';
      $slug     = $this->normalize_category_slug($category);

      if (!isset($tabs[$slug])) {
        $tabs[$slug] = $category;
      }

      $items[] = [
          'title'         => $title,
          'category'      => $category,
          'category_slug' => $slug,
          'image'         => $image,
      ];
    }

    if (empty($items)) {
      return;
    }

    $default_tab = $show_all_tab ? 'all' : array_key_first($tabs);

    if (get_plugin_data(ELEMENTOR__FILE__) < "3.5.0") {
      $this->add_render_attribute(
          'responsive_portfolio_tabs_params',
          [
              'class'                        => ['responsive-portfolio-tabs-params'],
              'data-default-category'        => esc_attr($default_tab),
              'data-overlay-click'           => esc_attr($overlay_category_click ? 'yes' : 'no'),
              'data-scroll-on-overlay-click' => esc_attr($scroll_on_overlay ? 'yes' : 'no'),
          ]
      );
    }

    $this->add_render_attribute(
        'responsive_portfolio_tabs',
        [
            'class'                        => [
                'responsive-portfolio-tabs',
                $mobile_overlay_visible ? 'responsive-portfolio-tabs--mobile-overlay-visible' : '',
            ],
            'data-default-category'        => esc_attr($default_tab),
            'data-overlay-click'           => esc_attr($overlay_category_click ? 'yes' : 'no'),
            'data-scroll-on-overlay-click' => esc_attr($scroll_on_overlay ? 'yes' : 'no'),
        ]
    );
    ?>

    <?php if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
    <div <?php echo $this->get_render_attribute_string('responsive_portfolio_tabs_params'); ?>></div>
  <?php } ?>

    <section <?php echo $this->get_render_attribute_string('responsive_portfolio_tabs'); ?>>
      <div class="responsive-portfolio-tabs__nav" role="tablist">
        <?php if ($show_all_tab) { ?>
          <div class="responsive-portfolio-tabs__tab is-active"
               data-category="all"
               role="tab"
               aria-selected="true"
          >
            <?php echo esc_html($all_tab_label); ?>
          </div>
        <?php } ?>

        <?php foreach ($tabs as $slug => $label) {
          $is_active = !$show_all_tab && $slug === $default_tab;
          ?>
          <div class="responsive-portfolio-tabs__tab<?php echo $is_active ? ' is-active' : ''; ?>"
               data-category="<?php echo esc_attr($slug); ?>"
               role="tab"
               aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
          >
            <?php echo esc_html($label); ?>
          </div>
        <?php } ?>
      </div>

      <div class="responsive-portfolio-tabs__grid">
        <?php foreach ($items as $item) { ?>
          <div class="responsive-portfolio-tabs__item"
               data-category="<?php echo esc_attr($item['category_slug']); ?>"
          >
            <div class="responsive-portfolio-tabs__item-inner">
              <?php if (!empty($item['image'])) { ?>
                <img class="responsive-portfolio-tabs__image"
                     src="<?php echo esc_url($item['image']); ?>"
                     alt="<?php echo esc_attr($item['title']); ?>"
                >
              <?php } ?>

              <div class="responsive-portfolio-tabs__overlay">
                <h3 class="responsive-portfolio-tabs__title">
                  <?php echo esc_html($item['title']); ?>
                </h3>

                <?php if ($overlay_category_click) { ?>
                  <div class="responsive-portfolio-tabs__overlay-link"
                       data-category-trigger="<?php echo esc_attr($item['category_slug']); ?>"
                  >
                    <?php echo esc_html($item['category']); ?>
                  </div>
                <?php } else { ?>
                  <span class="responsive-portfolio-tabs__overlay-link is-static">
										<?php echo esc_html($item['category']); ?>
									</span>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </section>
    <?php
  }
}