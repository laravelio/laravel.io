<?php
namespace Lio\Content;

class ForeignLanguageSpamDetector implements SpamDetector
{
    /** @inheritdoc */
    public function detectsSpam($value)
    {
        return (bool) preg_match(
            "/[일안명빠에외하전나밤사이팅토노카ぬ벳인포방어코리아맨강남야구장강배팅배트ミ법스포츠석사배지석사소테크카주소る】ズ]+/iu",
            $value
        );
    }
}
