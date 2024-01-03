<?php
/**
 *    Aurum WordPress Theme
 *
 *    Laborator.co
 *    www.laborator.co
 */

/**
 * Checks if WPBakery is used as theme-plugin mode.
 *
 * @return bool
 */
function aurum_wpb_is_vc_theme_plugin_mode() {
	if ( function_exists( 'vc_license' ) && vc_license()->isActivated() ) {
		return false;
	}

	return get_option( 'aurum_wpb_theme_plugin_mode', true );
}

/**
 * Disable updater, our theme provides updates for this plugin.
 */
function aurum_wpb_disable_vc_updater() {
	vc_manager()->disableUpdater();
}

/**
 * Hide promo popups.
 */
function aurum_wpb_hide_promo_popups() {
	global $pagenow;

	if ( in_array( $pagenow, [ 'post.php', 'post-new.php' ], true ) ) {
		echo '<style>#vc_ui-helper-promo-popup {display: none !important;}</style>';
	}
}

/**
 * Hide AI icon from param type.
 *
 * @param string $output
 *
 * @return string
 */
function aurum_wpb_hide_vc_ai_icon( $output ) {
	return str_replace( 'class="vc_ui-icon-ai"', 'class="vc_ui-icon-ai hidden" style="display:none"', $output );
}

/**
 * Hide several VC notices.
 *
 * @param string $notices
 *
 * @return string
 */
function aurum_wpb_hide_vc_notices( $notices ) {
	try {
		$notices_arr  = is_string( $notices ) ? json_decode( $notices, true ) : $notices;
		$filter_words = [
			'sale',
			'black friday',
			'get license',
		];

		if ( is_array( $notices_arr ) ) {
			foreach ( $notices_arr as $i => $notice ) {
				$should_exclude = false;
				$fields_content = ( $notice['title'] ?? '' ) . ( $notice['button_text'] ?? '' );

				foreach ( $filter_words as $filter_word ) {
					if ( false !== stripos( $fields_content, $filter_word ) ) {
						$should_exclude = true;
					}
				}

				if ( $should_exclude ) {
					unset( $notices_arr[ $i ] );
				}
			}

			return wp_json_encode( $notices_arr );
		}
	} catch ( Exception $e ) {
	}

	return $notices;
}

/**
 * Aurum WPBakery setup.
 */
function aurum_wpb_setup() {
	require get_template_directory() . '/inc/lib/visual-composer/config.php';
	vc_set_default_editor_post_types( [ 'page' ] );
}

add_action( 'vc_before_init', 'aurum_wpb_setup' );

/**
 * Theme-plugin mode option.
 */
function aurum_wpb_vc_theme_plugin_mode_option() {
	if ( ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	$theme_plugin_mode_field_name = 'aurum_wpb_theme_plugin_mode';

	$field_callback = function () use ( $theme_plugin_mode_field_name ) {
		$checked = get_option( $theme_plugin_mode_field_name, true );

		if ( empty( $checked ) ) {
			$checked = false;
		}
		?>
        <label>
            <input type="checkbox"<?php checked( $checked ); ?> value="1"
                   id="<?php echo esc_attr( $theme_plugin_mode_field_name ); ?>"
                   name="<?php echo esc_attr( $theme_plugin_mode_field_name ); ?>">
			<?php esc_html_e( 'Enable', 'js_composer' ); ?>
        </label><br/>
        <p class="description indicator-hint">The theme automatically provides WPBakery plugin updates. If you hold a
            WPBakery license and intend to apply it to this site, please turn off this feature.</p>
		<?php
	};

	register_setting( 'wpb_js_composer_settings_general', $theme_plugin_mode_field_name, [
		'sanitize_callback' => function ( $state ) {
			return ! ! $state;
		}
	] );
	add_settings_field( $theme_plugin_mode_field_name, 'Theme plugin mode', $field_callback, 'vc_settings_general', 'wpb_js_composer_settings_general' );

	// Create option with default value
	add_option( 'aurum_wpb_theme_plugin_mode', true );
}

add_action( 'admin_init', 'aurum_wpb_vc_theme_plugin_mode_option', 0 );

if ( aurum_wpb_is_vc_theme_plugin_mode() ) {
	add_action( 'vc_before_init', 'vc_set_as_theme' );
	add_action( 'vc_before_init', 'aurum_wpb_disable_vc_updater' );
	add_action( 'admin_footer', 'aurum_wpb_hide_promo_popups' );
	add_filter( 'vc_single_param_edit_holder_output', 'aurum_wpb_hide_vc_ai_icon' );
	add_filter( 'transient_wpb_notice_list', 'aurum_wpb_hide_vc_notices' );
}
