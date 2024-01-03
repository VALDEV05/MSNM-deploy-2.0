<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mnsm_2' );

/** Database username */
define( 'DB_USER', 'mamp' );

/** Database password */
define( 'DB_PASSWORD', '2diligence$' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'z7s^--icoS}~7LF7(|<aVMxt&R*@10Z2)mJ}0e??j7ICo!aX7=7Ik:c5 qIe,y0U' );
define( 'SECURE_AUTH_KEY',  'H9asN}D }.DK#{np<eOgM@]TgcHU5WP)i$i.)a0Q/YaUD)TetsiJEf%sO0+e<f >' );
define( 'LOGGED_IN_KEY',    'Ug4&pY309hNy2W}f^WO)n%]ER!/Lh9qIbZs hu~gAdK*OcswM!VHm/=JC7<%1k52' );
define( 'NONCE_KEY',        '5vN?2X0/N ZkZfQ-H8-itwC V8/eoE7q_@j4?*%7dgg}ED=%jB>Q1,19n!jA628G' );
define( 'AUTH_SALT',        ';BcNLq*N5/GdL+GNN}Oye;nhIRwIq?6R3>,NWLRLG[*gVT!|nU_BNG&tW8qpWp(|' );
define( 'SECURE_AUTH_SALT', 'Ro<fw{Nh3tqKh^s}X*hEhSmXzJa~-o_1HD-PP+37mS5I f-D*]t&)J_Gxk|fNOFJ' );
define( 'LOGGED_IN_SALT',   'Ql9~4Rjk{T>lK`KB??O2V|_xE!]g{-hUQpWy:|rZSD):E-om.() AwS1liP(Qn60' );
define( 'NONCE_SALT',       'P[QV,1CK&yi=v/20#5=VKoh#mCCv-FAWVW{:L2{)qn4^URD&GQaTc5kDY*p$MH<7' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
