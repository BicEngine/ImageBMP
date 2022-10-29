<?php

declare(strict_types=1);

namespace Bic\Image\BMP;

use Bic\Binary\Endianness;
use Bic\Binary\StreamInterface;
use Bic\Binary\TypedStream;
use Bic\Image\BMP\Exception\BitMapBitDepthException;
use Bic\Image\BMP\Exception\DdsCompressionException;
use Bic\Image\BMP\Metadata\BitMapFileHeader;
use Bic\Image\BMP\Metadata\BitMapInfoHeader;
use Bic\Image\BMP\Metadata\BitMapCompression;
use Bic\Image\BMP\Metadata\BitMapType;
use Bic\Image\Compression;
use Bic\Image\DecoderInterface;
use Bic\Image\Exception\FormatException;
use Bic\Image\PixelFormat;
use Bic\Image\Image;
use Bic\Image\ImageInterface;
use Bic\Image\Reader;

final class BitMapDecoder implements DecoderInterface
{
    /**
     * {@inheritDoc}
     */
    public function decode(StreamInterface $stream): ?iterable
    {
        if ($stream->read(2) === "\x42\x4D") {
            return [$this->read($stream)];
        }

        return null;
    }

    /**
     * @param StreamInterface $stream
     *
     * @return ImageInterface
     * @throws DdsCompressionException
     * @throws FormatException
     * @throws \Throwable
     *
     * @psalm-suppress ArgumentTypeCoercion
     */
    private function read(StreamInterface $stream): ImageInterface
    {
        $typed = new TypedStream($stream, Endianness::LITTLE);

        $file = self::readFileHeader($typed);
        $info = self::readInfoHeader($typed);

        // Only RGB images is supported
        if ($info->compression !== BitMapCompression::RGB) {
            throw DdsCompressionException::fromUnsupportedCompression($info->compression);
        }

        // Move to offset
        $stream->seek($file->offset);

        $format = match ($info->bitCount) {
            24 => PixelFormat::B8G8R8,
            32 => PixelFormat::B8G8R8A8,
            default => throw BitMapBitDepthException::fromUnsupportedBits($info->bitCount, [24, 32]),
        };

        return new Image(
            format: $format,
            width: $info->width,
            height: $info->height,
            contents: Reader::bottomUp(
                stream: $stream,
                width: $info->width,
                height: $info->height,
                bytes: $format->getBytesPerPixel(),
            ),
            compression: Compression::NONE,
            metadata: new BitMapMetadata(
                file: $file,
                info: $info,
            ),
        );
    }

    /**
     * @param TypedStream $stream
     *
     * @return BitMapInfoHeader
     *
     * @psalm-suppress PossiblyInvalidArgument
     */
    public static function readInfoHeader(TypedStream $stream): BitMapInfoHeader
    {
        return new BitMapInfoHeader(
            size: $stream->uint32(),
            width: $stream->int32(),
            height: $stream->int32(),
            planes: $stream->uint16(),
            bitCount: $stream->uint16(),
            compression: BitMapCompression::from($stream->uint32()),
            sizeImage: $stream->uint32(),
            xPelsPerMeter: $stream->int32(),
            yPelsPerMeter: $stream->int32(),
            clrUsed: $stream->uint32(),
            clrImportant: $stream->uint32(),
        );
    }

    /**
     * @param TypedStream $stream
     *
     * @return BitMapFileHeader
     *
     * @psalm-suppress PossiblyInvalidArgument
     */
    public static function readFileHeader(TypedStream $stream): BitMapFileHeader
    {
        return new BitMapFileHeader(
            type: BitMapType::BM,
            size: $stream->uint32(),
            reserved1: $stream->uint16(),
            reserved2: $stream->uint16(),
            offset: $stream->uint32(),
        );
    }
}
