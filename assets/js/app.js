// -- WEBPACK LOADER ----------------------------------- //

// -- CSS FILES ---------------------------------------- //
require('../scss/app.scss');

// -- JS FILES ----------------------------------------- //
// -- Bootstrap dependencies
const $ = require('jquery');
//require('popper.js');
require('bootstrap');
// -- End
// create global $ variables
global.$ = $;
require('./global/confirm_modal');