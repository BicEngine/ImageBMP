<?php

declare(strict_types=1);

namespace Bic\Image\BMP\Exception;

use Bic\Image\BMP\Metadata\BitMapCompression;
use Bic\Image\Exception\ImageException;

class CompressionException extends ImageException
{
    /**
     * @param BitMapCompression $compression
     *
     * @return static
     */
    public static function fromUnsupportedCompression(BitMapCompression $compression): self
    {
        return new static(\vsprintf('Unsupported bitmap image compression %s (0x%04X)', [
            $compression->name,
            $compression->value,
        ]));
    }
}
