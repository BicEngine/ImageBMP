<?php

declare(strict_types=1);

namespace Bic\Image\Bmp\Internal;

/**
 * The BITMAPFILEHEADER structure contains information about the type, size,
 * and layout of a file that contains a DIB.
 *
 * @link https://learn.microsoft.com/en-us/windows/win32/api/wingdi/ns-wingdi-bitmapfileheader
 *
 * @internal This is an internal library class, please do not use it in your code.
 * @psalm-internal Bic\Image\Bmp
 */
final class BitMapFileHeader
{
    /**
     * @param BitMapType $type The file type; must be BM.
     * @param positive-int|0 $size The size, in bytes, of the bitmap file.
     * @param positive-int|0 $reserved1 Reserved; must be zero.
     * @param positive-int|0 $reserved2 Reserved; must be zero.
     * @param positive-int|0 $offset The offset, in bytes, from the beginning of
     *                       the BITMAPFILEHEADER structure to the bitmap bits.
     */
    public function __construct(
        public readonly BitMapType $type,
        public readonly int $size,
        public readonly int $reserved1,
        public readonly int $reserved2,
        public readonly int $offset,
    ) {
    }
}
