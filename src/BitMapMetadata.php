<?php

declare(strict_types=1);

namespace Bic\Image\Bmp;

use Bic\Image\Bmp\Metadata\BitMapFileHeader;
use Bic\Image\Bmp\Metadata\BitMapInfoHeader;

final class BitMapMetadata
{
    public function __construct(
        public readonly BitMapFileHeader $file,
        public readonly BitMapInfoHeader $info,
    ) {
    }
}
