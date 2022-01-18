import Alpine from 'alpinejs';
import hljs from 'highlight.js';
import Choices from 'choices.js';

import 'choices.js/public/assets/styles/choices.css';

require('./bootstrap');
require('./search');
require('./editor');

window.Alpine = Alpine;

Alpine.start();

// Create a multiselect element.
window.choices = (element) => {
    return new Choices(element, { maxItemCount: 3, removeItemButton: true });
};

// Syntax highlight code blocks.
window.highlightCode = (element) => {
    element.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightBlock(block);
    });
};
