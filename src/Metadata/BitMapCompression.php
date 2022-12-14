<?php

declare(strict_types=1);

namespace Bic\Image\BMP\Metadata;

/**
 * @link https://learn.microsoft.com/en-us/openspecs/windows_protocols/ms-wmf/4e588f70-bd92-4a6f-b77f-35d0feaf7a57
 */
enum BitMapCompression: int
{
    case RGB = 0x0000;
    case RLE8 = 0x0001;
    case RLE4 = 0x0002;
    case BITFIELDS = 0x0003;
    case JPEG = 0x0004;
    case PNG = 0x0005;
    case CMYK = 0x000B;
    case CMYK_RLE8 = 0x000C;
    case CMYK_RLE4 = 0x000D;
}
