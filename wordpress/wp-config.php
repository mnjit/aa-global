<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'globalc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'US:rm6zDHRcD-O^6,9ZLZ(^Pr!sZ|v/9rTE.$LX0v|_V*M;$1Ji*JGSoeG*#IBM-');
define('SECURE_AUTH_KEY',  '+,<?3H*F=#P89;?x-bli3Qv.Yq_4dYh-Pwh`SXTHOLIPXBCh ]N3ixgJ=|@CvWOD');
define('LOGGED_IN_KEY',    '/bqFfPB7Rbn5t91[6{rIEf rI?W+5A1$AoJ@4Q0w-VX V&43~*][_}RtA-*TJ.&9');
define('NONCE_KEY',        '|6k)scg3cN9Ep^wGslOToHBt+gc&l#)W,2 z^.EsZb!|C}v3.0>Ac#P_l>za%l-K');
define('AUTH_SALT',        'Gv/toa<Th;M!TDOwV^y+*O6}=%P<VhG=`QF0L.zF=q{=BJJ6.W1o{ +o%5@p[/^2');
define('SECURE_AUTH_SALT', ')>j{5Xrst!;@<2h<PRAD?S}::mW8tGMR]MXY4o9b<-dmn=s0u9h|`f7a32!DP}Y}');
define('LOGGED_IN_SALT',   '`N+tJsk}xWl3)UR_*ox~|bg&N*Ge69SoRpu-B0v@sC8 8^EN&h,3vR+yffK[w_?e');
define('NONCE_SALT',       '% Guc}sNX%8[3Y8]R*}s=:Hq?>ni|6b0s%R]SprULBM}A~?6Klu f0=&:X+W-;%N');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
