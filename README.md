# PHP SVG Piano Documentation

- Introduction
- Getting Started
- Patterns
- Configuration
- Pitch
- NoteParser

## 1. Introduction  
- **Overview:**  
  A PHP library that generates customizable SVG pianos using an object-oriented approach.  
- **Features:**  
  - Dynamic piano generation  
  - Customizable key styles and interactions  
  - Configuration-driven rendering  
  - Pattern-based customization for key states (e.g., clicked, released)  
  - Support for musical theory with classes like Pitch and Octave  
- **Installation:**  
  Provide installation instructions (via Composer, etc.)

## 2. Getting Started  
- **Quick Start Example:**  
  - How to instantiate and render a piano  
  - Passing in configuration and options  
- **Basic Usage:**  
  - Creating a basic piano with default settings

## 3. Core Classes Overview  

### 3.1 Piano  
- **Description:**  
  Main class for generating the SVG piano.  
- **Key Methods:**  
  - `render(Configuration $config, Option $option)` – generates the SVG based on provided configurations and options.

### 3.2 PianoKey  
- **Description:**  
  Represents individual keys on the piano.  
- **Key Properties/Methods:**  
  - Styling attributes, status (pressed/released), and SVG generation for a key.

### 3.3 Pitch  
- **Description:**  
  Handles musical notes, including mapping between notes and their respective frequencies or positions.  
- **Usage:**  
  Provides support for enharmonic equivalents.

### 3.4 Octave  
- **Description:**  
  Represents an octave and groups a set of keys.  
- **Usage:**  
  Helps in organizing keys and their corresponding pitches.

## 4. Additional Classes

### 4.1 Configuration  
- **Description:**  
  Holds settings that determine how the piano is rendered.  
- **Usage:**  
  Passed as the first parameter to the `Piano::render` method.  
- **Key Attributes:**  
  - Dimensions, key spacing, styling defaults, etc.

### 4.2 Option  
- **Description:**  
  Provides extra options (e.g., piano title, metadata) for rendering the piano.  
- **Usage:**  
  Passed as the second parameter to the `Piano::render` method.

### 4.3 Patterns  
- **Description:**  
  A collection of classes that define how piano keys are rendered under various states.  
- **Available Pattern Classes:**
  - **KeyPattern:**  
    Determines the basic style and shape of a key.
  - **TextPattern:**  
    Handles the rendering of text (e.g., note labels) on the keys.
  - **RenderPattern:**  
    Defines more complex rendering behaviors, such as interactive states (clicked, released).

## 5. Advanced Topics  

### 5.1 Customizing Rendering  
- **How to use Configuration and Option classes:**  
  - Examples and use-cases for custom configurations.
- **Pattern Customization:**  
  - Creating custom patterns by extending KeyPattern, TextPattern, or RenderPattern.

### 5.2 Extending the Library  
- **Adding new patterns or custom behaviors:**  
  - Guidelines for subclassing and overriding default methods.

## 6. API Reference  
- Detailed method and property documentation for each class:
  - **Piano:** Methods like `render()`, `addOctave()`, etc.
  - **PianoKey:** Properties for key status, styling; methods for SVG generation.
  - **Pitch:** Methods for note handling.
  - **Octave:** Methods for grouping keys.
  - **Configuration & Option:** List available settings.
  - **Patterns:** Methods and properties of KeyPattern, TextPattern, RenderPattern.

## 7. Contributing  
- **Guidelines for Contribution:**  
  - Code style guidelines, branch naming, pull request process.
- **Contact/Support:**  
  - How to reach out for help or report issues.

## 8. License  
- **Details:**  
  Provide license information.

