<?php

declare(strict_types=1);

/*
 * This file is part of the league/commonmark package.
 *
 * (c) Colin O'Dell <colinodell@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Extension\Embed\EmbedAdapterInterface;

class DomainFilteringAdapter implements EmbedAdapterInterface
{
    private EmbedAdapterInterface $decorated;

    /** @var string[] */
    private array $allowedDomains;

    /**
     * @param  string[]  $allowedDomains
     */
    public function __construct(EmbedAdapterInterface $decorated, array $allowedDomains)
    {
        $this->decorated = $decorated;
        $this->allowedDomains = array_map('strtolower', $allowedDomains);
    }

    /**
     * {@inheritDoc}
     */
    public function updateEmbeds(array $embeds): void
    {
        $this->decorated->updateEmbeds(\array_values(\array_filter($embeds, function (Embed $embed): bool {
            $url = $embed->getUrl();
            $host = parse_url($url, PHP_URL_HOST);
            $scheme = parse_url($url, PHP_URL_SCHEME);

            if (! is_string($host) || ! is_string($scheme)
                || ! in_array(strtolower($scheme), ['http', 'https'], true)
                || parse_url($url, PHP_URL_USER) !== null
                || parse_url($url, PHP_URL_PASS) !== null) {
                return false;
            }

            $host = strtolower($host);

            foreach ($this->allowedDomains as $domain) {
                if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                    return true;
                }
            }

            return false;
        })));
    }
}
