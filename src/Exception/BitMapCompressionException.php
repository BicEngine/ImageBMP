<?php

declare(strict_types=1);

namespace Bic\Image\Bmp\Exception;

use Bic\Image\Bmp\Internal\Compression;

class BitMapCompressionException extends BitMapException
{
    /**
     * @param Compression $compression
     *
     * @return static
     */
    public static function fromUnsupportedCompression(Compression $compression): self
    {
        return new static(\vsprintf('Unsupported bitmap image compression %s (0x%04X)', [
            $compression->name,
            $compression->value,
        ]));
    }
}
