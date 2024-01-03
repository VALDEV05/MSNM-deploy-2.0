<?php

/**
 *	Aurum WordPress Theme
 *
 *	Laborator.co
 *	www.laborator.co
 */

$header_sticky_menu = get_data('header_sticky_menu');
$header_type        = get_data('header_type');
$header_type        = $header_type ? $header_type : 1;

$has_secondary_menu = $header_type && has_nav_menu('secondary-menu');
?>
<header class="site-header">

	<?php get_template_part('tpls/header-top-bar'); ?>

	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="menu-left">
					<?php get_template_part('tpls/header-logo-secondary'); ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="menu-right">
					<div class="button-custom-acquista-biglietti button-only-text button-only-text_black">
						<a href="<?php echo the_field('header_button_acquista_i_biglietti', 'options'); ?>">
							<svg width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M24.6667 6C24.6667 8.94552 27.0545 11.3333 30 11.3333C32.9455 11.3333 35.3333 8.94552 35.3333 6C35.3333 3.05448 32.9455 0.666669 30 0.666669C27.0545 0.666669 24.6667 3.05448 24.6667 6ZM-8.74228e-08 7L30 7L30 5L8.74228e-08 5L-8.74228e-08 7Z" fill="#2B2B2B" />
							</svg>
							<div class="text">
								Acquista i biglietti
							</div>
						</a>
					</div>
					<div class="button-custom-acquista-biglietti button-only-text button-only-text_light button-only-text_magenta">
						<svg width="36" height="12" viewBox="0 0 36 12" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M24.6667 6C24.6667 8.94552 27.0545 11.3333 30 11.3333C32.9455 11.3333 35.3333 8.94552 35.3333 6C35.3333 3.05448 32.9455 0.666669 30 0.666669C27.0545 0.666669 24.6667 3.05448 24.6667 6ZM-8.74228e-08 7L30 7L30 5L8.74228e-08 5L-8.74228e-08 7Z" fill="#2B2B2B" />
						</svg>
						<div class="text">
							Prossimi appuntamenti
						</div>
					</div>
				</div>
				<div class="active-menu-full-page">
					<svg width="59" height="34" viewBox="0 0 59 34" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="8.5" y="33.5" width="7" height="50" rx="3.5" transform="rotate(-90 8.5 33.5)" fill="#161513" />
						<rect x="0.5" y="20.5" width="7" height="50" rx="3.5" transform="rotate(-90 0.5 20.5)" fill="#161513" />
						<rect x="8.5" y="7.5" width="7" height="50" rx="3.5" transform="rotate(-90 8.5 7.5)" fill="#161513" />
					</svg>

				</div>
				<div class="close-menu-full-page">
					<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M12.2513 0.193176L21.6573 14.2167L22.3413 15.7559L23.1964 14.2167L32.5169 0.193176H44.5737L29.0111 22.5111L44.8303 45H32.7735L23.1109 31.062L22.3413 29.6084L21.6573 31.062L12.0802 45H0.0234375L15.8426 22.7676L0.279965 0.193176H12.2513Z" fill="#161513" />
					</svg>

				</div>
			</div>
		</div>
	</div>

</header>

<?php

// Header Mobile
get_template_part('tpls/header-mobile');
