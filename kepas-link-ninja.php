<?php
/**
 * Plugin Name:  Kepa's Link Ninja
 * Plugin URI:   https://github.com/kepa/link-ninja
 * Description:  A beautiful Linktree-style link page for musicians. Showcase your social media, streaming services, and new releases all in one place.
 * Version:      1.43
 * Author:       Kepa
 * License:      GPL-2.0+
 * Text Domain:  kepas-link-ninja
 * Domain Path:  /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Plugin constants
define( 'KLN_VERSION',     '1.43' );
define( 'KLN_PLUGIN_FILE', __FILE__ );
define( 'KLN_PLUGIN_DIR',  plugin_dir_path( __FILE__ ) );
define( 'KLN_PLUGIN_URL',  plugin_dir_url( __FILE__ ) );
define( 'KLN_PLUGIN_BASE', plugin_basename( __FILE__ ) );
define( 'KLN_GITHUB_REPO', 'kepanadolski/kepasLinkNinja' );

// Autoload classes
require_once KLN_PLUGIN_DIR . 'includes/class-kln-activator.php';
require_once KLN_PLUGIN_DIR . 'includes/class-kln-helpers.php';
require_once KLN_PLUGIN_DIR . 'includes/class-kln-updater.php';
require_once KLN_PLUGIN_DIR . 'admin/class-kln-admin.php';
require_once KLN_PLUGIN_DIR . 'public/class-kln-public.php';

// Activation / Deactivation hooks
register_activation_hook(   __FILE__, array( 'KLN_Activator', 'activate'   ) );
register_deactivation_hook( __FILE__, array( 'KLN_Activator', 'deactivate' ) );

/**
 * Main plugin class.
 */
final class Kepas_Link_Ninja {

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );

        if ( is_admin() ) {
            new KLN_Admin();
            KLN_Updater::init();
        }

        new KLN_Public();
    }

    public function load_textdomain() {
        load_plugin_textdomain(
            'kepas-link-ninja',
            false,
            dirname( KLN_PLUGIN_BASE ) . '/languages/'
        );
    }
}

// Kick it off
Kepas_Link_Ninja::instance();
