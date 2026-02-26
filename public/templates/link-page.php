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

if ( ! $embedded ) :
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo esc_html( $profile['name'] ?? get_bloginfo( 'name' ) ); ?> — Links</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=<?php echo urlencode( $font ); ?>:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body class="kln-body">
<?php endif; ?>

<div class="kln-page <?php echo $embedded ? 'kln-embedded' : 'kln-fullpage'; ?> kln-card-<?php echo esc_attr( $card_style ); ?>"
     style="<?php echo esc_attr( $css_vars ); ?><?php echo $embedded ? '' : $bg_css; ?>">

    <?php if ( ! $embedded ) : ?>
    <div class="kln-bg" style="<?php echo esc_attr( $bg_css ); ?>"></div>
    <?php endif; ?>

    <div class="kln-container">

        <!-- ----------------------------------------------------------------
             Profile
        ----------------------------------------------------------------- -->
        <header class="kln-profile">
            <?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
                <div class="kln-avatar">
                    <img src="<?php echo esc_url( $profile['avatar_url'] ); ?>"
                         alt="<?php echo esc_attr( $profile['name'] ?? '' ); ?>">
                </div>
            <?php endif; ?>
            <?php if ( ! empty( $profile['name'] ) ) : ?>
                <h1 class="kln-name"><?php echo esc_html( $profile['name'] ); ?></h1>
            <?php endif; ?>
            <?php if ( ! empty( $profile['bio'] ) ) : ?>
                <p class="kln-bio"><?php echo wp_kses_post( nl2br( esc_html( $profile['bio'] ) ) ); ?></p>
            <?php endif; ?>
        </header>

        <!-- ----------------------------------------------------------------
             Sections
        ----------------------------------------------------------------- -->
        <main class="kln-sections">
            <?php foreach ( $sections as $section ) :
                if ( empty( $section['active'] ) ) continue;
                $type = $section['type'] ?? 'custom';
            ?>

            <?php if ( $type === 'social' ) :
                $links = array_filter( $section['links'] ?? array(), fn($l) => ! empty( $l['active'] ) && ! empty( $l['url'] ) );
                if ( empty( $links ) ) continue;
                ?>
                <section class="kln-section kln-section--social">
                    <?php if ( ! empty( $section['title'] ) ) : ?>
                        <h2 class="kln-section-label"><?php echo esc_html( $section['title'] ); ?></h2>
                    <?php endif; ?>
                    <div class="kln-social-icons">
                        <?php foreach ( $links as $link ) :
                            $platform = $link['platform'] ?? 'link';
                            $color    = KLN_Helpers::get_platform_color( $platform );
                            $label    = ! empty( $link['label'] ) ? $link['label'] : KLN_Helpers::get_platform_label( $platform );
                            $svg      = KLN_Helpers::get_icon_svg( $platform, 22 );
                            ?>
                            <a href="<?php echo esc_url( $link['url'] ); ?>"
                               class="kln-social-icon"
                               style="--platform-color: <?php echo esc_attr( $color ); ?>"
                               target="_blank" rel="noopener noreferrer"
                               title="<?php echo esc_attr( $label ); ?>"
                               aria-label="<?php echo esc_attr( $label ); ?>">
                                <?php echo $svg; // SVG is built from our safe helper ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </section>

            <?php elseif ( $type === 'streaming' ) :
                $links = array_filter( $section['links'] ?? array(), fn($l) => ! empty( $l['active'] ) && ! empty( $l['url'] ) );
                if ( empty( $links ) ) continue;
                $expandable = ! empty( $section['expandable'] );
                ?>
                <section class="kln-section kln-section--streaming <?php echo $expandable ? 'kln-expandable' : ''; ?>">
                    <div class="kln-section-header <?php echo $expandable ? 'kln-expand-trigger' : ''; ?>">
                        <span class="kln-section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                        </span>
                        <h2 class="kln-section-title"><?php echo esc_html( $section['title'] ); ?></h2>
                        <?php if ( $expandable ) : ?>
                            <span class="kln-chevron">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="kln-section-content <?php echo $expandable ? 'kln-collapsible' : ''; ?>">
                        <div class="kln-streaming-buttons">
                            <?php foreach ( $links as $link ) :
                                $platform = $link['platform'] ?? 'link';
                                $color    = KLN_Helpers::get_platform_color( $platform );
                                $label    = ! empty( $link['label'] ) ? $link['label'] : KLN_Helpers::get_platform_label( $platform );
                                $svg      = KLN_Helpers::get_icon_svg( $platform, 20 );
                                ?>
                                <a href="<?php echo esc_url( $link['url'] ); ?>"
                                   class="kln-stream-btn"
                                   style="--platform-color: <?php echo esc_attr( $color ); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   aria-label="<?php echo esc_attr( $label ); ?>">
                                    <span class="kln-stream-icon"><?php echo $svg; ?></span>
                                    <span class="kln-stream-label"><?php echo esc_html( $label ); ?></span>
                                    <svg class="kln-ext-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

            <?php elseif ( $type === 'release' ) :
                $links      = array_filter( $section['links'] ?? array(), fn($l) => ! empty( $l['active'] ) && ! empty( $l['url'] ) );
                $expandable = ! empty( $section['expandable'] );
                ?>
                <section class="kln-section kln-section--release <?php echo $expandable ? 'kln-expandable' : ''; ?>">
                    <div class="kln-release-card <?php echo $expandable ? 'kln-expand-trigger' : ''; ?>">
                        <?php if ( ! empty( $section['cover_image_url'] ) ) : ?>
                            <div class="kln-release-cover">
                                <img src="<?php echo esc_url( $section['cover_image_url'] ); ?>"
                                     alt="<?php echo esc_attr( $section['title'] ); ?>">
                            </div>
                        <?php endif; ?>
                        <div class="kln-release-info">
                            <span class="kln-release-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                New Release
                            </span>
                            <h2 class="kln-release-title"><?php echo esc_html( $section['title'] ); ?></h2>
                            <?php if ( ! empty( $section['release_date'] ) ) : ?>
                                <span class="kln-release-date"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $section['release_date'] ) ) ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $section['description'] ) ) : ?>
                                <p class="kln-release-desc"><?php echo esc_html( $section['description'] ); ?></p>
                            <?php endif; ?>
                            <?php if ( $expandable ) : ?>
                                <span class="kln-expand-hint">
                                    Listen now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                </span>
                            <?php elseif ( ! empty( $links ) ) : ?>
                                <div class="kln-release-links">
                                    <?php foreach ( $links as $link ) :
                                        $platform = $link['platform'] ?? 'link';
                                        $color    = KLN_Helpers::get_platform_color( $platform );
                                        $label    = ! empty( $link['label'] ) ? $link['label'] : KLN_Helpers::get_platform_label( $platform );
                                        $svg      = KLN_Helpers::get_icon_svg( $platform, 16 );
                                        ?>
                                        <a href="<?php echo esc_url( $link['url'] ); ?>"
                                           class="kln-release-link-btn"
                                           style="--platform-color: <?php echo esc_attr( $color ); ?>"
                                           target="_blank" rel="noopener noreferrer"
                                           aria-label="<?php echo esc_attr( $label ); ?>">
                                            <?php echo $svg; ?>
                                            <?php echo esc_html( $label ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if ( $expandable && ! empty( $links ) ) : ?>
                    <div class="kln-section-content kln-collapsible">
                        <div class="kln-release-links kln-release-links--expanded">
                            <?php foreach ( $links as $link ) :
                                $platform = $link['platform'] ?? 'link';
                                $color    = KLN_Helpers::get_platform_color( $platform );
                                $label    = ! empty( $link['label'] ) ? $link['label'] : KLN_Helpers::get_platform_label( $platform );
                                $svg      = KLN_Helpers::get_icon_svg( $platform, 20 );
                                ?>
                                <a href="<?php echo esc_url( $link['url'] ); ?>"
                                   class="kln-stream-btn"
                                   style="--platform-color: <?php echo esc_attr( $color ); ?>"
                                   target="_blank" rel="noopener noreferrer"
                                   aria-label="<?php echo esc_attr( $label ); ?>">
                                    <span class="kln-stream-icon"><?php echo $svg; ?></span>
                                    <span class="kln-stream-label"><?php echo esc_html( $label ); ?></span>
                                    <svg class="kln-ext-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </section>

            <?php elseif ( $type === 'custom' ) :
                if ( empty( $section['url'] ) ) continue;
                ?>
                <section class="kln-section kln-section--custom">
                    <a href="<?php echo esc_url( $section['url'] ); ?>"
                       class="kln-custom-link-btn"
                       target="_blank" rel="noopener noreferrer">
                        <span class="kln-custom-icon">
                            <?php echo KLN_Helpers::get_icon_svg( $section['icon'] ?? 'link', 20 ); ?>
                        </span>
                        <span class="kln-custom-label"><?php echo esc_html( $section['title'] ); ?></span>
                        <svg class="kln-ext-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    </a>
                </section>
            <?php endif; ?>

            <?php endforeach; ?>
        </main>

        <!-- Footer -->
        <?php if ( $show_footer ) : ?>
        <footer class="kln-footer">
            <p>Made with <span class="kln-heart">♥</span> using <strong>Kepa's Link Ninja</strong></p>
        </footer>
        <?php endif; ?>

    </div><!-- .kln-container -->
</div><!-- .kln-page -->

<?php if ( ! $embedded ) : ?>
<?php wp_footer(); ?>
</body>
</html>
<?php endif; ?>
