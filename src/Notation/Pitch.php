<?php

namespace Ucscode\PhpSvgPiano\Notation;

use InvalidArgumentException;

class Pitch 
{
    public const NOTES = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
    public const ACCIDENTAL_SHARP = '#';
    public const ACCIDENTAL_FLAT = '_';


    protected const SUBSTITUTION = [
        'E' . self::ACCIDENTAL_SHARP => [
            'note' => 'F', 
            'octave' => 0,
        ],
        'F' . self::ACCIDENTAL_FLAT => [
            'note' => 'E', 
            'octave' => 0,
        ],
        'B' . self::ACCIDENTAL_SHARP => [
            'note' => 'C', 
            'octave' => 1,
        ],
        'C' . self::ACCIDENTAL_FLAT => [
            'note' => 'B', 
            'octave' => -1,
        ]
    ]; 

    protected string $note;
    protected ?string $accidental;
    protected int $octave;

    public function __construct(string $note, ?string $accidental = null, int $octave = 4) 
    {
        $this->setNote($note);
        $this->setAccidental($accidental);
        $this->setOctave($octave);
    }

    public function __toString(): string
    {
        return $this->getFullPitch();
    }

    public function setNote(string $note): static 
    {
        $note = strtoupper(trim($note));

        if (!in_array($note, self::NOTES)) {
            throw new InvalidArgumentException("Invalid note: $note");
        }

        $this->note = $note;
        $this->harmonizeNote();

        return $this;
    }

    public function getNote(): string 
    {
        return $this->note;
    }

    public function setAccidental(string $accidental): static 
    {
        if ($accidental !== null) {
            $accidental = trim($accidental);

            if (!in_array($accidental, [self::ACCIDENTAL_FLAT, self::ACCIDENTAL_SHARP])) {
                throw new InvalidArgumentException("Invalid accidental: $accidental");
            }
        }

        $this->accidental = $accidental;
        $this->harmonizeNote();

        return $this;
    }

    public function getAccidental(): ?string 
    {
        return $this->accidental;
    }

    public function setOctave(int $octave): static 
    {
        $this->octave = $octave;
        $this->harmonizeNote();

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

    public function getFullPitch(): string
    {
        return $this->getAccidentalNote() . $this->octave;
    }

    protected function harmonizeNote(): void
    {
        $accidentalNote = $this->getAccidentalNote();

        if (!array_key_exists($accidentalNote, self::SUBSTITUTION)) {
            return;
        }
            
        $substitution = self::SUBSTITUTION[$accidentalNote];
        $this->note = $substitution['note'];
        $this->octave += $substitution['octave'];
        $this->accidental = null;
    }
}