<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handles all public-facing functionality.
 */
class KLN_Public {

    public function __construct() {
        // Override template for the Link Ninja page (bypasses Divi completely)
        add_filter( 'template_include',     array( $this, 'override_template'   ), 99 );
        add_action( 'wp_enqueue_scripts',   array( $this, 'enqueue_assets'      ) );

        // Shortcode as alternative embed method
        add_shortcode( 'kepa_link_ninja',   array( $this, 'render_shortcode'    ) );
    }

    // -------------------------------------------------------------------------
    // Template override – completely bypasses Divi
    // -------------------------------------------------------------------------

    public function override_template( $template ) {
        if ( ! is_singular( 'page' ) ) return $template;

        $page_id = get_option( 'kln_page_id', 0 );
        if ( ! $page_id ) return $template;

        // Also match by meta key in case of manual setup
        if ( get_the_ID() == $page_id || get_post_meta( get_the_ID(), '_kln_link_page', true ) === '1' ) {
            $custom_template = KLN_PLUGIN_DIR . 'public/templates/link-page.php';
            if ( file_exists( $custom_template ) ) {
                return $custom_template;
            }
        }

        return $template;
    }

    // -------------------------------------------------------------------------
    // Assets
    // -------------------------------------------------------------------------

    public function enqueue_assets() {
        // Only load on our page or if shortcode might be present
        $page_id = get_option( 'kln_page_id', 0 );
        $is_our_page = ( $page_id && is_page( $page_id ) ) ||
                       ( is_singular( 'page' ) && get_post_meta( get_the_ID(), '_kln_link_page', true ) === '1' );

        if ( ! $is_our_page && ! is_a( get_post(), 'WP_Post' ) ) return;

        $appearance = get_option( 'kln_appearance', array() );
        $font       = sanitize_text_field( $appearance['font'] ?? 'Inter' );

        // Google Fonts
        wp_enqueue_style(
            'kln-google-fonts',
            'https://fonts.googleapis.com/css2?family=' . urlencode( $font ) . ':wght@300;400;500;600;700&display=swap',
            array(),
            null
        );

        wp_enqueue_style(
            'kln-public',
            KLN_PLUGIN_URL . 'public/css/public.css',
            array(),
            KLN_VERSION
        );

        wp_enqueue_script(
            'kln-public',
            KLN_PLUGIN_URL . 'public/js/public.js',
            array( 'jquery' ),
            KLN_VERSION,
            true
        );

        $streaming = KLN_Helpers::get_streaming_platforms();
        $platform_icons = array();
        $platform_colors = array();
        foreach ( array_merge( $streaming, array( 'link' => array( 'label' => 'Link', 'color' => '#666' ) ) ) as $slug => $data ) {
            $platform_colors[ $slug ] = $data['color'];
            $platform_icons[ $slug ]  = KLN_Helpers::get_icon_svg( $slug, 20 );
        }
        wp_localize_script( 'kln-public', 'klnData', array(
            'platformIcons'  => $platform_icons,
            'platformColors' => $platform_colors,
        ) );
    }

    // -------------------------------------------------------------------------
    // Shortcode
    // -------------------------------------------------------------------------

    public function render_shortcode( $atts ) {
        ob_start();
        $appearance = get_option( 'kln_appearance', array() );
        $profile    = get_option( 'kln_profile', array() );
        $sections   = get_option( 'kln_sections', array() );
        $embedded   = true; // shortcode mode: no full-page wrapper

        include KLN_PLUGIN_DIR . 'public/templates/link-page.php';
        return ob_get_clean();
    }

    // -------------------------------------------------------------------------
    // Static helpers used by the template
    // -------------------------------------------------------------------------

    /**
     * Build CSS custom properties from appearance settings.
     */
    public static function build_css_vars( $appearance ) {
        $font   = sanitize_text_field( $appearance['font']          ?? 'Inter'   );
        $text   = sanitize_hex_color( $appearance['text_color']     ?? '#ffffff' );
        $accent = sanitize_hex_color( $appearance['accent_color']   ?? '#a78bfa' );
        $radius = absint( $appearance['button_radius']               ?? 50       );
        $card   = $appearance['card_color'] ?? 'rgba(255,255,255,0.12)';

        return sprintf(
            '--kln-font:%s;--kln-text:%s;--kln-accent:%s;--kln-radius:%dpx;--kln-card:%s;',
            $font, $text, $accent, $radius, $card
        );
    }

    /**
     * Build background CSS.
     */
    public static function build_bg_css( $appearance ) {
        $type   = $appearance['bg_type']    ?? 'gradient';
        $color1 = sanitize_hex_color( $appearance['bg_color_1'] ?? '#1a0533' );
        $color2 = sanitize_hex_color( $appearance['bg_color_2'] ?? '#6C3AE8' );
        $angle  = absint( $appearance['bg_angle'] ?? 135 );
        $image  = esc_url( $appearance['bg_image_url'] ?? '' );

        if ( $type === 'gradient' ) {
            return "background: linear-gradient({$angle}deg, {$color1}, {$color2});";
        } elseif ( $type === 'solid' ) {
            return "background: {$color1};";
        } elseif ( $type === 'image' && $image ) {
            return "background: url('{$image}') center/cover no-repeat; background-color: {$color1};";
        }
        return "background: linear-gradient(135deg, #1a0533, #6C3AE8);";
    }
}
