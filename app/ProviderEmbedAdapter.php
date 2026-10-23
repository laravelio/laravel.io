<?php

namespace App;

use League\CommonMark\Extension\Embed\EmbedAdapterInterface;

class ProviderEmbedAdapter implements EmbedAdapterInterface
{
    /**
     * {@inheritDoc}
     */
    public function updateEmbeds(array $embeds): void
    {
        foreach ($embeds as $embed) {
            $embed->setEmbedCode($this->iframe($embed->getUrl()));
        }
    }

    private function iframe(string $url): ?string
    {
        $parts = parse_url($url);

        if ($parts === false || ! isset($parts['host'], $parts['scheme'])
            || ! in_array(strtolower($parts['scheme']), ['http', 'https'], true)
            || isset($parts['user']) || isset($parts['pass'])) {
            return null;
        }

        $host = strtolower($parts['host']);
        $path = $parts['path'] ?? '';
        $src = null;

        if ($host === 'youtube.com' || str_ends_with($host, '.youtube.com')) {
            if ($path === '/watch') {
                parse_str($parts['query'] ?? '', $query);
                $id = $query['v'] ?? null;
            } else {
                preg_match('~^/(?:embed|shorts)/([a-zA-Z0-9_-]+)$~D', $path, $matches);
                $id = $matches[1] ?? null;
            }

            if (is_string($id) && preg_match('/^[a-zA-Z0-9_-]+$/D', $id)) {
                $src = 'https://www.youtube.com/embed/'.$id;
            }
        } elseif ($host === 'twitter.com' || str_ends_with($host, '.twitter.com')
            || $host === 'x.com' || str_ends_with($host, '.x.com')) {
            if (preg_match('~^/[^/]+/status/([0-9]+)/?$~D', $path, $matches)) {
                $src = 'https://platform.twitter.com/embed/Tweet.html?id='.$matches[1];
            }
        }

        if ($src === null) {
            return null;
        }

        return '<iframe src="'.htmlspecialchars($src, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8').'"'
            .' title="Embedded content" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"'
            .' sandbox="allow-scripts allow-same-origin allow-presentation" allowfullscreen></iframe>';
    }
}
