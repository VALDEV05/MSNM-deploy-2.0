<?php
/**
 *	Aurum WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

// This function will enqueue style.css of child theme, feel free to add yours
function aurum_enqueue_child_theme_scripts() {
	wp_enqueue_style( 'aurum-child', get_stylesheet_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'aurum_enqueue_child_theme_scripts', 100 );