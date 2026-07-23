"use strict";
(self["webpackChunkwordpress_starter_kit"] = self["webpackChunkwordpress_starter_kit"] || []).push([["assets_js_modules_bugReport_js"],{

/***/ "./assets/js/modules/bugReport.js":
/*!****************************************!*\
  !*** ./assets/js/modules/bugReport.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _marker_io_browser__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @marker.io/browser */ "./node_modules/@marker.io/browser/src/index.js");
function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }


/* global ParamsData */

/* eslint-disable no-unused-vars */

/* harmony default export */ __webpack_exports__["default"] = (function (bugReport) {
  // console.log('bugReport', bugReport, ParamsData.bug_report_id);
  _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee() {
    return regeneratorRuntime.wrap(function _callee$(_context) {
      while (1) {
        switch (_context.prev = _context.next) {
          case 0:
            if (!(ParamsData.bug_report_id && ParamsData.bug_report_id !== '')) {
              _context.next = 3;
              break;
            }

            _context.next = 3;
            return _marker_io_browser__WEBPACK_IMPORTED_MODULE_0__["default"].loadWidget({
              destination: ParamsData.bug_report_id
            });

          case 3:
          case "end":
            return _context.stop();
        }
      }
    }, _callee);
  }))();
});

/***/ }),

/***/ "./node_modules/@marker.io/browser/src/index.js":
/*!******************************************************!*\
  !*** ./node_modules/@marker.io/browser/src/index.js ***!
  \******************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

__webpack_require__.r(__webpack_exports__);
function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/**
 * Marker.io - https://marker.io
 * Browser loader for the Marker.io SDK
 */
/* harmony default export */ __webpack_exports__["default"] = ({
  loadWidget: function loadWidget(params) {
    // Warn if unknown params are provided
    var knownParams = ['destination', 'reporter', 'customShimUrl', 'customData', 'silent', 'source', 'ssr', 'extension', 'keyboardShortcuts'];
    Object.keys(params).forEach(function (paramName) {
      if (!knownParams.includes(paramName)) {
        console.warn('(Marker.io SDK) unknown param "' + paramName + '" (need to upgrade?)');
      }
    }); // Extract params

    var destination = params.destination,
        reporter = params.reporter,
        customData = params.customData,
        silent = params.silent,
        ssr = params.ssr,
        extension = params.extension,
        keyboardShortcuts = params.keyboardShortcuts;

    if (typeof destination !== 'string') {
      throw new Error('destination must be a string');
    }

    if ('customData' in params && _typeof(customData) !== 'object') {
      throw new Error('customData must be an object');
    }

    if ('silent' in params && typeof silent !== 'boolean') {
      throw new Error('silent must be a boolean');
    }

    if ('ssr' in params && _typeof(ssr) !== 'object') {
      throw new Error('ssr must be a boolean');
    }

    if ('extension' in params && typeof extension !== 'boolean' && _typeof(extension) !== 'object') {
      throw new Error('extension must be a boolean/object');
    }

    if ('keyboardShortcuts' in params && typeof keyboardShortcuts !== 'boolean') {
      throw new Error('keyboardShortcuts must be a boolean');
    }

    if (window.Marker) {
      // Only one Marker.io widget can be loaded at a time
      window.Marker.unload();
    }

    window.markerConfig = {
      destination: destination,
      reporter: reporter,
      customData: customData,
      silent: silent,
      ssr: ssr,
      extension: extension,
      keyboardShortcuts: keyboardShortcuts,
      source: 'browser-sdk'
    };
    var __cs = [];
    var sdk = {
      __cs: __cs
    };

    var _loop = function _loop() {
      var methodName = _arr[_i];

      sdk[methodName] = function () {
        var t = Array.prototype.slice.call(arguments);
        t.unshift(methodName);

        __cs.push(t);
      };
    };

    for (var _i = 0, _arr = ['show', 'hide', 'isVisible', 'capture', 'cancelCapture', 'unload', 'reload', 'isExtensionInstalled', 'setReporter', 'setCustomData', 'on', 'off']; _i < _arr.length; _i++) {
      _loop();
    }

    window.Marker = sdk;
    var script = document.createElement('script');
    script.async = 1;
    script.src = params.customShimUrl || 'https://edge.marker.io/latest/shim.js';
    var anchorScript = document.getElementsByTagName('script')[0];
    anchorScript.parentNode.insertBefore(script, anchorScript);
    return new Promise(function (resolve, reject) {
      sdk.on('load', function () {
        resolve(window.Marker);
      });
      sdk.on('loaderror', function (error) {
        reject(error);
      });

      script.onerror = function (error) {
        return reject(error);
      };
    });
  }
});

/***/ })

}]);
//# sourceMappingURL=27db24ac9e2b8b3b4c4b.js.map