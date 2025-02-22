<?php

namespace Ucscode\PhpSvgPiano\Notation;

use InvalidArgumentException;
use Ucscode\PhpSvgPiano\Enums\AccidentalCharEnum;

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
    protected int $octaveNumber;

    public function __construct(string $note, ?string $accidental = null, int $octaveNumber = 4)
    {
        $this->setNote($note);
        $this->setAccidental($accidental);
        $this->setOctaveNumber($octaveNumber);
        $this->harmonizeNote();
    }

    public function __toString(): string
    {
        return $this->getIdentifier();
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function getAccidental(): ?string
    {
        return $this->accidental;
    }

    public function getOctaveNumber(): int
    {
        return $this->octaveNumber;
    }

    public function getAccidentalSymbol(): ?string
    {
        if ($this->accidental) {
            return $this->accidental === self::ACCIDENTAL_SHARP ?
                AccidentalCharEnum::SHARP_SYMBOL->value :
                AccidentalCharEnum::FLAT_SYMBOL->value
            ;
        }

        return null;
    }

    public function getAccidentalNote(): string
    {
        return $this->note . ($this->getAccidentalSymbol() ?? '');
    }

    public function getIdentifier(): string
    {
        return $this->getAccidentalNote() . $this->octaveNumber;
    }

    public function getEnharmonicEquivalence(): static
    {
        if ($this->accidental === self::ACCIDENTAL_SHARP) {
            $prevNote = $this->getNextNote();
            return new self($prevNote, self::ACCIDENTAL_FLAT, $this->octaveNumber);
        }

        if ($this->accidental === self::ACCIDENTAL_FLAT) {
            $nextNote = $this->getPreviousNote();
            return new self($nextNote, self::ACCIDENTAL_SHARP, $this->octaveNumber);
        }

        return $this;
    }

    /**
     * Check if the frequency of the argument matches frequency of the current pitch
     *
     * @param Pitch $pitch
     * @return boolean
     */
    public function matches(Pitch $pitch): bool
    {
        return in_array($this->getIdentifier(), [
            $pitch->getIdentifier(),
            $pitch->getEnharmonicEquivalence()->getIdentifier(),
        ], true);
    }

    protected function setNote(string $note): static
    {
        $note = strtoupper(trim($note));

        if (!in_array($note, self::NOTES)) {
            throw new InvalidArgumentException("Invalid note: $note");
        }

        $this->note = $note;

        return $this;
    }

    protected function setAccidental(?string $accidental): static
    {
        !empty($accidental) ?: $accidental = null;

        if ($accidental !== null) {
            $accidental = trim($accidental);

            if (!in_array($accidental, [self::ACCIDENTAL_FLAT, self::ACCIDENTAL_SHARP])) {
                throw new InvalidArgumentException("Invalid accidental: $accidental");
            }
        }

        $this->accidental = $accidental;

        return $this;
    }

    protected function setOctaveNumber(int $octave): static
    {
        $this->octaveNumber = $octave;

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
        $this->octaveNumber += $substitution['octave'];
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
