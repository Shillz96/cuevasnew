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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',          'MP$j7.Q$nDX#Qw;]1UKkk>JTkGV-$Jk6{K^F##Mi<}Qf `WN<vIY_IR~6t ~~MT~' );
define( 'SECURE_AUTH_KEY',   '7~O]0&83O@32yn5:H5zflf}4z0K[Vy9zkZ{.$4Zcw_<c%hN97a3*tVvK#eT^FCgo' );
define( 'LOGGED_IN_KEY',     '&5A#$//Q50j)E{547wJFub@#u+ee}~=1hoTPgel0s/)=1ZKu:i8IrDtQB0fDi6yK' );
define( 'NONCE_KEY',         'oy1L^Co<!~SYvW{_R/DlZqX$>0l>%/X=-6} UgUf).=a4QLlVCF@Bz.YQiPn]e/3' );
define( 'AUTH_SALT',         'L& ,lvQf;0Pq2i53D*/<n2$DHsx;-|*O3oFF^fq8^7Mqt{O]*wF1Fc_=*U[>b)2s' );
define( 'SECURE_AUTH_SALT',  '(5hKLkrs}B&]=jl<wfNIWMB6 3kt_ADbN*H#xO%/w)lZTc =b50gE KB$2P>O{wY' );
define( 'LOGGED_IN_SALT',    '#(*j[2j72Y(DmB}e%dQKt4i?auWszrc4^gG`e+V.eO;bR qSAQ>Am#8C6ep)N]dh' );
define( 'NONCE_SALT',        '0E&6R}^]3HM{t[3C+UG(ux<%Iy5d0?kJo!uzZS!t Nb}peZ^|9 !8C>5B1o~+c|=' );
define( 'WP_CACHE_KEY_SALT', '5o3t<MVkoQy0yQwst[?^218H,q09gQa:9#4yv?Em&E54yFFK`[bY:l SkJLI)5P+' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
