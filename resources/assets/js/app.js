
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

import Echo from "laravel-echo"

if (typeof io !== 'undefined') {
    window.Echo = new Echo({
        broadcaster: 'socket.io',
        host: window.Laravel.url + ':' + window.Laravel.socket_port,
    });
    // Define which channel Echo is gonna listen to
    window.Echo.channel('threads')
}

const app = new Vue({
    el: '#app'
});
