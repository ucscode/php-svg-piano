<?php

namespace Ucscode\PhpSvgPiano;

class Pitch 
{
    public const SHARP = '^';
    public const FLAT = '_';

    protected string $note;
    protected ?string $accidental;
    protected int $octave;

    public function __construct(string $input) 
    {
        $this->parsePitchString($input);
    }

    public function setNote(string $note): static 
    {
        if (!preg_match('/^[A-G]$/i', trim($note))) {
            throw new \InvalidArgumentException("Invalid musical note: Must be between A-G.");
        }

        $this->note = strtoupper(trim($note));

        return $this;
    }

    public function getNote(): string 
    {
        return $this->note;
    }

    public function setAccidental(?string $accidental): static 
    {
        if ($accidental !== null) {
            $accidental = trim($accidental);

            if (!in_array($accidental, [self::SHARP, self::FLAT], true)) {
                throw new \InvalidArgumentException(sprintf(
                    "Invalid Accidental: Must be %s(sharp), %(flat), or null(natural).",
                    self::SHARP,
                    self::FLAT
                ));
            }
        }
        
        $this->accidental = $accidental;

        return $this;
    }

    public function getAccidental(): ?string 
    {
        return $this->accidental;
    }

    public function setOctave(int $octave): static 
    {
        $this->octave = $octave;

        return $this;
    }

    public function getOctave(): int 
    {
        return $this->octave;
    }

    public function getAccidentalNote(): string
    {
        return $this->note . ($this->accidental ?? '');
    }

    public function getFullyQualifiedNote(): string
    {
        return $this->getAccidentalNote() . $this->octave;
    }

    protected function parsePitchString(string $pitch): void 
    {
        $pitch = str_replace(' ', '', $pitch);
        $expression = sprintf('/^([A-G])([\%s\%s]?)((?:\-?[0-9]+)?)$/i', self::SHARP, self::FLAT);

        if (preg_match($expression, $pitch, $matches)) {
            $this->setNote($matches[1]);
            $this->setAccidental($matches[2] ?: null);
            $this->setOctave((int)($matches[3] ?: 4));
        }
            
        throw new \InvalidArgumentException("Invalid pitch format: $pitch");
    }
}