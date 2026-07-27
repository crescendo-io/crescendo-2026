/**
 * Cookie consent manager (RGAA) + conditional GA4 loading.
 */
(function () {
    'use strict';

    var STORAGE_KEY = 'crescendo_cookie_consent_v1';
    var root = document.querySelector('[data-cookie-consent]');
    if (!root) {
        return;
    }

    var config = window.CrescendoCookieConsent || {};
    var gaId = config.gaId || '';
    var privacyUrl = config.privacyUrl || '/politique-de-confidentialite/';

    var dialog = root.querySelector('[data-cookie-dialog]');
    var bannerPanel = root.querySelector('[data-cookie-panel="banner"]');
    var prefsPanel = root.querySelector('[data-cookie-panel="prefs"]');
    var analyticsToggle = root.querySelector('#cookie-cat-analytics');
    var backdrop = root.querySelector('[data-cookie-backdrop]');
    var focusableSelector = 'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';
    var lastFocus = null;
    var gaLoaded = false;

    function readConsent() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            return null;
        }
    }

    function writeConsent(consent) {
        var payload = {
            necessary: true,
            analytics: !!consent.analytics,
            updatedAt: new Date().toISOString(),
            version: 1
        };
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
        } catch (e) {
            // Ignore quota / private mode errors.
        }
        return payload;
    }

    function clearAnalyticsCookies() {
        var hostname = window.location.hostname.replace(/^www\./, '');
        var names = ['_ga', '_gid', '_gat', '_ga_' + String(gaId || '').replace(/^G-/, '')];
        names.forEach(function (name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/';
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/; domain=.' + hostname;
        });
    }

    function loadGoogleAnalytics() {
        if (!gaId || gaLoaded) {
            return;
        }
        gaLoaded = true;

        window.dataLayer = window.dataLayer || [];
        window.gtag = window.gtag || function () {
            window.dataLayer.push(arguments);
        };

        window.gtag('js', new Date());
        window.gtag('config', gaId, {
            anonymize_ip: true,
            allow_google_signals: false,
            allow_ad_personalization_signals: false
        });

        var script = document.createElement('script');
        script.async = true;
        script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gaId);
        document.head.appendChild(script);
    }

    function applyConsent(consent) {
        if (consent && consent.analytics) {
            loadGoogleAnalytics();
        } else {
            clearAnalyticsCookies();
        }
    }

    function hasAnalyticsConsent() {
        var consent = readConsent();
        return !!(consent && consent.analytics);
    }

    function trackEvent(name, params, done) {
        if (!hasAnalyticsConsent()) {
            if (typeof done === 'function') {
                done();
            }
            return;
        }

        loadGoogleAnalytics();

        if (typeof window.gtag !== 'function') {
            if (typeof done === 'function') {
                done();
            }
            return;
        }

        var eventParams = params ? Object.assign({}, params) : {};

        if (typeof done === 'function') {
            var finished = false;
            var finish = function () {
                if (finished) {
                    return;
                }
                finished = true;
                done();
            };

            eventParams.event_callback = finish;
            eventParams.event_timeout = 2000;
            window.setTimeout(finish, 2100);
        }

        window.gtag('event', name, eventParams);
    }

    var generateLeadStorageKey = 'crescendo_generate_lead_sent_v1';

    function trackGenerateLead(done) {
        try {
            if (sessionStorage.getItem(generateLeadStorageKey)) {
                if (typeof done === 'function') {
                    done();
                }
                return;
            }
        } catch (e) {
            // Ignore storage failures.
        }

        trackEvent('generate_lead', null, function () {
            try {
                sessionStorage.setItem(generateLeadStorageKey, '1');
            } catch (e) {
                // Ignore storage failures.
            }

            if (typeof done === 'function') {
                done();
            }
        });
    }

    function getFocusable() {
        return Array.prototype.slice.call(dialog.querySelectorAll(focusableSelector)).filter(function (el) {
            return el.offsetParent !== null || el === document.activeElement;
        });
    }

    function trapFocus(event) {
        if (event.key !== 'Tab' || root.hidden) {
            return;
        }
        var focusable = getFocusable();
        if (!focusable.length) {
            return;
        }
        var first = focusable[0];
        var last = focusable[focusable.length - 1];
        if (event.shiftKey && document.activeElement === first) {
            event.preventDefault();
            last.focus();
        } else if (!event.shiftKey && document.activeElement === last) {
            event.preventDefault();
            first.focus();
        }
    }

    function showPanel(name) {
        var isPrefs = name === 'prefs';
        bannerPanel.hidden = isPrefs;
        prefsPanel.hidden = !isPrefs;
        dialog.setAttribute('aria-labelledby', isPrefs ? 'cookie-prefs-title' : 'cookie-consent-title');
        dialog.setAttribute('aria-describedby', isPrefs ? 'cookie-cat-analytics-desc' : 'cookie-consent-desc');
    }

    function openConsent(panel) {
        lastFocus = document.activeElement;
        root.hidden = false;
        document.body.classList.add('cookie-consent-open');
        showPanel(panel || 'banner');
        window.setTimeout(function () {
            var focusTarget = dialog.querySelector('[data-cookie-action="accept"]') || dialog;
            focusTarget.focus();
        }, 10);
        document.addEventListener('keydown', onKeydown);
    }

    function closeConsent() {
        root.hidden = true;
        document.body.classList.remove('cookie-consent-open');
        document.removeEventListener('keydown', onKeydown);
        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    }

    function onKeydown(event) {
        if (event.key === 'Escape') {
            var consent = readConsent();
            if (consent) {
                closeConsent();
            } else if (!prefsPanel.hidden) {
                showPanel('banner');
                dialog.querySelector('[data-cookie-action="customize"]').focus();
            }
            return;
        }
        trapFocus(event);
    }

    function acceptAll() {
        var consent = writeConsent({ analytics: true });
        applyConsent(consent);
        closeConsent();
    }

    function refuseAll() {
        if (analyticsToggle) {
            analyticsToggle.checked = false;
        }
        var consent = writeConsent({ analytics: false });
        applyConsent(consent);
        closeConsent();
    }

    function savePrefs() {
        var consent = writeConsent({
            analytics: !!(analyticsToggle && analyticsToggle.checked)
        });
        applyConsent(consent);
        closeConsent();
    }

    function syncToggleFromStorage() {
        var consent = readConsent();
        if (analyticsToggle) {
            analyticsToggle.checked = !!(consent && consent.analytics);
        }
    }

    root.addEventListener('click', function (event) {
        var actionEl = event.target.closest('[data-cookie-action]');
        if (!actionEl) {
            if (event.target === backdrop) {
                var existing = readConsent();
                if (existing) {
                    closeConsent();
                }
            }
            return;
        }

        var action = actionEl.getAttribute('data-cookie-action');
        if (action === 'accept') {
            acceptAll();
        } else if (action === 'refuse') {
            refuseAll();
        } else if (action === 'customize') {
            syncToggleFromStorage();
            showPanel('prefs');
            if (analyticsToggle) {
                analyticsToggle.focus();
            }
        } else if (action === 'save') {
            savePrefs();
        } else if (action === 'back') {
            showPanel('banner');
            dialog.querySelector('[data-cookie-action="customize"]').focus();
        }
    });

    document.addEventListener('click', function (event) {
        var trigger = event.target.closest('[data-cookie-open], a[href="#cookie-consent"], a[href="#rgpd-manage"]');
        if (!trigger) {
            return;
        }
        event.preventDefault();
        syncToggleFromStorage();
        openConsent('prefs');
    });

    var existing = readConsent();
    if (existing) {
        applyConsent(existing);
        root.hidden = true;
    } else {
        openConsent('banner');
    }

    window.CrescendoCookieConsentApi = {
        open: function () {
            syncToggleFromStorage();
            openConsent('prefs');
        },
        getConsent: readConsent,
        trackEvent: trackEvent,
        trackGenerateLead: trackGenerateLead,
        privacyUrl: privacyUrl
    };
})();
