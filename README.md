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

![Draw Piano](https://i.imgur.com/1Xn0FIX.png)

### PRESSING KEYS

PHPSVGPiano ```draw()``` method accepts comma separated musical notes as it's first parameter

```php

$C_Major = "C, E, G";

$piano->draw( $C_Major );

```

In PHPSVGPiano;

```Sharp``` is represented with a plus ``` + ``` sign

```Flat``` is represented with a minus ```-``` sign. 

---

So if you need to write a note like ```C#```, you would write ```C+``` instead.

And when you need to write ```Cb```, you'd write ```C-``` instead.

### Example:

```php

// Cmin#5 - C, Eb, G#

$C_Minor_Aug = "C, E-, G+";

$piano->draw( $C_Minor_Aug );

```

![Sample](https://i.imgur.com/lpwYvla.png)


### Piano Octaves

You can extend the piano octave by specifying how many octave should be rendered before calling the ```draw()``` method.

```php

// extend the piano to 2 octaves;

$piano->octaves = 2;

$piano->draw();

```

However, you can also specify the octave of a note. 

*This will automatically increase the piano octave if the octave specified is higher than the default.*

To specify a note octave, append a number to the note. For Example, ```C``` or ```C4``` represents the ```middle C``` & ```C5``` is an octave higher.

*The default octave for any natural note is 4*

### Example:

```php

// C Minor add9 = 1 - b3 - 5 - 9

$CmAdd9 = "C, E-, G, D5";

// Let's also play this in 3rd inversion

$CmAdd9_3rd = "G, C5, D5, E-5";

$piano->draw( $CmAdd9 );
$piano->draw( $CmAdd9_3rd );

```



