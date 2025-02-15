<?php

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Piano;

require '../vendor/autoload.php'; // Adjust the path as needed

// Create a configuration for the piano (optional)
$configuration = new Configuration();
$configuration->setNaturalKeyWidth(30);
$configuration->setAccidentalKeyWidth(20);
$configuration->setNaturalKeyColor('#ffffff');
$configuration->setAccidentalKeyColor('#000000');
$configuration->setWatermarkText('Ucscode Piano');

// Create a piano object
$piano = new Piano($configuration);

// Render the piano SVG with some notes pressed
$svgOutput = $piano->render('C4 E4 G4 C5');

// Display the SVG output
header('Content-Type: image/svg+xml');

echo $svgOutput;
