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

---

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

$piano->draw( $CmAdd9 );

```

![C Minor Add9](https://i.imgur.com/Uz8skvx.png)

```php

// Let's try a different chord
// Minor7 = 1, b3, 5, b7;

$Bbmin7 = "B-, D-5, E5, A-5"; // B-Flat;

$piano->draw( $Bbmin7 );

```

![Imgur](https://i.imgur.com/rYRoVMV.png)

---

### ADDING TITLE

You can display a title with the piano diagram by passing a string to the second parameter of ```draw()``` method;

```php

$piano->draw( "C, E-, G, B-", "C Minor 7" );

```

![Screenshot](https://i.imgur.com/SoccqnB.png)

---

### Predefined Properties

You can set the width of the piano octave and the height of the piano

```php

$piano->octave_width = 300;
$piano->piano_height = 60;
$piano->draw();

```

![Piano Resized](https://i.imgur.com/Kw0LDAS.png)

---

### Finally

You can return the svg result as string if you don't want to print the svg directly to the browser.

This can be achieved by passing a ```boolean``` value ```false``` to the 3rd parameter of ```draw()``` method

```php

$piano_svg = $piano->draw( null, null, false );

echo $piano_svg;

```

---

*That's it! Thanks for stopping by!*
*The idea of this project was inspired by [SVGuitar](https://github.com/omnibrain/svguitar)*
*Though they have nothing in common in terms of language but they do have something in common in terms of creating visual instrument representations*







