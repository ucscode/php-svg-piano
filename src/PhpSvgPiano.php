<?php

namespace Ucscode\PhpSvgPiano;

/**
 * @author Uchenna Ajah <uche23mail@gmail.com>
 */
class PhpSvgPiano extends AbstractPhpSvgPiano
{
    public function __construct(?string $svgName = null)
    {
        $this->svgName = $svgName;
    }

    public function draw(?string $music_notes = null, ?string $title = null, $print = true)
    {

        $this->play($music_notes);

        $this->configure();

        $title = $this->parseText('title', $title);

        $watermark = $this->parseText('watermark', $this->watermark);

        $this->canvas = "<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 {$this->piano_width} {$this->svg_height}' data-psvgp='{$this->svgname}'> ";

        if (!empty($title)) {
            $this->canvas .= $title;
        }

        for ($x = 1; $x <= $this->octaves; $x++) {
            $octave = $this->octave_range[ $x - 1 ] ?? null;
            $position = $this->set_white_keys($x, $octave);
            $this->set_black_keys($x, $position, $octave);
        };

        if (!empty($watermark)) {
            $this->canvas .= $watermark;
        }

        $this->canvas .= "</svg>";

        $svg = $this->canvas;
        $this->canvas = null;

        return print_r($svg, !$print);

    }
}
