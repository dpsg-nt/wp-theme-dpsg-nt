<?php

function dpsgnt_customize_register($wp_customize) {
    $wp_customize->add_section('dpsgnt_theme_options', array(
        'title' => 'DPSG-NT Theme Options',
        'description' => 'Theme specific options',
        'capability' => 'edit_theme_options'
    ));

    $wp_customize->add_setting('ga_tracking_id', array(
        'type' => 'theme_mod'
    ));
    $wp_customize->add_control('ga_tracking_id', array(
        'type' => 'text',
        'section' => 'dpsgnt_theme_options',
        'label' => 'GA Tracking ID',
        'description' => 'The Google Analytics tracking ID'
    ));

    $wp_customize->add_setting('google_calendar_api_key', array(
        'type' => 'theme_mod'
    ));
    $wp_customize->add_control('google_calendar_api_key', array(
        'type' => 'text',
        'section' => 'dpsgnt_theme_options',
        'label' => 'Google Calendar API key',
        'description' => 'The API key is used to access the calendar.'
    ));
}

add_action('customize_register', 'dpsgnt_customize_register');
