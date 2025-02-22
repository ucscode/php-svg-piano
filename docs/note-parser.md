## NoteParser

The `NoteParser` class is responsible for converting textual representations of musical notes into `Pitch` instances. This ensures that notes are consistently formatted and processed correctly within the library.

### Methods in NoteParser

| Method | Description |
|--------|-------------|
| `parse(string $note)` | Parses a single note string (e.g., `G_5`) and returns a `Pitch` instance. |
| `parseAll(string $notes)` | Parses a space- or comma-separated list of notes and returns an array of `Pitch` instances. |

---

### Using `parse()`

The `parse` method accepts a single note string and converts it into a `Pitch` instance.

#### Example:

```php
$parser = new NoteParser();
$pitch = $parser->parse("C#4");

$pitch instanceof Pitch; // true

$pitch->getIdentifier(); // C#4
```

---

### Using `parseAll()`

The `parseAll` method processes multiple notes provided as a space- or comma-separated string and returns an array of `Pitch` instances.

#### Example:

```php
$parser = new NoteParser();
$pitches = $parser->parseAll("A_3, C#4, G5");

foreach ($pitches as $pitch) {
    echo $pitch->getIdentifier() . " ";
}
// Output: A_3 C#4 G5
```

This makes it convenient to work with multiple notes efficiently while ensuring they adhere to the library’s standard pitch formatting.

---

[Back to Documentation Scheme](./index.md)
