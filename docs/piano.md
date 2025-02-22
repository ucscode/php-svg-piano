## The Piano Class

The `Piano` class is the primary entry point of the PHP SVG Piano Generator. It orchestrates the rendering process by combining configuration settings, note inputs, and additional options to produce a complete SVG piano diagram.

### Key Responsibilities

- **Integration of Configuration and Options:**  
  The `Piano` class uses a `Configuration` object to determine the visual style of keys, text, and overall layout. If no custom configuration is provided, it will default to a pre-defined configuration with sensible defaults.

- **Rendering Notes and Chords:**  
  The class’s `render` method accepts a string of notes or chords, which specify which keys should be rendered as "pressed". For example, passing `'C, E, G'` will display the keys for a C major chord as pressed.

- **Handling Rendering Options:**  
  An optional second parameter can be used to provide additional settings via an `Option` object or an associative array. This can include properties such as a custom title for the piano diagram.

---

### Constructor and Default Configuration

The `Piano` class is designed for ease of use. When you instantiate a new `Piano` object, you can either pass in a custom `Configuration` object or rely on the default settings:

```php
// Using the default configuration:
$piano = new Piano();
```

```php
// Using a custom configuration:
$config = new Configuration();
// (Customize your configuration as needed)
$piano = new Piano($config);
```

---

### The Render Method

The main method of the `Piano` class is `render()`. Its signature allows for two parameters:
- **Notes/Chords (optional):**  
  A string that specifies the notes or chords to be pressed. If omitted, the piano will render with no keys pressed.
  
- **Option (optional):**  
  Additional rendering options can be provided. This parameter can be a string (which will be interpreted as a title), an associative array, or an `Option` object.

#### Examples

**Rendering a Basic Piano Diagram**

```php
echo (new Piano())->render();
```

This call renders a basic piano diagram with no keys pressed, using default settings.

![Piano Plain](./images/piano.png)

**Rendering a Piano with a Chord**

```php
echo (new Piano())->render('C, E, G');
```

This call renders the piano with the keys corresponding to the C major chord pressed.

![Piano + C Major](./images/piano-cmaj.png)

**Rendering with Additional Options**

```php
// Using a string as the title.
echo (new Piano())->render('C, E_, G, B_', 'C Minor 7th');

// Using an associative array (or Option instance) for more options.
echo (new Piano())->render('C, E_, G, B_', ['title' => 'C Minor 7th']);
```

![Piano + C Major 7th + Title](./images/piano-cmin7-title.png)

In each case, the `render()` method internally constructs an `Option` object if necessary, and then delegates the drawing process to the `PianoBuilder` that uses the provided configuration and note inputs.

---

### Internal Workflow

When you call the `render()` method:

1. **Option Handling:**  
   The method checks if the provided option is already an `Option` object. If not, it converts strings or arrays into an `Option` instance.

2. **Delegation to the Builder:**  
   A `PianoBuilder` is instantiated with the configuration, note input, and options. This builder handles the logic of generating the SVG markup.

3. **SVG Generation:**  
   The builder processes the configuration and patterns, iterates over the necessary octaves and keys, applies the pressed states as specified by the input notes, and then composes the complete SVG output.

---

### Summary

- The **Piano** class is the core of the SVG generation process.
- It ties together a `Configuration` for styling, note input for which keys are pressed, and an optional `Option` for additional metadata like titles.
- Its `render()` method is flexible and easy to use, supporting multiple ways to specify options.

By encapsulating the rendering process, the `Piano` class allows you to generate complex, customizable piano diagrams with minimal code.

---

[Back to Documentation Scheme](./index.md)
