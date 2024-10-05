<?php function get_default_accordion_template($settings, $attributes)
{
  if (get_plugin_data(ELEMENTOR__FILE__)['Version'] < "3.5.0") { ?>
    <div <?php echo $attributes; ?>></div>
  <?php } ?>

  <section class="accordion-with-counter accordion-with-counter-tabs-block">
    <div class="accordion-with-counter-format-container">
      <div class="accordion-with-counter-tabs_box">
        <div class="accordion-with-counter-tabs_wrapper">
          <?php $counter_tab = 1;
          foreach ($settings['tab'] as $item_tab) { ?>
            <input type="radio" id="tab-<?php echo esc_attr($counter_tab); ?>" class="accordion-with-counter-tabs_input"
                   name="tabs" <?php echo esc_attr($counter_tab) === 1 ? 'checked=""' : '' ?>>
            <label for="tab-<?php echo esc_attr($counter_tab); ?>" class="accordion-with-counter-tabs_label">
              <?php if ($settings['accordion_counter'] || $settings['accordion_divider']) { ?>
                <span class="accordion-with-counter-tabs_counter">
                    <?php if ($settings['accordion_divider']) { ?>
                      <span class="accordion-with-counter-tabs_dash"></span>
                    <?php }

                    if ($settings['accordion_counter']) {
                      if ($counter_tab < 10)
                        echo '0';
                      echo wp_kses($counter_tab, []);
                    } ?>
                  </span>
              <?php }

              echo wp_kses_post($item_tab['tab_name']); ?>
            </label>
            <?php $counter_tab++;
          } ?>
        </div>

        <div class="accordion-with-counter-tabs_content">
          <?php $counter = 1;
          foreach ($settings['tab'] as $item) { ?>
            <div class="accordion-with-counter-tabs_item" id="tabs__item-<?php echo esc_attr($counter); ?>">
              <h2 class="accordion-with-counter-tabs_title"><?php echo wp_kses_post($item['tab_name']); ?></h2>
              <div class="accordion-with-counter-tabs_discr">
                <?php echo wp_kses_post($item['tab_content']); ?>
              </div>
            </div>
            <?php $counter++;
          } ?>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
