/**
 * Maha Construction & Interiors — Resilient Network & Asset Engine
 * Handles slow network detection, offline state, progressive loading,
 * request timeouts, auto-retries, and global image error fallbacks.
 */
(function () {
    'use strict';

    // 1. Connection Detection & Diagnostics
    var connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;
    var isSlow = false;

    function evaluateConnection() {
        if (!connection) {
            window.isSlowNetwork = false;
            return;
        }

        var saveData = connection.saveData === true;
        var effectiveType = connection.effectiveType || '';
        var rtt = connection.rtt || 0;
        var downlink = connection.downlink || 10;

        isSlow = saveData ||
            effectiveType === 'slow-2g' ||
            effectiveType === '2g' ||
            effectiveType === '3g' ||
            (rtt > 800) ||
            (downlink < 1.0);

        window.isSlowNetwork = isSlow;

        if (isSlow) {
            document.documentElement.classList.add('is-slow-connection');
        } else {
            document.documentElement.classList.remove('is-slow-connection');
        }
    }

    evaluateConnection();
    if (connection && typeof connection.addEventListener === 'function') {
        connection.addEventListener('change', evaluateConnection);
    }

    // 2. Online / Offline Status Toast
    function createOfflineToast() {
        if (document.getElementById('mahaOfflineToast')) return;

        var toast = document.createElement('div');
        toast.id = 'mahaOfflineToast';
        toast.className = 'maha-offline-toast';
        toast.setAttribute('role', 'status');
        toast.setAttribute('aria-live', 'polite');
        toast.innerHTML = '<span class="offline-dot"></span><span id="mahaOfflineMsg">Offline mode &bull; Viewing cached content</span>';
        document.body.appendChild(toast);
    }

    function updateOnlineStatus() {
        var toast = document.getElementById('mahaOfflineToast');
        if (!toast && document.body) {
            createOfflineToast();
            toast = document.getElementById('mahaOfflineToast');
        }

        if (!navigator.onLine) {
            document.documentElement.classList.add('is-offline');
            if (toast) {
                document.getElementById('mahaOfflineMsg').innerHTML = '<i class="fas fa-wifi-slash" style="margin-right:6px;"></i> Connection interrupted &bull; Viewing cached content';
                toast.classList.add('is-visible', 'is-warning');
            }
        } else {
            document.documentElement.classList.remove('is-offline');
            if (toast && toast.classList.contains('is-visible')) {
                document.getElementById('mahaOfflineMsg').innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;color:#10B981;"></i> Connection restored';
                toast.classList.remove('is-warning');
                toast.classList.add('is-online');
                setTimeout(function () {
                    toast.classList.remove('is-visible', 'is-online');
                }, 2800);
            }
        }
    }

    window.addEventListener('online', updateOnlineStatus);
    window.addEventListener('offline', updateOnlineStatus);

    document.addEventListener('DOMContentLoaded', function () {
        if (!navigator.onLine) {
            createOfflineToast();
            updateOnlineStatus();
        }
    });

    // 3. Global Bulletproof Image Error Fallback Net
    window.addEventListener('error', function (e) {
        if (e && e.target && e.target.tagName === 'IMG') {
            var img = e.target;
            if (!img.getAttribute('data-has-failed')) {
                img.setAttribute('data-has-failed', 'true');
                img.classList.add('img-load-fallback');
                var isAvatar = img.classList.contains('quote-avatar') || img.classList.contains('client-avatar') || img.classList.contains('int-card-cur-slide-num');
                var fallbackSvg = isAvatar ? '/images/placeholder-avatar.svg' : '/images/placeholder-project.svg';
                img.src = fallbackSvg;
            }
        }
    }, true);

    // 4. Resilient Fetch Wrapper (window.mahaFetch)
    window.mahaFetch = function (url, options, config) {
        options = options || {};
        config = config || {};

        var timeoutMs = config.timeout || (isSlow ? 12000 : 8000);
        var maxRetries = typeof config.retries === 'number' ? config.retries : 1;
        var retryDelay = config.retryDelay || 1200;

        return new Promise(function (resolve, reject) {
            var attempt = 0;

            function execute() {
                attempt++;
                var controller = new AbortController();
                var timeoutId = setTimeout(function () {
                    controller.abort();
                }, timeoutMs);

                var reqOptions = Object.assign({}, options, { signal: controller.signal });

                fetch(url, reqOptions)
                    .then(function (res) {
                        clearTimeout(timeoutId);
                        if (!res.ok && res.status >= 500 && attempt <= maxRetries) {
                            setTimeout(execute, retryDelay);
                        } else {
                            resolve(res);
                        }
                    })
                    .catch(function (err) {
                        clearTimeout(timeoutId);
                        if (attempt <= maxRetries && (!navigator.onLine || err.name === 'AbortError' || err.message.indexOf('network') !== -1)) {
                            setTimeout(execute, retryDelay);
                        } else {
                            reject(err);
                        }
                    });
            }

            execute();
        });
    };

})();
