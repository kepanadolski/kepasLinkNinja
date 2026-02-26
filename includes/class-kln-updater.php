<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * GitHub-based plugin updater.
 * Checks GitHub releases and exposes updates to WordPress (Plugins screen and Admin update button).
 * For "Update from GitHub" to work: create a Release and attach a .zip asset whose root folder
 * is the plugin directory name (e.g. kepas-link-ninja). If no asset is attached, no update is offered.
 */
class KLN_Updater {

    const GITHUB_API = 'https://api.github.com/repos/%s/releases/latest';
    const TRANSIENT   = 'kln_github_latest_release';
    const TRANSIENT_TTL = 300; // 5 minutes

    public static function init() {
        add_filter( 'pre_set_site_transient_update_plugins', array( __CLASS__, 'inject_update' ) );
        add_filter( 'plugins_api', array( __CLASS__, 'plugin_info' ), 20, 3 );
        add_action( 'admin_init', array( __CLASS__, 'maybe_clear_transient' ) );
    }

    /**
     * GitHub repo in form "owner/repo".
     */
    public static function get_repo() {
        return defined( 'KLN_GITHUB_REPO' ) ? KLN_GITHUB_REPO : 'kepanadolski/kepasLinkNinja';
    }

    public static function get_plugin_slug() {
        return dirname( KLN_PLUGIN_BASE );
    }

    /**
     * Fetch latest release from GitHub (cached). Works for public repos without any token.
     */
    public static function get_latest_release() {
        $cached = get_site_transient( self::TRANSIENT );
        if ( $cached !== false ) {
            return is_array( $cached ) ? $cached : null;
        }

        $url  = sprintf( self::GITHUB_API, self::get_repo() );
        $res  = wp_remote_get( $url, array(
            'headers' => array( 'Accept' => 'application/vnd.github.v3+json' ),
            'timeout' => 15,
        ) );

        if ( is_wp_error( $res ) || wp_remote_retrieve_response_code( $res ) !== 200 ) {
            set_site_transient( self::TRANSIENT, 'error', 60 );
            return null;
        }

        $body = json_decode( wp_remote_retrieve_body( $res ), true );
        if ( ! $body || empty( $body['tag_name'] ) ) {
            set_site_transient( self::TRANSIENT, 'empty', 60 );
            return null;
        }

        $version = ltrim( $body['tag_name'], 'v' );
        $package = null;
        if ( ! empty( $body['assets'] ) && is_array( $body['assets'] ) ) {
            foreach ( $body['assets'] as $asset ) {
                if ( isset( $asset['browser_download_url'] ) && substr( $asset['name'], -4 ) === '.zip' ) {
                    $package = $asset['browser_download_url'];
                    break;
                }
            }
        }
        if ( ! $package && ! empty( $body['tag_name'] ) ) {
            $tag     = $body['tag_name'];
            $package = 'https://github.com/' . self::get_repo() . '/archive/refs/tags/' . $tag . '.zip';
        }

        $data = array(
            'version'    => $version,
            'url'        => isset( $body['html_url'] ) ? $body['html_url'] : 'https://github.com/' . self::get_repo(),
            'package'    => $package,
            'package_ok' => (bool) $package && ! empty( $body['assets'] ),
            'body'       => isset( $body['body'] ) ? $body['body'] : '',
        );
        set_site_transient( self::TRANSIENT, $data, self::TRANSIENT_TTL );
        return $data;
    }

    public static function inject_update( $transient ) {
        if ( empty( $transient ) || ! is_object( $transient ) ) {
            return $transient;
        }
        $release = self::get_latest_release();
        if ( ! $release || ! $release['package'] || ! version_compare( $release['version'], KLN_VERSION, '>' ) ) {
            return $transient;
        }
        if ( empty( $release['package_ok'] ) ) {
            return $transient;
        }
        $slug = self::get_plugin_slug();
        $transient->response[ KLN_PLUGIN_BASE ] = (object) array(
            'slug'        => $slug,
            'plugin'     => KLN_PLUGIN_BASE,
            'new_version' => $release['version'],
            'url'        => $release['url'],
            'package'    => $release['package'],
            'icons'      => array(),
            'banners'    => array(),
            'banners_rtl' => array(),
            'tested'     => '',
            'requires_php' => '',
            'compatibility' => new stdClass(),
        );
        return $transient;
    }

    public static function plugin_info( $result, $action, $args ) {
        if ( $action !== 'plugin_information' || empty( $args->slug ) || $args->slug !== self::get_plugin_slug() ) {
            return $result;
        }
        $release = self::get_latest_release();
        if ( ! $release ) {
            return $result;
        }
        $result = new stdClass();
        $result->name = "Kepa's Link Ninja";
        $result->slug = self::get_plugin_slug();
        $result->version = $release['version'];
        $result->download_link = $release['package'];
        $result->sections = array(
            'description' => __( 'A beautiful Linktree-style link page for musicians.', 'kepas-link-ninja' ),
            'changelog'   => $release['body'] ? $release['body'] : __( 'See the release on GitHub for changelog.', 'kepas-link-ninja' ),
        );
        return $result;
    }

    /**
     * Allow clearing cache when user clicks "Check for updates" on our settings page.
     * Clears our GitHub cache and WordPress update_plugins transient, then forces
     * a fresh check so the Plugins screen shows the update.
     */
    public static function maybe_clear_transient() {
        if ( isset( $_GET['page'] ) && $_GET['page'] === 'kepas-link-ninja' && isset( $_GET['kln_check_updates'] ) && current_user_can( 'update_plugins' ) ) {
            delete_site_transient( self::TRANSIENT );
            delete_site_transient( 'update_plugins' );
            if ( function_exists( 'wp_update_plugins' ) ) {
                wp_update_plugins();
            }
            wp_safe_redirect( admin_url( 'plugins.php' ) );
            exit;
        }
    }
}
