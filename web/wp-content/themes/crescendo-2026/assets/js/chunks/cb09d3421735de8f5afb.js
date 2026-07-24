"use strict";
(self["webpackChunkwordpress_starter_kit"] = self["webpackChunkwordpress_starter_kit"] || []).push([["assets_js_modules_contactForm_js"],{

/***/ "./assets/js/modules/contactForm.js":
/*!******************************************!*\
  !*** ./assets/js/modules/contactForm.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = (function (root) {
  var step1Form = root.querySelector('.crescendo-contact-form__step1');

  if (!step1Form || typeof ParamsData === 'undefined') {
    return;
  }

  var modal = document.getElementById('crescendo-contact-modal');

  if (!modal) {
    return;
  }

  var step2Form = modal.querySelector('.crescendo-contact-modal__form');
  var feedbackStep1 = step1Form.querySelector('.crescendo-contact-form__feedback');
  var feedbackStep2 = step2Form.querySelector('.crescendo-contact-form__feedback');
  var submitStep1 = step1Form.querySelector('.crescendo-contact-form__submit');
  var submitStep2 = step2Form.querySelector('.crescendo-contact-form__submit');
  var closeTriggers = modal.querySelectorAll('[data-contact-modal-close]');
  var lastFocus = null;

  var setFeedback = function setFeedback(el, message, isError) {
    if (!el) {
      return;
    }

    el.hidden = !message;
    el.textContent = message || '';
    el.classList.toggle('is-error', Boolean(isError));
    el.classList.toggle('is-success', Boolean(message) && !isError);
  };

  var setLoading = function setLoading(button, loading) {
    if (!button) {
      return;
    }

    button.disabled = loading;
    button.classList.toggle('is-loading', loading);
  };

  var openModal = function openModal(leadId, leadKey) {
    step2Form.querySelector('[name="lead_id"]').value = leadId;
    step2Form.querySelector('[name="lead_key"]').value = leadKey;
    setFeedback(feedbackStep2, '', false);
    lastFocus = document.activeElement;
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('no-scroll');
    var firstField = step2Form.querySelector('input:not([type="hidden"]), textarea, select');

    if (firstField) {
      firstField.focus();
    }
  };

  var closeModal = function closeModal() {
    modal.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('no-scroll');

    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus();
    }
  };

  var postForm = function postForm(form, onSuccess) {
    var formData = new window.FormData(form);
    formData.append('nonce', ParamsData.contactFormNonce);
    return fetch(ParamsData.wp_ajax_url, {
      method: 'POST',
      body: formData,
      credentials: 'same-origin'
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.status === 200) {
        onSuccess(data);
        return;
      }

      throw new Error(data.message || 'Une erreur est survenue.');
    });
  };

  closeTriggers.forEach(function (trigger) {
    trigger.addEventListener('click', closeModal);
  });
  modal.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
      closeModal();
    }
  });
  step1Form.addEventListener('submit', function (event) {
    event.preventDefault();
    setFeedback(feedbackStep1, '', false);
    setLoading(submitStep1, true);
    postForm(step1Form, function (data) {
      setFeedback(feedbackStep1, data.message, false);
      step1Form.reset();
      openModal(data.lead_id, data.lead_key);
    }).catch(function (error) {
      setFeedback(feedbackStep1, error.message, true);
    }).finally(function () {
      setLoading(submitStep1, false);
    });
  });
  step2Form.addEventListener('submit', function (event) {
    event.preventDefault();
    setFeedback(feedbackStep2, '', false);
    setLoading(submitStep2, true);
    postForm(step2Form, function (data) {
      setFeedback(feedbackStep2, data.message, false);
      window.setTimeout(closeModal, 1800);
    }).catch(function (error) {
      setFeedback(feedbackStep2, error.message, true);
    }).finally(function () {
      setLoading(submitStep2, false);
    });
  });
});

/***/ })

}]);
//# sourceMappingURL=cb09d3421735de8f5afb.js.map