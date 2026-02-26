/* Kepa's Link Ninja — Public JavaScript */
(function () {
    'use strict';

    var shareModal, youtubeModal, releaseModal;
    var currentShareUrl = '', currentShareTitle = '', currentShareImg = '';

    function byId(id) { return document.getElementById(id); }
    function qs(el, sel) { return (el || document).querySelector(sel); }
    function qsAll(el, sel) { return (el || document).querySelectorAll(sel); }

    function openModal(modalEl) {
        if (!modalEl) return;
        modalEl.classList.add('is-open');
        modalEl.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalEl) {
        if (!modalEl) return;
        if (modalEl === youtubeModal) {
            var wrap = byId('kln-youtube-iframe-wrap');
            if (wrap) wrap.innerHTML = '';
        }
        modalEl.classList.remove('is-open');
        modalEl.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function openShareModal(url, title, img) {
        currentShareUrl = url || '';
        currentShareTitle = title || '';
        currentShareImg = img || '';
        var m = byId('kln-share-modal');
        var previewImg = byId('kln-share-preview-img');
        var previewTitle = byId('kln-share-preview-title');
        var previewUrl = byId('kln-share-preview-url');
        if (previewImg) previewImg.style.backgroundImage = currentShareImg ? 'url(' + currentShareImg + ')' : 'none';
        if (previewTitle) previewTitle.textContent = currentShareTitle;
        if (previewUrl) previewUrl.textContent = currentShareUrl;
        setShareLinks(currentShareUrl);
        openModal(m);
    }

    function setShareLinks(url) {
        var enc = encodeURIComponent(url || currentShareUrl);
        var textEnc = encodeURIComponent(currentShareTitle || document.title);
        qsAll(shareModal, '.kln-share-btn[data-action]').forEach(function (a) {
            var action = a.getAttribute('data-action');
            var href = '#';
            if (action === 'x') href = 'https://twitter.com/intent/tweet?url=' + enc + '&text=' + textEnc;
            else if (action === 'facebook') href = 'https://www.facebook.com/sharer/sharer.php?u=' + enc;
            else if (action === 'whatsapp') href = 'https://wa.me/?text=' + textEnc + '%20' + enc;
            else if (action === 'linkedin') href = 'https://www.linkedin.com/sharing/share-offsite/?url=' + enc;
            if (a.tagName === 'A') a.setAttribute('href', href);
        });
    }

    function copyToClipboard(str) {
        if (navigator.clipboard && navigator.clipboard.writeText) {
            return navigator.clipboard.writeText(str);
        }
        var ta = document.createElement('textarea');
        ta.value = str;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try {
            document.execCommand('copy');
            return Promise.resolve();
        } finally {
            document.body.removeChild(ta);
        }
    }

    function openYoutubeModal(videoId, title, url) {
        var m = byId('kln-youtube-modal');
        if (!m) return;
        var titleEl = byId('kln-youtube-modal-title');
        var wrap = byId('kln-youtube-iframe-wrap');
        var watchLink = qs(m, '.kln-youtube-watch-external');
        if (titleEl) titleEl.textContent = title || 'YouTube';
        if (watchLink) watchLink.href = url || ('https://www.youtube.com/watch?v=' + videoId);
        if (wrap) {
            wrap.innerHTML = '<iframe src="https://www.youtube.com/embed/' + videoId + '?autoplay=1" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        }
        openModal(m);
    }

    function openReleaseModal(data) {
        if (!data || !data.title) return;
        var m = byId('kln-release-modal');
        if (!m) return;
        var coverEl = byId('kln-release-modal-cover');
        var titleEl = byId('kln-release-modal-title');
        var subtitleEl = byId('kln-release-modal-subtitle');
        var streamingEl = byId('kln-release-streaming');
        if (coverEl) coverEl.style.backgroundImage = (data.cover_url && data.cover_url.length) ? 'url(' + data.cover_url + ')' : 'none';
        if (titleEl) titleEl.textContent = data.title;
        if (subtitleEl) subtitleEl.textContent = data.subtitle || '';
        if (streamingEl) {
            var icons = (typeof klnData !== 'undefined' && klnData.platformIcons) ? klnData.platformIcons : {};
            var colors = (typeof klnData !== 'undefined' && klnData.platformColors) ? klnData.platformColors : {};
            var html = '';
            (data.links || []).forEach(function (link) {
                var label = (link.label || link.platform || 'Link').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
                var url = (link.url || '#').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
                var platform = (link.platform || 'link').toLowerCase().replace(/-/g, '_');
                if (platform === 'apple_music') platform = 'apple_music';
                else if (platform === 'youtube_music') platform = 'youtube_music';
                else if (platform === 'amazon_music') platform = 'amazon_music';
                var color = colors[platform] || '#666';
                var icon = icons[platform] || icons['link'] || '';
                html += '<a href="' + url + '" class="kln-release-stream-btn" target="_blank" rel="noopener noreferrer" style="background:' + color + '"><span class="kln-release-stream-btn-icon">' + icon + '</span><span class="kln-release-stream-btn-label">' + label + '</span></a>';
            });
            streamingEl.innerHTML = html || '<p class="kln-release-no-links">No links</p>';
        }
        openModal(m);
    }

    function initModals() {
        shareModal = byId('kln-share-modal');
        youtubeModal = byId('kln-youtube-modal');
        releaseModal = byId('kln-release-modal');

        function closeAll() {
            closeModal(shareModal);
            closeModal(youtubeModal);
            closeModal(releaseModal);
        }

        qsAll(document, '.kln-modal-backdrop, .kln-modal-close').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                var modal = btn.closest('.kln-modal');
                closeModal(modal);
            });
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeAll();
        });

        if (shareModal) {
            shareModal.querySelector('.kln-share-copy') && shareModal.querySelector('.kln-share-copy').addEventListener('click', function () {
                copyToClipboard(currentShareUrl).then(function () {
                    var span = this.querySelector('span');
                    if (span) {
                        var t = span.textContent;
                        span.textContent = 'Copied!';
                        setTimeout(function () { span.textContent = t; }, 1500);
                    }
                }.bind(this));
            });
        }
    }

    function initCards() {
        document.querySelectorAll('.kln-link-card').forEach(function (card) {
            var type = card.getAttribute('data-type');
            var main = card.querySelector('.kln-link-card-main');
            var dots = card.querySelector('.kln-link-card-dots');

            if (main) {
                main.addEventListener('click', function (e) {
                    if (type === 'external') return;
                    e.preventDefault();
                    if (type === 'youtube') {
                        var videoId = card.getAttribute('data-video-id');
                        var url = card.getAttribute('data-url');
                        var title = card.querySelector('.kln-link-card-title');
                        openYoutubeModal(videoId, title ? title.textContent : '', url);
                    } else if (type === 'release') {
                        try {
                            var data = JSON.parse(card.getAttribute('data-release') || '{}');
                            openReleaseModal(data);
                        } catch (err) {}
                    }
                });
            }

            if (dots) {
                dots.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var url = dots.getAttribute('data-share-url') || '';
                    var title = dots.getAttribute('data-share-title') || '';
                    var img = dots.getAttribute('data-share-img') || '';
                    openShareModal(url, title, img);
                });
            }
        });
    }

    function initSharePage() {
        var btn = document.querySelector('.kln-icon-share-page');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var url = btn.getAttribute('data-share-url') || '';
            var title = btn.getAttribute('data-share-title') || document.title;
            if (navigator.share && navigator.canShare && navigator.canShare({ url: url, title: title })) {
                navigator.share({ url: url, title: title }).catch(function () {
                    openShareModal(url, title, '');
                });
            } else {
                openShareModal(url, title, '');
            }
        });
    }

    function initReleaseModalShare() {
        var btn = byId('kln-release-modal') && byId('kln-release-modal').querySelector('.kln-release-share');
        if (!btn) return;
        btn.addEventListener('click', function () {
            var pageUrl = document.querySelector('.kln-page') && document.querySelector('.kln-page').getAttribute('data-page-url');
            var titleEl = byId('kln-release-modal-title');
            openShareModal(pageUrl || '', titleEl ? titleEl.textContent : '', '');
        });
    }

    function initYoutubeModalShare() {
        var m = byId('kln-youtube-modal');
        if (!m) return;
        var shareBtn = m.querySelector('.kln-youtube-share');
        if (!shareBtn) return;
        shareBtn.addEventListener('click', function () {
            var watchLink = m.querySelector('.kln-youtube-watch-external');
            var titleEl = byId('kln-youtube-modal-title');
            openShareModal(watchLink ? watchLink.href : '', titleEl ? titleEl.textContent : '', '');
        });
    }

    function initExpandables() {
        document.querySelectorAll('.kln-expandable .kln-expand-trigger').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                var section = this.closest('.kln-expandable');
                var wasOpen = section.classList.contains('open');
                section.parentNode.querySelectorAll('.kln-expandable').forEach(function (s) {
                    if (s !== section) s.classList.remove('open');
                });
                section.classList.toggle('open', !wasOpen);
            });
        });
    }

    function initRipple() {
        document.querySelectorAll('.kln-stream-btn, .kln-custom-link-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var ripple = document.createElement('span');
                var rect = btn.getBoundingClientRect();
                var size = Math.max(rect.width, rect.height);
                ripple.style.cssText = [
                    'position:absolute', 'border-radius:50%', 'background:rgba(255,255,255,.25)',
                    'pointer-events:none', 'transform:scale(0)', 'animation:kln-ripple .5s linear',
                    'width:' + size + 'px', 'height:' + size + 'px',
                    'left:' + (e.clientX - rect.left - size / 2) + 'px',
                    'top:' + (e.clientY - rect.top - size / 2) + 'px'
                ].join(';');
                btn.style.position = 'relative';
                btn.style.overflow = 'hidden';
                btn.appendChild(ripple);
                setTimeout(function () { ripple.remove(); }, 600);
            });
        });
        if (!document.getElementById('kln-ripple-style')) {
            var style = document.createElement('style');
            style.id = 'kln-ripple-style';
            style.textContent = '@keyframes kln-ripple{to{transform:scale(2.5);opacity:0}}';
            document.head.appendChild(style);
        }
    }

    function initAvatarTilt() {
        var avatar = document.querySelector('.kln-avatar');
        if (!avatar || window.matchMedia('(pointer:coarse)').matches) return;
        document.addEventListener('mousemove', function (e) {
            var cx = window.innerWidth / 2, cy = window.innerHeight / 2;
            var dx = (e.clientX - cx) / cx, dy = (e.clientY - cy) / cy;
            avatar.style.transform = 'rotate3d(' + (-dy) + ',' + dx + ',0,6deg)';
        });
        document.addEventListener('mouseleave', function () { avatar.style.transform = ''; });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initModals();
        initCards();
        initSharePage();
        initReleaseModalShare();
        initYoutubeModalShare();
        initExpandables();
        initRipple();
        initAvatarTilt();
    });
})();
