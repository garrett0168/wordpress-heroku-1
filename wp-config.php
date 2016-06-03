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

// ** Heroku Postgres settings - from Heroku Environment ** //
$db = parse_url(getenv("DATABASE_URL"));

$wp_config = [
	'db_name' => trim($db["path"],"/"),
	'db_user' => $db["user"],
	'db_password' => $db["pass"],
	'db_host' => $db["host"],
	'db_ssl' => true,

	'auth_key' => getenv('AUTH_KEY'),
	'secure_auth_key' => getenv('SECURE_AUTH_KEY'),
	'logged_in_key' => getenv('LOGGED_IN_KEY'),
	'nonce_key' => getenv('NONCE_KEY'),
	'auth_salt' => getenv('AUTH_SALT'),
	'secure_auth_salt' => getenv('SECURE_AUTH_SALT'),
	'logged_in_salt' => getenv('LOGGED_IN_SALT'),
	'nonce_salt' => getenv('NONCE_SALT'),

	'wp_debug' => false,
	'wp_cache' => getenv('WP_CACHE') === 'false' ? false : true,
	'disallow_file_mods' => true,
	'force_ssl_admin' => true,
	'automatic_updater_disabled' => true,

	'wp_env' => getenv('WP_ENV') ?: 'production',
	'wp_config_env' => __DIR__ . '/config/env.php',
	'wp_config_local' => __DIR__ . '/config/local.php',
];

/* Settings for each environment */
if ( file_exists($wp_config['wp_config_local']) ) {
	require($wp_config['wp_config_local']);
} else {
	require($wp_config['wp_config_env']);
}

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', $wp_config['db_name']);

/** MySQL database username */
define('DB_USER', $wp_config['db_user']);

/** MySQL database password */
define('DB_PASSWORD', $wp_config['db_password']);

/** MySQL hostname */
define('DB_HOST', $wp_config['db_host']);

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/** MySQL options */
if ( $wp_config['db_ssl'] ) {
	define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_COMPRESS | MYSQLI_CLIENT_SSL);
} else {
	define('MYSQL_CLIENT_FLAGS', MYSQLI_CLIENT_COMPRESS);
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         $wp_config['auth_key']);
define('SECURE_AUTH_KEY',  $wp_config['secure_auth_key']);
define('LOGGED_IN_KEY',    $wp_config['logged_in_key']);
define('NONCE_KEY',        $wp_config['nonce_key']);
define('AUTH_SALT',        $wp_config['auth_salt']);
define('SECURE_AUTH_SALT', $wp_config['secure_auth_salt']);
define('LOGGED_IN_SALT',   $wp_config['logged_in_salt']);
define('NONCE_SALT',       $wp_config['nonce_salt']);

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
define('WP_DEBUG', $wp_config['wp_debug']);

/** Enable cache (include 'wp-content/advanced-cache.php') */
define('WP_CACHE', $wp_config['wp_cache']);

/** Disable plugin and theme update and installation */
define('DISALLOW_FILE_MODS', $wp_config['disallow_file_mods']);

/** Require SSL for admin and logins */
define('FORCE_SSL_ADMIN', $wp_config['force_ssl_admin']);

/** Disable WordPress auto updates */
define('AUTOMATIC_UPDATER_DISABLED', $wp_config['automatic_updater_disabled']);

/**
 * Check 'HTTP_X_FORWARDED_PROTO' header
 * because is_ssl() won't work when WordPress is behind a reverse proxy.
 * http://codex.wordpress.org/Administration_Over_SSL
 */
if ( isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' )
	$_SERVER['HTTPS'] = 'on';

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/public/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
