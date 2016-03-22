<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'reedmer');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'P@ssW0rd');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'dW?{,0Z*iedei+Y[l(+pgal[I!o9#$gI8m3?-(+Cy7kWwg;Q|UeKG7#:SR>=(<j5');
define('SECURE_AUTH_KEY',  'U]4Kf-)lAl`.MvJXr-?c-Sbu7%P;dimF2Bt6z7D+c2RHf5u|WuXZSRX%-E9{e+bj');
define('LOGGED_IN_KEY',    '0{8[^X/_$qOp54^3+`tdEV}%W9pnv..isv4*CHEc[zn{4q]CF|*(SC}(,w@jQ0-/');
define('NONCE_KEY',        '}]zwbMi%)a*+[3JzyP]{arfpV$Pc1!}*)9XY8aC}Net=sE;9a>^t``A``KiDW1%u');
define('AUTH_SALT',        'k;OZb]M6zJ$?Xo2o`$N`)&+[T,2_7v.1F1:<x`+FLouFMuz@~_&gQruz?X`8H00c');
define('SECURE_AUTH_SALT', 'izf}8mJ2Hc,Do9J#S0F.nY s6inQ3e!cYK82&ow9X-%|!ZWIO<+];^<30j%R8ao-');
define('LOGGED_IN_SALT',   'M#!qaj G%t_Z#o^*6uT/;PILTfL8LNf}< w%!Jad;>]|d,hyq4*+:dE~_PVg}tgt');
define('NONCE_SALT',       '!gY|Ft4pYJ$C $J!lDD^+Yi7#ssH@SbG+|<0|l8<**rguNInmMCK3Ul%#0OQ#add');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'front_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
