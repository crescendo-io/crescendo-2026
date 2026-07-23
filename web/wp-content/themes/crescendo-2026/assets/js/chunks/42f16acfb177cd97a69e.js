(self["webpackChunkwordpress_starter_kit"] = self["webpackChunkwordpress_starter_kit"] || []).push([["assets_js_vendors_cookies-eu-banner_js"],{

/***/ "./assets/js/vendors/cookies-eu-banner.js":
/*!************************************************!*\
  !*** ./assets/js/vendors/cookies-eu-banner.js ***!
  \************************************************/
/***/ (function(module, exports) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

; // jshint ignore:line

(function (root, factory, undefined) {
  'use strict';

  if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(window, function () {
  'use strict';

  var _CookiesEuBanner,
      document = window.document;

  _CookiesEuBanner = function CookiesEuBanner(launchFunction, waitAccept, undefined) {
    if (!(this instanceof _CookiesEuBanner)) {
      return new _CookiesEuBanner(launchFunction);
    }

    this.cookieTimeout = 33696000000; // 13 months in milliseconds

    this.bots = /bot|googlebot|crawler|spider|robot|crawling/i;
    this.cookieName = 'hasConsent';
    this.trackingCookiesNames = ['__utma', '__utmb', '__utmc', '__utmt', '__utmv', '__utmz', '_ga', '_gat', '_gid'];
    this.launchFunction = launchFunction;
    this.waitAccept = waitAccept || false;
    this.init();
  };

  _CookiesEuBanner.prototype = {
    init: function init() {
      // Do nothing if it is a bot
      // If DoNotTrack is activated, do nothing too
      if (this.isBot() || !this.isToTrack() || this.hasConsent() === false) {
        return false;
      } // User has already consent to use cookies to tracking


      if (this.hasConsent() === true) {
        // Launch user custom function
        this.launchFunction();
        return true;
      } // If it's not a bot, no DoNotTrack and not already accept : show banner


      this.showBanner();

      if (!this.waitAccept) {
        // Accept cookies by default for the next page
        this.setCookie(this.cookieName, true);
      }
    },

    /*
     * Show banner at the top of the page
     */
    showBanner: function showBanner() {
      var _this = this,
          banner = document.getElementById('cookies-eu-banner'),
          rejectButton = document.getElementById('cookies-eu-reject'),
          acceptButton = document.getElementById('cookies-eu-accept'),
          moreLink = document.getElementById('cookies-eu-more'),
          waitRemove = banner.dataset.waitRemove === undefined ? 0 : parseInt(banner.dataset.waitRemove);

      banner.style.display = 'block';

      if (moreLink) {
        this.addEventListener(moreLink, 'click', function () {
          _this.deleteCookie(_this.cookieName);
        });
      }

      if (acceptButton) {
        this.addEventListener(acceptButton, 'click', function () {
          _this.removeBanner(banner, waitRemove);

          _this.setCookie(_this.cookieName, true);

          _this.launchFunction();
        });
      }

      if (rejectButton) {
        this.addEventListener(rejectButton, 'click', function () {
          _this.removeBanner(banner, waitRemove);

          _this.setCookie(_this.cookieName, false);

          _this.deleteTrackingCookies();
        });
      }
    },

    /*
     * Check if user already consent
     */
    hasConsent: function hasConsent() {
      if (document.cookie.indexOf(this.cookieName + '=true') > -1) {
        return true;
      } else if (document.cookie.indexOf(this.cookieName + '=false') > -1) {
        return false;
      }

      return null;
    },

    /*
     * Detect if the visitor is a bot or not
     * Prevent for search engine take the cookie
     * alert message as main content of the page
     */
    isBot: function isBot() {
      return this.bots.test(navigator.userAgent);
    },

    /*
     * Check if DoNotTrack is activated
     */
    isToTrack: function isToTrack() {
      var dnt = navigator.doNotTrack || navigator.msDoNotTrack || window.doNotTrack;
      return dnt !== null && dnt !== undefined ? dnt && dnt !== 'yes' && dnt !== 1 && dnt !== '1' : true;
    },

    /*
     * Delete existent tracking cookies
     */
    deleteTrackingCookies: function deleteTrackingCookies() {
      var _this = this;

      this.trackingCookiesNames.map(function (cookieName) {
        _this.deleteCookie(cookieName);
      });
    },

    /*
     * Create/update cookie
     */
    setCookie: function setCookie(name, value) {
      var date = new Date();
      date.setTime(date.getTime() + this.cookieTimeout);
      document.cookie = name + '=' + value + ';expires=' + date.toGMTString() + ';path=/';
    },

    /*
     * Delete cookie by changing expire
     */
    deleteCookie: function deleteCookie(name) {
      var hostname = document.location.hostname;

      if (hostname.indexOf('www.') === 0) {
        hostname = hostname.substring(4);
      }

      document.cookie = name + '=; domain=.' + hostname + '; expires=Thu, 01-Jan-1970 00:00:01 GMT; path=/';
      document.cookie = name + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; path=/';
    },
    addEventListener: function addEventListener(DOMElement, evnt, callback) {
      if (document.addEventListener) {
        // For all major browsers, except IE 8 and earlier
        DOMElement.addEventListener(evnt, callback);
      } else if (DOMElement.attachEvent) {
        // For IE 8 and earlier versions
        DOMElement.attachEvent('on' + evnt, callback);
      }
    },

    /*
     * Delays removal of banner allowing developers
     * to specify their own transition effects
     */
    removeBanner: function removeBanner(banner, wait) {
      setTimeout(function () {
        banner.parentNode.removeChild(banner);
      }, wait);
    }
  };
  return _CookiesEuBanner;
});

/***/ })

}]);
//# sourceMappingURL=42f16acfb177cd97a69e.js.map