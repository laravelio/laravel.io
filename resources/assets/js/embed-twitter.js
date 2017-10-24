$.fn.twembed = function () {

    function changeMatchForEmbed(link, content) {
        content.innerHTML = content.innerHTML.replace(
            link,
            '<blockquote class="twitter-tweet" data-lang="en"><a href="' + link + '">' + link + '</a></blockquote>'
        )
    }

    function regexForMatch(id, content) {
        var regex = /((http(s|):\/\/)|)twitter.com\/\w*\/status\/\d*/g;
        var match = regex.exec($(content).text());
        if (match && match[0]) {
            changeMatchForEmbed(match[0], content);
        }
    }

    $(this).each(regexForMatch);
};