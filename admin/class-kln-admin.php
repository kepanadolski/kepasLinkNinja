<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handles all admin-side functionality.
 */
class KLN_Admin {

    public function __construct() {
        add_action( 'admin_menu',              array( $this, 'register_menu'    ) );
        add_action( 'admin_enqueue_scripts',   array( $this, 'enqueue_assets'   ) );
        add_action( 'wp_ajax_kln_save_all',    array( $this, 'ajax_save_all'    ) );
        add_action( 'wp_ajax_kln_create_page', array( $this, 'ajax_create_page' ) );
        add_action( 'wp_ajax_kln_upload_image',array( $this, 'ajax_upload_image') );
    }

    // -------------------------------------------------------------------------
    // Menu
    // -------------------------------------------------------------------------

    public function register_menu() {
        add_menu_page(
            __( "Kepa's Link Ninja", 'kepas-link-ninja' ),
            __( 'Link Ninja', 'kepas-link-ninja' ),
            'manage_options',
            'kepas-link-ninja',
            array( $this, 'render_admin_page' ),
            $this->get_menu_icon(),
            30
        );
    }

    private function get_menu_icon() {
        return 'data:image/svg+xml;base64,' . base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#a78bfa">
                <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
            </svg>'
        );
    }

    // -------------------------------------------------------------------------
    // Assets
    // -------------------------------------------------------------------------

    public function enqueue_assets( $hook ) {
        if ( 'toplevel_page_kepas-link-ninja' !== $hook ) return;

        // WordPress bundled
        wp_enqueue_media();
        wp_enqueue_script( 'jquery-ui-sortable' );

        // Plugin admin assets
        wp_enqueue_style(
            'kln-admin',
            KLN_PLUGIN_URL . 'admin/css/admin.css',
            array(),
            KLN_VERSION
        );
        wp_enqueue_script(
            'kln-admin',
            KLN_PLUGIN_URL . 'admin/js/admin.js',
            array( 'jquery', 'jquery-ui-sortable' ),
            KLN_VERSION,
            true
        );

        wp_localize_script( 'kln-admin', 'klnAdmin', array(
            'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
            'nonce'            => wp_create_nonce( 'kln_admin_nonce' ),
            'pageUrl'          => $this->get_page_url(),
            'socialPlatforms'  => KLN_Helpers::get_social_platforms(),
            'streamPlatforms'  => KLN_Helpers::get_streaming_platforms(),
            'strings'          => array(
                'saved'         => __( 'Saved!', 'kepas-link-ninja' ),
                'saveError'     => __( 'Error saving. Please try again.', 'kepas-link-ninja' ),
                'confirmDelete' => __( 'Delete this item?', 'kepas-link-ninja' ),
                'pageCreated'   => __( 'Page created!', 'kepas-link-ninja' ),
                'selectImage'   => __( 'Select Image', 'kepas-link-ninja' ),
                'useImage'      => __( 'Use this image', 'kepas-link-ninja' ),
            ),
        ) );
    }

    private function get_page_url() {
        $page_id = get_option( 'kln_page_id', 0 );
        return $page_id ? get_permalink( $page_id ) : '';
    }

    // -------------------------------------------------------------------------
    // Admin page render
    // -------------------------------------------------------------------------

    public function render_admin_page() {
        $profile    = get_option( 'kln_profile', array() );
        $appearance = get_option( 'kln_appearance', array() );
        $sections   = get_option( 'kln_sections', array() );
        $page_id    = get_option( 'kln_page_id', 0 );
        $page_url   = $page_id ? get_permalink( $page_id ) : '';

        include KLN_PLUGIN_DIR . 'admin/views/admin-page.php';
    }

    // -------------------------------------------------------------------------
    // AJAX: Save all settings
    // -------------------------------------------------------------------------

    public function ajax_save_all() {
        check_ajax_referer( 'kln_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_die( -1 );

        // Profile
        if ( isset( $_POST['profile'] ) ) {
            $p = $_POST['profile'];
            update_option( 'kln_profile', array(
                'name'       => sanitize_text_field( $p['name'] ?? '' ),
                'bio'        => sanitize_textarea_field( $p['bio'] ?? '' ),
                'avatar_url' => esc_url_raw( $p['avatar_url'] ?? '' ),
                'avatar_id'  => absint( $p['avatar_id'] ?? 0 ),
            ) );
        }

        // Appearance
        if ( isset( $_POST['appearance'] ) ) {
            $a = $_POST['appearance'];
            update_option( 'kln_appearance', array(
                'bg_type'       => sanitize_key( $a['bg_type'] ?? 'gradient' ),
                'bg_color_1'    => sanitize_hex_color( $a['bg_color_1'] ?? '#1a0533' ),
                'bg_color_2'    => sanitize_hex_color( $a['bg_color_2'] ?? '#6C3AE8' ),
                'bg_angle'      => absint( $a['bg_angle'] ?? 135 ),
                'bg_image_url'  => esc_url_raw( $a['bg_image_url'] ?? '' ),
                'theme'         => ( isset( $a['theme'] ) && $a['theme'] === 'light' ) ? 'light' : 'dark',
                'card_style'    => sanitize_key( $a['card_style'] ?? 'glass' ),
                'card_color'    => sanitize_text_field( $a['card_color'] ?? 'rgba(255,255,255,0.12)' ),
                'text_color'    => sanitize_hex_color( $a['text_color'] ?? '#ffffff' ),
                'accent_color'  => sanitize_hex_color( $a['accent_color'] ?? '#a78bfa' ),
                'font'          => sanitize_text_field( $a['font'] ?? 'Inter' ),
                'button_radius' => absint( $a['button_radius'] ?? 50 ),
                'show_footer'   => ! empty( $a['show_footer'] ),
            ) );
        }

        // Sections
        if ( isset( $_POST['sections'] ) ) {
            $raw = $_POST['sections'];
            // sections come JSON-encoded from JS
            if ( is_string( $raw ) ) {
                $raw = json_decode( stripslashes( $raw ), true );
            }
            update_option( 'kln_sections', KLN_Helpers::sanitize_sections( $raw ?? array() ) );
        }

        wp_send_json_success( array( 'message' => __( 'Settings saved.', 'kepas-link-ninja' ) ) );
    }

    // -------------------------------------------------------------------------
    // AJAX: Create / recreate link page
    // -------------------------------------------------------------------------

    public function ajax_create_page() {
        check_ajax_referer( 'kln_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'manage_options' ) ) wp_die( -1 );

        $page_id = get_option( 'kln_page_id', 0 );
        if ( $page_id && get_post( $page_id ) ) {
            wp_send_json_success( array(
                'url'     => get_permalink( $page_id ),
                'message' => __( 'Page already exists.', 'kepas-link-ninja' ),
            ) );
            return;
        }

        $page_id = wp_insert_post( array(
            'post_title'   => sanitize_text_field( $_POST['title'] ?? 'Links' ),
            'post_name'    => sanitize_title( $_POST['slug'] ?? 'links' ),
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'meta_input'   => array( '_kln_link_page' => '1' ),
        ) );

        if ( is_wp_error( $page_id ) ) {
            wp_send_json_error( array( 'message' => $page_id->get_error_message() ) );
        }

        update_option( 'kln_page_id', $page_id );
        wp_send_json_success( array(
            'url'     => get_permalink( $page_id ),
            'message' => __( 'Page created!', 'kepas-link-ninja' ),
        ) );
    }

    // -------------------------------------------------------------------------
    // AJAX: Image upload helper (returns attachment data)
    // -------------------------------------------------------------------------

    public function ajax_upload_image() {
        check_ajax_referer( 'kln_admin_nonce', 'nonce' );
        if ( ! current_user_can( 'upload_files' ) ) wp_die( -1 );

        $attachment_id = absint( $_POST['attachment_id'] ?? 0 );
        if ( ! $attachment_id ) {
            wp_send_json_error();
        }

        wp_send_json_success( array(
            'url' => wp_get_attachment_image_url( $attachment_id, 'medium' ),
            'id'  => $attachment_id,
        ) );
    }

    // -------------------------------------------------------------------------
    // Section / link row renderers (called by admin-page.php view)
    // -------------------------------------------------------------------------

    public function render_section( $section, $index, $is_template = false ) {
        $id                  = $section['id'];
        $type                = $section['type'];
        $social_platforms    = KLN_Helpers::get_social_platforms();
        $streaming_platforms = KLN_Helpers::get_streaming_platforms();
        $all_platforms       = array_merge( $social_platforms, $streaming_platforms );
        ?>
        <div class="kln-section kln-section-<?php echo esc_attr( $type ); ?>" data-id="<?php echo esc_attr( $id ); ?>" data-type="<?php echo esc_attr( $type ); ?>">
            <div class="kln-section-head">
                <span class="kln-drag-handle" title="Drag to reorder">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </span>
                <span class="kln-section-type-badge kln-type-<?php echo esc_attr( $type ); ?>"><?php echo esc_html( ucfirst( $type ) ); ?></span>
                <input class="kln-section-title-input" type="text" value="<?php echo esc_attr( $section['title'] ); ?>" placeholder="Section title">
                <div class="kln-section-head-actions">
                    <label class="kln-toggle" title="<?php esc_attr_e( 'Active', 'kepas-link-ninja' ); ?>">
                        <input type="checkbox" class="kln-section-active" <?php checked( $section['active'] ); ?>>
                        <span class="kln-toggle-slider"></span>
                    </label>
                    <?php if ( $type !== 'custom' ) : ?>
                    <label class="kln-toggle-small" title="<?php esc_attr_e( 'Expandable', 'kepas-link-ninja' ); ?>">
                        <input type="checkbox" class="kln-section-expandable" <?php checked( $section['expandable'] ?? false ); ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </label>
                    <?php endif; ?>
                    <button class="kln-btn-icon kln-section-toggle-body" title="Collapse">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                    </button>
                    <button class="kln-btn-icon kln-btn-danger kln-delete-section" title="Delete section">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
                    </button>
                </div>
            </div>

            <div class="kln-section-body">
                <?php if ( $type === 'release' ) : ?>
                <div class="kln-release-meta">
                    <div class="kln-release-cover">
                        <div class="kln-cover-preview" style="<?php echo ! empty( $section['cover_image_url'] ) ? 'background-image:url(' . esc_url( $section['cover_image_url'] ) . ')' : ''; ?>">
                            <?php if ( empty( $section['cover_image_url'] ) ) : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <?php endif; ?>
                        </div>
                        <button type="button" class="kln-btn kln-btn-sm kln-btn-outline kln-upload-btn" data-target="release_cover"><?php esc_html_e( 'Upload Cover', 'kepas-link-ninja' ); ?></button>
                        <input type="hidden" class="kln-cover-url" value="<?php echo esc_attr( $section['cover_image_url'] ?? '' ); ?>">
                        <input type="hidden" class="kln-cover-id"  value="<?php echo esc_attr( $section['cover_image_id']  ?? 0 ); ?>">
                    </div>
                    <div class="kln-release-fields">
                        <div class="kln-field">
                            <label><?php esc_html_e( 'Release Date', 'kepas-link-ninja' ); ?></label>
                            <input type="date" class="kln-release-date" value="<?php echo esc_attr( $section['release_date'] ?? '' ); ?>">
                        </div>
                        <div class="kln-field">
                            <label><?php esc_html_e( 'Description', 'kepas-link-ninja' ); ?></label>
                            <textarea class="kln-release-description" rows="3" placeholder="<?php esc_attr_e( 'Describe this release...', 'kepas-link-ninja' ); ?>"><?php echo esc_textarea( $section['description'] ?? '' ); ?></textarea>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if ( $type === 'custom' ) : ?>
                <div class="kln-custom-fields">
                    <div class="kln-field">
                        <label><?php esc_html_e( 'URL', 'kepas-link-ninja' ); ?></label>
                        <input type="url" class="kln-custom-url" value="<?php echo esc_attr( $section['url'] ?? '' ); ?>" placeholder="https://">
                    </div>
                </div>
                <?php else : ?>
                <div class="kln-links-list" data-type="<?php echo esc_attr( $type ); ?>">
                    <?php
                    foreach ( ( $section['links'] ?? array() ) as $link ) {
                        $this->render_link_row( $link, $type, $all_platforms );
                    }
                    ?>
                </div>
                <div class="kln-add-link-row">
                    <select class="kln-new-platform">
                        <?php
                        $pool = ( $type === 'social' ) ? $social_platforms
                              : ( ( $type === 'streaming' ) ? $streaming_platforms
                              : array_merge( $social_platforms, $streaming_platforms ) );
                        foreach ( $pool as $slug => $data ) {
                            echo '<option value="' . esc_attr( $slug ) . '">' . esc_html( $data['label'] ) . '</option>';
                        }
                        ?>
                    </select>
                    <input type="url" class="kln-new-link-url" placeholder="https://...">
                    <button class="kln-btn kln-btn-sm kln-btn-primary kln-add-link-btn">+ <?php esc_html_e( 'Add', 'kepas-link-ninja' ); ?></button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    public function render_link_row( $link, $type, $all_platforms ) {
        $platform = $link['platform'] ?? 'link';
        $color    = KLN_Helpers::get_platform_color( $platform );
        $label    = KLN_Helpers::get_platform_label( $platform );
        ?>
        <div class="kln-link-row" data-id="<?php echo esc_attr( $link['id'] ?? '' ); ?>">
            <span class="kln-drag-handle-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
            </span>
            <span class="kln-platform-dot" style="background:<?php echo esc_attr( $color ); ?>"></span>
            <span class="kln-platform-name"><?php echo esc_html( $label ); ?></span>
            <input type="url"  class="kln-link-url"      value="<?php echo esc_attr( $link['url']   ?? '' ); ?>" placeholder="URL">
            <input type="text" class="kln-link-label"    value="<?php echo esc_attr( $link['label'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Label (optional)', 'kepas-link-ninja' ); ?>">
            <input type="hidden" class="kln-link-platform" value="<?php echo esc_attr( $platform ); ?>">
            <label class="kln-toggle kln-toggle-sm" title="<?php esc_attr_e( 'Active', 'kepas-link-ninja' ); ?>">
                <input type="checkbox" class="kln-link-active" <?php checked( $link['active'] ?? true ); ?>>
                <span class="kln-toggle-slider"></span>
            </label>
            <button class="kln-btn-icon kln-btn-danger kln-delete-link" title="<?php esc_attr_e( 'Delete', 'kepas-link-ninja' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <?php
    }
}
