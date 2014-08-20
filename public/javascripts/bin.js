/**
 * Laravel.io Pastebin
 */
var PasteBin = (function($) {

    /**
     * Initialize all handlers/listeners/plugins
     */
    var init = function() {
        if (window.PasteBinInitialized == true) return;

        _initToastr();
        _initTabby();
        _bindKeys();
        _bindCopyButtons();
        _prettyPrintLines();
        _responsiveNav();

        window.PasteBinInitialized = true;
    };

    /**
     * Bind buttons and listeners to make right nav work responsively
     *
     * @private
     */
    var _responsiveNav = function() {
        var $showHideButton = $('.show-sidebar'),
            $sidebar = $('.sidebar');

        $showHideButton.on('click', function(e) {
            e.preventDefault();

            $showHideButton.toggleClass('show');
            $sidebar.toggleClass('hide');
        });
    };

    /**
     * Pass options to Toastr notification library
     *
     * @source https://github.com/CodeSeven/toastr
     * @private
     */
    var _initToastr = function() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
    };

    /**
     * Pass options to Tabby
     *
     * @source https://github.com/alanhogan/Tabby
     * @private
     */
    var _initTabby = function() {
        // Set tab string to 4 spaces
        $('.editor').focus().tabby({ tabString: '    '});
    };

    /**
     * Bind keyboard shortcuts with MouseTrap
     *
     * @private
     */
    var _bindKeys = function() {

        // Bind show keys
        if ($('.show-container').length) {
            // Fork shortcut
            Mousetrap.bind('f', function () {
                if ($('.button.fork').length) {
                    $('.button.fork')[0].click();
                }
                return false;
            });

            // New shortcut
            Mousetrap.bind('n', function () {
                if ($('.button.new').length) {
                    $('.button.new')[0].click();
                }
                return false;
            });

            // Raw shortcut
            Mousetrap.bind('r', function () {
                if ($('.button.raw').length) {
                    $('.button.raw')[0].click();
                }
                return false;
            });

            // Copy shortcut
            Mousetrap.bind('mod+c', function() {
                if (window.getSelection().toString() == '') {
                    if ($('.button.copy').length) {
                        $('#copy-data').val(location.toString()).select();
                        toastr.info('Copied URL to clipboard! ' + $('#copy-data').val());
                    }
                }
            });
        }

        // Bind edit keys
        if ($('.editor-container').length) {
            // Save shortcut
            Mousetrap.bind('mod+s', function (event) {
                event.preventDefault();
                if ($('.editor').length) {
                    $('.editor-form').submit();
                }
            });
        }
    };

    /**
     * Bind copy buttons for URL and content
     *
     * @private
     */
    var _bindCopyButtons = function() {
        // Setup copy
        $(document).on('copy', function (event) {
            if (window.getSelection().toString() == '') {
                event.preventDefault();
                var url = $('#copy-data').val();
                event.originalEvent.clipboardData.setData('text/plain', url);
            }
        });

        $('.button.copy').zclip({
            path: '/javascripts/vendor/ZeroClipboard.swf',
            copy: location.toString(),
            afterCopy: function() {
                toastr.info('Copied URL to clipboard! ' + location.toString());
            }
        });
    };

    /**
     * Pretty print source code
     *
     * @source https://code.google.com/p/google-code-prettify/ (right?)
     * @todo Get rid of function definitions
     * @private
     */
    var _prettyPrintLines = function() {
        var defaults = {
                $list: $('.list'),
                selectedClass: 'selected',
                preventTextSelectionClass: 'prevent-user-select'
            },
            _lines, options, $lastLineToggled;

        // Call this public method like $.myMethod();
        $.handleLines = function(options){
            defaults = $.extend(defaults, options);
            defaults.$lines = defaults.$list.find('li');

            _lines = expandLines(window.location.hash);
            highlight();
            events();
        };

        function highlight() {
            for(var i = 0; i < _lines.length; i++) {
                defaults.$lines.eq(_lines[i] - 1).addClass(defaults.selectedClass);
            }
        }

        function events() {
            defaults.$list.on('click', 'li', function (e) {
                var $line = $(this);
                if ($lastLineToggled && e.shiftKey) {
                    var $range,
                        lineIndex = $line.index(),
                        lastLineIndex = $lastLineToggled.index() + 1;

                    $range = (lineIndex > lastLineIndex) ? defaults.$lines.slice(lastLineIndex, lineIndex + 1) : defaults.$lines.slice(lineIndex, lastLineIndex - 1);
                    $range.toggleClass(defaults.selectedClass);
                    manage($range);
                } else {
                    $line.toggleClass(defaults.selectedClass);
                    manage($line);
                }
                $lastLineToggled = $line;
            });

            $(document).mousedown(function (e) {
                if (e.shiftKey) e.preventDefault();
            });
        }

        /* expand #1-7,12,20 into [1,2,3,4,5,6,7,12,20] */
        function expandLines(lines) {
            if(lines == '') return [];
            lines = lines.replace(/#/g, '').split(',');
            var linesExpanded = [];
            for(var i in lines) {
                if(lines.hasOwnProperty(i)) {
                    linesExpanded = linesExpanded.concat(expand(lines[i]));
                }
            }

            return sanitize(linesExpanded)
        }

        function expand(item) {
            return (item.indexOf('-') > 0) ? generateRange(item.split('-')) : [parseInt(item, 10)];
        }

        function generateRange(values) {
            var range = [];
            for (var i = parseInt(values[0], 10); i <= parseInt(values[1], 10); i++) {
                range.push(i);
            }
            return range;
        }

        /* sort linesnumbers array and remove duplicate numbers */
        function sanitize(lines) {
            lines = lines.sort(function(a, b) { return a-b; });
            uniqueLines = [];
            for(var i = 0; i < lines.length; i++) {
                if(uniqueLines.indexOf(lines[i]) === -1) uniqueLines.push(lines[i]);
            }
            return uniqueLines;
        }

        /* collapse [1,2,3,4,5,6,7,12,20] into #1-7,12,20 */
        function collapser() {
            lines = sanitize(_lines);
            var ranges = [], rstart, rend;
            for (var i = 0; i < lines.length; i++) {
                rstart = lines[i];
                rend = rstart;
                while (lines[i + 1] - lines[i] == 1) {
                    rend = lines[i + 1];
                    i++;
                }
                ranges.push(rstart == rend ? rstart+'' : rstart + '-' + rend);
            }
            return '#' + ranges.join(',');
        }

        /* update lines array */
        function manage(items) {
            items.each(function() {
                var indexOfLine = $(this).index() + 1,
                    indexInLinesArray = _lines.indexOf(indexOfLine);

                if(indexInLinesArray < 0) {
                    _lines.push(indexOfLine);
                } else {
                    _lines.splice(indexInLinesArray, 1);
                }
            });
            window.location.hash = collapser();
        }

        prettyPrint(function() {
            $.handleLines({
                $list: $('ol.linenums'),
                selectClass: 'selected',
                preventTextSelectionClass: 'prevent-user-select'
            });
        });
    };

    /**
     * Temporarily disabled drag and drop
     *
     * @todo Delete the code or bring it back
     * @private
     */
    var _bindDragAndDrop = function() {
        return;

        // drag and drop file api stuff
        function handleFileSelect(e) {
            e.stopPropagation();
            e.preventDefault();

            var files = e.dataTransfer.files;

            $.each(files, function() {
                var file = this;

                // if ( ! file.type.match('text.*')) {
                //   continue;
                // }

                var reader = new FileReader();

                reader.onload = (function() {
                    return function(e) {
                        addFile(file.name, e.target.result);
                    };
                })(file);

                reader.readAsText(file);
            });
        }

        function handleDragOver(e) {
            e.stopPropagation();
            e.preventDefault();
            e.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
        }

        function bindDragAndDrop() {
            var dropZone = document.getElementById('drop_zone');
            dropZone.addEventListener('dragover', handleDragOver, false);
            dropZone.addEventListener('drop', handleFileSelect, false);
        }

        function addFile(name, contents) {
            var template = $('._file_template').html();

            template = template.replace(/\|filename\|/g, name);
            template = template.replace(/\|contents\|/g, contents);

            $('._files').append(template);
        }

        // go
        $(function() {
            bindDragAndDrop();
        });
    };

    return {
        init: init
    };
})(jQuery);

$(function() {
    PasteBin.init();
});
