<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', "u288807094_8ilUA" );

/** Database username */
define( 'DB_USER', "u288807094_dvqs3" );

/** Database password */
define( 'DB_PASSWORD', "QZU7RcEzc4" );

/** Database hostname */
define( 'DB_HOST', "127.0.0.1" );

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
define( 'AUTH_KEY',         'km1qle8g7n7xtswlsmgxswccw3n174fhftcufvsyuibdasbd7h8ijrch4flic1m5' );
define( 'SECURE_AUTH_KEY',  'olqw4swp48ayfm4rkzv7chdc0lyotlzvws1gtzlnwipqhecfhgkl5p7zhagemczp' );
define( 'LOGGED_IN_KEY',    'l1wvlzpcxrnhzaa3crrtmotyvsnk1hix5nn9pacl3x2jisxqgafzuprktzgmsz2u' );
define( 'NONCE_KEY',        'qylnjdowiscp2ft5pdrsdqk8x8zm796tirph6m95gyynxhijcimgr3il2kzdyvig' );
define( 'AUTH_SALT',        'bu8ivjoyoglctx9lattghlfyb6k5fijc2rdv3jnsctdfsgxfnkafs2tyyblzwzem' );
define( 'SECURE_AUTH_SALT', 'tiyrunjcm8o2uekclrc9zyft5zot0tidf90y8t7xbqkwun7bn3ciavxw4wcmozcx' );
define( 'LOGGED_IN_SALT',   'brvk18qtcj2mur84hvfyrm6kvxxwjeczhinfp4opmzi53sycfn2hdpb3cryqlr4a' );
define( 'NONCE_SALT',       'oeno3muxfgmrxrhbubrghq6qhnjxygz9qiksjvkb2jbep4k1ktqjoff5nncqffut' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp5k_';

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



define( 'DUPLICATOR_AUTH_KEY', '.Y3KK&X?)?9Hp{x|fIV) <DyC^}I5Bi=ppcV7 P!yHUFR}F*MS^{L6G#O|c@l1]W' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
