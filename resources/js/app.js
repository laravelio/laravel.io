import SimpleMDE from 'simplemde';
import 'simplemde/dist/simplemde.min.css';

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
    data: {
        activeModal: null,
        navOpen: false,
        value: [],
    },
    methods: {
        /**
         * Add a class to an HTML element
         */
        addClass(element, className) {
            element.classList.add(className);
        },
        /**
         * Remove a class from an HTML element
         */
        removeClass(element, className) {
            element.classList.remove(className);
        },
        hideSidebar() {
            this.navOpen = false;
            Array.from(document.getElementsByClassName('subnav')).forEach(subnav => {
                this.toggleNav();
                Array.from(document.getElementsByClassName('nav')).forEach(nav => {
                    this.removeClass(nav, 'active');
                });
            });
        },
        showSidebar() {
            this.navOpen = true;
            this.toggleNav();
            Array.from(document.getElementsByClassName('nav')).forEach(nav => {
                nav.classList.add('active');
            });
        },
        toggleNav() {
            document.getElementById('sidebar-open').style.display = this.navOpen ? 'none' : 'block';
            document.getElementById('sidebar-close').style.display = this.navOpen ? 'block' : 'none';
        },
        addDocumentListener() {
            // when clicking anywhere on the page, remove all subnavs
            // this will not be fired if a dropdown item is clicked as we stop the propogation of the event 
            document.addEventListener('click', (e) => {
                Array.from(document.getElementsByClassName('subnav')).forEach(subnav => {
                    this.removeClass(subnav, 'active');
                });
            });
            window.addEventListener('resize', (e) => {
                // if the window is a large viewport, hide the sidebar and hamburger
                if (window.innerWidth >= 1024) {
                    this.hideSidebar();
                    document.getElementById('sidebar-open').style.display = 'none';
                } else {
                    // if not, show the nav
                    this.toggleNav();
                }
            });
        },
        addNavListeners() {
            // get all the dropdown elements on the page
            const dropdowns = document.getElementsByClassName('dropdown');
            // turn the html collection into an array and loop
            Array.from(dropdowns).forEach(dropdown => {
                dropdown.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    // hide any currently active subnavs
                    Array.from(document.getElementsByClassName('subnav')).forEach(subnav => {
                        this.removeClass(subnav, 'active');
                    });
                    // activer the subnav of the selected dropdown
                    this.addClass(dropdown.nextElementSibling, 'active');
                });
            });
        },
        addSidebarListeners() {
            // open the sidebar
            const openButton = document.getElementById('sidebar-open');
            if (openButton) {
                openButton.addEventListener('click', (e) => {
                    this.showSidebar();
                });
            }

            // close the sidebar
            const closeButton = document.getElementById('sidebar-close');
            if (closeButton) {
                closeButton.addEventListener('click', (e) => {
                    this.hideSidebar();
                });
            }
        },
        addAlertListeners() {
            const closeAlertButtons = document.querySelectorAll('.alert .close');
            // turn the html collection into an array and loop
            Array.from(closeAlertButtons).forEach(button => {
                button.addEventListener('click', function (e) {
                    e.target.parentNode.parentNode.remove();
                });
            });
        },
        registerEditors() {
            Array.from(this.$el.getElementsByClassName('editor')).forEach(editor => {
                new SimpleMDE({
                    showIcons: ["code"],
                    hideIcons: ['preview', 'side-by-side', 'guide'],
                    element: editor,
                    status: false
                });
            });
        }
    },
    mounted() {
        this.addDocumentListener();
        this.addNavListeners();
        this.addSidebarListeners();
        this.addAlertListeners();
        this.registerEditors();
    }
});
