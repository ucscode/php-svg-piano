## Patterns

In PHP SVG Piano, **Patterns** are the building blocks that determine the visual appearance of individual piano elements. The two primary pattern types exist: 

1. [KeyPattern](#keypattern)
2. [TextPattern](#textpattern) 

These patterns allow you to precisely control the style of keys and their associated text.

---

### KeyPattern

KeyPattern defines how a **single** piano key should render. It includes settings for dimensions, border color (stroke), background color (fill), and border thickness (stroke width). This pattern is used to display the key in various states—typically, **a released state** and **a pressed state**.

**Example:**  

Imagine you want your natural (white) keys to have the following properties:

- **Dimensions:** 30px width and 90px height 
- **Released State:**  
  - Border color: `black`  
  - Background color: `white`
- **Pressed State:**  
  - Border color changed to `blue`  
  - Background color changed to `yellow`

You would create two instances of `KeyPattern` &mdash; one for the released state and one for the pressed state:

```php
// Released state for a natural key.
$releasedNaturalKeyPattern = new KeyPattern(30, 90, 'black', 'white');

// Pressed state for a natural key.
$pressedNaturalKeyPattern = new KeyPattern(30, 90, 'blue', 'yellow');
```

These instances dictate the visual style for natural keys depending on whether they are pressed or not.

For accidental (black) keys, you might define a different size and color scheme, for example:

```php
// Released state for an accidental key.
$releasedAccidentalKeyPattern = new KeyPattern(25, 55, 'black', 'black');

// Pressed state for an accidental key.
$pressedAccidentalKeyPattern = new KeyPattern(25, 55, 'brown', 'red');
```

---

### TextPattern

TextPattern controls the appearance of text elements associated with the keys. This includes parameters such as font size, color, and font-family. TextPattern ensures that labels like note names remain legible and aesthetically pleasing regardless of the key's state.

**Example:**  

Suppose you want the text on a key to be dark gray in its released state and white in its pressed state. You could define the text patterns as follows:

```php
// Text for a released key appears in dark gray.
$releasedTextPattern = new TextPattern(0, 0, 'transparent', 'darkgrey');
$releasedTextPattern->setFontSize(14);

// Text for a pressed key appears in white.
$pressedTextPattern = new TextPattern(0, 0, 'blue', 'white');
$releasedTextPattern->setFontFamily('monospace')
```

In these examples, the text on released keys will be darkgrey with transparent stroke. However, when the key is pressed, the text would be white in color with a blue stroke.

---

### How Patterns Are Used

While `KeyPattern` and `TextPattern` independently define style for a single key and text, they are typically grouped into a `RenderPattern` for consistency. A `RenderPattern` serves as a container for:

- **Released** KeyPattern
- **Pressed** KeyPattern
- **Released** TextPattern
- **Pressed** TextPattern

#### Example

```php
$renderPattern = (new RenderPattern())
  // applies to all released key
  ->setReleasedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#f9f9f9ff'))

  // applies to all pressed key
  ->setPressedKeyPattern(new KeyPattern(30, 90, '#353535ff', '#d3bc5fff'))

  // applies to all released key
  ->setReleasedTextPattern(new TextPattern(0, 0, '', '#353535ff'))

  // applies to all text keys
  ->setPressedTextPattern(new TextPattern(0, 0, '', '#353535ff'))
;
```

This grouping means that **every key** of a specific type (e.g., natural or accidental) will consistently use the same visual rules for both its key shape and its text, regardless of whether the key is pressed or released.

---

### Summary

- **KeyPattern:**  
  - Sets dimensions, stroke, fill, and stroke width.
  - Defines distinct visual styles for released and pressed states.
  
- **TextPattern:**  
  - Controls the appearance of key labels or titles.
  - Ensures text remains clear and visually harmonious with the key styles.

By defining and adjusting these patterns, you can customize the appearance of your piano at a granular level, ensuring that every element—from the shape and color of keys to the style of the text—meets your design requirements.

---

[Back to Documentation Scheme](./index.md)
