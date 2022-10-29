<?php

declare(strict_types=1);

namespace Bic\Image\BMP\Exception;

use Bic\Image\Exception\ImageException;

class BitMapBitDepthException extends ImageException
{
    /**
     * @param int $bits
     * @param array<int> $supported
     *
     * @return static
     */
    public static function fromUnsupportedBits(int $bits, array $supported): self
    {
        $supported = \implode('bits, ', $supported) . 'bits';

        return new static(\sprintf('Supported only [%s] image bit depth, but %d given', $supported, $bits));
    }
}
