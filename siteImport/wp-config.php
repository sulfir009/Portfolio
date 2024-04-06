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
define( 'DB_NAME', 'brandgt1_wp403' );

/** Database username */
define( 'DB_USER', 'brandgt1_wp403' );

/** Database password */
define( 'DB_PASSWORD', 'p2I8XS]!c1' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'htfwpca3mjsznuzppmvrirtjmhvi4mnm0uawaqft2syy9wrceunhwejz4etskhkz' );
define( 'SECURE_AUTH_KEY',  'ipoulwhjtbucrjjpc7xcekc2ltmad1yj5xaqsxvhnmcbedygtezqysy9v9by9cjw' );
define( 'LOGGED_IN_KEY',    'odyx8wrb60nzq6u3ydalxymeca5abdhilgszu5yewrr4o8oal44s41imxbutrlkv' );
define( 'NONCE_KEY',        'jtyqvlr0tywihuybzahtawuvawemjljauxh8njzpeiqzfrzru4bevav0dm0jdabi' );
define( 'AUTH_SALT',        'bara2guwqiaibotpbijgk0tqtkye5qdj9oivo9iiahabb9w0bwdhvu7ftatxjsjl' );
define( 'SECURE_AUTH_SALT', 'bwrnbapb5zuli8be99n6bx8mp8juvrxk5p8tnzelegbbr1rrwquyigthozwn1fjr' );
define( 'LOGGED_IN_SALT',   'ixi2glqvd8sz8fqt9n1rgzjv1jformyonmgzbut1qtfxxbfqb2u8qguyh9hwpr0s' );
define( 'NONCE_SALT',       'ggyn3p8tuihhvxfbcyjoczgoepnhbvqwlttjptgqhhwnezcug6l8lro2242t56f3' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpet_';

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
