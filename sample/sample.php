<?php

use Ucscode\PhpSvgPiano\Piano;

require '../vendor/autoload.php'; // Adjust the path as needed

// Create a piano object
$piano = new Piano();

// Render the piano SVG with some notes pressed
$svgOutput = $piano->render('C4 E4 G#4 B_ A_5');

// Display the SVG output
// header('Content-Type: image/svg+xml');

echo $svgOutput;
