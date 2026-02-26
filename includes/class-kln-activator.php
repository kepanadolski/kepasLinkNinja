<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Handles plugin activation and deactivation.
 */
class KLN_Activator {

    public static function activate() {
        self::set_defaults();
        self::create_link_page();
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    private static function set_defaults() {
        if ( ! get_option( 'kln_profile' ) ) {
            update_option( 'kln_profile', array(
                'name'       => get_bloginfo( 'name' ),
                'bio'        => 'Musician | Artist | Creator',
                'avatar_url' => '',
                'avatar_id'  => 0,
            ) );
        }

        if ( ! get_option( 'kln_appearance' ) ) {
            update_option( 'kln_appearance', array(
                'theme'         => 'light',
                'bg_type'       => 'solid',
                'bg_color_1'    => '#f8fafc',
                'bg_color_2'    => '#e2e8f0',
                'bg_angle'      => 135,
                'bg_image_url'  => '',
                'card_style'    => 'glass',
                'card_color'    => 'rgba(0,0,0,0.06)',
                'text_color'    => '#1e293b',
                'accent_color'  => '#6366f1',
                'font'          => 'Inter',
                'button_radius' => 50,
                'show_footer'   => true,
            ) );
        }

        if ( ! get_option( 'kln_sections' ) ) {
            update_option( 'kln_sections', array(
                array(
                    'id'          => 'sec_social',
                    'type'        => 'social',
                    'title'       => 'Follow Me',
                    'active'      => true,
                    'display'     => 'icons',
                    'expandable'  => false,
                    'links'       => array(),
                ),
                array(
                    'id'          => 'sec_streaming',
                    'type'        => 'streaming',
                    'title'       => 'Listen Now',
                    'active'      => true,
                    'display'     => 'buttons',
                    'expandable'  => false,
                    'links'       => array(),
                ),
            ) );
        }
    }

    private static function create_link_page() {
        $existing = get_option( 'kln_page_id', 0 );
        if ( $existing && get_post( $existing ) ) {
            return; // Page already exists
        }

        $page_id = wp_insert_post( array(
            'post_title'   => 'Links',
            'post_name'    => 'links',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
            'meta_input'   => array( '_kln_link_page' => '1' ),
        ) );

        if ( ! is_wp_error( $page_id ) ) {
            update_option( 'kln_page_id', $page_id );
        }
    }
}
