<?php
/**
 * Local Docker wp-config for zixhr.com dev stack.
 *
 * Reads all settings from environment variables defined in docker-compose.yml
 * (which in turn come from your .env file). This file is mounted over
 * /var/www/html/wp-config.php inside the php container ONLY — it never
 * replaces the tracked/production wp-config.php.
 *
 * TEST/LOCAL USE ONLY.
 */

// ** Database settings from the container environment ** //
// All-in-one container: MariaDB runs on localhost alongside php-fpm/nginx.
$db_host = getenv( 'WORDPRESS_DB_HOST' ) ?: '127.0.0.1';

define( 'DB_NAME', getenv( 'WORDPRESS_DB_NAME' ) ?: 'zixhr_wp' );
define( 'DB_USER', getenv( 'WORDPRESS_DB_USER' ) ?: 'zixhr' );
define( 'DB_PASSWORD', getenv( 'WORDPRESS_DB_PASSWORD' ) ?: 'zixhr_local_pw' );
define( 'DB_HOST', $db_host );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

$table_prefix = getenv( 'WORDPRESS_TABLE_PREFIX' ) ?: 'wp_';

// ** Local URLs — keeps WP from redirecting to the production domain ** //
$wp_home    = getenv( 'WP_HOME' ) ?: 'http://localhost:8080';
$wp_siteurl = getenv( 'WP_SITEURL' ) ?: 'http://localhost:8080';
define( 'WP_HOME', $wp_home );
define( 'WP_SITEURL', $wp_siteurl );

// ** Debugging — on by default for local dev ** //
$wp_debug = getenv( 'WORDPRESS_DEBUG' );
define( 'WP_DEBUG', $wp_debug === '' || $wp_debug === false ? true : (bool) intval( $wp_debug ) );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// ** Salts — static local values. Fine for a throwaway dev box ONLY. ** //
define( 'AUTH_KEY',         'local-dev-auth-key' );
define( 'SECURE_AUTH_KEY',  'local-dev-secure-auth-key' );
define( 'LOGGED_IN_KEY',    'local-dev-logged-in-key' );
define( 'NONCE_KEY',        'local-dev-nonce-key' );
define( 'AUTH_SALT',        'local-dev-auth-salt' );
define( 'SECURE_AUTH_SALT', 'local-dev-secure-auth-salt' );
define( 'LOGGED_IN_SALT',   'local-dev-logged-in-salt' );
define( 'NONCE_SALT',       'local-dev-nonce-salt' );

// Allow WordPress to work behind the nginx proxy container.
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
    $_SERVER['HTTPS'] = 'on';
}

if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
