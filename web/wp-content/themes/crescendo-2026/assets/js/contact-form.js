(function () {
    function setFeedback(el, message, isError) {
        if (!el) return;
        el.hidden = !message;
        el.textContent = message || '';
        el.classList.toggle('is-error', Boolean(isError));
        el.classList.toggle('is-success', Boolean(message) && !isError);
    }

    function setLoading(button, loading) {
        if (!button) return;
        button.disabled = loading;
        button.classList.toggle('is-loading', loading);
    }

    function validatePrestations(form) {
        var fieldset = form.querySelector('[data-prestations-required="1"]');
        if (!fieldset) {
            return true;
        }
        return fieldset.querySelectorAll('input[name="prestations[]"]:checked').length > 0;
    }

    function validateRgpdConsent(form) {
        var consent = form.querySelector('input[name="rgpd_consent"]');
        return consent && consent.checked;
    }

    function syncPrestations(fromForm, toForm) {
        var checked = fromForm.querySelectorAll('input[name="prestations[]"]:checked');
        toForm.querySelectorAll('input[name="prestations[]"]').forEach(function (input) {
            input.checked = false;
        });
        checked.forEach(function (input) {
            var match = toForm.querySelector('input[name="prestations[]"][value="' + input.value + '"]');
            if (match) {
                match.checked = true;
            }
        });
    }

    function postForm(form, onSuccess) {
        var formData = new window.FormData(form);
        formData.append('nonce', ParamsData.contactFormNonce);

        return window.fetch(ParamsData.wp_ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                if (data.status === 200) {
                    onSuccess(data);
                    return;
                }
                throw new Error(data.message || 'Une erreur est survenue.');
            });
    }

    function initContactForm(root) {
        var step1Form = root.querySelector('.crescendo-contact-form__step1');
        if (!step1Form) return;

        var modal = document.getElementById('crescendo-contact-modal');
        if (!modal) return;

        var step2Form = modal.querySelector('.crescendo-contact-modal__form');
        var feedbackStep1 = step1Form.querySelector('.crescendo-contact-form__feedback');
        var feedbackStep2 = step2Form.querySelector('.crescendo-contact-form__feedback');
        var submitStep1 = step1Form.querySelector('.crescendo-contact-form__submit');
        var submitStep2 = step2Form.querySelector('.crescendo-contact-form__submit');
        var closeTriggers = modal.querySelectorAll('[data-contact-modal-close]');
        var lastFocus = null;

        function openModal(leadId, leadKey) {
            step2Form.reset();
            step2Form.querySelector('[name="lead_id"]').value = leadId;
            step2Form.querySelector('[name="lead_key"]').value = leadKey;
            setFeedback(feedbackStep2, '', false);
            syncPrestations(step1Form, step2Form);
            lastFocus = document.activeElement;
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('no-scroll');
            var firstField = step2Form.querySelector('input:not([type="hidden"]), textarea, select');
            if (firstField) firstField.focus();
        }

        function closeModal() {
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('no-scroll');
            if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
        }

        closeTriggers.forEach(function (trigger) {
            trigger.addEventListener('click', closeModal);
        });

        modal.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') closeModal();
        });

        step1Form.addEventListener('submit', function (event) {
            event.preventDefault();
            setFeedback(feedbackStep1, '', false);

            if (!validatePrestations(step1Form)) {
                setFeedback(feedbackStep1, 'Sélectionnez au moins une prestation.', true);
                return;
            }

            if (!validateRgpdConsent(step1Form)) {
                setFeedback(feedbackStep1, 'Vous devez accepter le traitement de vos données pour envoyer votre demande.', true);
                return;
            }

            setLoading(submitStep1, true);

            postForm(step1Form, function (data) {
                setFeedback(feedbackStep1, data.message, false);
                step1Form.reset();
                openModal(data.lead_id, data.lead_key);
            })
                .catch(function (error) {
                    setFeedback(feedbackStep1, error.message, true);
                })
                .finally(function () {
                    setLoading(submitStep1, false);
                });
        });

        step2Form.addEventListener('submit', function (event) {
            event.preventDefault();
            setFeedback(feedbackStep2, '', false);
            setLoading(submitStep2, true);

            postForm(step2Form, function (data) {
                setFeedback(feedbackStep2, data.message, false);
                step2Form.reset();
                window.setTimeout(closeModal, 1800);
            })
                .catch(function (error) {
                    setFeedback(feedbackStep2, error.message, true);
                })
                .finally(function () {
                    setLoading(submitStep2, false);
                });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof ParamsData === 'undefined') return;
        document.querySelectorAll('.crescendo-contact-form').forEach(initContactForm);
    });
}());
