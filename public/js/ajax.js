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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/ajax.js":
/*!******************************!*\
  !*** ./resources/js/ajax.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

// Modal Show
$('body').on('click', '.modal-show', function (event) {
  event.preventDefault();
  var me = $(this),
      url = me.attr('href'),
      title = me.attr('title');
  $('#modal-title').text(title);
  $('#btn-submit').text(me.hasClass('edit') ? 'Ubah' : 'Tambah');
  $('#btn-submit').show();
  $.ajax({
    url: url,
    dataType: 'html',
    success: function success(response) {
      $('#modal-body').html(response);
    }
  });
  $('#modalForm').modal('show');
}); // Ajax Post Data

$('#btn-submit').click(function (event) {
  event.preventDefault();
  var form = $('#modal-body form'),
      url = form.attr('action'),
      method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
  form.find('.invalid-feedback').remove();
  form.find('.form-control').removeClass('is-invalid');
  $.ajax({
    url: url,
    method: method,
    data: form.serialize(),
    success: function success(response) {
      form.trigger('reset');
      $('#modalForm').modal('hide');

      if ($('#dataTable').length !== 0) {
        $('#dataTable').DataTable().ajax.reload();
      }

      swal({
        title: 'Sukses!',
        text: 'Data berhasil disimpan.',
        icon: 'success',
        timer: 3000
      });
    },
    error: function error(xhr) {
      var res = xhr.responseJSON;

      if ($.isEmptyObject(res) == false) {
        $.each(res.errors, function (key, value) {
          $('#' + key).closest('.form-control').addClass('is-invalid').after('<span class="invalid-feedback">' + value + '</span>');
        });
      }
    }
  });
}); // Modal Show for Action View

$('body').on('click', '.action-show', function (event) {
  event.preventDefault();
  var me = $(this),
      url = me.attr('href'),
      title = me.attr('title');
  console.log(url);
  $('#modal-title').text(title);
  $('#btn-submit').hide();
  $.ajax({
    url: url,
    dataType: 'html',
    success: function success(response) {
      $('#modal-body').html(response);
    }
  });
  $('#modalForm').modal('show');
}); // Ajax Delete

$('body').on('click', '.action-delete', function (event) {
  event.preventDefault();
  var me = $(this),
      name = me.attr('data-name'),
      url = me.attr('href'),
      csrf_token = $('meta[name="csrf-token"]').attr('content');
  swal({
    text: 'Apakah anda yakin menghapus data ' + name + '?',
    buttons: {
      cancel: true,
      confirm: true
    }
  }).then(function (result) {
    if (result) {
      $.ajax({
        url: url,
        type: "POST",
        data: {
          '_method': 'DELETE',
          '_token': csrf_token
        },
        success: function success(response) {
          console.log(response);

          if ($('#dataTable').length !== 0) {
            $('#dataTable').DataTable().ajax.reload();
          }

          swal({
            title: 'Sukses!',
            text: 'Data berhasil dihapus.',
            icon: 'success',
            timer: 3000
          });
        },
        error: function error(xhr) {
          swal({
            title: 'Error!',
            text: 'Data gagal dihapus.',
            icon: 'error',
            timer: 3000
          });
        }
      });
    }
  });
});

/***/ }),

/***/ 1:
/*!************************************!*\
  !*** multi ./resources/js/ajax.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Volumes/Developments/Website/cashierx/resources/js/ajax.js */"./resources/js/ajax.js");


/***/ })

/******/ });