import hljs from 'highlight.js';
import Choices from 'choices.js';

import 'choices.js/public/assets/styles/choices.css';

import './bootstrap';
import './nav';
import './search';
import './editor';

// Create a multiselect element.
window.choices = (element) => {
    return new Choices(element, { maxItemCount: 3, removeItemButton: true });
};

// Syntax highlight code blocks.
window.highlightCode = (element) => {
    element.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
};
