## Pitch

In the piano library, a **Pitch** represents a musical note with its letter name, accidental (if any), and octave number. Understanding pitch is essential for handling notes and chords correctly.

### Understanding Accidentals

Accidentals are symbols that modify a note's pitch. The common accidentals are:

- **Sharp (`#`):** Raises the pitch by a semitone (e.g., C# is a semitone higher than C).
- **Flat (`_`):** Lowers the pitch by a semitone (e.g., B_ is a semitone lower than B).

### Why "`_`" is Used for Flats

Since the standard flat symbol (&flat;) is not easily typable in plain text and can cause encoding issues in some environments, the library uses "`_`" as an alternative. This ensures compatibility across different systems while maintaining clear notation.

### Enharmonic Equivalents

Some notes sound the same but are written differently. These are called **[enharmonic equivalents](https://en.wikipedia.org/wiki/Enharmonic_equivalence)**. The library standardizes certain equivalents to maintain consistency:

- `E#` is treated as `F`, and `F_` is treated as `E`.
- `B#` is treated as `C`, and `C_` is treated as `B`.
- For all other sharps and flats, their alternative notations are used:
  - If the note is sharp (e.g., `G#`), its equivalence would be A flat (`A_`).
  - If the note is flat (e.g., `A_`), it is rewritten as the next letter with a sharp (`G#`).

This approach ensures that every pitch is consistently interpreted and prevents ambiguity in note representation.

### Pitch Representation in the Library

Each pitch is uniquely represented by:

- A musical alphabet (A &mdash; G)
- An accidental (if applicable: `#` or `_`)
- An octave number

#### For example:

```php
$pitch = new Pitch("G", '#', 6);
```

This represents G-sharp in the 6th octave. The library ensures that all pitches are standardized based on the defined enharmonic rules.

---

### Pitch Methods

| Method | Description |
|--------|-------------|
| `getNote()` | Returns the note letter (A–G). |
| `getAccidental()` | Returns `#`, `_`, or `null` if there is no accidental. |
| `getOctaveNumber()` | Returns the octave number. |
| `getAccidentalSymbol()` | Returns the original musical accidental symbol (`♯` or `♭`). |
| `getAccidentalNote()` | Returns the note along with its accidental (e.g., `G#`). |
| `getIdentifier()` | Returns the full identifier (note + accidental + octave number, e.g., `G#6`). |
| `getEnharmonicEquivalence()` | Returns the enharmonic equivalent as a `Pitch` instance or itself if it’s natural. |
| `matches(Pitch $pitch)` | Checks if the pitch matches another pitch instance. |

---

### Example Usage

```php
$pitch = new Pitch("A", "_", 3);

$pitch->getNote(); // A
$pitch->getAccidental(); // _
$pitch->getOctaveNumber(); // 3
$pitch->getAccidentalSymbol(); // ♭
$pitch->getIdentifier(); // A_3
```

```php
$enharmonic = $pitch->getEnharmonicEquivalence();

$enharmonic->getIdentifier(); // G#3
```

```php
$pitch->matches(new Pitch("A", "_", 3)); // true
$pitch->matches(new Pitch("G", "#", 3)); // true
$pitch->matches(new Pitch("A", "_", 4)); // false
```

By using this approach, the piano library maintains clarity and avoids redundancy in note representation, making it easier to handle musical structures like scales, chords, and melodies.

