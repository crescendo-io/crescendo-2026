(function (window) {
    var STORAGE_KEY = 'crescendo_lead_attribution_v1';
    var TRACKED_PARAMS = [
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'msclkid',
        'fbclid',
    ];
    var FIELD_MAP = {
        utm_source: 'attribution_utm_source',
        utm_medium: 'attribution_utm_medium',
        utm_campaign: 'attribution_utm_campaign',
        utm_term: 'attribution_utm_term',
        utm_content: 'attribution_utm_content',
        gclid: 'attribution_gclid',
        msclkid: 'attribution_msclkid',
        fbclid: 'attribution_fbclid',
        landing_page: 'attribution_landing_page',
        referrer: 'attribution_referrer',
    };

    function readStoredAttribution() {
        try {
            var raw = window.sessionStorage.getItem(STORAGE_KEY);
            return raw ? JSON.parse(raw) : null;
        } catch (error) {
            return null;
        }
    }

    function writeStoredAttribution(data) {
        try {
            window.sessionStorage.setItem(STORAGE_KEY, JSON.stringify(data));
        } catch (error) {
            // Ignore storage failures (private mode, quota, etc.).
        }
    }

    function captureAttribution() {
        var stored = readStoredAttribution() || {};
        var params = new URLSearchParams(window.location.search);
        var changed = false;

        TRACKED_PARAMS.forEach(function (key) {
            if (!params.has(key)) {
                return;
            }

            var value = params.get(key);
            if (!value) {
                return;
            }

            stored[key] = value;
            changed = true;
        });

        if (!stored.landing_page) {
            stored.landing_page = window.location.href.split('#')[0];
            changed = true;
        }

        if (!stored.referrer && document.referrer) {
            stored.referrer = document.referrer;
            changed = true;
        }

        if (changed || !readStoredAttribution()) {
            writeStoredAttribution(stored);
        }

        return stored;
    }

    function setHiddenValue(form, name, value) {
        var input = form.querySelector('[name="' + name + '"]');
        if (input) {
            input.value = value || '';
        }
    }

    function applyAttributionToForm(form) {
        if (!form) {
            return;
        }

        var data = readStoredAttribution() || captureAttribution();

        Object.keys(FIELD_MAP).forEach(function (key) {
            setHiddenValue(form, FIELD_MAP[key], data[key] || '');
        });
    }

    function initAttributionForms() {
        captureAttribution();
        document.querySelectorAll('.crescendo-contact-form__step1').forEach(applyAttributionToForm);
    }

    window.CrescendoLeadAttribution = {
        capture: captureAttribution,
        applyToForm: applyAttributionToForm,
        init: initAttributionForms,
    };

    document.addEventListener('DOMContentLoaded', initAttributionForms);
}(window));
