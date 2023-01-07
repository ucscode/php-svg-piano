# php-svg-piano
Render SVG Piano graphics on web browser directly from PHP

![Screenshot](https://i.imgur.com/SoccqnB.png)

PHPSVGPiano makes it possible for you to draw piano keys and chords directly into your browser as svg. No Javascript Required.

Since the file being rendered is in ```<svg/>``` format, you can easily change the style using HTML or make some animation using Javascript. The choices are yours!

## HOW TO USE

```php

// get the class file

require_once "PHPSVGPiano.php";

//create a piano instance

$piano = new PHPSVGPiano();

//render an svg piano into the browser;

$piano->draw();

```
