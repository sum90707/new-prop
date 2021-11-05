/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 53);
/******/ })
/************************************************************************/
/******/ ({

/***/ 1:
/***/ (function(module, exports) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var AlertMsg = function () {
    function AlertMsg() {
        _classCallCheck(this, AlertMsg);
    }

    _createClass(AlertMsg, [{
        key: 'ajaxErrors',
        value: function ajaxErrors(xhr) {
            $.uiAlert({
                textHead: "Error " + xhr.status,
                text: xhr.responseJSON.message ? xhr.responseJSON.message : '',
                bgcolor: '#DB2828',
                textcolor: '#fff',
                position: 'bottom-right',
                icon: 'remove circle',
                time: 5
            });
        }
    }, {
        key: 'ajaxSussMsg',
        value: function ajaxSussMsg(xhr) {
            $.uiAlert({
                textHead: '',
                text: xhr.responseJSON.message ? xhr.responseJSON.message : 'Operation succeeded',
                bgcolor: '#19c3aa',
                textcolor: '#fff',
                position: 'bottom-right',
                icon: 'checkmark box',
                time: 5
            });
        }
    }, {
        key: 'sussMsg',
        value: function sussMsg() {
            $.uiAlert({
                textHead: '',
                text: 'Operation succeeded',
                bgcolor: '#19c3aa',
                textcolor: '#fff',
                position: 'bottom-right',
                icon: 'checkmark box',
                time: 5
            });
        }
    }, {
        key: 'errorsMsg',
        value: function errorsMsg(status) {
            var msg = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : null;

            $.uiAlert({
                textHead: "Error " + (status ? status : ''),
                text: msg ? msg : 'Operation fail',
                bgcolor: '#DB2828',
                textcolor: '#fff',
                position: 'bottom-right',
                icon: 'remove circle',
                time: 5
            });
        }
    }, {
        key: 'errorAlert',
        value: function errorAlert(xhr, errorFields) {
            if (xhr.responseJSON.errors) {
                this.processErrorsMsg(xhr, errorFields);
            } else {
                this.ajaxErrors(xhr);
            }
        }
    }, {
        key: 'processErrorsMsg',
        value: function processErrorsMsg(xhr, errorFields) {
            $.each(xhr.responseJSON.errors, function (label, msg) {
                label = label.toLowerCase();
                this.errorsMsg(xhr.status, msg.shift().replace(label, errorFields[label]));
            }.bind(this));
        }
    }], [{
        key: 'alertMsg',
        value: function alertMsg(message) {
            var fail = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;

            console.log(fail);
            $.uiAlert({
                textHead: fail ? "Error" : '',
                text: message,
                bgcolor: fail ? '#DB2828' : '#19c3aa',
                textcolor: '#fff',
                position: 'bottom-right',
                icon: fail ? 'remove circle' : 'checkmark box',
                time: 5
            });
        }
    }]);

    return AlertMsg;
}();

window.AlertMsg = AlertMsg;

/***/ }),

/***/ 53:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(54);


/***/ }),

/***/ 54:
/***/ (function(module, exports, __webpack_require__) {

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

__webpack_require__(1);

var Toggle = function (_AlertMsg) {
    _inherits(Toggle, _AlertMsg);

    function Toggle(config) {
        _classCallCheck(this, Toggle);

        return _possibleConstructorReturn(this, (Toggle.__proto__ || Object.getPrototypeOf(Toggle)).call(this));
    }

    _createClass(Toggle, null, [{
        key: 'setCheckboxs',
        value: function setCheckboxs($elements, column) {
            $.each($elements, function (index, $element) {
                if ($($element).data(column)) {
                    $($element).checkbox('set checked');
                } else {
                    $($element).checkbox('set unchecked');
                }
            });
        }
    }, {
        key: 'setCheckbox',
        value: function setCheckbox($element, column) {
            if ($($element).data(column)) {
                $($element).checkbox('set checked');
            } else {
                $($element).checkbox('set unchecked');
            }
        }
    }, {
        key: 'statusToggle',
        value: function statusToggle($elements, callback) {
            $.each($elements, function (index, $element) {
                $($element).on('click', function () {
                    this.toggleRequest(this.takeInfo($element), callback);
                }.bind(this));
            }.bind(this));
        }
    }, {
        key: 'selectToggle',
        value: function selectToggle($elements, callback) {
            $.each($elements, function (index, $element) {
                $($element).on('change', function () {
                    this.toggleRequest(this.takeInfo($element), callback);
                }.bind(this));
            }.bind(this));
        }
    }, {
        key: 'takeInfo',
        value: function takeInfo($element) {
            return {
                url: $($element).data('route'),
                data: $($element).val(),
                method: $($element).data('method') ? $($element).data('method') : 'PUT',
                token: $('meta[name="csrf-token"]').attr('content'),
                element: $($element)
            };
        }
    }, {
        key: 'toggleRequest',
        value: function toggleRequest(info, callback) {
            $.ajax({
                url: info.url,
                type: info.method,
                headers: {
                    'X-CSRF-TOKEN': info.token
                },
                data: { 'toggle': info.data },
                success: function success(json, status, xhr) {
                    callback();
                    this.alertMsg(json.message);
                }.bind(this)
            }).fail(function (e) {
                callback();
                this.alertMsg(e.responseJSON.message, 'fail');
            }.bind(this));
        }
    }]);

    return Toggle;
}(AlertMsg);

window.Toggle = Toggle;

/***/ })

/******/ });