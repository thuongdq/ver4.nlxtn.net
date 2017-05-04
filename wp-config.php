<?php
define('WP_CACHE', false); // Added by WP Rocket
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
define('DB_NAME', 'ver4.nlxtn.net');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('FS_METHOD', 'direct');
define('WP_DEBUG', true);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'U@tN|e[;-g C1gHw#gS/ e4g;0]-9V$:yJ(He[>7OZIK7WQ_I_c(~pTb!A>F0%Gy');
define('SECURE_AUTH_KEY',  'ZL4Xv1Co%-bBlfr^KjAYB+`9p}I6pv=qK+(p`33BdbC$~d!Z^E;e7E:? (Tz4-rz');
define('LOGGED_IN_KEY',    '^Fj-z_Y!F8F*Y~;xi,gNT*KX|<pw:sQQ-:2;{_6/~U>t]o#HO4h:Gr)BnAPUzjQs');
define('NONCE_KEY',        'BVMZNY&C$m}-tEK-i%S=6aad,;D87~bOX#?2+YEx6hZBU/%fW|4.r8|S!knf1(F5');
define('AUTH_SALT',        'R!5DLv]L=,NJC`b/.e!$3;9hy,_(Dz Wb$]T_k7a,-`>+@Ysdy{)!ve*$K`%8J)N');
define('SECURE_AUTH_SALT', ':7bZD8L9nNJCvYT11B^mc%GUbd`9>Z1p9o.uBX KE$qqAk7+W:$&NnGVr(6F!>y!');
define('LOGGED_IN_SALT',   '$NXXL$A#7P qr:-Y|&`?zm P=w Ae,^L%pP2M_Y2yI=9W9P,M;es2:,Y^bF(,P5/');
define('NONCE_SALT',       'qskT*i#S;(3x3/xg$fo:CBepAjE>UJ~o@}LH}(rQI_qB|jD]~xnX/<-nTSF%Z5,*');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
