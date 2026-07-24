export default (root) => {
    const step1Form = root.querySelector('.crescendo-contact-form__step1');
    if (!step1Form || typeof ParamsData === 'undefined') {
        return;
    }

    const modal = document.getElementById('crescendo-contact-modal');
    if (!modal) {
        return;
    }

    const step2Form = modal.querySelector('.crescendo-contact-modal__form');
    const feedbackStep1 = step1Form.querySelector('.crescendo-contact-form__feedback');
    const feedbackStep2 = step2Form.querySelector('.crescendo-contact-form__feedback');
    const submitStep1 = step1Form.querySelector('.crescendo-contact-form__submit');
    const submitStep2 = step2Form.querySelector('.crescendo-contact-form__submit');
    const closeTriggers = modal.querySelectorAll('[data-contact-modal-close]');
    let lastFocus = null;

    const setFeedback = (el, message, isError) => {
        if (!el) {
            return;
        }
        el.hidden = !message;
        el.textContent = message || '';
        el.classList.toggle('is-error', Boolean(isError));
        el.classList.toggle('is-success', Boolean(message) && !isError);
    };

    const setLoading = (button, loading) => {
        if (!button) {
            return;
        }
        button.disabled = loading;
        button.classList.toggle('is-loading', loading);
    };

    const openModal = (leadId, leadKey) => {
        step2Form.querySelector('[name="lead_id"]').value = leadId;
        step2Form.querySelector('[name="lead_key"]').value = leadKey;
        setFeedback(feedbackStep2, '', false);
        lastFocus = document.activeElement;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('no-scroll');
        const firstField = step2Form.querySelector('input:not([type="hidden"]), textarea, select');
        if (firstField) {
            firstField.focus();
        }
    };

    const closeModal = () => {
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('no-scroll');
        if (lastFocus && typeof lastFocus.focus === 'function') {
            lastFocus.focus();
        }
    };

    const postForm = (form, onSuccess) => {
        const formData = new window.FormData(form);
        formData.append('nonce', ParamsData.contactFormNonce);

        return fetch(ParamsData.wp_ajax_url, {
            method: 'POST',
            body: formData,
            credentials: 'same-origin',
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === 200) {
                    onSuccess(data);
                    return;
                }
                throw new Error(data.message || 'Une erreur est survenue.');
            });
    };

    closeTriggers.forEach((trigger) => {
        trigger.addEventListener('click', closeModal);
    });

    modal.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    step1Form.addEventListener('submit', (event) => {
        event.preventDefault();
        setFeedback(feedbackStep1, '', false);
        setLoading(submitStep1, true);

        postForm(step1Form, (data) => {
            setFeedback(feedbackStep1, data.message, false);
            step1Form.reset();
            openModal(data.lead_id, data.lead_key);
        })
            .catch((error) => {
                setFeedback(feedbackStep1, error.message, true);
            })
            .finally(() => {
                setLoading(submitStep1, false);
            });
    });

    step2Form.addEventListener('submit', (event) => {
        event.preventDefault();
        setFeedback(feedbackStep2, '', false);
        setLoading(submitStep2, true);

        postForm(step2Form, (data) => {
            setFeedback(feedbackStep2, data.message, false);
            window.setTimeout(closeModal, 1800);
        })
            .catch((error) => {
                setFeedback(feedbackStep2, error.message, true);
            })
            .finally(() => {
                setLoading(submitStep2, false);
            });
    });
};
