import 'alpinejs'
import hljs from "highlight.js";
import Choices from "choices.js";
import CookieConsent from 'cookieconsent';

import "highlight.js/styles/github.css";
import "cookieconsent/build/cookieconsent.min.css";
import "choices.js/public/assets/styles/choices.css";

require('./bootstrap');
require('./search');
require('./editor');

// Initialise cookie consent.
document.addEventListener('DOMContentLoaded', () => {
    cookieconsent.initialise({
        "palette": {
            "popup": {
                "background": "#000"
            },
            "button": {
                "background": "#f1d600"
            }
        },
        "type": "opt-in",
        "content": {
            "href": "https://laravel.io/privacy"
        }
    });
});

// Create a multiselect element.
window.choices = (element) => {
    return new Choices(element, {
        maxItemCount: 3,
        removeItemButton: true
    })
};

// Syntax highlight code blocks.
window.highlightCode = (element) => {
    element.querySelectorAll("pre code").forEach(block => {
        hljs.highlightBlock(block);
    });
}