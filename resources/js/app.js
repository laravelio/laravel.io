
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

$('select.selectize').selectize({ maxItems: 3 });
$('textarea.wysiwyg').markdown({ iconlibrary: 'fa' });

$('.dropdown').on('click', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const activate = $(this).next().hasClass('active') ? false : true;
    $('.subnav').removeClass('active');
    if (activate) {
        $(this).next().addClass('active');
    }
});

$(document).on('click', function (e) {
    $('.subnav').removeClass('active');
});

$('#sidebar-open').on('click', function (e) {
    $('#sidebar-open').hide();
    $('#sidebar-close').show();
    $('.nav').addClass('active');
});

$('#sidebar-close').on('click', function (e) {
    $('#sidebar-open').show();
    $('#sidebar-close').hide();
    $('.nav').removeClass('active');
});

// const app = new Vue({
//     el: '#app'
// });
