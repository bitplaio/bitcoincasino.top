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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'wordpress' );

/** MySQL database password */
define( 'DB_PASSWORD', 'de05379cc082955e58e367ba4f71048e065d53547dae8300' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         '@M-MqEM.Q/:U</jfY=ic=;38ub}Ty FwN~LG]Nl[<We7a}b |~V~Km{S!AB&^%KT' );
define( 'SECURE_AUTH_KEY',  'HrNsErkXRsa[gVp[!?54vebN/-HLaycNJhs/|fO<;7^u.P`K;X=#E7wQle#PVlA7' );
define( 'LOGGED_IN_KEY',    'c>>3Ir9i(3xs=nUzE!VRsKzG0%_P$:3RWkSV^M/Sy[J{pjUN{:#liq-sQsdYiGew' );
define( 'NONCE_KEY',        'K`nftX/3@Hz ^FoaM[@DafQ!4ML`eIFOBIryQCRZHqZ4;#=JCoZ_2KT}bg<~n:lL' );
define( 'AUTH_SALT',        's;,m(%ch<zYb!C`PmeLk)GC7^ttNI8+;,|O|9uwqwE=tt(o[&%B[6X*h!9t^!P`G' );
define( 'SECURE_AUTH_SALT', '~cY%<Qmy:X+zhhMY=s$,r1Mu:zO7A.~zJd?HRKyCt&y5IcZ7*-0=Vwiy-!I<j:hf' );
define( 'LOGGED_IN_SALT',   '&O/TQ`<.ugAFw euL44Bij6p&Sy*GtDm#F.o^*x-3/{OGYyf,NmPDalvbb[01-~U' );
define( 'NONCE_SALT',       'dM#-Fk]@QV{>AMWwiZ5}<C7{1t{YvdqYyo(+(dmxtkkMY7_ c+%<.#JS(-sQo~Z ' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

define( 'WP_HOME', 'https://bitcoincasinos.top' );
define( 'WP_SITEURL', 'https://bitcoincasinos.top' );
define('FORCE_SSL_ADMIN', true);
