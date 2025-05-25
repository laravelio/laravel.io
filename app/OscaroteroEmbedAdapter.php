<?php

namespace App;

use Embed\Embed as EmbedLib;
use League\CommonMark\Exception\MissingDependencyException;
use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Extension\Embed\EmbedAdapterInterface;

class OscaroteroEmbedAdapter implements EmbedAdapterInterface
{
    private EmbedLib $embedLib;

    public function __construct(?EmbedLib $embed = null)
    {
        if ($embed === null) {
            if (! \class_exists(EmbedLib::class)) {
                throw new MissingDependencyException('The embed/embed package is not installed. Please install it with Composer to use this adapter.');
            }

            $embed = new EmbedLib;
        }

        $this->embedLib = $embed;
    }

    /**
     * {@inheritDoc}
     */
    public function updateEmbeds(array $embeds): void
    {
        $urls = \array_map(static fn (Embed $embed) => $embed->getUrl(), $embeds);
        
        $extractors = $this->embedLib->getMulti(...$urls);

        foreach ($extractors as $i => $extractor) {
            if ($extractor->code !== null) {
                $embeds[$i]->setEmbedCode($extractor->code->html);
            }
        }
    }
}
