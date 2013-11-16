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
define('DB_NAME', 'pcblog');

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
define('AUTH_KEY',         'k!{,#ttQ;TY_&I!T%Y{G_TVa%H!5nrN10#cmgpDnPvFV/fHHrsza9._9EKzp(/8:');
define('SECURE_AUTH_KEY',  ',H *~x6Rtp}DTo=-aG1]B6[FeKH|okS8_({u?d5Y|m-FNW@p7tqi1AL: +/7+f[:');
define('LOGGED_IN_KEY',    'l0gD9?r! Yb }r.j@{)rfqsS7`Y-`rfw^!wDf<|i8B_ OjN;LOy |.nF<sGLrws9');
define('NONCE_KEY',        '^sk:!%1?.@4uab;u!/a4qtB7`YSNcQs|CR;X>?,6wfD`7-xlg;h}]cT4:Q(XP(c-');
define('AUTH_SALT',        'N-)BtM_;qTO ?OSqh4PnE|BCZ^iMcy-0Q/`&8<iPUV2zuq$i?L7J=-A_f=[&?E7s');
define('SECURE_AUTH_SALT', 'xzW&]?][7tP3v3m+FvfY1I)ldA#c|6XzWAoo=zeyc10MC#~>M]-wWxsOUFx3B6|C');
define('LOGGED_IN_SALT',   'px{NV]v8#xlXQcsW#CR<.v^<t|4nSQ{~nSFyQE3z!;sp4K1u>(KyVuYB&$~q(ip8');
define('NONCE_SALT',       '/abCS;@Bd.84n( yAUR*lBM-#:lu:_/!St$L?E@vn;(z~44q-vY!wh+sR0..+sy[');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
