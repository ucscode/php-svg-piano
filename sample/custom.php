<?php

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Enums\AccidentalTypeEnum;
use Ucscode\PhpSvgPiano\Pattern\RenderPattern;
use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\PhpSvgPiano\Pattern\TextPattern;
use Ucscode\PhpSvgPiano\Piano;

require '../vendor/autoload.php';

// Define key patterns for released and pressed states with vibrant colors
$releasedKeyPattern = new KeyPattern(30, 100, '#ff0000', '#000000', 2); // Bright red white keys
$pressedKeyPattern = new KeyPattern(30, 100, '#ff8800', '#000000', 2); // Orange pressed white keys

$releasedAccidentalPattern = new KeyPattern(20, 70, '#0000ff', '#ffff00', 2); // Blue black keys with yellow stroke
$pressedAccidentalPattern = new KeyPattern(20, 70, '#00ff00', '#ff00ff', 2); // Green pressed black keys with magenta stroke

// Define text patterns with vibrant colors
$releasedTextPattern = new TextPattern(0, 0, '#00ffff', null, 1); // Cyan text
$pressedTextPattern = new TextPattern(0, 0, '#ff00ff', null, 1); // Magenta text

// Define render patterns for natural and accidental keys
$naturalPattern = new RenderPattern();
$naturalPattern->setReleasedKeyPattern($releasedKeyPattern);
$naturalPattern->setPressedKeyPattern($pressedKeyPattern);
$naturalPattern->setReleasedTextPattern($releasedTextPattern);
$naturalPattern->setPressedTextPattern($pressedTextPattern);

$accidentalPattern = new RenderPattern();
$accidentalPattern->setReleasedKeyPattern($releasedAccidentalPattern);
$accidentalPattern->setPressedKeyPattern($pressedAccidentalPattern);
$accidentalPattern->setReleasedTextPattern($releasedTextPattern);
$accidentalPattern->setPressedTextPattern($pressedTextPattern);

// Create configuration
$config = new Configuration();
$config->setNaturalKeyPattern($naturalPattern);
$config->setAccidentalKeyPattern($accidentalPattern);
$config->setTitlePattern(new TextPattern(0, 0, '#ff00ff', '#ff1493', 2)); // Deep pink title text
$config->setDefaultAccidentalType(AccidentalTypeEnum::TYPE_SHARP);
$config->setOctaveStartPoint(3);
$config->setOctaveEndPoint(5);
$config->setShowReleasedKeyText(true);
$config->setShowPressedKeyText(true);
$config->setShowOctaveNumber(false);

// Create piano instance with custom configuration
$piano = new Piano($config);

// Render the piano
echo $piano->render(null, 'No Key');
