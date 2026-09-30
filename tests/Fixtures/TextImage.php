<?php

namespace Tests\Fixtures;

/**
 * Builds a real PNG containing legible text so OCR tests run against the
 * actual Tesseract binary instead of a mocked driver.
 */
class TextImage
{
    public static function make(string $line, int $scale = 3): string
    {
        $width = 900;
        $height = 200;
        $small = imagecreatetruecolor($width, $height);
        imagefill($small, 0, 0, imagecolorallocate($small, 255, 255, 255));
        imagestring($small, 5, 20, 80, $line, imagecolorallocate($small, 0, 0, 0));

        $large = imagecreatetruecolor($width * $scale, $height * $scale);
        imagefill($large, 0, 0, imagecolorallocate($large, 255, 255, 255));
        imagecopyresampled($large, $small, 0, 0, 0, 0, $width * $scale, $height * $scale, $width, $height);

        $path = tempnam(sys_get_temp_dir(), 'ocr_fixture_').'.png';
        imagepng($large, $path);

        imagedestroy($small);
        imagedestroy($large);

        return $path;
    }
}
