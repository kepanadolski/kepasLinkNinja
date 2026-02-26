/* Kepa's Link Ninja — Public JavaScript */
(function () {
    'use strict';

    // =========================================================================
    // Expandable sections
    // =========================================================================

    function initExpandables() {
        document.querySelectorAll('.kln-expandable .kln-expand-trigger').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                var section = this.closest('.kln-expandable');
                var wasOpen = section.classList.contains('open');

                // Close all siblings in same parent (accordion-style)
                // (optional - remove loop if you want multiple open at once)
                var siblings = section.parentNode.querySelectorAll('.kln-expandable');
                siblings.forEach(function (s) {
                    if (s !== section) s.classList.remove('open');
                });

                section.classList.toggle('open', !wasOpen);
            });
        });
    }

    // =========================================================================
    // Smooth link hover ripple effect
    // =========================================================================

    function initRipple() {
        document.querySelectorAll('.kln-stream-btn, .kln-custom-link-btn').forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                var ripple = document.createElement('span');
                var rect   = btn.getBoundingClientRect();
                var size   = Math.max(rect.width, rect.height);
                ripple.style.cssText = [
                    'position:absolute',
                    'border-radius:50%',
                    'background:rgba(255,255,255,.25)',
                    'pointer-events:none',
                    'transform:scale(0)',
                    'animation:kln-ripple .5s linear',
                    'width:'  + size + 'px',
                    'height:' + size + 'px',
                    'left:'   + (e.clientX - rect.left - size/2) + 'px',
                    'top:'    + (e.clientY - rect.top  - size/2) + 'px',
                ].join(';');
                btn.style.position = 'relative';
                btn.style.overflow = 'hidden';
                btn.appendChild(ripple);
                setTimeout(function () { ripple.remove(); }, 600);
            });
        });

        // Inject ripple keyframe once
        if (!document.getElementById('kln-ripple-style')) {
            var style = document.createElement('style');
            style.id  = 'kln-ripple-style';
            style.textContent = '@keyframes kln-ripple{to{transform:scale(2.5);opacity:0}}';
            document.head.appendChild(style);
        }
    }

    // =========================================================================
    // Avatar parallax tilt (subtle, on desktop only)
    // =========================================================================

    function initAvatarTilt() {
        var avatar = document.querySelector('.kln-avatar');
        if (!avatar || window.matchMedia('(pointer:coarse)').matches) return;

        document.addEventListener('mousemove', function (e) {
            var cx = window.innerWidth  / 2;
            var cy = window.innerHeight / 2;
            var dx = (e.clientX - cx) / cx;
            var dy = (e.clientY - cy) / cy;
            avatar.style.transform = 'rotate3d(' + (-dy) + ',' + dx + ',0,6deg)';
        });
        document.addEventListener('mouseleave', function () {
            avatar.style.transform = '';
        });
    }

    // =========================================================================
    // Init
    // =========================================================================

    document.addEventListener('DOMContentLoaded', function () {
        initExpandables();
        initRipple();
        initAvatarTilt();
    });

}());
