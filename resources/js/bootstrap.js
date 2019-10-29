window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

require('bootstrap');


window.validator = require('validator');
window.Inputmask = require('inputmask');

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
