<?php

use Symfony\Component\Yaml\Yaml;

require __DIR__.'/../vendor/autoload.php';

// Parse YAML rather than grepping: quoted keys, flow mappings and multiline
// scalars must obey the same policy as ordinary uses: lines.
$files = array_slice($argv, 1) ?: glob(__DIR__.'/workflows/*.{yml,yaml}', GLOB_BRACE);
$failed = false;

foreach ($files as $file) {
    try {
        $workflow = Yaml::parseFile($file);
        $check = function (array $node) use (&$check, &$failed, $file): void {
            foreach ($node as $key => $value) {
                if ($key === 'uses') {
                    $reference = is_string($value) ? trim($value) : '';
                    $local = preg_match('~^\./[^\s@]+$~D', $reference);
                    $commit = preg_match('~^[\w.-]+/[\w.-]+(?:/[\w./-]+)?@[a-fA-F0-9]{40}$~D', $reference);
                    $digest = preg_match('~^docker://[^\s@]+@sha256:[a-fA-F0-9]{64}$~D', $reference);

                    if (! $local && ! $commit && ! $digest) {
                        fwrite(STDERR, "$file: uses must be local, pinned to a full commit SHA, or a Docker SHA-256 digest: $reference\n");
                        $failed = true;
                    }
                } elseif (is_array($value)) {
                    $check($value);
                }
            }
        };
        $check($workflow);
    } catch (Throwable $error) {
        fwrite(STDERR, "$file: {$error->getMessage()}\n");
        $failed = true;
    }
}

exit($failed ? 1 : 0);
