<?php

/**
 *	Aurum WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

/* Add bootstrap support to the Wordpress theme*/



function theme_add_bootstrap()
{
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '-child/bootstrap/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '-child/bootstrap/js/bootstrap.min.js', array(), true);
}

add_action('wp_enqueue_scripts', 'theme_add_bootstrap', 102);



// This function will enqueue style.css of child theme, feel free to add yours
function aurum_enqueue_child_theme_scripts()
{
    wp_enqueue_style('aurum-child', get_stylesheet_directory_uri() . '/custom-css/style.css');
}

add_action('wp_enqueue_scripts', 'aurum_enqueue_child_theme_scripts', 103);
add_action('wp_enqueue_scripts', 'add_my_script');
function add_my_script()
{
    wp_enqueue_script(
        'custom', // name your script so that you can attach other scripts and de-register, etc.
        get_template_directory_uri() . '-child/js/custom.js', // this is the location of your script file
        array('jquery') // this array lists the scripts upon which your script depends
    );
}



if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'    => 'Header Options Supply',
        'menu_title'    => 'Header Options',
        'menu_slug'     => 'header-options-supply',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    /* acf_add_options_sub_page(array(
        'page_title'    => 'Header First Logo',
        'menu_title'    => 'Header-first-logo',
        'parent_slug'   => 'header-options-supply',
    ));

    acf_add_options_sub_page(array(
        'page_title'    => 'Header Second Logo',
        'menu_title'    => 'header-second-logo',
        'parent_slug'   => 'header-options-supply',
    )); */

}
