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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'UWLy^M96uj/dQ#5RJ~aPC<M)A-Cz_{`<RWzN>{u1D:ObSi@Hhz)^2)nrraCf?Oou' );
define( 'SECURE_AUTH_KEY',  'k$oZN@)@t.=N)tx)jLf7B0@M[j;1e0jotSG]bnr0<%LhIYm>?72.s5Yv%P+FqH3G' );
define( 'LOGGED_IN_KEY',    'uRrV:<)QLH+~HwX&]VPgZ[`ld+=$8tv}CClG$gzxHY2B?K?Vqz;K1^0?s^L9<:qS' );
define( 'NONCE_KEY',        'o G-rz#IeeK!tX[y?cUq$]IvSF4AN@N4n2z$Y?)$=;%Mz?s{pn:J|*!sjsGzz&b1' );
define( 'AUTH_SALT',        '4]:<p|}lP$spnI1iTk/81`{w3D|TR2yIV5(7-Jq>KNG;LpO$?&~)j$U6#LtlFCY)' );
define( 'SECURE_AUTH_SALT', 'C_}`Bzb1LI.WVZ,>wx$D+gS8c|Rnum#3E|R,b`*(jr|4!PJ~NFDa[[<~yB).Ubr}' );
define( 'LOGGED_IN_SALT',   'dfga#6?]Fl&l(8,IQPb^N4OZt)kX{OI$9anJO&v[l}HS-`&@m_=$(Cfj#ed*t~f9' );
define( 'NONCE_SALT',       '%uZBs^I}b |D.1Cthy#O!9=#Jo9wNgX=^HmX!3Q+eW(q`f/Ngf>~RgKxOh4kUxi ' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
