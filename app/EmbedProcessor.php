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

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Extension\Embed\EmbedAdapterInterface;
use League\CommonMark\Node\Block\Paragraph;
use League\CommonMark\Node\Inline\Text;
use League\CommonMark\Node\NodeIterator;

final class EmbedProcessor
{
    public const FALLBACK_REMOVE = 'remove';

    public const FALLBACK_LINK = 'link';

    private EmbedAdapterInterface $adapter;

    private string $fallback;

    public function __construct(EmbedAdapterInterface $adapter, string $fallback = self::FALLBACK_REMOVE)
    {
        $this->adapter = $adapter;
        $this->fallback = $fallback;
    }

    public function __invoke(DocumentParsedEvent $event): void
    {
        $document = $event->getDocument();
        $embeds = [];
        
        foreach (new NodeIterator($document) as $node) {
            info('Processing node of type: ' . get_class($node));
            if (! ($node instanceof Embed)) {
                continue;
            }
            info('Node is an embed, processing...');

            if ($node->parent() !== $document) {
                $replacement = new Paragraph;
                $replacement->appendChild(new Text($node->getUrl()));
                $node->replaceWith($replacement);
            } else {
                $embeds[] = $node;
            }
        }

        if (! empty($embeds)) {
            $this->adapter->updateEmbeds($embeds);
        }

        foreach ($embeds as $embed) {
            if ($embed->getEmbedCode() !== null) {
                continue;
            }

            if ($this->fallback === self::FALLBACK_REMOVE) {
                $embed->detach();
            } elseif ($this->fallback === self::FALLBACK_LINK) {
                $paragraph = new Paragraph;
                $paragraph->appendChild(new Link($embed->getUrl(), $embed->getUrl()));
                $embed->replaceWith($paragraph);
            }
        }
    }
}
