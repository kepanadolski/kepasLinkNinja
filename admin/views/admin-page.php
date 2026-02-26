<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<div class="kln-wrap">

    <!-- Header -->
    <div class="kln-header">
        <div class="kln-header-brand">
            <svg class="kln-logo-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <h1><?php esc_html_e( "Kepa's Link Ninja", 'kepas-link-ninja' ); ?></h1>
            <span class="kln-version">v<?php echo esc_html( KLN_VERSION ); ?></span>
        </div>
        <div class="kln-header-actions">
            <?php if ( $page_url ) : ?>
                <a href="<?php echo esc_url( $page_url ); ?>" target="_blank" class="kln-btn kln-btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15,3 21,3 21,9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    <?php esc_html_e( 'View Page', 'kepas-link-ninja' ); ?>
                </a>
            <?php endif; ?>
            <button id="kln-save-btn" class="kln-btn kln-btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17,21 17,13 7,13 7,21"/><polyline points="7,3 7,8 15,8"/></svg>
                <?php esc_html_e( 'Save Changes', 'kepas-link-ninja' ); ?>
            </button>
        </div>
    </div>

    <div id="kln-save-notice" class="kln-notice kln-notice-success" style="display:none"></div>

    <!-- Tabs -->
    <nav class="kln-tabs">
        <button class="kln-tab active" data-tab="profile">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            <?php esc_html_e( 'Profile', 'kepas-link-ninja' ); ?>
        </button>
        <button class="kln-tab" data-tab="links">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
            <?php esc_html_e( 'Links', 'kepas-link-ninja' ); ?>
        </button>
        <button class="kln-tab" data-tab="appearance">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/><path d="M2 12h20"/></svg>
            <?php esc_html_e( 'Appearance', 'kepas-link-ninja' ); ?>
        </button>
        <button class="kln-tab" data-tab="settings">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93L17.66 6.34M4.93 4.93L6.34 6.34M12 2v2M12 20v2M20 12h2M2 12h2M19.07 19.07l-1.41-1.41M4.93 19.07l1.41-1.41"/></svg>
            <?php esc_html_e( 'Settings', 'kepas-link-ninja' ); ?>
        </button>
        <button class="kln-tab kln-tab-help" data-tab="help">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            <?php esc_html_e( 'Help & Guide', 'kepas-link-ninja' ); ?>
        </button>
    </nav>

    <!-- =====================================================================
         TAB: PROFILE
    ====================================================================== -->
    <div class="kln-panel active" id="kln-tab-profile">
        <div class="kln-card">
            <h2 class="kln-card-title"><?php esc_html_e( 'Your Profile', 'kepas-link-ninja' ); ?></h2>
            <div class="kln-row">
                <!-- Avatar -->
                <div class="kln-avatar-picker">
                    <div class="kln-avatar-preview" id="kln-avatar-preview">
                        <?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
                            <img src="<?php echo esc_url( $profile['avatar_url'] ); ?>" alt="Avatar">
                        <?php else : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="kln-btn kln-btn-outline kln-upload-btn" data-target="avatar">
                        <?php esc_html_e( 'Upload Photo', 'kepas-link-ninja' ); ?>
                    </button>
                    <input type="hidden" id="kln-profile-avatar-url" name="profile[avatar_url]" value="<?php echo esc_attr( $profile['avatar_url'] ?? '' ); ?>">
                    <input type="hidden" id="kln-profile-avatar-id"  name="profile[avatar_id]"  value="<?php echo esc_attr( $profile['avatar_id']  ?? 0 ); ?>">
                </div>
                <!-- Fields -->
                <div class="kln-fields">
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Display Name', 'kepas-link-ninja' ); ?></label>
                        <input type="text" id="kln-profile-name" name="profile[name]" value="<?php echo esc_attr( $profile['name'] ?? '' ); ?>" placeholder="<?php esc_attr_e( 'Your Name', 'kepas-link-ninja' ); ?>">
                    </div>
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Bio / Tagline', 'kepas-link-ninja' ); ?></label>
                        <textarea id="kln-profile-bio" name="profile[bio]" rows="3" placeholder="<?php esc_attr_e( 'Musician | Artist | Creator', 'kepas-link-ninja' ); ?>"><?php echo esc_textarea( $profile['bio'] ?? '' ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         TAB: LINKS
    ====================================================================== -->
    <div class="kln-panel" id="kln-tab-links">

        <div class="kln-toolbar">
            <span class="kln-toolbar-hint"><?php esc_html_e( 'Drag sections to reorder. Add links inside each section.', 'kepas-link-ninja' ); ?></span>
            <div class="kln-add-section-btns">
                <button class="kln-btn kln-btn-sm kln-btn-outline" data-add-section="social">+ Social</button>
                <button class="kln-btn kln-btn-sm kln-btn-outline" data-add-section="streaming">+ Streaming</button>
                <button class="kln-btn kln-btn-sm kln-btn-outline" data-add-section="release">+ Release</button>
                <button class="kln-btn kln-btn-sm kln-btn-outline" data-add-section="custom">+ Custom Link</button>
            </div>
        </div>

        <div id="kln-sections" class="kln-sections-list">
            <?php foreach ( $sections as $index => $section ) :
                $this->render_section( $section, $index );
            endforeach; ?>
        </div>

        <?php if ( empty( $sections ) ) : ?>
            <div class="kln-empty-state" id="kln-empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                <p><?php esc_html_e( 'No sections yet. Add your first section above!', 'kepas-link-ninja' ); ?></p>
            </div>
        <?php endif; ?>
    </div>

    <!-- =====================================================================
         TAB: APPEARANCE
    ====================================================================== -->
    <div class="kln-panel" id="kln-tab-appearance">
        <div class="kln-appearance-grid">

            <!-- Background -->
            <div class="kln-card">
                <h2 class="kln-card-title"><?php esc_html_e( 'Background', 'kepas-link-ninja' ); ?></h2>

                <div class="kln-field">
                    <label><?php esc_html_e( 'Background Type', 'kepas-link-ninja' ); ?></label>
                    <div class="kln-radio-group">
                        <?php foreach ( array( 'gradient' => 'Gradient', 'solid' => 'Solid Color', 'image' => 'Image' ) as $val => $lbl ) : ?>
                            <label class="kln-radio">
                                <input type="radio" name="appearance[bg_type]" value="<?php echo esc_attr( $val ); ?>" <?php checked( $appearance['bg_type'] ?? 'gradient', $val ); ?> class="kln-bg-type-radio">
                                <?php echo esc_html( $lbl ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="kln-bg-options kln-bg-gradient" <?php echo ( ( $appearance['bg_type'] ?? 'gradient' ) !== 'gradient' ) ? 'style="display:none"' : ''; ?>>
                    <div class="kln-inline-fields">
                        <div class="kln-field">
                            <label><?php esc_html_e( 'Color 1', 'kepas-link-ninja' ); ?></label>
                            <input type="color" name="appearance[bg_color_1]" value="<?php echo esc_attr( $appearance['bg_color_1'] ?? '#1a0533' ); ?>">
                        </div>
                        <div class="kln-field">
                            <label><?php esc_html_e( 'Color 2', 'kepas-link-ninja' ); ?></label>
                            <input type="color" name="appearance[bg_color_2]" value="<?php echo esc_attr( $appearance['bg_color_2'] ?? '#6C3AE8' ); ?>">
                        </div>
                        <div class="kln-field">
                            <label><?php esc_html_e( 'Angle', 'kepas-link-ninja' ); ?></label>
                            <input type="number" name="appearance[bg_angle]" value="<?php echo esc_attr( $appearance['bg_angle'] ?? 135 ); ?>" min="0" max="360" style="width:80px">
                        </div>
                    </div>
                </div>

                <div class="kln-bg-options kln-bg-solid" <?php echo ( ( $appearance['bg_type'] ?? 'gradient' ) !== 'solid' ) ? 'style="display:none"' : ''; ?>>
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Background Color', 'kepas-link-ninja' ); ?></label>
                        <input type="color" name="appearance[bg_color_1]" value="<?php echo esc_attr( $appearance['bg_color_1'] ?? '#1a0533' ); ?>">
                    </div>
                </div>

                <div class="kln-bg-options kln-bg-image" <?php echo ( ( $appearance['bg_type'] ?? 'gradient' ) !== 'image' ) ? 'style="display:none"' : ''; ?>>
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Background Image', 'kepas-link-ninja' ); ?></label>
                        <div class="kln-image-picker">
                            <input type="text" name="appearance[bg_image_url]" id="kln-bg-image-url" value="<?php echo esc_attr( $appearance['bg_image_url'] ?? '' ); ?>" placeholder="https://">
                            <button type="button" class="kln-btn kln-btn-outline kln-upload-btn" data-target="bg_image"><?php esc_html_e( 'Browse', 'kepas-link-ninja' ); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cards & Buttons -->
            <div class="kln-card">
                <h2 class="kln-card-title"><?php esc_html_e( 'Cards & Buttons', 'kepas-link-ninja' ); ?></h2>

                <div class="kln-field">
                    <label><?php esc_html_e( 'Card Style', 'kepas-link-ninja' ); ?></label>
                    <div class="kln-radio-group">
                        <?php foreach ( array( 'glass' => 'Glass', 'solid' => 'Solid', 'outline' => 'Outline' ) as $val => $lbl ) : ?>
                            <label class="kln-radio">
                                <input type="radio" name="appearance[card_style]" value="<?php echo esc_attr( $val ); ?>" <?php checked( $appearance['card_style'] ?? 'glass', $val ); ?>>
                                <?php echo esc_html( $lbl ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="kln-inline-fields">
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Text Color', 'kepas-link-ninja' ); ?></label>
                        <input type="color" name="appearance[text_color]" value="<?php echo esc_attr( $appearance['text_color'] ?? '#ffffff' ); ?>">
                    </div>
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Accent Color', 'kepas-link-ninja' ); ?></label>
                        <input type="color" name="appearance[accent_color]" value="<?php echo esc_attr( $appearance['accent_color'] ?? '#a78bfa' ); ?>">
                    </div>
                </div>

                <div class="kln-field">
                    <label><?php esc_html_e( 'Button Roundness', 'kepas-link-ninja' ); ?> <span id="kln-radius-val"><?php echo esc_html( $appearance['button_radius'] ?? 50 ); ?>px</span></label>
                    <input type="range" name="appearance[button_radius]" id="kln-radius-slider" value="<?php echo esc_attr( $appearance['button_radius'] ?? 50 ); ?>" min="0" max="50">
                </div>
            </div>

            <!-- Typography -->
            <div class="kln-card">
                <h2 class="kln-card-title"><?php esc_html_e( 'Typography', 'kepas-link-ninja' ); ?></h2>
                <div class="kln-field">
                    <label><?php esc_html_e( 'Font', 'kepas-link-ninja' ); ?></label>
                    <select name="appearance[font]">
                        <?php foreach ( array( 'Inter', 'Poppins', 'Montserrat', 'Raleway', 'Nunito', 'DM Sans', 'Outfit', 'Space Grotesk' ) as $font ) : ?>
                            <option value="<?php echo esc_attr( $font ); ?>" <?php selected( $appearance['font'] ?? 'Inter', $font ); ?>><?php echo esc_html( $font ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="kln-field">
                    <label class="kln-checkbox-label">
                        <input type="checkbox" name="appearance[show_footer]" value="1" <?php checked( ! empty( $appearance['show_footer'] ) ); ?>>
                        <?php esc_html_e( 'Show "Powered by Kepa\'s Link Ninja" footer', 'kepas-link-ninja' ); ?>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         TAB: SETTINGS
    ====================================================================== -->
    <div class="kln-panel" id="kln-tab-settings">
        <div class="kln-card">
            <h2 class="kln-card-title"><?php esc_html_e( 'Update from GitHub', 'kepas-link-ninja' ); ?></h2>
            <p><strong><?php esc_html_e( 'Your links and settings are stored in the database and are never lost when you update the plugin.', 'kepas-link-ninja' ); ?></strong></p>
            <p>
                <?php echo esc_html( sprintf( __( 'Current version: %s', 'kepas-link-ninja' ), KLN_VERSION ) ); ?>
                <?php
                $release = class_exists( 'KLN_Updater' ) ? KLN_Updater::get_latest_release() : null;
                if ( $release && ! empty( $release['version'] ) && version_compare( $release['version'], KLN_VERSION, '>' ) ) :
                    ?>
                    — <strong><?php esc_html_e( 'New version available:', 'kepas-link-ninja' ); ?> <?php echo esc_html( $release['version'] ); ?></strong>
                <?php endif; ?>
            </p>

            <h3 class="kln-card-subtitle"><?php esc_html_e( 'How to update from your first version (v1.0.0) right now', 'kepas-link-ninja' ); ?></h3>
            <ol class="kln-update-steps">
                <li><?php esc_html_e( 'Download the latest plugin code from GitHub (clone or Download ZIP from the repo).', 'kepas-link-ninja' ); ?></li>
                <li><?php esc_html_e( 'Rename the folder to exactly: kepas-link-ninja (if it has another name like kepasLinkNinja).', 'kepas-link-ninja' ); ?></li>
                <li><?php esc_html_e( 'Zip that folder so the zip contains one folder named kepas-link-ninja with all plugin files inside.', 'kepas-link-ninja' ); ?></li>
                <li><?php esc_html_e( 'In WordPress: Plugins → Add New → Upload Plugin → choose your zip → Install Now → Replace current with upload.', 'kepas-link-ninja' ); ?></li>
            </ol>
            <p class="kln-description"><?php esc_html_e( 'Or replace the plugin folder via FTP / file manager: upload the new kepas-link-ninja folder over the old one. Your links and settings stay safe.', 'kepas-link-ninja' ); ?></p>

            <h3 class="kln-card-subtitle"><?php esc_html_e( 'One-click updates later (optional)', 'kepas-link-ninja' ); ?></h3>
            <p class="kln-description"><?php esc_html_e( 'To get "Update" on the Plugins page from GitHub: create a Release on GitHub and attach a .zip file. The zip must contain a single folder named kepas-link-ninja with the plugin files (same as above). Then click "Check for updates" below and update from the Plugins screen.', 'kepas-link-ninja' ); ?></p>

            <a href="<?php echo esc_url( admin_url( 'admin.php?page=kepas-link-ninja&kln_check_updates=1' ) ); ?>" class="kln-btn kln-btn-primary">
                <?php esc_html_e( 'Check for updates', 'kepas-link-ninja' ); ?>
            </a>
            <p class="kln-description" style="margin-top:12px">
                <a href="<?php echo esc_url( admin_url( 'plugins.php' ) ); ?>"><?php esc_html_e( 'Go to Plugins page', 'kepas-link-ninja' ); ?></a>
                <?php esc_html_e( 'to see and run updates when available.', 'kepas-link-ninja' ); ?>
            </p>
        </div>

        <div class="kln-card">
            <h2 class="kln-card-title"><?php esc_html_e( 'Link Page', 'kepas-link-ninja' ); ?></h2>

            <?php if ( $page_url ) : ?>
                <div class="kln-notice kln-notice-info">
                    <?php esc_html_e( 'Your Link Ninja page is live at:', 'kepas-link-ninja' ); ?>
                    <a href="<?php echo esc_url( $page_url ); ?>" target="_blank"><?php echo esc_html( $page_url ); ?></a>
                </div>
                <div class="kln-page-actions">
                    <a href="<?php echo esc_url( get_edit_post_link( $page_id ) ); ?>" class="kln-btn kln-btn-outline"><?php esc_html_e( 'Edit Page', 'kepas-link-ninja' ); ?></a>
                    <a href="<?php echo esc_url( $page_url ); ?>" target="_blank" class="kln-btn kln-btn-primary"><?php esc_html_e( 'View Page', 'kepas-link-ninja' ); ?></a>
                </div>
            <?php else : ?>
                <p><?php esc_html_e( 'No link page found. Create one below.', 'kepas-link-ninja' ); ?></p>
                <div class="kln-inline-fields">
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Page Title', 'kepas-link-ninja' ); ?></label>
                        <input type="text" id="kln-new-page-title" value="Links" placeholder="Links">
                    </div>
                    <div class="kln-field">
                        <label><?php esc_html_e( 'Page Slug', 'kepas-link-ninja' ); ?></label>
                        <input type="text" id="kln-new-page-slug" value="links" placeholder="links">
                    </div>
                </div>
                <button id="kln-create-page-btn" class="kln-btn kln-btn-primary"><?php esc_html_e( 'Create Link Page', 'kepas-link-ninja' ); ?></button>
                <div id="kln-create-page-result" style="margin-top:12px"></div>
            <?php endif; ?>
        </div>

        <div class="kln-card">
            <h2 class="kln-card-title"><?php esc_html_e( 'Shortcode', 'kepas-link-ninja' ); ?></h2>
            <p><?php esc_html_e( 'Alternatively, embed your links anywhere using this shortcode:', 'kepas-link-ninja' ); ?></p>
            <div class="kln-shortcode-box" onclick="this.querySelector('code').select()">
                <code>[kepa_link_ninja]</code>
            </div>
        </div>
    </div>

    <!-- =====================================================================
         TAB: HELP & GUIDE
    ====================================================================== -->
    <div class="kln-panel" id="kln-tab-help">
        <?php include KLN_PLUGIN_DIR . 'admin/views/help-tab.php'; ?>
    </div>

</div>

<!-- =========================================================================
     SECTION TEMPLATE (hidden, cloned by JS)
========================================================================== -->
<script type="text/html" id="kln-section-tpl-social">
    <?php $this->render_section( array(
        'id' => '__ID__', 'type' => 'social', 'title' => 'Follow Me',
        'active' => true, 'expandable' => false, 'display' => 'icons', 'links' => array()
    ), '__INDEX__', true ); ?>
</script>
<script type="text/html" id="kln-section-tpl-streaming">
    <?php $this->render_section( array(
        'id' => '__ID__', 'type' => 'streaming', 'title' => 'Listen Now',
        'active' => true, 'expandable' => false, 'display' => 'buttons', 'links' => array()
    ), '__INDEX__', true ); ?>
</script>
<script type="text/html" id="kln-section-tpl-release">
    <?php $this->render_section( array(
        'id' => '__ID__', 'type' => 'release', 'title' => 'New Release',
        'active' => true, 'expandable' => true, 'display' => 'buttons',
        'cover_image_url' => '', 'cover_image_id' => 0,
        'description' => '', 'release_date' => '', 'links' => array()
    ), '__INDEX__', true ); ?>
</script>
<script type="text/html" id="kln-section-tpl-custom">
    <?php $this->render_section( array(
        'id' => '__ID__', 'type' => 'custom', 'title' => 'My Link',
        'active' => true, 'url' => '', 'icon' => 'link', 'links' => array()
    ), '__INDEX__', true ); ?>
</script>
