@if ($appId = config('services.twitter.embeds.enabled'))
<script>
    (function ($, block) {
        function embedTwitterWidgetScript() {
            var notEmbedded = $('script[src="//platform.twitter.com/widgets.js"]').length === 0;
            if (notEmbedded) {
                $('body').append('<script async src="//platform.twitter.com/widgets.js" charset="utf-8"><\/script>');
            }
        }

        function changeMatchForEmbed(link, content) {
            content.innerHTML = content.innerHTML.replace(
                link,
                '<blockquote class="twitter-tweet" data-lang="en"><a href="'+link+'">'+link+'</a></blockquote>'
            )
        }

        function regexForMatch(id, content) {
            var regex = /((http(s|):\/\/)|)twitter.com\/\w*\/status\/\d*/g;
            var match = regex.exec($(content).text())
            if (match && match[0]) {
                changeMatchForEmbed(match[0], content)
                embedTwitterWidgetScript();
            }
        }

        $(block).each(regexForMatch)
    })($, '.forum-content > p');
</script>
@endif