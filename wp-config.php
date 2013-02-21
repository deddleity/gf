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
define('DB_NAME', 'georgefa_wrdp1');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '|y9Qy!Cj5aceIER|psOHFp:Jv2q:^Q\`23dFW$q_H91*cqwyO@_$NqGaQ#JC|u$Qnbh0X\`zBrFi$B>G2');
define('SECURE_AUTH_KEY',  'hL^)@UMqSiD(<XVES>OlQs?P6$4F40R:jtMATunna7EtGeWG5S;kWDqF>Y6aL@Fo-AG');
define('LOGGED_IN_KEY',    '_/Ym#gQQemLp^ZTV?fS;)iY)L!=ZrMcF;YH4d_g~Wf-^DzO8Yx|SuG7T8S7JSD\`cmf@zF8oPEvJ');
define('NONCE_KEY',        '5E^)YPapOD>r_4G^@2o>q*I!\`/i$Ci4OyE8(Fla8dV-/o3QB46lVL6ij2w:~Oyb3BN~wk\`A**/v#yq3?/o*');
define('AUTH_SALT',        '5OkrE<ZRc(B8u=rsxnVF~^-Vl5_G(Z<8er1bBnA18=@9BjVntELg@v7<QO3|5P<');
define('SECURE_AUTH_SALT', 'Cnd/4a3nWIi?ua!KP:JL8XO3oz(GMu9mxqBPY<igV^ZZrt0lSiN?DJi:4*^U<|d4l|(fDja:~?R\`mF\`UL');
define('LOGGED_IN_SALT',   'oDzVe0Pye6~oZ5ma5sgoxFmXSG:n7Kq9GPt(d#WLN;KfTt3or7g$se$/2u*)9hnj');
define('NONCE_SALT',       '<~_>Pze;>C*aZTBIv4gr35=4PE8J8hoPoP>/ILu0Q;adh^*-RJNQoO-Z7EUIiK@*5@V<eJ/2#@X0(^E');

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

define('CONCATENATE_SCRIPTS', false );