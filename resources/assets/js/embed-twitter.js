$.fn.twembed = function () {

    const regex = /((http(s|):\/\/)|)twitter.com\/\w*\/status\/\d*/g;

    function changeMatchForEmbed(link, content) {
        content.innerHTML = content.innerHTML.replace(
            link,
            `<blockquote class="twitter-tweet" data-lang="en"><a href="${link}">${link}</a></blockquote>`
        )
    }

    function regexForMatch(id, content) {
        const match = regex.exec($(content).text());
        if (match && match[0]) {
            changeMatchForEmbed(match[0], content);
        }
    }

    $(this).each(regexForMatch);
};