<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$appearance = isset( $appearance ) ? $appearance : get_option( 'kln_appearance', array() );
$profile    = isset( $profile )    ? $profile    : get_option( 'kln_profile', array() );
$sections   = isset( $sections )   ? $sections   : get_option( 'kln_sections', array() );
$embedded   = isset( $embedded )   ? $embedded   : false;

$bg_css      = KLN_Public::build_bg_css( $appearance );
$css_vars    = KLN_Public::build_css_vars( $appearance );
$font        = sanitize_text_field( $appearance['font'] ?? 'Inter' );
$card_style  = sanitize_key( $appearance['card_style'] ?? 'glass' );
$show_footer = ! empty( $appearance['show_footer'] );
$profile_name = $profile['name'] ?? get_bloginfo( 'name' );

// Build flat list of link cards from sections (Linktree-style)
$cards = array();
foreach ( $sections as $section ) {
    if ( empty( $section['active'] ) ) continue;
    $type = $section['type'] ?? 'custom';

    if ( $type === 'release' ) {
        $links = array_filter( $section['links'] ?? array(), function ( $l ) { return ! empty( $l['active'] ) && ! empty( $l['url'] ); } );
        $cards[] = array(
            'card_type' => 'release',
            'title'     => $section['title'] ?? '',
            'subtitle'  => sprintf( /* translators: %s = artist name */ __( 'Album • %s', 'kepas-link-ninja' ), $profile_name ),
            'cover_url' => $section['cover_image_url'] ?? '',
            'links'     => $links,
            'section'   => $section,
        );
        continue;
    }

    if ( $type === 'custom' ) {
        if ( empty( $section['url'] ) ) continue;
        $cards[] = array(
            'card_type' => 'external',
            'url'       => $section['url'],
            'title'     => $section['title'] ?? __( 'Link', 'kepas-link-ninja' ),
            'subtitle'  => '',
            'thumbnail' => '',
            'platform'  => $section['icon'] ?? 'link',
        );
        continue;
    }

    // social / streaming: one card per link
    $links = array_filter( $section['links'] ?? array(), function ( $l ) { return ! empty( $l['active'] ) && ! empty( $l['url'] ); } );
    foreach ( $links as $link ) {
        $platform = $link['platform'] ?? 'link';
        $url      = $link['url'];
        $label    = ! empty( $link['label'] ) ? $link['label'] : KLN_Helpers::get_platform_label( $platform );
        $video_id = ( $platform === 'youtube' ) ? KLN_Helpers::get_youtube_video_id( $url ) : null;

        $cards[] = array(
            'card_type'  => $video_id ? 'youtube' : 'external',
            'url'        => $url,
            'title'      => $label,
            'subtitle'   => $video_id ? ( '► YouTube • ' . $profile_name ) : ( $profile_name ),
            'thumbnail'  => $video_id ? KLN_Helpers::get_youtube_thumbnail_url( $video_id, 'mqdefault' ) : '',
            'platform'   => $platform,
            'video_id'   => $video_id,
        );
    }
}

$page_url_for_share = ( ! $embedded && get_option( 'kln_page_id', 0 ) ) ? get_permalink( get_option( 'kln_page_id' ) ) : '';
$admin_url = admin_url( 'admin.php?page=kepas-link-ninja' );

if ( ! $embedded ) :
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html( $profile_name ); ?> — <?php esc_html_e( 'Links', 'kepas-link-ninja' ); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <?php wp_head(); ?>
</head>
<body class="kln-body">
<?php endif; ?>

<div class="kln-page <?php echo $embedded ? 'kln-embedded' : 'kln-fullpage'; ?> kln-card-<?php echo esc_attr( $card_style ); ?> kln-theme-dark"
     style="<?php echo esc_attr( $css_vars ); ?><?php echo $embedded ? '' : $bg_css; ?>"
     data-page-url="<?php echo esc_attr( $page_url_for_share ); ?>">

    <?php if ( ! $embedded ) : ?>
    <div class="kln-bg" style="<?php echo esc_attr( $bg_css ); ?>"></div>
    <?php endif; ?>

    <div class="kln-container">

        <!-- Top bar: settings + share page -->
        <div class="kln-topbar">
            <?php if ( current_user_can( 'manage_options' ) ) : ?>
            <a href="<?php echo esc_url( $admin_url ); ?>" class="kln-topbar-icon kln-icon-settings" aria-label="<?php esc_attr_e( 'Settings', 'kepas-link-ninja' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            </a>
            <?php else : ?>
            <span class="kln-topbar-icon kln-topbar-spacer"></span>
            <?php endif; ?>
            <?php if ( $page_url_for_share ) : ?>
            <button type="button" class="kln-topbar-icon kln-icon-share-page" aria-label="<?php esc_attr_e( 'Share page', 'kepas-link-ninja' ); ?>" data-share-url="<?php echo esc_attr( $page_url_for_share ); ?>" data-share-title="<?php echo esc_attr( $profile_name ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
            </button>
            <?php endif; ?>
        </div>

        <!-- Profile -->
        <header class="kln-profile">
            <?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
                <div class="kln-avatar">
                    <img src="<?php echo esc_url( $profile['avatar_url'] ); ?>"
                         alt="<?php echo esc_attr( $profile_name ); ?>">
                </div>
            <?php endif; ?>
            <?php if ( ! empty( $profile['name'] ) ) : ?>
                <h1 class="kln-name"><?php echo esc_html( $profile['name'] ); ?></h1>
            <?php endif; ?>
            <?php if ( ! empty( $profile['bio'] ) ) : ?>
                <p class="kln-bio"><?php echo wp_kses_post( nl2br( esc_html( $profile['bio'] ) ) ); ?></p>
            <?php endif; ?>
        </header>

        <!-- Unified link cards (Linktree-style) -->
        <main class="kln-cards">
            <?php foreach ( $cards as $index => $card ) :
                $card_type = $card['card_type'];
                $title     = $card['title'];
                $subtitle  = $card['subtitle'] ?? '';
                $anim_delay = ( $index + 1 ) * 0.05;
            ?>
            <div class="kln-link-card kln-card-<?php echo esc_attr( $card_type ); ?>"
                 data-type="<?php echo esc_attr( $card_type ); ?>"
                 data-url="<?php echo esc_attr( $card['url'] ?? '' ); ?>"
                 <?php if ( ! empty( $card['video_id'] ) ) : ?>data-video-id="<?php echo esc_attr( $card['video_id'] ); ?>"<?php endif; ?>
                 <?php if ( $card_type === 'release' ) : ?>data-release="<?php echo esc_attr( wp_json_encode( $card ) ); ?>"<?php endif; ?>
                 style="animation-delay: <?php echo esc_attr( $anim_delay ); ?>s">

                <a href="<?php echo in_array( $card_type, array( 'youtube', 'release' ), true ) ? '#' : esc_url( $card['url'] ?? '#' ); ?>"
                   class="kln-link-card-main"
                   <?php if ( $card_type === 'external' ) : ?>target="_blank" rel="noopener noreferrer"<?php endif; ?>
                   data-card-type="<?php echo esc_attr( $card_type ); ?>">
                    <?php if ( $card_type === 'release' && ! empty( $card['cover_url'] ) ) : ?>
                        <div class="kln-link-card-thumb" style="background-image:url(<?php echo esc_url( $card['cover_url'] ); ?>)"></div>
                    <?php elseif ( ! empty( $card['thumbnail'] ) ) : ?>
                        <div class="kln-link-card-thumb" style="background-image:url(<?php echo esc_url( $card['thumbnail'] ); ?>)"></div>
                    <?php else : ?>
                        <div class="kln-link-card-thumb kln-link-card-thumb-icon">
                            <?php echo KLN_Helpers::get_icon_svg( $card['platform'] ?? 'link', 28 ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="kln-link-card-text">
                        <span class="kln-link-card-title"><?php echo esc_html( $title ); ?></span>
                        <?php if ( $subtitle ) : ?>
                            <span class="kln-link-card-subtitle"><?php echo esc_html( $subtitle ); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ( $card_type === 'external' ) : ?>
                    <span class="kln-link-card-external">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </span>
                    <?php endif; ?>
                </a>

                <button type="button" class="kln-link-card-dots" aria-label="<?php esc_attr_e( 'Share link', 'kepas-link-ninja' ); ?>"
                        data-share-url="<?php echo esc_attr( $card_type === 'release' ? $page_url_for_share : ( $card['url'] ?? '' ) ); ?>"
                        data-share-title="<?php echo esc_attr( $title ); ?>"
                        data-share-img="<?php echo esc_attr( $card['cover_url'] ?? $card['thumbnail'] ?? '' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                </button>
            </div>
            <?php endforeach; ?>
        </main>

        <?php if ( $show_footer ) : ?>
        <footer class="kln-footer">
            <p><?php printf( /* translators: 1: heart, 2: plugin name */ __( 'Made with %1$s using %2$s', 'kepas-link-ninja' ), '<span class="kln-heart">♥</span>', '<strong>Kepa\'s Link Ninja</strong>' ); ?></p>
        </footer>
        <?php endif; ?>
    </div>
</div>

<!-- Share link modal -->
<div id="kln-share-modal" class="kln-modal" role="dialog" aria-labelledby="kln-share-modal-title" aria-hidden="true">
    <div class="kln-modal-backdrop"></div>
    <div class="kln-modal-dialog kln-modal-share">
        <button type="button" class="kln-modal-close" aria-label="<?php esc_attr_e( 'Close', 'kepas-link-ninja' ); ?>">&times;</button>
        <h2 id="kln-share-modal-title" class="kln-modal-title"><?php esc_html_e( 'Share link', 'kepas-link-ninja' ); ?></h2>
        <div class="kln-share-preview">
            <div class="kln-share-preview-img" id="kln-share-preview-img"></div>
            <div class="kln-share-preview-text">
                <span class="kln-share-preview-title" id="kln-share-preview-title"></span>
                <span class="kln-share-preview-url" id="kln-share-preview-url"></span>
            </div>
        </div>
        <div class="kln-share-actions">
            <button type="button" class="kln-share-btn kln-share-copy" data-action="copy">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <span><?php esc_html_e( 'Copy link', 'kepas-link-ninja' ); ?></span>
            </button>
            <a href="#" class="kln-share-btn kln-share-x" data-action="x" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.63 5.905-5.63zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg><span>X</span></a>
            <a href="#" class="kln-share-btn kln-share-fb" data-action="facebook" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
            <a href="#" class="kln-share-btn kln-share-wa" data-action="whatsapp" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg><span>WhatsApp</span></a>
            <a href="#" class="kln-share-btn kln-share-li" data-action="linkedin" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
        </div>
    </div>
</div>

<!-- YouTube embed modal -->
<div id="kln-youtube-modal" class="kln-modal" role="dialog" aria-labelledby="kln-youtube-modal-title" aria-hidden="true">
    <div class="kln-modal-backdrop"></div>
    <div class="kln-modal-dialog kln-modal-youtube">
        <button type="button" class="kln-modal-close" aria-label="<?php esc_attr_e( 'Close', 'kepas-link-ninja' ); ?>">&times;</button>
        <div class="kln-youtube-header">
            <h2 id="kln-youtube-modal-title" class="kln-youtube-title"></h2>
            <div class="kln-youtube-actions">
                <a href="#" class="kln-youtube-watch-external" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Watch on YouTube', 'kepas-link-ninja' ); ?></a>
                <button type="button" class="kln-youtube-share" aria-label="<?php esc_attr_e( 'Share', 'kepas-link-ninja' ); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
                </button>
            </div>
        </div>
        <div class="kln-youtube-player-wrap">
            <div class="kln-youtube-player" id="kln-youtube-iframe-wrap"></div>
        </div>
    </div>
</div>

<!-- Music release modal -->
<div id="kln-release-modal" class="kln-modal" role="dialog" aria-labelledby="kln-release-modal-title" aria-hidden="true">
    <div class="kln-modal-backdrop"></div>
    <div class="kln-modal-dialog kln-modal-release">
        <button type="button" class="kln-modal-close" aria-label="<?php esc_attr_e( 'Close', 'kepas-link-ninja' ); ?>">&times;</button>
        <div class="kln-release-modal-cover" id="kln-release-modal-cover"></div>
        <h2 id="kln-release-modal-title" class="kln-release-modal-title"></h2>
        <p class="kln-release-modal-subtitle" id="kln-release-modal-subtitle"></p>
        <p class="kln-release-listen"><?php esc_html_e( 'Listen on', 'kepas-link-ninja' ); ?></p>
        <div class="kln-release-streaming" id="kln-release-streaming"></div>
        <div class="kln-release-modal-actions">
            <button type="button" class="kln-release-share kln-btn-icon" aria-label="<?php esc_attr_e( 'Share', 'kepas-link-ninja' ); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 002 2h12a2 2 0 002-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
            </button>
        </div>
    </div>
</div>

<?php if ( ! $embedded ) : ?>
<?php wp_footer(); ?>
</body>
</html>
<?php endif; ?>
