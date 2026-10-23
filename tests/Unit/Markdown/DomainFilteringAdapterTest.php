<?php

use App\DomainFilteringAdapter;
use League\CommonMark\Extension\Embed\Embed;
use League\CommonMark\Extension\Embed\EmbedAdapterInterface;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

uses(MockeryPHPUnitIntegration::class);

it('only forwards URLs with an allowed parsed host', function (string $url, bool $allowed) {
    $embed = new Embed($url);
    $adapter = Mockery::mock(EmbedAdapterInterface::class);
    $adapter->shouldReceive('updateEmbeds')->once()->with($allowed ? [$embed] : []);

    (new DomainFilteringAdapter($adapter, ['youtube.com', 'twitter.com', 'x.com']))->updateEmbeds([$embed]);
})->with([
    ['https://youtube.com/watch?v=x', true],
    ['https://www.youtube.com/watch?v=x', true],
    ['https://x.com/u/status/1', true],
    ['https://twitter.com/u/status/1', true],
    ['HTTPS://WWW.YouTube.COM/watch?v=x', true],
    ['https://youtube.com@attacker.example/', false],
    ['https://youtube.com.attacker.example/', false],
    ['http://youtube.com.169.254.169.254.nip.io/', false],
    ['https://evilyoutube.com/', false],
    ['http://169.254.169.254/', false],
    ['https://youtube.com:pw@attacker.example/', false],
    ['https://user:pw@youtube.com/', false],
    ['https://@youtube.com/', false],
    ['ftp://youtube.com/', false],
    ['//youtube.com/watch?v=x', false],
    ['youtube.com/watch?v=x', false],
    ['https://', false],
]);

it('reindexes allowed embeds after filtering', function () {
    $allowed = new Embed('https://youtube.com/watch?v=x');
    $adapter = Mockery::mock(EmbedAdapterInterface::class);
    $adapter->shouldReceive('updateEmbeds')->once()->with([$allowed]);

    (new DomainFilteringAdapter($adapter, ['youtube.com']))->updateEmbeds([
        new Embed('https://attacker.example/'),
        $allowed,
    ]);
});
