<?php

namespace App\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait PreparesSearch
{
    public function split($value)
    {
        // Split the string on new paragraph.
        $chunks = $this->splitToCollection($value, "/\r\n\r\n/")
            ->flatMap(function ($chunk) {
                // If the chunk is still too long, split it on new line.
                if (strlen($chunk) > 5000) {
                    return $this->splitToCollection($chunk, "/\r\n/")->toArray();
                }

                return [$chunk];
            });

        // Batch the paragraphs into chunks of <= 5000 characters.
        return $this->batch($chunks, 5000);
    }

    private function splitToCollection($string, $delimiter): Collection
    {
        return collect(preg_split($delimiter, $string));
    }

    private function batch(Collection $chunks, int $limit): array
    {
        return $chunks->reduce(function ($carry, $item) use ($limit) {
            // First iteration, set the item as first array item.s
            if (is_null($carry)) {
                return [$item];
            }

            if ($item === '') {
                return $carry;
            }

            // Append current item to last element of carry if the combination is < 5000 characters.
            if (strlen(Arr::last($carry).$item) < $limit) {
                $carry[count($carry) - 1] .= "\r\n{$item}";

                return $carry;
            }

            // Add the current item to the carry.
            array_push($carry, $item);

            return $carry;
        });
    }
}
