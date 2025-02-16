<?php

namespace Ucscode\PhpSvgPiano\Enums;

enum AccidentalCharEnum: string
{
    case FLAT_SYMBOL = '♭';
    case FLAT_UNICODE = '&#9837;';

    case NATURAL_SYMBOL = '♮';
    case NATURAL_UNICODE = '&#9838;';

    case SHARP_SYMBOL = '♯';
    case SHARP_UNICODE = '&#9839;';
}
