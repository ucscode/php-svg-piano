<?php

namespace Ucscode\PhpSvgPiano;

class Configurable
{
    /**
     * The width per octave (12 notes)
     */
    public int $octaveWidth = 400;

    /**
     * The height of the piano
     */
    public int $pianoHeight = 200;

    /**
     * The number of octaves to render
     */
    public int $numberOfOctaves = 1;

    /**
     * The watermark text to include in the piano
     */
    public string $watermarkText = '';
}
