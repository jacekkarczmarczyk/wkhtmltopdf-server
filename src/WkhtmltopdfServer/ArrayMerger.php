<?php

declare(strict_types=1);

namespace WkhtmltopdfServer;

class ArrayMerger
{
    /**
     * @param array<mixed> $array1
     * @param array<mixed> $array2
     * @return array<mixed>
     * @psalm-suppress MixedArrayAccess
     * @psalm-suppress MixedAssignment
     * @psalm-suppress MixedArgument
     */
    public static function mergeRecursiveDistinct(array $array1, array &$array2): array
    {
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && is_array($array1[$key] ?? null)) {
                $array1[$key] = self::mergeRecursiveDistinct($array1[$key], $value);
            } else {
                $array1[$key] = $value;
            }
        }

        return $array1;
    }
}
