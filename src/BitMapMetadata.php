<?php

declare(strict_types=1);

namespace Bic\Image\BMP;

use Bic\Image\BMP\Metadata\BitMapFileHeader;
use Bic\Image\BMP\Metadata\BitMapInfoHeader;

final class BitMapMetadata
{
    public function __construct(
        public readonly BitMapFileHeader $file,
        public readonly BitMapInfoHeader $info,
    ) {
    }
}
