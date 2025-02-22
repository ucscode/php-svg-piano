# **PhpSvgPiano Documentation**  

PhpSvgPiano allows you to generate an SVG representation of a piano keyboard, with flexible customization options for key colors, text styles, and octave ranges. It is object-oriented, making it easy to manipulate and configure.

## [Introduction](./introduction.md)  
- Overview of the library  
- Key features  
- Use Cases 

## [Getting Started](./getting-started.md)  
- Installation instructions (`composer require ucscode/php-svg-piano`)  
- Quickstart Example  
- Rendering the SVG output  

## [Patterns](./patterns.md)   
- **KeyPattern**: Specifies fill, stroke, and other key properties  
- **TextPattern**: Controls font color, size, stroke, and positioning  
- **RenderPattern**: Defines appearance for pressed/released keys and text 

## [Configuration](./configuration.md)  
- Overview of `Configuration` class  
- Components Of Configuration 
- How configuration works with Piano 
- Controlling text visibility 
- Example configurations  

## [Piano](./piano.md)
- Constructor and configuration
- Piano rendering
- Internal Workflow

## [Pitch](./pitch.md)  
- Understanding `Pitch` class  
- Handling note names and octaves 
- Enharmonic equivalence 
- Example usage  

## [NoteParser](./note-parser.md)  
- Parsing single/multiple notes 
- Handling input formats (space/comma-separated notes)  
- Example conversions 

---

[Back to README](../README.md)
