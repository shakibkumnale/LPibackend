<?php
/**
 * Elementor Widget
 * @package Senatory
 * @since 1.0.0
 */

namespace Elementor;
class Senatory_Heading_Title_Widget extends Widget_Base
{

    /**
     * Get widget name.
     *
     * Retrieve Elementor widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'senatory-heading-title';
    }

    /**
     * Get widget title.
     *
     * Retrieve Elementor widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Heading Title: 01', 'senatory-master');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Elementor widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'bl_icon eicon-archive-title';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Elementor widget belongs to.
     *
     * @return array Widget categories.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_categories()
    {
        return ['senatory_widgets'];
    }

    /**
     * Register Elementor widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls()
    {

        $this->start_controls_section(
            'settings_heading',
            [
                'label' => esc_html__('General Settings', 'senatory-core'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control('sub_status',
            [
                'label' => esc_html__('Subtitle Show/Hide', 'senatory-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('show/hide Subtitle', 'senatory-core'),
                'default' => 'yes',
            ]);
        $this->add_control('icon_status',
            [
                'label' => esc_html__('Subtitle Icon Show/Hide', 'senatory-core'),
                'type' => Controls_Manager::SWITCHER,
                'description' => esc_html__('show/hide Subtitle icon', 'senatory-core'),
                'default' => 'yes',
            ]);

            $this->add_control(
                'icon_position',
                [
                    'label' => esc_html__( 'Icon Position', 'senatory-core' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'after',
                    'options' => [
                        'before'  => esc_html__( 'Before Subtitle', 'senatory-core' ),
                        'after' => esc_html__( 'After Subtitle', 'senatory-core' ),
                        'both' => esc_html__( 'Both Side', 'senatory-core' ),
                    ],
                    'condition' => [
                        'icon_status' => 'yes',
                    ],
                ]
            );
            $this->add_control(
                'icon_count',
                [
                    'label' => esc_html__( 'Icon Number', 'senatory-core' ),
                    'type' => Controls_Manager::SELECT,
                    'default' => '3',
                    'options' => [
                        '1'  => esc_html__( '1 Star', 'senatory-core' ),
                        '2'  => esc_html__( '2 Star', 'senatory-core' ),
                        '3'  => esc_html__( '3 Star', 'senatory-core' ),
                        '4'  => esc_html__( '4 Star', 'senatory-core' ),
                        '5'  => esc_html__( '5 Star', 'senatory-core' ),
                    ],
                    'condition' => [
                        'icon_status' => 'yes',
                    ],
                ]
            );
        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__('Subtitle', 'senatory-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Enter subtitle.', 'senatory-core'),
                'default' => esc_html__('About Us', 'senatory-core'),
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'senatory-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Enter title. Use {c}color text{/c} for color text', 'senatory-core'),
                'default' => esc_html__('Core level values and amazing team', 'senatory-core')
            ]
        );
        $this->add_control('desc_status',
        [
            'label' => esc_html__('Description Show/Hide', 'senatory-core'),
            'type' => Controls_Manager::SWITCHER,
            'description' => esc_html__('show/hide Subtitle icon', 'senatory-core'),
            'default' => 'yes',
        ]);
        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'senatory-core'),
                'type' => Controls_Manager::TEXTAREA,
                'description' => esc_html__('Enter  Description.', 'senatory-core'),
                'default' => esc_html__('Our mission is to create a society in which an informed and active citizenry is sovereign and makes policy decisions based on the will of the majority.', 'senatory-core'),
                'condition' => [
                    'desc_status' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'senatory-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'senatory-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'senatory-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'senatory-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'selectors' => [
                    "{{WRAPPER}} .theme-custom-titlebar .content" => "text-align: {{VALUE}}"
                ]
            ]
        );

        $this->end_controls_section();

        // STYLING TAB
        $this->start_controls_section(
            'styling_heading',
            [
                'label' => esc_html__('Styling Settings', 'senatory-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'sub_bottom_space',
            [
                'label' => esc_html__('Sub title Bottom Space', 'senatory-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .party-single-item .subtitle_wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_bottom_space',
            [
                'label' => esc_html__('Title Bottom Space', 'senatory-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .party-single-item .content .title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'desc_bottom_space',
            [
                'label' => esc_html__('Description Bottom Space', 'senatory-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .party-single-item .content .heading_description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control('title_color', [
            'label' => esc_html__('Title Color', 'senatory-core'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                "{{WRAPPER}} .theme-custom-titlebar .content .title" => "color: {{VALUE}}"
            ]
        ]);
        $this->add_control('title_extra_color', [
            'label' => esc_html__('Title Extra Color', 'yotta-core'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                "{{WRAPPER}} .theme-custom-titlebar .content .title span" => "color: {{VALUE}}"
            ]
        ]);
        $this->add_control('title_styling_divider', [
            'type' => Controls_Manager::DIVIDER
        ]);

        $this->add_control('subtitle_color', [
            'label' => esc_html__('Sub Title Color', 'senatory-core'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                "{{WRAPPER}} .theme-custom-titlebar .content .subtitle p" => "color: {{VALUE}}"
            ]
        ]);

        $this->add_control(
			'subtitle_padding',
			[
				'label' => esc_html__( 'Subtitle Padding', 'senatory-core' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .theme-custom-titlebar .subtitle_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'subtitle_bg',
				'label' => esc_html__( 'Background', 'senatory-core' ),
				'types' => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .subtitle_wrapper',
			]
		);
        $this->add_control('subtitle_styling_divider', [
            'type' => Controls_Manager::DIVIDER
        ]);

        $this->add_control('description_color', [
            'label' => esc_html__('Description Color', 'senatory-core'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                "{{WRAPPER}} .theme-custom-titlebar .content .heading_description" => "color: {{VALUE}}"
            ]
        ]);
        $this->add_control('icon_color', [
            'label' => esc_html__('Icon Color', 'senatory-core'),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                "{{WRAPPER}} .theme-custom-titlebar .content .subtitle .icon i" => "color: {{VALUE}}"
            ]
        ]);
		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'senatory-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 12,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 12,
				],
				'selectors' => [
					'{{WRAPPER}} .theme-custom-titlebar .content .subtitle .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'styling_typogrpahy_heading',
            [
                'label' => esc_html__('Typography Settings', 'senatory-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'senatory-core'),
            'selector' => "{{WRAPPER}} .theme-custom-titlebar .content .title"
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'title_extra_typography',
            'label' => esc_html__('Title Extra Typography', 'senatory-core'),
            'selector' => "{{WRAPPER}} .theme-custom-titlebar .content .title span"
        ]);

        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'subtitle_typography',
            'label' => esc_html__('Subtitle Typography', 'senatory-core'),
            'selector' => "{{WRAPPER}} .theme-custom-titlebar .content .subtitle p"
        ]);
        $this->add_group_control(Group_Control_Typography::get_type(), [
            'name' => 'description_typography',
            'label' => esc_html__('Description Typography', 'senatory-core'),
            'selector' => "{{WRAPPER}} .theme-custom-titlebar .content .heading_description"
        ]);

        $this->end_controls_section();


    }

    /**
     * Render Elementor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
    
        ?>
        <div class="party-single-item theme-custom-titlebar <?php echo esc_attr(('center' === $settings['alignment']) ? 'title-center' : ' '); ?> <?php echo esc_attr(('right' === $settings['alignment']) ? 'title-right' : ' '); ?> ">
            <div class="content">
                <?php if (!empty($settings['sub_status'])) : ?>
                    <div class="subtitle_wrapper">
                        <div class="subtitle custom_subtitle wow animate__animated animate__fadeInUp">
                            <?php if ($settings['icon_status'] === 'yes' && $settings['icon_position'] ==='before') : ?>
                            <div class="icon">
                                <?php 
                                    for($i = 0; $i < $settings['icon_count']; $i++ ){
                                        print('<i class="icomoon-star"></i>'); 
                                    }
                                ?>
                            </div>
                            <?php endif; ?>
                            <p><?php echo esc_html($settings['subtitle']) ?></p>
                            <?php if ($settings['icon_status'] === 'yes' && $settings['icon_position'] ==='after') : ?>
                                <div class="icon">
                                    <?php 
                                        for($i = 0; $i < $settings['icon_count']; $i++ ){
                                            print('<i class="icomoon-star"></i>'); 
                                        }
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <h4 class="title wow animate__animated animate__fadeInUp">
                    <?php
                        $title = str_replace(['{c}', '{/c}'], ['<span>', '</span>'], $settings['title']);
                        print wp_kses($title, senatory_core()->kses_allowed_html('all'));
                    ?>
                </h4>
                <?php if($settings['desc_status'] === 'yes'): ?>
                    <?php if (!empty($settings['description'])): ?>
                        <div class="heading_description"><?php echo wp_kses_post($settings['description']); ?></div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>


        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type(new Senatory_Heading_Title_Widget());