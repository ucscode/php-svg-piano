<?php

use Ucscode\PhpSvgPiano\Piano;

require '../vendor/autoload.php';

// Create a piano object
$piano = new Piano();

// Render the piano SVG with some notes pressed
echo $piano->render('C E_ G# B_', 'Agumented 7th');
echo $piano->render('A C5 E5', 'A minor');
