<?php

namespace Ucscode\PhpSvgPiano\Notation;

use InvalidArgumentException;

class Pitch
{
    public const ACCIDENTAL_SHARP = '#';
    public const ACCIDENTAL_FLAT = '_';

    public const NOTES = [
        'C',
        'D',
        'E',
        'F',
        'G',
        'A',
        'B',
    ];

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
        return $this->getIdentifier();
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

    public function getIdentifier(): string
    {
        return $this->getAccidentalNote() . $this->octave;
    }

    public function getEnharmonicEquivalence(): static
    {
        if ($this->accidental === self::ACCIDENTAL_SHARP) {
            $prevNote = $this->getPreviousNote();
            return new self($prevNote, self::ACCIDENTAL_FLAT, $this->octave);
        }

        if ($this->accidental === self::ACCIDENTAL_FLAT) {
            $nextNote = $this->getNextNote();
            return new self($nextNote, self::ACCIDENTAL_SHARP, $this->octave);
        }

        return $this;
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

    protected function getPreviousNote(): string
    {
        $index = array_search($this->note, self::NOTES);
        $prevIndex = ($index - 1 + count(self::NOTES)) % count(self::NOTES);

        return self::NOTES[$prevIndex];
    }

    protected function getNextNote(): string
    {
        $index = array_search($this->note, self::NOTES);
        $nextIndex = ($index + 1) % count(self::NOTES);

        return self::NOTES[$nextIndex];
    }
}
