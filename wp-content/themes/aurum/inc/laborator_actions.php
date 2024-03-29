<?php
/**
 *    Aurum WordPress Theme
 *
 *    Laborator.co
 *    www.laborator.co
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * After Setup Theme
 */
function aurum_after_setup_theme() {

	// Theme Support
	add_theme_support( 'menus' );

	add_theme_support( 'widgets' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'featured-image' );
	add_theme_support( 'title-tag' );

	// Add theme support for WooCommerce
	add_theme_support( 'woocommerce', array(
		'product_grid' => array(
			'default_rows' => 4,
			'min_rows'     => 1,
			'max_rows'     => 50,

			'default_columns' => 3,
			'min_columns'     => 1,
			'max_columns'     => 6,
		),
	) );

	add_theme_support( 'wc-product-gallery-slider' );

	if ( apply_filters( 'aurum_product_gallery_zoom_enable', true ) ) {
		add_theme_support( 'wc-product-gallery-zoom' );
	}

	if ( apply_filters( 'aurum_product_gallery_lightbox_enable', true ) ) {
		add_theme_support( 'wc-product-gallery-lightbox' );
	}

	// Theme Textdomain
	load_theme_textdomain( 'aurum', get_template_directory() . '/languages' );

	// Testimonials Post type
	register_post_type( 'testimonial',
		array(
			'labels'              => array(
				'name'          => __( 'Testimonials', 'aurum' ),
				'singular_name' => __( 'Testimonial', 'aurum' )
			),
			'public'              => true,
			'has_archive'         => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'menu_icon'           => 'dashicons-testimonial'
		)
	);

	// Register Menus
	register_nav_menus(
		array(
			'main-menu'      => 'Main Menu',
			'secondary-menu' => 'Secondary Menu',
			'mobile-menu'    => 'Mobile Menu',
		)
	);

	// Gallery Boxes
	new GalleryBox( 'post_slider_images', array( 'title' => 'Post Slider Images', 'post_types' => array( 'post' ) ) );
}

add_action( 'after_setup_theme', 'aurum_after_setup_theme' );

/**
 * Aurum init
 */
function aurum_init() {
	global $theme_version;

	$theme_obj     = wp_get_theme();
	$theme_version = $theme_obj->get( 'Version' );

	if ( is_child_theme() ) {
		$template_dir  = basename( get_template_directory() );
		$theme_obj     = wp_get_theme( $template_dir );
		$theme_version = $theme_obj->get( 'Version' );
	}

	// Styles
	wp_register_style( 'aurum-admin-css', aurum_assets_url() . '/css/admin/main.css', null, $theme_version );
	wp_register_style( 'bootstrap', aurum_assets_url() . '/css/bootstrap.css', null, $theme_version );
	wp_register_style( 'bootstrap-rtl', aurum_assets_url() . '/css/bootstrap-rtl.css', null, null );
	wp_register_style( 'aurum-main', aurum_assets_url() . '/css/aurum.css', null, $theme_version );

	wp_register_style( 'animate-css', aurum_assets_url() . '/css/animate.css', null, null );

	wp_register_style( 'icons-fontawesome', aurum_assets_url() . '/css/fonts/font-awesome/css/font-awesome.min.css', null, null );
	wp_register_style( 'icons-aurum', aurum_assets_url() . '/css/fonts/aurum-icons/font-icons.css', null, null );

	wp_register_style( 'style', get_template_directory_uri() . '/style.css', null, $theme_version );

	// Scripts
	wp_register_script( 'bootstrap', aurum_assets_url() . '/js/bootstrap.min.js', null, null, true );
	wp_register_script( 'tweenmax', aurum_assets_url() . '/js/gsap.min.js', null, null, true );
	wp_register_script( 'aurum-custom', aurum_assets_url() . '/js/aurum-custom.min.js', null, $theme_version, true );
	wp_register_script( 'aurum-contact', aurum_assets_url() . '/js/aurum-contact.min.js', null, $theme_version, true );

	// Admin Scripts
	wp_register_script( 'aurum-admin-js', aurum_assets_url() . '/js/admin/main.min.js', 'jquery', $theme_version, true );

	// Nivo Lightbox
	wp_register_script( 'nivo-lightbox', aurum_assets_url() . '/js/nivo-lightbox/nivo-lightbox.min.js', null, null, true );
	wp_register_style( 'nivo-lightbox', aurum_assets_url() . '/js/nivo-lightbox/nivo-lightbox.css', null, null );
	wp_register_style( 'nivo-lightbox-default', aurum_assets_url() . '/js/nivo-lightbox/themes/default/default.css', array( 'nivo-lightbox' ), null );

	// Slick
	wp_register_script( 'slick', aurum_assets_url() . '/js/slick/slick.min.js', null, $theme_version, true );
	wp_register_style( 'slick', aurum_assets_url() . '/js/slick/slick.css', null, $theme_version );
	wp_register_style( 'slick-theme', aurum_assets_url() . '/js/slick/slick-theme.css', array( 'slick' ), $theme_version );

	// Cycle 2
	wp_register_script( 'cycle-2', aurum_assets_url() . '/js/jquery.cycle2.min.js', null, null, true );

	// Isotope
	wp_register_script( 'aurum-isotope', aurum_assets_url() . '/js/isotope.pkgd.min.js', null, null, true );

	// Google Maps
	$google_api_key = aurum_get_google_api();
	wp_register_script( 'aurum-google-maps', 'https://maps.googleapis.com/maps/api/js?key=' . $google_api_key . '&callback=aurumInitializeMap', null, null, true );


	// Google API Key for ACF
	add_filter( 'acf/fields/google_map/api', 'aurum_google_api_key_acf', 10 );
}

add_action( 'init', 'aurum_init' );

/**
 * After switch theme.
 */
function aurum_after_switch_theme() {

	// WooCommerce options
	if ( class_exists( 'WooCommerce' ) ) {
		aurum_woocommerce_reset_thumbnail_sizes();
	}
}

add_action( 'after_switch_theme', 'aurum_after_switch_theme' );

/**
 * Setup post data for pages and archives
 */
function aurum_setup_postdata_for_pages() {
	setup_postdata( get_queried_object() );
}

add_action( 'template_redirect', 'aurum_setup_postdata_for_pages' );

/**
 * Get Google API Key
 */
function aurum_get_google_api() {
	return apply_filters( 'aurum_google_api_key', get_data( 'google_maps_api' ) );
}

/**
 * Get Google API Key Array for ACF
 */
function aurum_google_api_key_acf() {
	$api = array(
		'libraries' => 'places',
		'key'       => aurum_get_google_api(),
	);

	return $api;
}

/**
 * Enqueue Scripts and other stuff
 */
function aurum_wp_enqueue_scripts() {
	// Styles
	$rtl_include = '';

	wp_enqueue_style( 'icons-fontawesome' );
	wp_enqueue_style( 'icons-aurum' );
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'aurum-main' );

	if ( ! is_child_theme() ) {
		wp_enqueue_style( 'style' );
	}

	// Right to left bootstrap
	if ( is_rtl() ) {
		wp_enqueue_style( array( 'bootstrap-rtl' ) );
	}

	// Custom Skin
	if ( get_data( 'use_custom_skin' ) ) {
		if ( false == apply_filters( 'aurum_use_filebased_custom_skin', aurum_use_filebased_custom_skin() ) ) {
			wp_enqueue_style( 'custom-skin', site_url( '?custom-skin=1' ), null, null );
		}
	}

	// Scripts
	wp_enqueue_script( array( 'jquery', 'bootstrap', 'tweenmax' ) );
}

add_action( 'wp_enqueue_scripts', 'aurum_wp_enqueue_scripts' );

/**
 * Print scripts in the header
 */
function aurum_wp_print_scripts() {
	?>
    <script type="text/javascript">
		var ajaxurl = ajaxurl || '<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>';
    </script><?php
}

add_action( 'wp_print_scripts', 'aurum_wp_print_scripts' );

/**
 * Laborator Menu Page
 */
function laborator_menu_page() {
	add_menu_page( 'Laborator', 'Laborator', 'edit_theme_options', 'laborator_options', 'laborator_main_page', '', 2 );

	if ( lab_get( 'page' ) == 'laborator_options' ) {
		wp_redirect( admin_url( 'themes.php?page=theme-options' ) );
	}
}

function laborator_main_page() {
}

add_action( 'admin_menu', 'laborator_menu_page' );

/**
 * Redirect to Theme Options
 */
function laborator_options() {
	wp_redirect( admin_url( 'themes.php?page=theme-options' ) );
}

/**
 * Documentation Page iFrame
 */
function aurum_documentation_page() {
	include 'admin-tpls/page-theme-documentation.php';
}

function aurum_menu_documentation() {

	// Documentation Page
	add_submenu_page( 'laborator_options', 'Documentation', 'Theme Help', 'edit_theme_options', 'laborator_docs', 'aurum_documentation_page' );
}

add_action( 'admin_menu', 'aurum_menu_documentation', 100 );

/**
 * Admin Enqueue
 */
function aurum_admin_enqueue_scripts() {
	wp_enqueue_style( 'aurum-admin-css' );
	wp_enqueue_script( 'aurum-admin-js' );
}

add_action( 'admin_enqueue_scripts', 'aurum_admin_enqueue_scripts' );

/**
 * Admin Print Styles
 */
function aurum_admin_print_styles() {
	?>
    <style>

        #toplevel_page_laborator_options .wp-menu-image {
            background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon.png) no-repeat 11px 8px !important;
            background-size: 16px !important;
        }

        #toplevel_page_laborator_options .wp-menu-image:before {
            display: none;
        }

        #toplevel_page_laborator_options .wp-menu-image img {
            display: none;
        }

        #toplevel_page_laborator_options:hover .wp-menu-image, #toplevel_page_laborator_options.wp-has-current-submenu .wp-menu-image {
            background-position: 11px -24px !important;
        }

    </style>
	<?php
}

add_action( 'admin_print_styles', 'aurum_admin_print_styles' );

/**
 * Header actions
 */
function aurum_wp_head() {
	// Font style
	laborator_load_font_style();
}

add_action( 'wp_enqueue_scripts', 'aurum_wp_head' );

/**
 * Footer actions
 */
function aurum_wp_footer() {
	// Custom.js
	wp_enqueue_script( 'aurum-custom' );

	// Tracking Code
	echo get_data( 'google_analytics' );
}

add_action( 'wp_footer', 'aurum_wp_footer' );

/**
 * Fav Icon
 */
function aurum_favicon() {
	$favicon_image    = get_data( 'favicon_image' );
	$apple_touch_icon = get_data( 'apple_touch_icon' );

	if ( $favicon_image || $apple_touch_icon ) {
		$favicon_image    = str_replace( array( 'http:', 'https:' ), '', $favicon_image );
		$apple_touch_icon = str_replace( array( 'http:', 'https:' ), '', $apple_touch_icon );
		?>
        <!-- Favicons -->
		<?php if ( $favicon_image ) : ?>
            <link rel="shortcut icon" href="<?php echo $favicon_image; ?>">
		<?php endif; ?>
		<?php if ( $apple_touch_icon ) : ?>
            <link rel="apple-touch-icon" href="<?php echo esc_attr( $apple_touch_icon ); ?>">
            <link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_attr( $apple_touch_icon ); ?>">
		<?php endif; ?>
		<?php
	}
}

add_action( 'wp_head', 'aurum_favicon' );

/**
 * Widgets Init
 */
function aurum_widgets_init() {
	// Blog Sidebar
	$blog_sidebar = array(
		'id'   => 'blog_sidebar',
		'name' => 'Blog Widgets',

		'before_widget' => '<div class="widget sidebar-entry %2$s %1$s">',
		'after_widget'  => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title'  => '</h3>'
	);

	register_sidebar( $blog_sidebar );

	// Footer Sidebar
	$footer_sidebar_column = 'col-md-2 col-sm-4';

	switch ( get_data( 'footer_widgets_columns' ) ) {
		case 'two':
			$footer_sidebar_column = 'col-sm-6';
			break;

		case 'three':
			$footer_sidebar_column = 'col-sm-4';
			break;

		case 'four':
			$footer_sidebar_column = 'col-sm-3';
			break;
	}

	$footer_sidebar = array(
		'id'   => 'footer_sidebar',
		'name' => 'Footer Widgets',

		'before_widget' =>
			'<div class="' . $footer_sidebar_column . '">'
			. '<div class="widget sidebar %2$s %1$s">',

		'after_widget' =>
			'</div>' .
			'</div>',

		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	);

	register_sidebar( $footer_sidebar );

	// Shop Footer Sidebar
	$shop_footer_sidebar_column = 'col-md-2 col-sm-4';

	switch ( get_data( 'shop_sidebar_footer_columns' ) ) {
		case 2:
			$shop_footer_sidebar_column = 'col-sm-6';
			break;

		case 3:
			$shop_footer_sidebar_column = 'col-sm-4';
			break;

		case 4:
			$shop_footer_sidebar_column = 'col-md-3 col-sm-6';
			break;
	}

	$shop_footer_sidebar = array(
		'id'   => 'shop_footer_sidebar',
		'name' => 'Shop Footer Widgets',

		'before_widget' =>
			'<div class="' . $shop_footer_sidebar_column . '">'
			. '<div class="widget sidebar-entry %2$s %1$s">',

		'after_widget' =>
			'</div>' .
			'</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title'  => '</h3>'
	);

	register_sidebar( $shop_footer_sidebar );

	// Shop Sidebar
	$shop_sidebar = array(
		'id'   => 'shop_sidebar',
		'name' => 'Shop Widgets',

		'before_widget' => '<div class="widget sidebar-entry %2$s %1$s">',
		'after_widget'  => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title'  => '</h3>'
	);

	register_sidebar( $shop_sidebar );

	// Shop Single Sidebar
	$shop_single_sidebar = array(
		'id'          => 'shop_single_sidebar',
		'name'        => 'Shop Single Widgets',
		'description' => 'The Widgets you put here will be shown only when viewing single product page. If there are no widgets in here, "Shop Widgets" will be shown instead.',

		'before_widget' => '<div class="widget sidebar-entry %2$s %1$s">',
		'after_widget'  => '</div>',

		'before_title' => '<h3 class="sidebar-entry-title">',
		'after_title'  => '</h3>'
	);

	register_sidebar( $shop_single_sidebar );
}

add_action( 'widgets_init', 'aurum_widgets_init' );

/**
 * Contact Form
 */
function lab_req_contact_token() {
	$name    = post( 'name' );
	$subject = post( 'subject' );
	$email   = post( 'email' );
	$message = post( 'message' );

	$hash = md5( $name . $email . $message );

	$nonce = wp_create_nonce( 'cf_' . $hash );

	die( "{$hash}_{$nonce}" );
}

function lab_contact_form() {
	$resp = array( 'errors' => true );

	$id = post( 'id' );

	$name    = post( 'name' );
	$subject = post( 'subject' );
	$email   = post( 'email' );
	$phone   = post( 'phone' );
	$message = post( 'message' );

	$hash  = '';
	$nonce = '';

	foreach ( $_POST as $key => $val ) {
		if ( strlen( $key ) == 32 ) {
			$hash  = "cf_{$key}";
			$nonce = $val;
		}
	}

	if ( wp_verify_nonce( $nonce, $hash ) || defined( 'LAB_NO_CONTACT_TOKEN' ) ) {
		$admin_email = get_option( 'admin_email' );
		$ip          = $_SERVER['REMOTE_ADDR'];

		if ( $id ) {
			$custom_receiver = get_post_meta( $id, 'email_notifications', true );

			if ( is_email( $custom_receiver ) ) {
				$admin_email = $custom_receiver;
			}
		}

		$email_subject = "[" . get_bloginfo( 'name' ) . "] ";
		$email_subject .= __( 'New contact form message submitted.', 'aurum' );
		$email_subject = apply_filters( 'aurum_contact_subject', $email_subject, $name );


		$email_message = __( 'New message has been submitted on your website contact form. IP Address:', 'aurum' );

		$email_message .= " {$ip}\n\n=====\n\n";

		$fields = array( 'name', 'email', ( $phone ? 'phone' : '' ), 'subject', 'message' );
		$fields = array_filter( $fields );

		__( 'Name', 'aurum' );
		__( 'Email', 'aurum' );
		__( 'Phone', 'aurum' );
		__( 'Subject', 'aurum' );
		__( 'Message', 'aurum' );

		foreach ( $fields as $key ) {
			$val = post( $key );

			$field_label = isset( $field_names[ $key ] ) ? $field_names[ $key ] : ucfirst( $key );

			$email_message .= "{$field_label}:\n" . ( $val ? $val : '/' ) . "\n\n";
		}

		$email_message .= "=====\n\n";

		$email_message .= __( 'This email has been automatically sent from Contact Form.', 'aurum' );

		$headers = array();

		if ( $email ) {
			$headers[] = "Reply-To: {$name} <{$email}>";
		}

		wp_mail( $admin_email, $email_subject, $email_message, $headers );

		$resp['errors'] = false;
	}

	die( json_encode( $resp ) );
}

add_action( 'wp_ajax_lab_req_contact_token', 'lab_req_contact_token' );
add_action( 'wp_ajax_nopriv_lab_req_contact_token', 'lab_req_contact_token' );

add_action( 'wp_ajax_lab_contact_form', 'lab_contact_form' );
add_action( 'wp_ajax_nopriv_lab_contact_form', 'lab_contact_form' );

/**
 * WPBakery Page Builder Mapping
 */
function aurum_vc_mapping() {
	include_once get_template_directory() . '/inc/lib/visual-composer/map.php';
}

add_action( 'vc_before_mapping', 'aurum_vc_mapping' );

/**
 * Third party plugins
 */
function aurum_plugins() {
	$plugins = array(

		array(
			'name'     => 'Advanced Custom Fields PRO',
			'slug'     => 'advanced-custom-fields-pro',
			'source'   => get_template_directory() . '/inc/thirdparty-plugins/advanced-custom-fields-pro.zip',
			'required' => false,
			'version'  => '6.2.4',
		),

		array(
			'name'     => 'WPBakery Page Builder',
			'slug'     => 'js_composer',
			'source'   => get_template_directory() . '/inc/thirdparty-plugins/js_composer.zip',
			'required' => false,
			'version'  => '7.3',
		),

		array(
			'name'     => 'Layer Slider',
			'slug'     => 'LayerSlider',
			'source'   => get_template_directory() . '/inc/thirdparty-plugins/layersliderwp.zip',
			'required' => false,
			'version'  => '7.9.6',
		),

		array(
			'name'     => 'Slider Revolution',
			'slug'     => 'revslider',
			'source'   => get_template_directory() . '/inc/thirdparty-plugins/revslider.zip',
			'required' => false,
			'version'  => '6.6.18',
		),

		array(
			'name'     => 'Envato Market (Theme Updater)',
			'slug'     => 'envato-market',
			'source'   => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
			'required' => false
		),

		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => false,
		),
	);

	$plugins[] = array(
		'name'               => 'YITH WooCommerce Wishlist',
		'slug'               => 'yith-woocommerce-wishlist',
		'required'           => false,
		'version'            => '',
		'force_activation'   => false,
		'force_deactivation' => false,
	);

	$config = array(
		'default_path' => '',
		'menu'         => 'tgmpa-install-plugins',
		'has_notices'  => true,
		'dismissable'  => true,
		'dismiss_msg'  => '',
		'is_automatic' => false,
		'message'      => '',
	);

	tgmpa( $plugins, $config );

	// Fix issues with Update package not available
	add_filter( 'upgrader_pre_download', 'aurum_tgmpa_fix_bundled_sources', 1000, 3 );
}

add_action( 'tgmpa_register', 'aurum_plugins' );

/**
 * Fix TGMPA bundled sources
 */
function aurum_tgmpa_fix_bundled_sources( $return, $package, $upgrader ) {
	global $tgmpa;

	$skin = $upgrader->skin;

	// Make sure it is a plugin
	if ( $skin instanceof Plugin_Upgrader_Skin ) {
		$plugin_slug = dirname( $skin->plugin );

		if ( isset( $tgmpa->plugins[ $plugin_slug ] ) ) {
			$plugin = $tgmpa->plugins[ $plugin_slug ];

			if ( ! empty( $plugin['source'] ) && 'repo' !== $plugin['source'] ) {
				return $plugin['source'];
			}
		}
	}

	return $return;
}

/**
 * Update ACF Pro Message
 */
function aurum_acfpr_update_message() {
	global $tgmpa;

	if ( $tgmpa->does_plugin_require_update( 'advanced-custom-fields-pro' ) ) {
		echo '<br>&mdash;<br>This is theme bundled plugin and all updates are free of charge, you can install updates only on <a href="' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) . '">Appearance > Install Plugins</a>.';
	}
}

add_action( 'in_plugin_update_message-advanced-custom-fields-pro/acf.php', 'aurum_acfpr_update_message', 100 );

/**
 * Remove greensock from LayerSlider because it causes theme incompatibility issues
 */
function layerslider_remove_greensock() {
	wp_dequeue_script( array( 'greensock', 'layerslider-greensock' ) );
}

add_action( 'wp_enqueue_scripts', 'layerslider_remove_greensock' );

/**
 * Custom Skin
 */
if ( isset( $_GET['custom-skin'] ) ) {
	header( 'Content-type: text/css; charset: UTF-8' );
	echo get_option( 'aurum_skin_custom_css' );
	exit;
}

/**
 * Theme Options Link in Admin Bar
 */
function aurum_modify_admin_bar( $wp_admin_bar ) {
	list( $plugin_updates, $updates_notification ) = aurum_get_plugin_updates_requires();

	$icon = '<i class="wp-menu-image dashicons-before dashicons-admin-generic laborator-admin-bar-menu"></i>';

	$wp_admin_bar->add_menu( array(
		'id'    => 'laborator-options',
		'title' => $icon . wp_get_theme(),
		'href'  => is_admin() ? home_url() : admin_url( 'themes.php?page=theme-options' ),
		'meta'  => array( 'target' => is_admin() ? '_blank' : '_self' )
	) );

	$wp_admin_bar->add_menu( array(
		'parent' => 'laborator-options',
		'id'     => 'laborator-options-sub',
		'title'  => 'Theme Options',
		'href'   => admin_url( 'themes.php?page=theme-options' )
	) );

	if ( $plugin_updates > 0 ) {
		$wp_admin_bar->add_menu( array(
			'parent' => 'laborator-options',
			'id'     => 'install-plugins',
			'title'  => 'Update Plugins' . $updates_notification,
			'href'   => admin_url( 'themes.php?page=tgmpa-install-plugins' )
		) );
	}

	$wp_admin_bar->add_menu( array(
		'parent' => 'laborator-options',
		'id'     => 'laborator-custom-css',
		'title'  => 'Custom CSS',
		'href'   => admin_url( 'admin.php?page=laborator_custom_css' )
	) );

	$wp_admin_bar->add_menu( array(
		'parent' => 'laborator-options',
		'id'     => 'laborator-demo-content-importer',
		'title'  => 'Demo Content',
		'href'   => admin_url( 'admin.php?page=laborator_demo_content_installer' )
	) );

	$wp_admin_bar->add_menu( array(
		'parent' => 'laborator-options',
		'id'     => 'laborator-help',
		'title'  => 'Theme Help',
		'href'   => admin_url( 'admin.php?page=laborator_docs' )
	) );

	$wp_admin_bar->add_menu( array(
		'parent' => 'laborator-options',
		'id'     => 'laborator-themes',
		'title'  => 'Browse Our Themes',
		'href'   => 'https://1.envato.market/bgEJb',
		'meta'   => array( 'target' => '_blank' )
	) );
}

function aurum_get_plugin_updates_requires() {
	global $tgmpa;

	// Plugin Updates Notification
	$plugin_updates       = 0;
	$updates_notification = '';

	if ( $tgmpa instanceof TGM_Plugin_Activation && ! $tgmpa->is_tgmpa_complete() ) {
		// Plugins
		$plugins = $tgmpa->plugins;

		foreach ( $tgmpa->plugins as $slug => $plugin ) {
			if ( $tgmpa->is_plugin_active( $slug ) && true == $tgmpa->does_plugin_have_update( $slug ) ) {
				$plugin_updates ++;
			}
		}
	}

	if ( $plugin_updates > 0 ) {
		$updates_notification = " <span class=\"lab-update-badge\">{$plugin_updates}</span>";
	}

	return array( $plugin_updates, $updates_notification );
}

function aurum_mab_admin_print_styles() {
	?>
    <style>
    .laborator-admin-bar-menu {
        position: relative !important;
        display: inline-block;
        width: 16px !important;
        height: 16px !important;
        background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon.png) no-repeat 0px 0px !important;
        background-size: 16px !important;
        margin-right: 8px !important;
        top: 3px !important;
    }

    .rtl .laborator-admin-bar-menu {
        margin-right: 0 !important;
        margin-left: 8px !important;
    }

    #wp-admin-bar-laborator-options:hover .laborator-admin-bar-menu {
        background-position: 0 -32px !important;
    }

    .laborator-admin-bar-menu:before {
        display: none !important;
    }

    #toplevel_page_laborator_options .wp-menu-image {
        background: url(<?php echo get_template_directory_uri(); ?>/assets/images/laborator-icon.png) no-repeat 11px 8px !important;
        background-size: 16px !important;
    }

    #toplevel_page_laborator_options .wp-menu-image:before {
        display: none;
    }

    #toplevel_page_laborator_options .wp-menu-image img {
        display: none;
    }

    #toplevel_page_laborator_options:hover .wp-menu-image, #toplevel_page_laborator_options.wp-has-current-submenu .wp-menu-image {
        background-position: 11px -24px !important;
    }
    </style><?php
}

add_action( 'admin_bar_menu', 'aurum_modify_admin_bar', 10000 );
add_action( 'admin_print_styles', 'aurum_mab_admin_print_styles' );
add_action( 'wp_print_styles', 'aurum_mab_admin_print_styles' );

/**
 * Plugin Updates Admin Menu Link
 */
function aurum_menu_page_plugin_updates() {

	// Updates Notification
	list( $plugin_updates, $updates_notification ) = aurum_get_plugin_updates_requires();

	if ( $plugin_updates > 0 ) {
		add_submenu_page( 'laborator_options', 'Update Plugins', 'Update Plugins' . $updates_notification, 'edit_theme_options', 'tgmpa-install-plugins', 'laborator_null_function' );
	}
}

add_action( 'admin_menu', 'aurum_menu_page_plugin_updates' );

/**
 * Page Custom CSS
 */
function aurum_custom_page_css_wp() {
	if ( is_singular() ) {
		$page_custom_css = aurum_get_field( 'page_custom_css' );

		if ( trim( $page_custom_css ) ) {
			$post_id         = get_the_id();
			$page_custom_css = str_replace( '.post-ID', ".page-id-{$post_id}", $page_custom_css );

			define( 'PAGE_CUSTOM_CSS', $page_custom_css );
		}
	}
}

function aurum_custom_page_css() {
	if ( is_singular() && defined( 'PAGE_CUSTOM_CSS' ) ) {
		echo '<style>' . PAGE_CUSTOM_CSS . '</style>';
	}
}

add_action( 'template_redirect', 'aurum_custom_page_css_wp' );
add_action( 'get_footer', 'aurum_custom_page_css' );

/**
 * Open Graph Meta
 */
function aurum_wp_head_open_graph_meta() {
	global $post;

	// Only show if open graph meta is allowed
	if ( ! apply_filters( 'aurum_open_graph_meta', true ) ) {
		return;
	}

	// Do not show open graph meta on single posts
	if ( ! is_singular() ) {
		return;
	}

	$featured_image = $post_thumb_id = '';

	if ( has_post_thumbnail( $post->ID ) ) {
		$post_thumb_id  = get_post_thumbnail_id( $post->ID );
		$featured_image = wp_get_attachment_image_src( $post_thumb_id, 'original' );
	}

	// Excerpt, clean styles
	$excerpt = aurum_clean_excerpt( get_the_excerpt(), true );

	?>

    <meta property="og:type" content="article"/>
    <meta property="og:title" content="<?php echo esc_attr( get_the_title() ); ?>"/>
    <meta property="og:url" content="<?php echo esc_url( get_permalink() ); ?>"/>
    <meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>

	<?php if ( $excerpt ) : ?>
        <meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>"/>
	<?php endif; ?>

	<?php if ( is_array( $featured_image ) ) : ?>
        <meta property="og:image" content="<?php echo $featured_image[0]; ?>"/>
        <link itemprop="image" href="<?php echo $featured_image[0]; ?>"/>

		<?php if ( apply_filters( 'aurum_meta_google_thumbnail', true ) ) : $thumb = wp_get_attachment_image_src( $post_thumb_id, 'thumbnail' ); ?>
            <!--
<PageMap>
    <DataObject type="thumbnail">
        <Attribute name="src" value="<?php echo $thumb[0]; ?>"/>
        <Attribute name="width" value="<?php echo $thumb[1]; ?>"/>
        <Attribute name="height" value="<?php echo $thumb[2]; ?>"/>
    </DataObject>
</PageMap>
-->
		<?php endif; ?>

	<?php endif;
}

add_action( 'wp_head', 'aurum_wp_head_open_graph_meta', 5 );

/**
 * LayerSlider ready
 */
function layerslider_disable_autoupdates() {
	$GLOBALS['lsAutoUpdateBox'] = false;
}

add_action( 'layerslider_ready', 'layerslider_disable_autoupdates' );

/**
 * Search page filter by post type
 */
function aurum_search_page_filter_by_post_type( $query ) {
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
		return;
	}

	if ( $query->is_main_query() && $query->is_search() ) {
		$search_results_count = get_data( 'search_results_count' );

		if ( ! is_numeric( $search_results_count ) || $search_results_count < 1 ) {
			$search_results_count = 10;
		}

		$query->set( 'posts_per_page', apply_filters( 'laborator_search_results_count', $search_results_count ) );

		if ( isset( $_GET['type'] ) ) {
			$post_type = sanitize_title_for_query( $_GET['type'] );
			$query->set( 'post_type', $post_type );
		}
	}
}

add_action( 'pre_get_posts', 'aurum_search_page_filter_by_post_type', 100 );

/**
 * Check if page is fullwidth
 */
function aurum_check_fullwidth_page() {
	global $post;

	if ( $post && $post->post_type == 'page' ) {
		$is_fullwidth = false;

		if ( in_array( $post->page_template, array( 'full-width-page.php' ) ) ) {
			$is_fullwidth = true;
		} elseif ( aurum_get_field( 'fullwidth_page' ) ) {
			$is_fullwidth = true;
		}

		if ( $is_fullwidth ) {
			define( 'IS_FULLWIDTH_PAGE', true );
		}
	}
}

add_action( 'wp', 'aurum_check_fullwidth_page' );

/**
 * Slick indicator on mobile
 */
function aurum_slick_carousel_mobile_indicator() {

	?>
    <script>
		jQuery( document ).ready( function ( $ ) {
			$.debounce( 200, function () {
				$( '.slick-initialized' ).each( function ( i, slick ) {
					if ( slick.slick.slideCount > 1 ) {
						var watcher = scrollMonitor.create( slick, - jQuery( slick ).height() * - 0.7 );
						watcher.enterViewport( function () {
							$( slick ).addClass( 'slick-swipe-sample' );
							watcher.destroy();
						} );
					}
				} );
			} )
		} );
    </script>
	<?php
}

add_action( 'wp_footer', 'aurum_slick_carousel_mobile_indicator', 1000 );

/**
 * Go to top
 */
function aurum_go_to_top_link() {

	if ( get_data( 'go_to_top' ) ) {

		$offset      = get_data( 'go_to_top_offset' );
		$button_type = get_data( 'go_to_top_button_type' );
		$alignment   = get_data( 'go_to_top_alignment' );

		// Offset type
		$type = 'pixels';

		if ( strpos( $offset, '%' ) ) {
			$type = 'percentage';
		} else if ( 'footer' == trim( strtolower( $offset ) ) ) {
			$type = 'footer';
		}

		// Classes
		$classes = array( 'go-to-top' );

		$classes[] = 'go-to-top--' . $alignment;

		if ( 'circle' == $button_type ) {
			$classes[] = 'go-to-top--rounded';
		}

		?>
    <a <?php aurum_class_attr( $classes ); ?> href="#top" data-offset-type="<?php echo $type; ?>" data-offset-value="<?php echo 'footer' != $offset ? intval( $offset ) : esc_attr( $offset ); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z"/>
            </svg>
        </a><?php

	}
}

add_action( 'wp_footer', 'aurum_go_to_top_link', 100 );

/**
 * Slider Revolution affiliate.
 */
function aurum_revslider_affiliate_link() {
	?>
	<script>
		/**
		 * Setup revolution slider affiliate link.
		 */
		jQuery( document ).on( 'mousedown', [
			'.lilabuybutton',
			'.wp-list-table [data-plugin="revslider/revslider.php"] .plugin-version-author-uri a',
			'.wp-list-table [data-slug="slider-revolution"] .go_premium a',
			'#rbm_activate_slider .dcenter a[target="_blank"]',
			'.dr_warningbox .mcg_quit_page',
			'#revslider_premium_link',
		].join( ', ' ), function( ev ) {
			ev.preventDefault();

			window.open( 'https://themepunch.pxf.io/J5997' );
		} );
	</script>
	<?php
}

add_action( 'admin_footer', 'aurum_revslider_affiliate_link' );

/**
 * WooCommerce 3.3 migration
 */
if ( class_exists( 'WC' ) && version_compare( WC()->version, '3.3', '>=' ) && false == get_option( 'aurum_woocommerce_3_3_transfer_image_sizes', false ) ) {

	function _get_aspect_ratio( $a, $b ) {
		// sanity check
		if ( $a <= 0 || $b <= 0 ) {
			return array( 0, 0 );
		}
		$total = $a + $b;
		for ( $i = 1; $i <= 40; $i ++ ) {
			$arx = $i * 1.0 * $a / $total;
			$brx = $i * 1.0 * $b / $total;
			if ( $i == 40 || ( abs( $arx - round( $arx ) ) <= 0.02 && abs( $brx - round( $brx ) ) <= 0.02 ) ) {
				// Accept aspect ratios within a given tolerance
				return array( round( $arx ), round( $brx ) );
			}
		}
	}

	function aurum_woocommerce_3_3_transfer_image_sizes() {

		// Whether to resize or not
		$do_resize = false;

		// WooCommerce Thumbnail
		if ( ( $shop_catalog_image_size = get_theme_mod( 'shop_catalog_image_size' ) ) ) {

			// {width}x{height} format
			if ( preg_match( '#^(?<width>[0-9]+)x(?<height>[0-9]+)(x(?<cropped>0|1))?$#', $shop_catalog_image_size, $shop_catalog_image_size_matches ) ) {
				$width    = $shop_catalog_image_size_matches['width'];
				$height   = $shop_catalog_image_size_matches['height'];
				$cropping = ! isset( $shop_catalog_image_size_matches['cropped'] ) || $shop_catalog_image_size_matches['cropped'];

				$ratio = _get_aspect_ratio( $width, $height );

				update_option( 'woocommerce_thumbnail_cropping', $cropping ? 'custom' : 'uncropped' );
				update_option( 'woocommerce_thumbnail_cropping_custom_width', $ratio[0] );
				update_option( 'woocommerce_thumbnail_cropping_custom_height', $ratio[1] );

				$do_resize = true;
			} // Crop width only
			else if ( is_numeric( $shop_catalog_image_size ) ) {
				update_option( 'woocommerce_thumbnail_cropping', 'uncropped' );
				update_option( 'woocommerce_thumbnail_cropping_custom_width', $shop_catalog_image_size );

				$do_resize = true;
			}
		}

		// Single image
		if ( ( $shop_single_image_size = get_theme_mod( 'shop_single_image_size' ) ) ) {

			if ( preg_match( '#^(?<width>[0-9]+)(x(?<height>[0-9]+))?(x(?<cropped>0|1))?$#', $shop_single_image_size, $shop_single_image_size_matches ) ) {
				update_option( 'woocommerce_single_image_width', $shop_single_image_size_matches['width'] );

				$do_resize = true;
			}
		}

		// Request image regeneration
		if ( $do_resize && class_exists( 'WC_Regenerate_Images' ) ) {
			WC_Regenerate_Images::queue_image_regeneration();
		}

		// Lightbox has moved
		set_theme_mod( 'shop_single_lightbox', ! get_theme_mod( 'shop_single_lightbox_disable', false ) );


		// WooCommerce columns
		$shop_product_columns = get_data( 'shop_product_columns' );

		update_option( 'woocommerce_catalog_columns', aurum_get_number_from_word( 'decide' == $shop_product_columns ? 4 : $shop_product_columns ) );

		if ( preg_match( '#[0-9]+#', get_data( 'shop_products_per_page' ), $matches ) ) {
			update_option( 'woocommerce_catalog_rows', $matches[0] );
		}

		// Run this once
		update_option( 'aurum_woocommerce_3_3_transfer_image_sizes', true );
	}

	add_action( 'woocommerce_init', 'aurum_woocommerce_3_3_transfer_image_sizes' );
}

/**
 * Warn users to install ACF5 Pro
 *
 * @type action
 */
function aurum_acf5_warning_init() {
	$is_using_acf4 = function_exists( 'acf' ) ? version_compare( acf()->version, '4.4.12', '<=' ) : false;

	if ( $is_using_acf4 && 'aurum-install-plugins' !== lab_get( 'page' ) ) {
		add_action( 'admin_notices', 'aurum_acf5_warning_display', 1000 );

		// Plugin disable and enable
		if ( post( 'aurum_acf4_deactivate' ) && current_user_can( 'manage_options' ) ) {
			$acf4_plugin = 'advanced-custom-fields/acf.php';
			deactivate_plugins( array(
				$acf4_plugin,
				'acf-flexible-content/acf-flexible-content.php',
				'acf-gallery/acf-gallery.php',
				'acf-repeater/acf-repeater.php',
			) );
			die( did_action( "deactivate_{$acf4_plugin}" ) ? '1' : '-1' );
		}
	}

	// Activate ACF5 Pro
	if ( post( 'aurum_acf5_activate' ) && current_user_can( 'manage_options' ) ) {
		$acf5_plugin = 'advanced-custom-fields-pro/acf.php';
		$all_plugins = apply_filters( 'all_plugins', get_plugins() );
		$success     = - 1;

		// Install and activate the plugin
		if ( ! isset( $all_plugins[ $acf5_plugin ] ) ) {

			if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
				require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			}

			// Plugin file
			$download_url = TGM_Plugin_Activation::get_instance()->get_download_url( 'advanced-custom-fields-pro' );

			$skin_args = array(
				'type'   => 'upload',
				'title'  => "ACF Pro",
				'url'    => '',
				'nonce'  => 'install-plugin_advanced-custom-fields-pro',
				'plugin' => '',
				'api'    => '',
				'extra'  => array(),
			);

			$skin = new Plugin_Installer_Skin( $skin_args );

			// Create a new instance of Plugin_Upgrader.
			$upgrader = new Plugin_Upgrader( $skin );
			$upgrader->install( $download_url );
			$success = 1;

			// Update list of activated plugins
			$all_plugins = apply_filters( 'all_plugins', get_plugins() );
		}

		// Plugin exists, simply activate it
		if ( isset( $all_plugins[ $acf5_plugin ] ) ) {
			activate_plugins( $acf5_plugin );
			if ( did_action( 'activated_plugin' ) ) {
				$success = 1;
			}
		}

		die( (string) $success );
	}
}

function aurum_acf5_warning_display() {
	$install_button = '<button type="button" class="button" id="aurum-acf5-pro-install-button"><i class="loading"></i> Deactivate ACF4 &amp; Install ACF5 Pro</button>';
	$acf_warning    = sprintf( 'You are currently using <strong>Advanced Custom Fields &ndash; %s</strong> which will not be supported in the upcoming updates of Aurum!<br><br>Please install and activate <strong>Advanced Custom Fields 5 (Pro)</strong> plugin which is bundled with the theme <em>(free of charge)</em> either by installing from <a href="%s">Appearance &gt; Install Plugins</a> or clicking the button below which will deactivate previous version and install/activate ACF5 Pro automatically: <br><br>%s<br><br><em>Note: ACF4 and its addons will not be deleted (<a href="https://d.pr/i/RbEchZ" target="_blank">see here</a>), however we recommend you to delete them after installing ACF5 Pro.</em>', acf()->version, esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ), $install_button );

	?>
    <div class="laborator-notice notice notice-warning">
		<?php echo wpautop( $acf_warning ); ?>
    </div>
	<?php
}

add_action( 'admin_init', 'aurum_acf5_warning_init', 10 );

/**
 * Heading font text transformation.
 */
function aurum_heading_font_text_transform() {
	$text_transform = get_data( 'custom_heading_font_transform' );

	if ( in_array( $text_transform, [ 'none', 'uppercase', 'lowercase', 'capitalize' ] ) ) {

		?>
        <style>
            h1, h2, h3, h4, h5, h6,
            .up,
            .to-uppercase,
            .breadcrumb,
            .tooltip-inner,
            .header-menu .lab-mini-cart .cart_list li .product-details a span,
            .header-menu .lab-mini-cart .cart_list li .product-details .quantity,
            .header-menu .lab-mini-cart .total,
            header.site-header ul.nav li a,
            header.site-header div.nav > ul li a,
            header.mobile-menu div.mobile-menu > ul li,
            header.mobile-menu ul.mobile-menu li,
            .chosen-container .chosen-results li,
            .search .search-results-list .search-results li .post-details .meta,
            .sidebar .sidebar-entry.widget_shopping_cart .total strong,
            .top-menu--cart-totals,
            .top-menu--link,
            .top-menu--widget-current-date,
            .top-menu--widget-menu .menu li,
            .top-menu--widget-wpml-currency-switcher .wcml-dropdown,
            .top-menu--widget-wpml-language-switcher .wpml-ls-legacy-list-horizontal li a,
            .sidebar .sidebar-entry ul li,
            #yith-wcwl-popup-message,
            .shop-empty-cart-page .cart-empty-title p a,
            .header-menu .lab-mini-cart .cart_list li.empty,
            .search .search-header .tabs a,
            .banner .button_outer .button_inner .banner-content strong,
            .banner .button_outer .button_inner .banner-content span,
            .sidebar .sidebar-entry ul li,
            .page-container .wpb_content_element.lab_wpb_testimonials .testimonials-inner .testimonial-entry .testimonial-blockquote cite,
            .woocommerce #place_order,
            .woocommerce .coupon-form .coupon .woocommerce-error,
            .woocommerce .coupon-form .coupon .woocommerce-info,
            .woocommerce .coupon-form .coupon .woocommerce-message,
            .woocommerce .cross-sells .product-item .product-link .button,
            .woocommerce .products .product .item-info a[data-product_id].is-textual,
            .woocommerce .single-product .product-type-external .cart .single_add_to_cart_button,
            .woocommerce .summary form.cart .button,
            .woocommerce .woocommerce-cart-form table.wishlist_table tbody tr td.product-add-to-cart .button,
            .woocommerce .woocommerce-cart-form table.wishlist_table thead tr td.product-add-to-cart .button,
            .woocommerce .woocommerce-cart-form table.wishlist_table thead tr th,
            .woocommerce .woocommerce-order-details .order-again .button,
            .woocommerce-breadcrumb,
            .woocommerce .icon-button .title,
            .woocommerce .woocommerce-cart-form .shop_table td .name,
            .woocommerce .shop_attributes td,
            .woocommerce .shop_attributes th,
            .woocommerce .summary form.cart .variations .label,
            .woocommerce .summary form.cart .reset_variations,
            .woocommerce .woocommerce-cart-form .shop_table th,
            .woocommerce #order_review .shop_table tr td,
            .woocommerce #order_review .shop_table tr th,
            .woocommerce .cart_totals .shop_table tr td,
            .woocommerce .cart_totals .shop_table tr th,
            .woocommerce .woocommerce-MyAccount-links {
                text-transform: <?php echo $text_transform; ?>;
            }
        </style>
		<?php
	}
}

add_action( 'wp_head', 'aurum_heading_font_text_transform' );

/**
 * Theme demo file
 */
if ( file_exists( get_template_directory() . '/theme-demo/theme-demo.php' ) && is_readable( get_template_directory() . '/theme-demo/theme-demo.php' ) ) {
	require get_template_directory() . '/theme-demo/theme-demo.php';
}

/**
 * Frontend Edit modify admin bar link title
 *
 * @param WP_Admin_Bar $wp_admin_bar
 */
function aurum_admin_bar_button_frontend_edit( $wp_admin_bar ) {
	if ( $node = $wp_admin_bar->get_node( 'vc_inline-admin-bar-link' ) ) {
		$node->title = 'Edit Frontend';
		$wp_admin_bar->add_node( get_object_vars( $node ) );
	}
}

add_action( 'admin_bar_menu', 'aurum_admin_bar_button_frontend_edit', 1001 );

/**
 * Lazy load option for Single Image element.
 */
function _aurum_vc_image_lazyload_attr() {
	foreach ( [ 'vc_gallery', 'vc_single_image' ] as $shortcode ) {
		vc_add_param( $shortcode, [
			'type'        => 'checkbox',
			'heading'     => 'Lazy load',
			'param_name'  => 'lazy_load',
			'description' => 'Enable lazy loading for this image (only if browser supports this natively)',
			'value'       => [
				'Yes' => 'yes',
			],
		] );
	}
}

add_action( 'vc_after_init', '_aurum_vc_image_lazyload_attr' );

/**
 * Add lazy load attribute for image.
 *
 * @param $output
 * @param $object
 * @param $atts
 *
 * @return string
 */
function _aurum_vc_image_lazyload( $output, $object, $atts ) {

	// Single Image element with retina image checked option
	if ( in_array( $object->settings( 'base' ), [ 'vc_gallery', 'vc_single_image' ] ) ) {
		$lazy_load = isset( $atts['lazy_load'] ) && 'yes' === $atts['lazy_load'];

		if ( $lazy_load ) {
			return str_replace( '<img ', '<img loading="lazy" ', $output );
		}
	}

	return $output;
}

add_filter( 'vc_shortcode_output', '_aurum_vc_image_lazyload', 100, 3 );


/**
 * Set Include libraries globally to "Off" initially.
 *
 * @param array $settings
 *
 * @return array
 * @since 3.19
 */
function aurum_rs_get_global_settings( $settings ) {
	if ( ! is_array( $settings ) ) {
		$settings = [
			'allinclude' => false,
			'fontdownload' => 'preload',
		];
	}

	return $settings;
}

add_filter( 'rs_get_global_settings', 'aurum_rs_get_global_settings' );

/**
 * LayerSlider Conditional script loading.
 *
 * @since 3.19
 */
add_filter( 'ls_conditional_script_loading', '__return_true' );
