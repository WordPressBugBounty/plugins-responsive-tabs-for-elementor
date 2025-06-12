<?php

use Elementor\Utils;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

// Content Section Controls
function get_hover_image_reveal_tabs_content_section_controls($controls, $default_tabs)
{
  $controls->start_controls_section(
    'hover_image_reveal_tabs_content_section',
    [
      'label' => esc_html__('Tabs', 'responsive-tabs-for-elementor'),
    ]
  );

  $repeater = new Repeater();

  $repeater->add_control('tab_title', [
    'label'       => esc_html__('Title', 'responsive-tabs-for-elementor'),
    'type'        => Controls_Manager::TEXT,
    'default'     => esc_html__('Title', 'responsive-tabs-for-elementor'),
    'label_block' => true,
  ]);

  $repeater->add_control('tab_image', [
    'label'   => esc_html__('Choose Image', 'responsive-tabs-for-elementor'),
    'type'    => Controls_Manager::MEDIA,
    'default' => [
      'url' => Utils::get_placeholder_image_src(),
    ],
  ]);

  $repeater->add_control('tab_link', [
    'label'       => esc_html__('Link', 'responsive-tabs-for-elementor'),
    'type'        => Controls_Manager::URL,
    'default'     => [
      'url' => '',
    ],
    'label_block' => true,
  ]);

  $controls->add_control(
    'tab',
    [
      'label'              => esc_html__('Tabs', 'responsive-tabs-for-elementor'),
      'type'               => Controls_Manager::REPEATER,
      'fields'             => $repeater->get_controls(),
      'title_field'        => '{{{ tab_title }}}',
      'frontend_available' => true,
      'default'            => array_pad([], 3, $default_tabs),
      'classes'            => 'responsive-hover-image-tabs-control',
    ]
  );

  $controls->add_control('link_text', [
    'label'       => esc_html__('Link Text', 'responsive-tabs-for-elementor'),
    'type'        => Controls_Manager::TEXT,
    'default'     => esc_html__('Read More', 'responsive-tabs-for-elementor'),
    'label_block' => true,
  ]);

  $controls->end_controls_section();
}

// Global Style Section Controls
function get_hover_image_reveal_tabs_global_styles_section_controls($controls)
{
  $controls->start_controls_section(
    'tabs_global_styles_section',
    [
      'label' => esc_html__('Global Styles', 'responsive-tabs-for-elementor'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]
  );

  $controls->add_control('tabs_margin', [
    'label'              => esc_html__('Margin', 'responsive-tabs-for-elementor'),
    'type'               => Controls_Manager::DIMENSIONS,
    'size_units'         => ['px', 'em'],
    'default'            => [
      'top'    => 0,
      'right'  => 0,
      'bottom' => 0,
      'left'   => 0,
      'unit'   => 'px',
    ],
    'frontend_available' => true,
    'selectors'          => [
      '{{WRAPPER}} .hover-image-reveal-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
  ]);

  $controls->add_control('tabs_padding', [
    'label'              => esc_html__('Padding', 'responsive-tabs-for-elementor'),
    'type'               => Controls_Manager::DIMENSIONS,
    'size_units'         => ['px', 'em'],
    'default'            => [
      'top'    => 0,
      'right'  => 0,
      'bottom' => 0,
      'left'   => 0,
      'unit'   => 'px',
    ],
    'frontend_available' => true,
    'selectors'          => [
      '{{WRAPPER}} .hover-image-reveal-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
  ]);

  $controls->add_control(
    'tabs_wrapper_background_color',
    [
      'label'     => esc_html__('Background Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .hover-image-reveal-tabs' => 'background-color: {{VALUE}};',
      ],
    ]
  );

  $controls->add_control(
    'tabs_border_radius',
    [
      'label'      => esc_html__('Border Radius', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', 'em', '%'],
      'default'    => [
        'top'    => 21,
        'right'  => 21,
        'bottom' => 21,
        'left'   => 21,
        'unit'   => 'px',
      ],
      'selectors'  => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__list' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_section();
}

// Tab Styles Section Controls
function get_hover_image_reveal_tabs_tab_styles_section_controls($controls)
{
  $controls->start_controls_section(
    'tabs_styles_section',
    [
      'label' => esc_html__('Tab Styles', 'responsive-tabs-for-elementor'),
      'tab'   => Controls_Manager::TAB_STYLE,
    ]
  );

  $controls->start_controls_tabs('tabs_styles_tabs');

  $controls->start_controls_tab(
    'tabs_tab_styles_tab',
    [
      'label' => esc_html__('Tab', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_responsive_control('tab_padding', [
    'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
    'type'       => Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em'],
    'default'    => [
      'top'      => '40',
      'right'    => '30',
      'bottom'   => '40',
      'left'     => '30',
      'unit'     => 'px',
      'isLinked' => false,
    ],
    'selectors'  => [
      '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
  ]);

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'tabs_background',
      'types'          => ['gradient'],
      'fields_options' => [
        'background'  => [
          'label' => 'Background',
        ],
        'description' => esc_html__('Displayed on tablets and mobile', 'responsive-tabs-for-elementor'),
      ],
      'selector'       => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item .hover-image-reveal-tabs__item-description::before',
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'tabs_background_active',
      'types'          => ['gradient'],
      'fields_options' => [
        'background' => [
          'label' => 'Active Background',
        ],
      ],
      'selector'       => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item.is-visible .hover-image-reveal-tabs__item-description::before',
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'tabs_name_styles_tab',
    [
      'label' => esc_html__('Title', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'name_typography',
      'label'    => esc_html__('Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-title',
    ]
  );

  $controls->add_control(
    'name_color',
    [
      'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'default'   => '#000',
      'selectors' => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-title' => 'color: {{VALUE}};',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'name_active_typography',
      'label'    => esc_html__('Active Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item.is-visible .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-title',
    ]
  );

  $controls->add_control(
    'name_active_color',
    [
      'label'     => esc_html__('Active Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'default'   => '#fff',
      'selectors' => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item.is-visible .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-title' => 'color: {{VALUE}};',
      ],
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'tabs_button_styles_tab',
    [
      'label' => esc_html__('Button', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_responsive_control('tab_button_padding', [
    'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
    'type'       => Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em'],
    'default'    => [
      'top'      => '12',
      'right'    => '16',
      'bottom'   => '12',
      'left'     => '16',
      'unit'     => 'px',
      'isLinked' => false,
    ],
    'selectors'  => [
      '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item.is-visible .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
  ]);

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'tabs_button_background',
      'types'          => ['classic', 'gradient'],
      'fields_options' => [
        'background' => [
          'label' => 'Background',
        ],
      ],
      'selector'       => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link',
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'tabs_hover_button_background',
      'types'          => ['classic', 'gradient'],
      'fields_options' => [
        'background' => [
          'label' => 'Hover Background',
        ],
      ],
      'selector'       => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link:hover',
    ]
  );

  $controls->add_control('indicator_border_radius', [
    'label'      => esc_html__('Border Radius', 'responsive-tabs-for-elementor'),
    'type'       => Controls_Manager::DIMENSIONS,
    'size_units' => ['px', 'em', '%'],
    'default'    => [
      'top'    => 100,
      'right'  => 100,
      'bottom' => 100,
      'left'   => 100,
      'unit'   => 'px',
    ],
    'selectors'  => [
      '{{WRAPPER}} {{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
    ],
  ]);

  $controls->add_group_control(
    Group_Control_Box_Shadow::get_type(), [
    'name'     => 'tab_button_box_shadow',
    'selector' => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link',
  ]);

  $controls->add_group_control(
    Group_Control_Border::get_type(),
    [
      'name'     => 'tab_border',
      'selector' => '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description .hover-image-reveal-tabs__item-link',
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'tabs_divider_styles_tab',
    [
      'label' => esc_html__('Divider', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_responsive_control(
    'tabs_divider_width',
    [
      'label'      => esc_html__('Width', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'size_units' => ['px', '%', 'custom'],
      'range'      => [
        'px' => [
          'min' => 0,
          'max' => 300,
        ],
      ],
      'selectors'  => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description::after' => 'width: {{SIZE}}{{UNIT}};',
      ],
      'default'    => [
        'unit' => 'px',
        'size' => 1,
      ],
    ]
  );

  $controls->add_responsive_control(
    'tabs_divider_height',
    [
      'label'      => esc_html__('Height', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'size_units' => ['px', '%', 'custom'],
      'range'      => [
        'px' => [
          'min' => 0,
          'max' => 300,
        ],
      ],
      'selectors'  => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description::after' => 'height: {{SIZE}}{{UNIT}};',
      ],
      'default'    => [
        'unit' => 'px',
        'size' => 150,
      ],
    ]
  );

  $controls->add_control(
    'tabs_divider_color',
    [
      'label'     => esc_html__('Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .hover-image-reveal-tabs .hover-image-reveal-tabs__item-description::after' => 'background-color: {{VALUE}};',
      ],
    ]
  );

  $controls->end_controls_tab();

  $controls->end_controls_tabs();
  $controls->end_controls_section();
}