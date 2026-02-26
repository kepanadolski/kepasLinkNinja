/* global klnAdmin, jQuery */
(function ($) {
    'use strict';

    // =========================================================================
    // Helpers
    // =========================================================================

    function uid() {
        return 'kln_' + Math.random().toString(36).slice(2, 10);
    }

    function showNotice(msg, type) {
        type = type || 'success';
        var $n = $('#kln-save-notice');
        $n.attr('class', 'kln-notice kln-notice-' + type).text(msg).fadeIn(200);
        clearTimeout($n.data('timer'));
        $n.data('timer', setTimeout(function () { $n.fadeOut(300); }, 3000));
    }

    // =========================================================================
    // Visibility helpers — sync inactive CSS state with toggle checkboxes
    // =========================================================================

    function syncSectionVisibility( $section ) {
        var active = $section.find('.kln-section-active').is(':checked');
        $section.toggleClass( 'kln-inactive', ! active );
    }

    function syncLinkVisibility( $row ) {
        var active = $row.find('.kln-link-active').is(':checked');
        $row.toggleClass( 'kln-inactive', ! active );
    }

    // Apply on page load
    $('.kln-section').each( function () { syncSectionVisibility( $(this) ); } );
    $('.kln-link-row').each( function () { syncLinkVisibility( $(this) ); } );

    // React to toggle changes
    $(document).on( 'change', '.kln-section-active', function () {
        syncSectionVisibility( $(this).closest('.kln-section') );
    });
    $(document).on( 'change', '.kln-link-active', function () {
        syncLinkVisibility( $(this).closest('.kln-link-row') );
    });

    // =========================================================================
    // Tabs
    // =========================================================================

    $(document).on('click', '.kln-tab', function () {
        var tab = $(this).data('tab');
        $('.kln-tab').removeClass('active');
        $(this).addClass('active');
        $('.kln-panel').removeClass('active');
        $('#kln-tab-' + tab).addClass('active');
    });

    // =========================================================================
    // Section body collapse
    // =========================================================================

    $(document).on('click', '.kln-section-toggle-body', function () {
        var $body = $(this).closest('.kln-section').find('.kln-section-body');
        var open  = !$body.hasClass('collapsed');
        $body.toggleClass('collapsed', open);
        $(this).toggleClass('open', !open);
    });

    // =========================================================================
    // Add section
    // =========================================================================

    $(document).on('click', '[data-add-section]', function () {
        var type = $(this).data('add-section');
        var $tpl = $('#kln-section-tpl-' + type);
        if (!$tpl.length) return;

        var id  = uid();
        var html = $tpl.html()
            .replace(/__ID__/g,    id)
            .replace(/__INDEX__/g, $('.kln-section').length);

        var $new = $(html);
        $('#kln-sections').append($new);
        $('#kln-empty-state').hide();
        initSortable($new.find('.kln-links-list'));
        $new.find('.kln-section-body').scrollIntoView && $new[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });

    // =========================================================================
    // Delete section
    // =========================================================================

    $(document).on('click', '.kln-delete-section', function () {
        if (!confirm(klnAdmin.strings.confirmDelete)) return;
        $(this).closest('.kln-section').remove();
        if (!$('.kln-section').length) {
            $('#kln-empty-state').show();
        }
    });

    // =========================================================================
    // Add link inside section
    // =========================================================================

    $(document).on('click', '.kln-add-link-btn', function () {
        var $row    = $(this).closest('.kln-section');
        var $list   = $row.find('.kln-links-list');
        var type    = $row.data('type');
        var platform = $row.find('.kln-new-platform').val();
        var url      = $row.find('.kln-new-link-url').val().trim();

        if (!url) { $row.find('.kln-new-link-url').focus(); return; }

        var color = '#888';
        var label = platform;
        var all   = Object.assign({}, klnAdmin.socialPlatforms, klnAdmin.streamPlatforms);
        if (all[platform]) { color = all[platform].color; label = all[platform].label; }

        var $link = $('<div class="kln-link-row" data-id="' + uid() + '">' +
            '<span class="kln-drag-handle-sm"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg></span>' +
            '<span class="kln-platform-dot" style="background:' + color + '"></span>' +
            '<span class="kln-platform-name">' + $('<span>').text(label).html() + '</span>' +
            '<input type="url" class="kln-link-url" value="' + $('<span>').text(url).html() + '" placeholder="URL">' +
            '<input type="text" class="kln-link-label" placeholder="Label (optional)">' +
            '<input type="hidden" class="kln-link-platform" value="' + $('<span>').text(platform).html() + '">' +
            '<label class="kln-toggle kln-toggle-sm">' +
            '  <input type="checkbox" class="kln-link-active" checked>' +
            '  <span class="kln-toggle-slider"></span>' +
            '</label>' +
            '<button class="kln-btn-icon kln-btn-danger kln-delete-link" title="Delete">' +
            '  <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
            '</button>' +
            '</div>');

        $list.append($link);
        $row.find('.kln-new-link-url').val('');
    });

    // =========================================================================
    // Delete link
    // =========================================================================

    $(document).on('click', '.kln-delete-link', function () {
        if (!confirm(klnAdmin.strings.confirmDelete)) return;
        $(this).closest('.kln-link-row').remove();
    });

    // =========================================================================
    // Drag-and-drop — sections
    // =========================================================================

    function initSectionSortable() {
        $('#kln-sections').sortable({
            handle: '.kln-drag-handle',
            placeholder: 'kln-section ui-sortable-placeholder',
            tolerance: 'pointer',
            axis: 'y',
        });
    }
    initSectionSortable();

    // =========================================================================
    // Drag-and-drop — links inside section
    // =========================================================================

    function initSortable($list) {
        $list.sortable({
            handle: '.kln-drag-handle-sm',
            tolerance: 'pointer',
            axis: 'y',
        });
    }
    $('.kln-links-list').each(function () { initSortable($(this)); });

    // =========================================================================
    // Background type toggle
    // =========================================================================

    $(document).on('change', '.kln-bg-type-radio', function () {
        var val = $(this).val();
        $('.kln-bg-options').hide();
        $('.kln-bg-' + val).show();
    });

    // =========================================================================
    // Radius slider live preview
    // =========================================================================

    $('#kln-radius-slider').on('input', function () {
        $('#kln-radius-val').text($(this).val() + 'px');
    });

    // =========================================================================
    // Media uploader
    // =========================================================================

    var mediaFrame;

    $(document).on('click', '.kln-upload-btn', function (e) {
        e.preventDefault();
        var target = $(this).data('target');
        var $btn   = $(this);

        if (mediaFrame) { mediaFrame.open(); return; }

        mediaFrame = wp.media({
            title:    klnAdmin.strings.selectImage,
            button:   { text: klnAdmin.strings.useImage },
            multiple: false,
        });

        mediaFrame.on('select', function () {
            var att = mediaFrame.state().get('selection').first().toJSON();
            var url = att.sizes && att.sizes.medium ? att.sizes.medium.url : att.url;

            if (target === 'avatar') {
                $('#kln-profile-avatar-url').val(url);
                $('#kln-profile-avatar-id').val(att.id);
                var $preview = $('#kln-avatar-preview');
                $preview.empty().append($('<img>').attr('src', url));
            } else if (target === 'bg_image') {
                $('#kln-bg-image-url').val(url);
            } else if (target === 'release_cover') {
                var $section = $btn.closest('.kln-section');
                $section.find('.kln-cover-url').val(url);
                $section.find('.kln-cover-id').val(att.id);
                $section.find('.kln-cover-preview').css({
                    backgroundImage: 'url(' + url + ')',
                }).empty();
            }

            mediaFrame = null; // allow re-open next time
        });

        mediaFrame.open();
    });

    // =========================================================================
    // Help tab — FAQ accordion
    // =========================================================================

    $(document).on( 'click', '.kln-faq-question', function () {
        var $item   = $(this).closest('.kln-faq-item');
        var $answer = $item.find('.kln-faq-answer');
        var isOpen  = $item.hasClass('kln-faq-open');

        // Close all others
        $('.kln-faq-item.kln-faq-open').not($item)
            .removeClass('kln-faq-open')
            .find('.kln-faq-answer').slideUp( 200 );

        if ( isOpen ) {
            $item.removeClass('kln-faq-open');
            $answer.slideUp( 200 );
        } else {
            $item.addClass('kln-faq-open');
            $answer.slideDown( 200 );
        }
    });

    // =========================================================================
    // Create page (Settings tab)
    // =========================================================================

    $('#kln-create-page-btn').on('click', function () {
        var $btn = $(this).prop('disabled', true).text('Creating…');
        $.post(klnAdmin.ajaxUrl, {
            action: 'kln_create_page',
            nonce:  klnAdmin.nonce,
            title:  $('#kln-new-page-title').val() || 'Links',
            slug:   $('#kln-new-page-slug').val()  || 'links',
        }, function (resp) {
            $btn.prop('disabled', false).text('Create Link Page');
            if (resp.success) {
                $('#kln-create-page-result').html(
                    '<div class="kln-notice kln-notice-success">Page created! <a href="' +
                    resp.data.url + '" target="_blank">View it →</a></div>'
                );
            } else {
                $('#kln-create-page-result').html(
                    '<div class="kln-notice kln-notice-error">' + (resp.data.message || 'Error') + '</div>'
                );
            }
        });
    });

    // =========================================================================
    // Collect data and save
    // =========================================================================

    function collectSections() {
        var sections = [];

        $('.kln-section').each(function () {
            var $sec  = $(this);
            var type  = $sec.data('type');
            var links = [];

            $sec.find('.kln-link-row').each(function () {
                var $lr = $(this);
                links.push({
                    id:       $lr.data('id'),
                    platform: $lr.find('.kln-link-platform').val(),
                    url:      $lr.find('.kln-link-url').val(),
                    label:    $lr.find('.kln-link-label').val(),
                    active:   $lr.find('.kln-link-active').is(':checked') ? 1 : 0,
                });
            });

            var sec = {
                id:         $sec.data('id'),
                type:       type,
                title:      $sec.find('.kln-section-title-input').val(),
                active:     $sec.find('.kln-section-active').is(':checked') ? 1 : 0,
                expandable: $sec.find('.kln-section-expandable').is(':checked') ? 1 : 0,
                display:    'buttons',
                links:      links,
            };

            if (type === 'release') {
                sec.cover_image_url = $sec.find('.kln-cover-url').val();
                sec.cover_image_id  = $sec.find('.kln-cover-id').val();
                sec.description     = $sec.find('.kln-release-description').val();
                sec.release_date    = $sec.find('.kln-release-date').val();
            }
            if (type === 'social') {
                sec.display = 'icons';
            }
            if (type === 'custom') {
                sec.url  = $sec.find('.kln-custom-url').val();
                sec.icon = 'link';
            }

            sections.push(sec);
        });

        return sections;
    }

    $('#kln-save-btn').on('click', function () {
        var $btn = $(this).prop('disabled', true);
        var origText = $btn.find('svg').prop('outerHTML') + ' ' + klnAdmin.strings.saved;

        // Collect appearance
        var appearance = {};
        $('[name^="appearance["]').each(function () {
            var key = $(this).attr('name').replace('appearance[', '').replace(']', '');
            if ($(this).is('[type=radio]') && !$(this).is(':checked')) return;
            if ($(this).is('[type=checkbox]')) {
                appearance[key] = $(this).is(':checked') ? 1 : 0;
            } else {
                appearance[key] = $(this).val();
            }
        });

        // Collect profile
        var profile = {
            name:       $('#kln-profile-name').val(),
            bio:        $('#kln-profile-bio').val(),
            avatar_url: $('#kln-profile-avatar-url').val(),
            avatar_id:  $('#kln-profile-avatar-id').val(),
        };

        $.post(klnAdmin.ajaxUrl, {
            action:     'kln_save_all',
            nonce:      klnAdmin.nonce,
            profile:    profile,
            appearance: appearance,
            sections:   JSON.stringify(collectSections()),
        }, function (resp) {
            $btn.prop('disabled', false);
            if (resp.success) {
                showNotice(klnAdmin.strings.saved, 'success');
            } else {
                showNotice(klnAdmin.strings.saveError, 'error');
            }
        }).fail(function () {
            $btn.prop('disabled', false);
            showNotice(klnAdmin.strings.saveError, 'error');
        });
    });

}(jQuery));
