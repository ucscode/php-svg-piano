<?php

use Ucscode\PhpSvgPiano\Piano;

require '../vendor/autoload.php';

// Create a piano object
echo (new Piano())->render('C, E_, G, B_', 'C Minor 7th');
