<?php

use App\Rules\InvalidMentionRule;

it('passes when no invalid mentions are detected', function ($body) {
    expect((new InvalidMentionRule())->validate('body', $body, fn () => throw new Exception()));
})->with([
    'Hello, I\'m looking for some help',
    'I\'ve seen [this link](https://example.com), is it legit?',
    "### Help needed!
    \n
    Hello @joedixon I am hoping you can help.
    \n
    Here is some **bold** and _italic_ text
    \n
    > I'm quoting you now!
    \n
    `code goes here`
    \n
    ```javascript
    const string = 'more code goes here'
    ```
    \n
    [link](https://example.com)
    \n
    ![image](https://example.com/image.png)",
])->throwsNoExceptions();

it('fails when invalid mentions are detected', function ($body) {
    expect((new InvalidMentionRule())->validate('body', $body, fn () => throw new Exception()));
})->with([
    '[@driesvints](https://somethingnasty.com)',
    'Hey [@joedixon](https://somethingnasty.com), is it legit?',
    "### Help needed!
    \n
    Hello [@joedixon](https://somethingnasty.com) I am hoping you can help.
    \n
    Here is some **bold** and _italic_ text
    \n
    > I'm quoting you now!
    \n
    `code goes here`
    \n
    ```javascript
    const string = 'more code goes here'
    ```
    \n
    [link](https://example.com)
    \n
    ![image](https://example.com/image.png)",
])->throws(Exception::class);
