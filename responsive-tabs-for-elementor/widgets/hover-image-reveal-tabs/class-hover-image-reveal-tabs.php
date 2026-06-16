<?php
/**
 * Responsive_Hover_Image_Reveal_Tabs class.
 *
 * @category   Class
 * @package    ResponsiveTabsForElementor
 * @subpackage WordPress
 * @author     UAPP GROUP
 * @copyright  2026 UAPP GROUP
 * @license    https://opensource.org/licenses/GPL-3.0 GPL-3.0-only
 * @link
 * @since      11.0.1
 * php version 7.4.1
 */

namespace ResponsiveTabsForElementor\Widgets;

use ResponsiveTabsForElementor\Responsive_Tabs_Assets;
use Elementor\Utils;
use Elementor\Widget_Base;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * ResponsiveTestimonialsTabs widget class.
 *
 * @since 11.0.1
 */
class Responsive_Hover_Image_Reveal_Tabs extends Widget_Base
{
  /**
   * ResponsiveTestimonialsTabs constructor.
   *
   * @param array $data
   * @param null  $args
   *
   * @throws \Exception
   */
  public function __construct($data = [], $args = null)
  {
    parent::__construct($data, $args);
    wp_register_style('responsive-hover-image-reveal-tabs', plugins_url('/assets/css/responsive-hover-image-reveal-tabs.min.css', RESPONSIVE_TABS_FOR_ELEMENTOR), [], RESPONSIVE_TABS_VERSION);

    Responsive_Tabs_Assets::register_tabs_handler();
  }

  /**
   * Retrieve the widget name.
   *
   * @return string Widget name.
   * @since  11.0.1
   *
   * @access public
   *
   */
  public function get_name()
  {
    return 'responsive-hover-image-reveal-tabs';
  }

  /**
   * Retrieve the widget title.
   *
   * @return string Widget title.
   * @since  11.0.1
   *
   * @access public
   *
   */
  public function get_title()
  {
    return __('Hover Image Reveal Tabs', 'responsive-tabs-for-elementor');
  }

  /**
   * Retrieve the widget icon.
   *
   * @return string Widget icon.
   * @since  11.0.1
   *
   * @access public
   *
   */
  public function get_icon()
  {
    return 'icon-hover-image-reveal-tabs';
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
   * @since  11.0.1
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
    $styles = ['responsive-hover-image-reveal-tabs'];

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
   * @since  11.0.1
   *
   * @access protected
   *
   */
  protected function get_default_tab()
  {
    return [
        'tab_image' => [
            'url' => Utils::get_placeholder_image_src(),
        ],
        'tab_title' => __('Milton Austin', 'responsive-tabs-for-elementor'),
    ];
  }

  /**
   * Register the widget controls.
   *
   * Adds different input fields to allow the user to change and customize the widget settings.
   *
   * @since  11.0.1
   *
   * @access protected
   */
  protected function register_controls()
  {
    // Get Hover Image Reveal Tabs Content Section Controls
    get_hover_image_reveal_tabs_content_section_controls($this, $this->get_default_tab());

    // Get Hover Image Reveal Tabs Global Tab Styles Section Controls
    get_hover_image_reveal_tabs_global_styles_section_controls($this);

    // Get Hover Image Reveal Tabs Tab Styles Section Controls
    get_hover_image_reveal_tabs_tab_styles_section_controls($this);
  }

  /**
   * Render the widget output on the frontend.
   *
   * Written in PHP and used to generate the final HTML.
   *
   * @since  11.0.1
   *
   * @access protected
   */
  protected function render()
  {
    $settings = $this->get_settings_for_display();

    ?>
    <section class="hover-image-reveal-tabs">
      <ul class="hover-image-reveal-tabs__list">
        <?php foreach ($settings['tab'] as $index => $tab) {
          $this->add_link_attributes('tab_link', $tab['tab_link'] ?? [], true);
          ?>
          <li class="hover-image-reveal-tabs__item <?php echo esc_attr($index === 0 ? 'active' : ''); ?>">
            <?php if (!empty($tab['tab_image']['url'])) { ?>
              <figure class="hover-image-reveal-tabs__item-figure">
                <img
                    src="<?php echo esc_url($tab['tab_image']['url']); ?>"
                    alt="<?php echo esc_attr($tab['tab_title']); ?>"
                    class="hover-image-reveal-tabs__item-image"
                >
              </figure>
            <?php } ?>

            <div class="hover-image-reveal-tabs__item-description">
              <?php if (!empty($tab['tab_title'])) { ?>
                <h2 class="hover-image-reveal-tabs__item-title">
                  <?php echo esc_html($tab['tab_title']); ?>
                </h2>
              <?php }

              if (!empty($tab['tab_link']['url']) && !empty($tab['link_text']) && $tab['tab_link_enable'] === 'yes') { ?>
                <a <?php $this->print_render_attribute_string('tab_link'); ?>
                    class="hover-image-reveal-tabs__item-link <?php if (!empty($settings['tab_button_hover_animation'])) { ?> elementor-animation-<?php echo esc_attr($settings['tab_button_hover_animation']);
                    } ?>">
                  <?php echo esc_html($tab['link_text']); ?>
                </a>
              <?php } ?>
            </div>
          </li>
        <?php } ?>
      </ul>
    </section>
    <?php
  }
}
