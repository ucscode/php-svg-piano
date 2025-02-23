## Configuration

The `Configuration` class is the central hub for setting up how your piano is rendered. It aggregates various parameters—such as key and text patterns, octave range, and display toggles—into a single object that controls the entire rendering process. By using a `Configuration` instance, you can ensure consistency in how every element of the piano is drawn.

### Key Components of Configuration

1. **Key Patterns:**  
   The configuration holds two distinct render patterns:
   - **Natural Key Pattern:**  
     This pattern applies to the white (natural) keys. It includes separate settings for both the released and pressed states. For example, natural keys might be set up with a default width of 30px and a height of 90px. The released state might have a light fill, while the pressed state uses a darker fill.
   - **Accidental Key Pattern:**  
     This pattern is used for black (accidental) keys. Typically, these keys have different dimensions (for example, 25px wide and 55px high) and color schemes to distinguish them from natural keys.

2. **Text Pattern for the Title:**  
   A separate TextPattern is used to style the piano’s title. This allows you to define font size, font family, and color settings for the title independent of the key labels.

3. **Octave Settings:**  
   - **Octave Start and End Points:**  
     These properties determine which octaves are displayed on the piano. For instance, setting both the start and end points to 4 would render a single octave centered around **middle C**.
   - **Octave Number Display:**  
     A toggle exists to show or hide the octave number on the piano diagram.

4. **Display Options for Key Text:**  
   - **Released Key Text:**  
     You can choose whether to display labels on keys when they are in the released (unpressed) state.
   - **Pressed Key Text:**  
     Similarly, there is an option for displaying text when keys are pressed.

5. **Default Accidental Type:**  
   This setting defines how accidentals are represented (e.g., using sharps by default). This can affect how keys are labeled and how the visual arrangement is handled.

---

### How Configuration Works

When you create a new `Piano` instance without providing a custom configuration, a default `Configuration` object is instantiated. This default configuration sets up reasonable defaults for all patterns and display options, ensuring that you can render a piano diagram out-of-the-box. However, if you want to fine-tune the appearance, you can create your own configuration, adjust the patterns, and set custom values for octaves and display options.

---

### Example: Using a Custom Configuration

Imagine you want to tweak the default appearance of your natural keys and adjust some display options. You could do something like this:

```php
<?php
use  Ucscode\PhpSvgPiano\Configuration;
use  Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use  Ucscode\PhpSvgPiano\Pattern\RenderPattern;
use  Ucscode\PhpSvgPiano\Pattern\TextPattern;

// Create a custom configuration instance.
$config = new Configuration();

// Customize the natural key patterns.
$naturalKeysRenderPattern = (new RenderPattern())
    ->setReleasedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#f9f9f9ff'))
    ->setPressedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#d3bc5fff'))
    ->setReleasedTextPattern((new TextPattern(0, 0, null, '#a9a9a9'))->setFontSize(14))
    ->setPressedTextPattern((new TextPattern(0, 0, null, '#ffffff'))->setFontFamily('monospace'))
;

$config->setNaturalKeyPattern($naturalKeysRenderPattern);

// Set the octave range (e.g., display 4th and 5th octaves).
$config->setOctaveStartPoint(4);
$config->setOctaveEndPoint(5);

// Toggle display options.
$config->setShowReleasedKeyText(false);
$config->setShowPressedKeyText(true);
$config->setShowOctaveNumber(false);

// Optionally, set the default accidental type, if applicable.
// $config->setDefaultAccidentalType(AccidentalTypeEnum::TYPE_SHARP);
```

In this example:

- We customize the visual appearance of the natural keys by defining their width, height, stroke, and fill for both released and pressed states.
- We adjust the text patterns to ensure that labels are legible and meet our design requirements.
- We set the octave range to display the 4th and 5th octaves, which might be useful for extended diagrams.
- Display options allow for toggling the visibility of key text and octave numbers.

---

### Applying the configuration

When creating a new `Piano` instance, pass the configuration to the constructor. For example:

```php
$piano = new Piano($configuration);

$piano->render(); // Uses the custom configuration pattern
```

---

### Summary

The `Configuration` class is essential for controlling the overall look and behavior of your SVG piano. It combines individual pattern settings with higher-level display options to ensure that every aspect—from the size and color of keys to the font and visibility of text—is customizable. By using a Configuration instance, you can tailor the piano diagram to perfectly match your design preferences and application requirements.

---

[Back to Documentation Scheme](./index.md)
