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
define('DB_NAME', 'dealexport');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', '5xaD5YNttOj98FQXz9PXMWxAXudQxGcR7aP44SZFUA');

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
define('AUTH_KEY', 'v7Bdo70T3G4zkwUzAjEdzvQfwTKDC99WXJh7UiB3WSJNytcUrFjUY2tJq4J1haVw');
define('SECURE_AUTH_KEY', 'YBTH8jZNJtNyka9P8VDIl3CwlLrNEVr1u4d2a4wqOWyDpfU1QWO4co3dzR4b3cxx');
define('LOGGED_IN_KEY', 'x2tCzMobEK8FBT0byeFrTSsdZ5F4RZ8C0rsm1xpnmfskbeansjrAsiXw0Dm4tAjg');
define('NONCE_KEY', '0NJuvI0FS5vmZcFhbbrAm0Hw8cMFCNKMCbDBX7DJmc0sAa3G2eItm2CmG8HfDuS1');
define('AUTH_SALT', 'qlokxiwRBQSm7xiY0l6sn7hLKQxzz53MM3oiJQUH7HZi4GS2WiFR5MPffzHK8han');
define('SECURE_AUTH_SALT', 'npzty8TqJR16ssNF7AYVKVZYPYZH3WWaoaryEvGQhfNmGIozItvOVgE0TEjv7gFL');
define('LOGGED_IN_SALT', 'fjc2eaJS2ZX5aXrbBha9nMbeaxW8fWzz1dVusDgQBHJfks9DDnWeV8qZulYMd3pi');
define('NONCE_SALT', 'Ohl85NWRVgDC2CUD3W6CvpVEEEJhsONWhrCBWuGSPmDN68Hj8AEMZ2AzPnBmt11V');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
// $table_prefix  = 'wp_';
$table_prefix  = 'db_';
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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/** Force SSL for administrator and sign in pages */
//define('FORCE_SSL_ADMIN', true);


/** Limit Posts revisions */
define('AUTOSAVE_INTERVAL', 300 ); // seconds
define('WP_POST_REVISIONS', false );
define('WP_MEMORY_LIMIT', '2560M');

@ini_set( 'upload_max_filesize' , '128M' );
@ini_set( 'post_max_size', '128M');
@ini_set( 'memory_limit', '2560M' );