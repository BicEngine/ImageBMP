<?php

declare(strict_types=1);

namespace Bic\Image\Bmp\Exception;

use Bic\Image\Bmp\Metadata\BitMapCompression;

class DdsCompressionException extends DdsException
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