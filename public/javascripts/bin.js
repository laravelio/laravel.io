$(function() {
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
    }

    // Save shortcut
    Mousetrap.bind('mod+s', function(event) {
        event.preventDefault();
        if ($('.editor')) {
            $('.editor-form').submit();
        }
    });

    // Fork shorcut
    Mousetrap.bind('f', function() {
        if ($('.button.fork')) {
            $('.button.fork')[0].click();
        }
        return false;
    });

    // New shorcut
    Mousetrap.bind('n', function() {
        if ($('.button.new')) {
            $('.button.new')[0].click();
        }
        return false;
    });

    // Fork shorcut
    Mousetrap.bind('r', function() {
        if ($('.button.raw')) {
            $('.button.raw')[0].click();
        }
        return false;
    });

    Mousetrap.bind('mod+c', function() {
        if (window.getSelection().toString() == '') {
            if ($('.button.copy')) {
                $('#copy-data').val(location.toString()).select();
                toastr.info('Copied URL to clipboard! ' + $('#copy-data').val());
            }
        }
    });

    // Setup tabby
    var tabbyOptions = { tabString:'    '};
    $('.editor').focus().tabby(tabbyOptions);

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

    (function($){

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

    })(jQuery);

    prettyPrint(function() {
        $.handleLines({
            $list: $('ol.linenums'),
            selectClass: 'selected',
            preventTextSelectionClass: 'prevent-user-select'
        });
    });


});

// // drag and drop file api stuff
// function handleFileSelect(e) {
//   e.stopPropagation();
//   e.preventDefault();

//   var files = e.dataTransfer.files;

//   $.each(files, function() {
//     var file = this;

//     // if ( ! file.type.match('text.*')) {
//     //   continue;
//     // }

//     var reader = new FileReader();

//     reader.onload = (function() {
//       return function(e) {
//         addFile(file.name, e.target.result);
//       };
//     })(file);

//     reader.readAsText(file);
//   });
// }

// function handleDragOver(e) {
//   e.stopPropagation();
//   e.preventDefault();
//   e.dataTransfer.dropEffect = 'copy'; // Explicitly show this is a copy.
// }

// function bindDragAndDrop() {
//   var dropZone = document.getElementById('drop_zone');
//   dropZone.addEventListener('dragover', handleDragOver, false);
//   dropZone.addEventListener('drop', handleFileSelect, false);
// }

// //
// function addFile(name, contents) {
//   var template = $('._file_template').html();

//   template = template.replace(/\|filename\|/g, name);
//   template = template.replace(/\|contents\|/g, contents);

//   $('._files').append(template);
// }

// // go
// $(function() {
//   bindDragAndDrop();
// });