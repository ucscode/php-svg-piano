<?php

namespace Ucscode\PhpSvgPiano\Notation;

class Alphabet
{
    public const TONE_A = 'A';

    protected const MUSIC_NOTES = [
        'C',
        'D',
        'E',
        'F',
        'G',
        'A',
        'B'
    ];

    protected const SHARP_NOTES = [
        'C+',
        'D+',
        'F+',
        'G+',
        'A+'
    ];

    protected const FLAT_NOTES = [
        'D-',
        'E-',
        'G-',
        'A-',
        'B-'
    ];

    protected const SUBSTITUTION = [
        'E+' => 'F',
        'F-' => 'E',
        'B+' => 'C',
        'C-' => 'B'
    ]; 
}