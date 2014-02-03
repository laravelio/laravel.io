;(function ($, window) {
    "use strict";

    /**
     * @options
     * @param customClass [string] <''> "Class applied to instance"
     * @param label [boolean] <true> "Display handle width label"
     * @param labels.closed [string] <'Navigation'> "Closed state text"
     * @param labels.open [string] <'Close'> "Open state text"
     * @param maxWidth [string] <'980px'> "Width at which to auto-disable plugin"
     */
    var options = {
        customClass: "",
        label: true,
        labels: {
            closed: "Navigation",
            open: "Close"
        },
        maxWidth: "980px"
    };

    /**
     * @events
     * @event open.naver "Navigation opened"
     * @event close.naver "Navigation closed"
     */

    var pub = {

        /**
         * @method
         * @name close
         * @description Closes instance
         * @example $(".target").naver("close");
         */
        close: function(e) {
            return $(this).each(function(i, nav) {
                var data = $(nav).data("naver");

                if (data !== null) {
                    data.$wrapper.css({
                        height: 0
                    });
                    if (data.label) {
                        data.$handle.html(data.labels.closed);
                    }
                    data.$nav.removeClass("open")
                             .trigger("close.naver");
                }
            });
        },

        /**
         * @method
         * @name defaults
         * @description Sets default plugin options
         * @param opts [object] <{}> "Options object"
         * @example $.naver("defaults", opts);
         */
        defaults: function(opts) {
            options = $.extend(true, options, opts || {});
            return $(this);
        },

        /**
         * @method
         * @name disable
         * @description Disables instance
         * @example $(".target").naver("disable");
         */
        disable: function() {
            return $(this).each(function(i, nav) {
                var data = $(nav).data("naver");

                if (data !== null) {
                    data.$nav.removeClass("enabled");
                    data.$wrapper.css({ height: "" });
                }
            });
        },

        /**
         * @method
         * @name destroy
         * @description Destroys instance
         * @example $(".target").naver("destroy");
         */
        destroy: function() {
            return $(this).each(function(i, nav) {
                var data = $(nav).data("naver");

                if (data !== null) {
                    data.$handle.remove();
                    data.$container.contents()
                                   .unwrap()
                                   .unwrap();

                    data.$nav.removeClass("enabled disabled naver " + data.customClass)
                             .off(".naver")
                             .removeData("naver");
                }
            });
        },

        /**
         * @method
         * @name enable
         * @description Enables instance
         * @example $(".target").naver("enable");
         */
        enable: function() {
            return $(this).each(function(i, nav) {
                var data = $(nav).data("naver");

                if (data !== null) {
                    data.$nav.addClass("enabled");
                    pub.close.apply(data.$nav);
                }
            });
        },

        /**
         * @method
         * @name open
         * @description Opens instance
         * @example $(".target").naver("open");
         */
        open: function() {
            return $(this).each(function(i, nav) {
                var data = $(nav).data("naver");

                if (data !== null) {
                    data.$wrapper.css({
                        height: data.$container.outerHeight(true)
                    });
                    if (data.label) {
                        data.$handle.html(data.labels.open);
                    }
                    data.$nav.addClass("open")
                             .trigger("open.naver");
                }
            });
        }
    };

    /**
     * @method private
     * @name _init
     * @description Initializes plugin
     * @param opts [object] "Initialization options"
     */
    function _init(opts) {
        // Settings
        opts = $.extend(true, {}, options, opts);

        // Apply to each element
        var $items = $(this);
        for (var i = 0, count = $items.length; i < count; i++) {
            _build($items.eq(i), opts);
        }
        return $items;
    }

    /**
     * @method private
     * @name _build
     * @description Builds each instance
     * @param $nav [jQuery object] "Target jQuery object"
     * @param opts [object] <{}> "Options object"
     */
    function _build($nav, opts) {
        if (!$nav.data("naver")) {
            // Extend Options
            opts = $.extend(true, {}, opts, $nav.data("naver-options"));

            var $handle = $nav.find(".naver-handle").length ? $nav.find(".naver-handle").detach() : $('<span class="naver-handle"></span>');

            $nav.addClass("naver " + opts.customClass)
                .wrapInner('<div class="naver-container"></div>')
                .wrapInner('<div class="naver-wrapper"></div>')
                .prepend($handle);

            var data = $.extend(true, {
                $nav: $nav,
                $container: $nav.find(".naver-container"),
                $wrapper: $nav.find(".naver-wrapper"),
                $handle: $nav.find(".naver-handle")
            }, opts);

            data.$handle.text((opts.label) ? opts.labels.closed : '');
            data.$nav.on("touchstart.naver mousedown.naver", ".naver-handle", data, _onClick)
                .data("naver", data);

            // Navtive MQ Support
            if (window.matchMedia !== undefined) {
                data.mediaQuery = window.matchMedia("(max-width:" + (data.maxWidth === Infinity ? "100000px" : data.maxWidth) + ")");
                // Make sure we stay in context
                data.mediaQuery.addListener(function() {
                    _onRespond.apply(data.$nav);
                });
                _onRespond.apply(data.$nav);
            }
        }
    }

    /**
     * @method private
     * @name _onClick
     * @description Handles click nav click
     * @param e [object] "Event data"
     */
    function _onClick(e) {
        e.preventDefault();
        e.stopPropagation();

        var $target = $(e.currentTarget),
            data = e.data;

        // Close other open instances
        $(".naver").not(data.$nav)
                   .naver("close");

        if (data.$nav.hasClass("open")) {
            pub.close.apply(data.$nav);
        } else {
            pub.open.apply(data.$nav);
        }
    }

    /**
     * @method private
     * @name _onRespond
     * @description Handles media query match change
     */
    function _onRespond() {
        var data = $(this).data("naver");

        if (data.mediaQuery.matches) {
            pub.enable.apply(data.$nav);
        } else {
            pub.disable.apply(data.$nav);
        }
    }

    $.fn.naver = function(method) {
        if (pub[method]) {
            return pub[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return _init.apply(this, arguments);
        }
        return this;
    };

    $.naver = function(method) {
        if (method === "defaults") {
            pub.defaults.apply(this, Array.prototype.slice.call(arguments, 1));
        }
    };
})(jQuery, window);