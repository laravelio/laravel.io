window.$ = window.jQuery = require('jquery')
require('bootstrap-sass');
require('selectize');

$('select.selectize').selectize({
    maxItems: 3
});
