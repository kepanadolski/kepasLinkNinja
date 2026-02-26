<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<div class="kln-help">

    <!-- =====================================================================
         HERO BANNER
    ====================================================================== -->
    <div class="kln-help-hero">
        <svg class="kln-help-hero-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        <div>
            <h2><?php esc_html_e( "Welcome to Kepa's Link Ninja", 'kepas-link-ninja' ); ?></h2>
            <p><?php esc_html_e( 'Your personal Linktree-style page — built for musicians. Everything you need to know is right here.', 'kepas-link-ninja' ); ?></p>
        </div>
    </div>

    <!-- =====================================================================
         QUICK START
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-green">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            </span>
            <?php esc_html_e( 'Quick Start — 4 steps to go live', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-steps">
            <div class="kln-step">
                <div class="kln-step-num">1</div>
                <div class="kln-step-content">
                    <strong><?php esc_html_e( 'Check your page exists', 'kepas-link-ninja' ); ?></strong>
                    <p><?php esc_html_e( 'Go to the Settings tab. A "Links" page was created automatically when you activated the plugin. If it is missing, click "Create Link Page".', 'kepas-link-ninja' ); ?></p>
                </div>
            </div>
            <div class="kln-step">
                <div class="kln-step-num">2</div>
                <div class="kln-step-content">
                    <strong><?php esc_html_e( 'Set up your Profile', 'kepas-link-ninja' ); ?></strong>
                    <p><?php esc_html_e( 'Go to the Profile tab. Upload your photo, enter your name and a short bio or tagline. This appears at the top of your link page.', 'kepas-link-ninja' ); ?></p>
                </div>
            </div>
            <div class="kln-step">
                <div class="kln-step-num">3</div>
                <div class="kln-step-content">
                    <strong><?php esc_html_e( 'Add your links', 'kepas-link-ninja' ); ?></strong>
                    <p><?php esc_html_e( 'Go to the Links tab. Use the "+ Social", "+ Streaming", "+ Release", or "+ Custom Link" buttons at the top to add sections. Inside each section, select a platform, paste your URL, and click "+ Add".', 'kepas-link-ninja' ); ?></p>
                </div>
            </div>
            <div class="kln-step">
                <div class="kln-step-num">4</div>
                <div class="kln-step-content">
                    <strong><?php esc_html_e( 'Save and view your page', 'kepas-link-ninja' ); ?></strong>
                    <p><?php esc_html_e( 'Click the purple "Save Changes" button at the top right. Then click "View Page" to see your live link page. Share that URL wherever you want!', 'kepas-link-ninja' ); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         SECTION TYPES
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </span>
            <?php esc_html_e( 'Section Types — what each one does', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-help-type-grid">
            <div class="kln-help-type-card">
                <span class="kln-section-type-badge kln-type-social">Social</span>
                <p><?php esc_html_e( 'Displays your social profiles as a row of circular coloured icons — Instagram, TikTok, Facebook, YouTube, Twitter/X, Discord, Twitch, Patreon and more. Best placed near the top.', 'kepas-link-ninja' ); ?></p>
                <div class="kln-help-tip">
                    <strong><?php esc_html_e( 'Tip:', 'kepas-link-ninja' ); ?></strong>
                    <?php esc_html_e( 'You only need one Social section. Add all your profiles inside it.', 'kepas-link-ninja' ); ?>
                </div>
            </div>
            <div class="kln-help-type-card">
                <span class="kln-section-type-badge kln-type-streaming">Streaming</span>
                <p><?php esc_html_e( 'Shows your music on streaming platforms as big labelled buttons — Spotify, Apple Music, SoundCloud, Bandcamp, Tidal, Beatport, Deezer, Amazon Music, YouTube Music, Audiomack.', 'kepas-link-ninja' ); ?></p>
                <div class="kln-help-tip">
                    <strong><?php esc_html_e( 'Tip:', 'kepas-link-ninja' ); ?></strong>
                    <?php esc_html_e( 'Enable "Expandable" (the chevron icon in the section header) to let visitors click to reveal the list — great if you have many platforms.', 'kepas-link-ninja' ); ?>
                </div>
            </div>
            <div class="kln-help-type-card">
                <span class="kln-section-type-badge kln-type-release">Release</span>
                <p><?php esc_html_e( 'A rich card for a new song, EP, or album. Upload cover art, add a release date and description, then link to every platform where it is available.', 'kepas-link-ninja' ); ?></p>
                <div class="kln-help-tip">
                    <strong><?php esc_html_e( 'Tip:', 'kepas-link-ninja' ); ?></strong>
                    <?php esc_html_e( 'Turn on "Expandable" so visitors tap the card to reveal platform links — it keeps the page clean while still giving full access.', 'kepas-link-ninja' ); ?>
                </div>
            </div>
            <div class="kln-help-type-card">
                <span class="kln-section-type-badge kln-type-custom">Custom</span>
                <p><?php esc_html_e( 'A single button that links to any URL — your website, a merch store, a booking form, a newsletter signup, anything you like.', 'kepas-link-ninja' ); ?></p>
                <div class="kln-help-tip">
                    <strong><?php esc_html_e( 'Tip:', 'kepas-link-ninja' ); ?></strong>
                    <?php esc_html_e( 'Use the section title as the button label — keep it short and action-oriented, e.g. "Book Me", "Buy Merch", "Subscribe".', 'kepas-link-ninja' ); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         VISIBILITY
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </span>
            <?php esc_html_e( 'Showing and hiding links', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-help-two-col">
            <div>
                <p><?php esc_html_e( 'Every section and every individual link has its own on/off toggle. When you turn something off:', 'kepas-link-ninja' ); ?></p>
                <ul class="kln-help-list">
                    <li><?php esc_html_e( 'The item goes dimmed with a strikethrough in the admin — you can see it is hidden at a glance.', 'kepas-link-ninja' ); ?></li>
                    <li><?php esc_html_e( 'It disappears from your public page immediately after you save.', 'kepas-link-ninja' ); ?></li>
                    <li><?php esc_html_e( 'The link is still saved — flip it back on anytime.', 'kepas-link-ninja' ); ?></li>
                </ul>
                <p><?php esc_html_e( 'Links with no URL are always hidden automatically — you never need to worry about empty buttons showing up.', 'kepas-link-ninja' ); ?></p>
                <p><?php esc_html_e( 'Sections where all links are hidden (or there are no links yet) are also hidden automatically.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-visual-box">
                <div class="kln-help-mock-row kln-help-mock-on">
                    <span class="kln-help-mock-dot" style="background:#1DB954"></span>
                    <span>Spotify</span>
                    <span class="kln-help-mock-badge kln-help-mock-badge-on">Visible</span>
                </div>
                <div class="kln-help-mock-row kln-help-mock-off">
                    <span class="kln-help-mock-dot" style="background:#aaa"></span>
                    <span style="text-decoration:line-through;opacity:.5">SoundCloud</span>
                    <span class="kln-help-mock-badge kln-help-mock-badge-off">Hidden</span>
                </div>
                <div class="kln-help-mock-row kln-help-mock-on">
                    <span class="kln-help-mock-dot" style="background:#FC3C44"></span>
                    <span>Apple Music</span>
                    <span class="kln-help-mock-badge kln-help-mock-badge-on">Visible</span>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         ORDERING
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-orange">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </span>
            <?php esc_html_e( 'Reordering sections and links', 'kepas-link-ninja' ); ?>
        </h3>
        <p><?php esc_html_e( 'Everything is drag-and-drop.', 'kepas-link-ninja' ); ?></p>
        <ul class="kln-help-list">
            <li><?php esc_html_e( 'Grab the three-line handle on the left edge of a section header to drag the whole section up or down.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'Inside a section, each link row has a smaller handle — drag links to change their order within that section.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'The order you see in the admin is exactly the order visitors see on your page.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'Always click "Save Changes" after reordering.', 'kepas-link-ninja' ); ?></li>
        </ul>
    </div>

    <!-- =====================================================================
         APPEARANCE
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-pink">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
            </span>
            <?php esc_html_e( 'Customising the look', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-help-appearance-grid">
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Background', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( 'Choose between a two-colour gradient (with adjustable angle), a solid colour, or a full background image. Gradient looks the most modern.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Card Style', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( '"Glass" (blurred semi-transparent panels) works best on gradients. "Solid" gives dark opaque buttons. "Outline" gives a minimal bordered look.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Button Roundness', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( 'Drag the slider all the way right for fully rounded pill buttons (like Linktree). Drag it left for square-cornered buttons.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Accent Colour', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( 'Used for the "New Release" badge, expand hints, and other highlights. Match it to your brand colour for a cohesive look.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Font', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( '8 Google Fonts to choose from. "Inter" and "DM Sans" are modern and readable. "Poppins" and "Raleway" have a more artistic feel.', 'kepas-link-ninja' ); ?></p>
            </div>
            <div class="kln-help-appearance-item">
                <strong><?php esc_html_e( 'Shortcode', 'kepas-link-ninja' ); ?></strong>
                <p><?php esc_html_e( 'Need to embed your links inside an existing page? Use ', 'kepas-link-ninja' ); ?><code>[kepa_link_ninja]</code><?php esc_html_e( ' anywhere in a page or post.', 'kepas-link-ninja' ); ?></p>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         DIVI COMPATIBILITY
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-teal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </span>
            <?php esc_html_e( 'Divi compatibility', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-help-notice kln-help-notice-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            <strong><?php esc_html_e( 'This plugin is designed to be 100% Divi-safe.', 'kepas-link-ninja' ); ?></strong>
        </div>
        <p><?php esc_html_e( 'When a visitor opens your Link Ninja page, the plugin completely replaces the page template before Divi can load. This means:', 'kepas-link-ninja' ); ?></p>
        <ul class="kln-help-list">
            <li><?php esc_html_e( 'Divi Builder will NOT interfere with your link page — it never even runs on that page.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'Your Divi theme and all other Divi pages are completely untouched.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'Do not open the Link Ninja page in the Divi Visual Builder — it has nothing to build there.', 'kepas-link-ninja' ); ?></li>
            <li><?php esc_html_e( 'All other pages on your site continue to use Divi normally.', 'kepas-link-ninja' ); ?></li>
        </ul>
    </div>

    <!-- =====================================================================
         FAQ
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-yellow">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </span>
            <?php esc_html_e( 'Frequently Asked Questions', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-faq">
            <?php
            $faqs = array(
                array(
                    'q' => __( 'I activated the plugin but the "Links" page looks like a regular WordPress page.', 'kepas-link-ninja' ),
                    'a' => __( 'This means the plugin page ID is not set correctly. Go to Settings tab, delete the current page from WordPress (Pages menu), then click "Create Link Page" in the plugin settings. The page must be created through the plugin so it gets the correct internal tag.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'My link page is blank / white screen.', 'kepas-link-ninja' ),
                    'a' => __( 'This is almost always a PHP error. In your hosting control panel, enable "Display Errors" or check the PHP error log. The most common cause is a PHP version below 7.4. This plugin requires PHP 7.4 or higher.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'Can I have more than one link page?', 'kepas-link-ninja' ),
                    'a' => __( 'Currently the plugin manages one link page. To create a second version, use the shortcode [kepa_link_ninja] on any other page — it will embed the same content inline.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'I saved but changes are not showing on the frontend.', 'kepas-link-ninja' ),
                    'a' => __( 'If you use a caching plugin (WP Rocket, W3 Total Cache, LiteSpeed Cache, etc.) or your host has server-side caching, you need to flush the cache after saving. In your caching plugin, click "Clear Cache" or "Purge All".', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'Can I use this without Divi?', 'kepas-link-ninja' ),
                    'a' => __( 'Yes, absolutely. The plugin works with any WordPress theme — Divi, Astra, GeneratePress, Twenty Twenty-Four, or any other. The link page always uses its own standalone template.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'Will deactivating the plugin delete my data?', 'kepas-link-ninja' ),
                    'a' => __( 'No. Deactivating keeps all your data intact. The link page will stop working (it will fall back to the default theme template), but all your links, profile, and settings are preserved. Reactivate to restore everything.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'I want to move the link page to a different URL slug.', 'kepas-link-ninja' ),
                    'a' => __( 'Go to WordPress Admin → Pages, find your Links page, and edit the permalink slug just like any other page. The plugin will still recognise it.', 'kepas-link-ninja' ),
                ),
                array(
                    'q' => __( 'What happens if I delete the link page from WordPress Pages?', 'kepas-link-ninja' ),
                    'a' => __( 'The page will disappear from your site but your links, profile, and settings in the plugin are safe. Just go to the Settings tab and click "Create Link Page" to create a fresh one.', 'kepas-link-ninja' ),
                ),
            );
            foreach ( $faqs as $faq ) :
            ?>
            <div class="kln-faq-item">
                <button class="kln-faq-question" type="button">
                    <span><?php echo esc_html( $faq['q'] ); ?></span>
                    <svg class="kln-faq-chevron" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="kln-faq-answer">
                    <p><?php echo esc_html( $faq['a'] ); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- =====================================================================
         QUICK REFERENCE CHEATSHEET
    ====================================================================== -->
    <div class="kln-help-section">
        <h3 class="kln-help-section-title">
            <span class="kln-help-section-icon kln-icon-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
            </span>
            <?php esc_html_e( 'Quick Reference', 'kepas-link-ninja' ); ?>
        </h3>
        <div class="kln-cheatsheet">
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Save', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Purple "Save Changes" button — top right, always visible', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Hide link', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Toggle switch on each link row (right side) — dimmed = hidden', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Hide section', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Toggle switch in the section header bar', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Reorder', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Drag the ≡ handle on the left of sections or links', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Collapse section', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Click the chevron (›) on the far right of the section header', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Expandable', 'kepas-link-ninja' ); ?></kbd>
                <span><?php esc_html_e( 'Chevron icon next to the Active toggle — makes the section expand on click on the public page', 'kepas-link-ninja' ); ?></span>
            </div>
            <div class="kln-cheatsheet-item">
                <kbd><?php esc_html_e( 'Shortcode', 'kepas-link-ninja' ); ?></kbd>
                <span><code>[kepa_link_ninja]</code> — <?php esc_html_e( 'embed anywhere', 'kepas-link-ninja' ); ?></span>
            </div>
        </div>
    </div>

</div><!-- .kln-help -->
