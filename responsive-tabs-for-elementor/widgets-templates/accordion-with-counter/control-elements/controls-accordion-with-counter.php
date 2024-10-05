<?php

use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Utils;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

// Content Default Accordion
function get_repeater_accordion_with_counter($controls, $repeater, $default_item)
{
  $repeater->add_control(
    'tab_name',
    [
      'label'              => __('Tab Name', 'responsive-tabs-for-elementor'),
      'type'               => Controls_Manager::TEXT,
      'default'            => __('Lorem ipsum', 'responsive-tabs-for-elementor'),
      'label_block'        => true,
      'frontend_available' => true,
      'dynamic'            => [
        'active' => true,
      ],
    ]
  );

  $repeater->add_control(
    'tab_content',
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
    'tab',
    [
      'label'       => __('Repeater Tab', 'responsive-tabs-for-elementor'),
      'type'        => Controls_Manager::REPEATER,
      'fields'      => $repeater->get_controls(),
      'title_field' => 'Tab',
      'default'     => [$default_item, $default_item, $default_item],
      'condition'   => [
        'accordion_templates' => '',
      ],
    ]
  );
}

// General Styles Default Accordion
function get_general_style_accordion_with_counter($controls)
{
  $controls->add_responsive_control(
    'tab_margin',
    [
      'label'      => esc_html__('Margin', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .accordion-with-counter-tabs-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_padding',
    [
      'label'      => esc_html__('Padding', 'responsive-tabs-for-elementor'),
      'type'       => Controls_Manager::DIMENSIONS,
      'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
      'selectors'  => [
        '{{WRAPPER}} .accordion-with-counter-tabs-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Background::get_type(),
    [
      'name'           => 'background',
      'types'          => ['classic', 'gradient'],
      'fields_options' => [
        'background' => [
          'label' => 'Tabs Background',
        ],
      ],
      'selector'       => '{{WRAPPER}} .accordion-with-counter-tabs-block',
      'condition'      => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_position',
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_box'     => 'flex-direction: {{VALUE}}',
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label'   => 'flex-direction: {{VALUE}}',
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_counter' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_height',
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
        "{{WRAPPER}} .accordion-with-counter-format-container" => 'height: {{SIZE}}{{UNIT}};',
      ],
      'condition'  => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_space',
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_box' => 'gap: {{SIZE}}{{UNIT}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );
}

// Tab Styles Default Accordion
function get_tab_style_accordion_with_counter($controls)
{
  $controls->add_responsive_control(
    'tab_name_position',
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_alignment',
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => 'justify-content: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_title_stroke',
    [
      'label'     => esc_html__('Stroke', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'range'     => [
        'px' => [
          'min' => 0,
          'max' => 5,
        ],
      ],
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => '-webkit-text-stroke-width: {{SIZE}}{{UNIT}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_title_stroke_color',
    [
      'label'     => esc_html__('Stroke Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => '-webkit-text-stroke-color: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_title_space',
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => 'gap: {{SIZE}}{{UNIT}}',
      ],
      'separator' => 'before',
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->start_controls_tabs('tab_name_style', [
    'condition' => [
      'accordion_templates' => '',
    ],
  ]);

  $controls->start_controls_tab(
    'tab_name_normal',
    [
      'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'tab_name_color',
    [
      'label'     => esc_html__('Name Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'tab_name_typography',
      'label'    => esc_html__('Name Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_label',
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'tab_name_active',
    [
      'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'active_tab_name_color',
    [
      'label'     => esc_html__('Name Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:checked+label' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'active_tab_name_typography',
      'label'    => esc_html__('Name Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:checked+label',
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_tabs();
}

// Counter And Divider Styles Default Accordion
function get_counter_divider_style_accordion_with_counter($controls)
{
  $controls->start_controls_tabs('tab_counter_style', [
    'condition' => [
      'accordion_templates' => '',
    ],
  ]);

  $controls->start_controls_tab(
    'tab_counter_normal',
    [
      'label' => esc_html__('Normal', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'tab_counter_color',
    [
      'label'     => esc_html__('Counter Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_counter' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'tab_counter_typography',
      'label'    => esc_html__('Counter Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_counter',
    ]
  );

  $controls->end_controls_tab();

  $controls->start_controls_tab(
    'tab_counter_active',
    [
      'label' => esc_html__('Active', 'responsive-tabs-for-elementor'),
    ]
  );

  $controls->add_control(
    'active_tab_counter_color',
    [
      'label'     => esc_html__('Counter Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_counter' => 'color: {{VALUE}}',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'     => 'active_tab_counter_typography',
      'label'    => esc_html__('Counter Typography', 'responsive-tabs-for-elementor'),
      'selector' => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_counter',
    ]
  );

  $controls->end_controls_tab();
  $controls->end_controls_tabs();

  $controls->add_control(
    'tab_divider_color',
    [
      'label'     => esc_html__('Divider Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_dash' => 'background-color: {{VALUE}}',
      ],
      'separator' => 'before',
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_divider_width',
    [
      'label'     => esc_html__('Divider Size', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::SLIDER,
      'range'     => [
        'px' => [
          'min' => 10,
          'max' => 30,
        ],
      ],
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:hover + label .accordion-with-counter-tabs_dash'   => 'width: {{SIZE}}{{UNIT}}',
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_input:checked + label .accordion-with-counter-tabs_dash' => 'width: {{SIZE}}{{UNIT}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'tab_divider_position',
    [
      'label'     => esc_html__('Divider Position', 'responsive-tabs-for-elementor'),
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_counter' => 'flex-direction: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );
}

// Content Styles Default Accordion
function get_content_style_accordion_with_counter($controls)
{
  $controls->add_control(
    'title_content_color',
    [
      'label'     => esc_html__('Title Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_title' => 'color: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'title_content_typography',
      'label'     => esc_html__('Title Typography', 'responsive-tabs-for-elementor'),
      'selector'  => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_title',
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
    'title_content_align',
    [
      'label'     => esc_html__('Alignment Title', 'responsive-tabs-for-elementor'),
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_title' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_control(
    'content_color',
    [
      'label'     => esc_html__('Content Color', 'responsive-tabs-for-elementor'),
      'type'      => Controls_Manager::COLOR,
      'selectors' => [
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_discr' => 'color: {{VALUE}}',
      ],
      'separator' => 'before',
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_group_control(
    Group_Control_Typography::get_type(),
    [
      'name'      => 'content_typography',
      'label'     => esc_html__('Content Typography', 'responsive-tabs-for-elementor'),
      'selector'  => '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_discr',
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );

  $controls->add_responsive_control(
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
        '{{WRAPPER}} .accordion-with-counter .accordion-with-counter-tabs_discr' => 'text-align: {{VALUE}}',
      ],
      'condition' => [
        'accordion_templates' => '',
      ],
    ]
  );
}
