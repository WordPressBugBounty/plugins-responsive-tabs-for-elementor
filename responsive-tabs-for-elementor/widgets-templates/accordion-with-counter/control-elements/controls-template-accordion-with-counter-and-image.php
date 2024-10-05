<?php

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Content Templates Accordion With Image
function get_repeater_template_accordion_with_counter_image($controls, $repeater, $default_item)
{
  $repeater->add_control(
    'accordion_name',
    [
      'label'              => __('Tab Name', 'responsive-tabs-for-elementor'),
      'type'               => Controls_Manager::TEXT,
      'default'            => __('Title', 'responsive-tabs-for-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
    ]
  );

  $repeater->add_control(
    'accordion_name_content',
    [
      'label'              => __('Tab Name Content', 'responsive-tabs-for-elementor'),
      'type'               => Controls_Manager::TEXT,
      'default'            => __('Title', 'responsive-tabs-for-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
      'classes'            => 'accordion-name-limit-content',
    ]
  );

  $repeater->add_control(
    'accordion_image',
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

  $repeater->add_control(
    'accordion_content',
    [
      'label'   => __('Tab Content', 'responsive-tabs-for-elementor'),
      'type'    => Controls_Manager::WYSIWYG,
      'default' => __('<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'responsive-tabs-for-elementor</p>'),
      'rows'    => 20,
      'dynamic' => [
        'active' => true,
      ],
    ]
  );

  $controls->add_control(
    'accordion',
    [
      'label'       => __('Repeater Tab', 'responsive-tabs-for-elementor'),
      'type'        => Controls_Manager::REPEATER,
      'fields'      => $repeater->get_controls(),
      'title_field' => 'Tab',
      'default'     => [$default_item, $default_item, $default_item],
      'condition'   => [
        'accordion_templates' => '1',
      ],
    ]
  );
}

// General Styles Templates Accordion With Image
function get_general_style_template_accordion_with_counter_image($controls)
{
  $controls->add_responsive_control(
    'accordion_margin',
    [
      'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter-tabs-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_padding',
    [
      'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter-tabs-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'accordion_background',
      'types'          => ['classic', 'gradient'],
      'fields_options' => [
        'background' => [
          'label' => 'Tabs Background',
        ],
      ],
      'selector'       => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter-tabs-block',
      'condition'      => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_position',
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
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_box'     => 'flex-direction: {{VALUE}}',
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label'   => 'flex-direction: {{VALUE}}',
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_counter' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_height',
    [
      'label'      => esc_html__('Height', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::SLIDER,
      'size_units' => ['px', 'vh'],
      'default'    => [
        'unit' => 'px',
      ],
      'range'      => [
        'px' => [
          'min' => 0,
          'max' => 800,
        ],
        'vh' => [
          'min' => 0,
          'max' => 100,
        ],
      ],
      'selectors'  => [
        "{{WRAPPER}} #accordion-with-counter-image .accordion-with-counter-format-container" => 'height: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_space',
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
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_box' => 'gap: {{SIZE}}{{UNIT}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );
}

// Tab Styles Templates Accordion With Image
function get_tab_style_template_accordion_with_counter_image($controls)
{
  $controls->add_responsive_control(
    'accordion_name_position',
    [
      'label'     => esc_html__('Name Position', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'row'         => [
          'title' => esc_html__('Start', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-order-start',
        ],
        'row-reverse' => [
          'title' => esc_html__('End', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-order-end',
        ],
      ],
      'default'   => 'row',
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_alignment',
    [
      'label'     => esc_html__('Alignment', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'flex-start'    => [
          'title' => esc_html__('Flex-Left', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-start-h',
        ],
        'center'        => [
          'title' => esc_html__('Center', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-center-h',
        ],
        'flex-end'      => [
          'title' => esc_html__('Flex-End', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-end-h',
        ],
        'space-between' => [
          'title' => esc_html__('Space-Between', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-space-between-h',
        ],
        'space-around'  => [
          'title' => esc_html__('Space-Around', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-space-around-h',
        ],
        'space-evenly'  => [
          'title' => esc_html__('Space-Evenly', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-justify-space-evenly-h',
        ],
      ],
      'default'   => 'flex-start',
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label' => 'justify-content: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_title_space',
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
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label' => 'gap: {{SIZE}}{{UNIT}}',
      ],
      'separator' => 'before',
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->start_controls_tabs('accordion_name_style', [
    'condition' => [
      'accordion_templates' => '1',
    ],
  ]);

  $controls->start_controls_tab(
    'accordion_name_normal',
    [
      'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
    ]
  );
  $controls->add_control(
    'accordion_name_color',
    [
      'label'     => esc_html__('Name Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label' => 'color: {{VALUE}}',
      ],
    ]
  );
  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'accordion_name_typography',
      'label'    => esc_html__('Name Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_label',
    ]
  );
  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'accordion_name_active',
    [
      'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'active_accordion_name_color',
    [
      'label'     => esc_html__('Name Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_input:checked+label' => 'color: {{VALUE}}',
      ],
    ]
  );
  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'active_accordion_name_typography',
      'label'    => esc_html__('Name Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_input:checked+label',
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_tabs();
}

// Counter And Divider Styles Templates Accordion With Image
function get_counter_divider_style_template_accordion_with_counter_image($controls)
{
  $controls->start_controls_tabs('accordion_counter_style', [
    'label'     => esc_html__('Counter', 'responsive-tabs-for-elementor'),
    'condition' => [
      'accordion_templates' => '1',
    ],
  ]);

  $controls->start_controls_tab(
    'accordion_counter_normal',
    [
      'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'accordion_counter_color',
    [
      'label'     => esc_html__('Counter Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_counter' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'accordion_counter_typography',
      'label'    => esc_html__('Counter Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_counter',
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'accordion_counter_active',
    [
      'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'active_accordion_counter_color',
    [
      'label'     => esc_html__('Counter Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_counter' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'active_accordion_counter_typography',
      'label'    => esc_html__('Counter Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_counter',
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_tabs();

  $controls->start_controls_tabs('accordion_divider_style', [
    'label'     => esc_html__('Divider', 'responsive-tabs-for-elementor'),
    'condition' => [
      'accordion_templates' => '1',
    ],
  ]);

  $controls->start_controls_tab(
    'accordion_divider_normal',
    [
      'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'accordion_divider_color_normal',
    [
      'label'     => esc_html__('Divider Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_divider' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'accordion_divider_active',
    [
      'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'accordion_divider_color_active',
    [
      'label'     => esc_html__('Divider Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_divider' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_tabs();

  $controls->add_responsive_control(
    'accordion_divider_position',
    [
      'label'     => esc_html__('Divider Position', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::CHOOSE,
      'options'   => [
        'row-reverse' => [
          'title' => esc_html__('Start', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-order-start',
        ],
        'row'         => [
          'title' => esc_html__('End', 'responsive-tabs-for-elementor'),
          'icon'  => 'eicon-order-end',
        ],
      ],
      'default'   => 'row',
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_counter' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_divider_space',
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
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_counter' => 'gap: {{SIZE}}{{UNIT}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );
}

// Content Styles Templates Accordion With Image
function get_content_style_template_accordion_with_counter_image($controls)
{
  $controls->add_control(
    'title_accordion_content_color',
    [
      'label'     => esc_html__('Title Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_title' => 'color: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'title_accordion_content_typography',
      'label'     => esc_html__('Title Typography', 'responsive-tabs-for-elementor'),
      'selector'  => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_title',
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_control(
    'accordion_content_color',
    [
      'label'     => esc_html__('Content Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_discr' => 'color: {{VALUE}}',
      ],
      'separator' => 'before',
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'accordion_content_typography',
      'label'     => esc_html__('Content Typography', 'responsive-tabs-for-elementor'),
      'selector'  => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_discr',
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_responsive_control(
    'accordion_content_align',
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
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_discr' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );
}

// Images style Section
function get_images_section_template_accordion_with_counter_image($controls)
{
  $controls->start_controls_section(
    'accordion_images_styles_section',
    [
      'label'     => esc_html__('Images styles', 'responsive-tabs-for-elementor'),
      'tab'       => Controls_Manager::TAB_STYLE,
      'condition' => [
        'accordion_templates' => '1',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Border::get_type(),
    [
      'name'     => 'accordion_border_images',
      'selector' => '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_image img',
    ]
  );

  $controls->add_responsive_control(
    'accordion_border_radius_images',
    [
      'label'      => esc_html__('Border Radius Images', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} #accordion-with-counter-image.accordion-with-counter .accordion-with-counter-tabs_image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
    ]
  );
  $controls->end_controls_section();
}
