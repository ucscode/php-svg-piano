<?php

namespace Ucscode\PhpSvgPiano;

use Ucscode\PhpSvgPiano\Notation\NoteParser;
use Ucscode\PhpSvgPiano\Notation\PianoKey;
use Ucscode\PhpSvgPiano\Notation\Pitch;

class PianoBuilder
{
    protected Configuration $configuration;

    protected int $minOctave = 1;
    protected int $maxOctave = 1;

    /**
     * @var array<int,array{octave:int,white:PianoKey[],black:PianoKey[]}>
     */
    protected array $keys = [];

    /**
     * @var Pitch[]
     */
    protected array $inputPitches = [];

    public function __construct(Configuration $configuration, ?string $notes = null)
    {
        $this->configuration = $configuration ?? new Configuration();
        !$notes ?: $this->parseAndPressNotes($notes);
        $this->generateKeys();
    }

    protected function parseAndPressNotes(string $notes): void
    {
        $this->inputPitches = (new NoteParser())->parse($notes);

        $octaves = array_map(fn (Pitch $pitch) => $pitch->getOctave(), $this->inputPitches);

        $this->minOctave = min($octaves);
        $this->maxOctave = max($octaves);
    }

    protected function generateKeys(): void
    {
        foreach (range($this->minOctave, $this->maxOctave) as $octave) {
            $group = [
                'octave' => $octave,
                'white' => [],
                'black' => []
            ];

            foreach (Pitch::NOTES as $note) {
                // Create white key
                $whiteKey = new PianoKey(new Pitch($note, null, $octave));
                $group['white'][] = $this->pressPianoKey($whiteKey);

                // Add black keys for accidentals
                if ($note !== 'E' && $note !== 'B') {
                    $blackKey = new PianoKey(new Pitch($note, Pitch::ACCIDENTAL_SHARP, $octave));
                    $group['black'][] = $this->pressPianoKey($blackKey);
                }
            }

            $this->keys[] = $group;
        }
    }

    protected function pressPianoKey(PianoKey $pianoKey): PianoKey
    {
        foreach ($this->inputPitches as $pitch) {
            $isPressed = in_array($pianoKey->getPitch()->getIdentifier(), [
                $pitch->getIdentifier(),
                $pitch->getEnharmonicEquivalence(),
            ], true);

            !$isPressed ?: $pianoKey->setPressed(true);
        }

        return $pianoKey;
    }

    public function render(): string
    {
        $svg = '<svg width="1500" height="200" xmlns="http://www.w3.org/2000/svg">';
        $x = 0;

        foreach ($this->keys as $group) {
            foreach ($group['white'] as $key) {
                $color = $key->getColor() ?? $this->configuration->getNaturalKeyColor();
                $border = $key->getBorderColor() ?? $this->configuration->getNaturalKeyBorderColor();
                $width = $key->getWidth() ?? ($key->isAccidental() ? $this->configuration->getAccidentalKeyWidth() : $this->configuration->getNaturalKeyWidth());
                $height = $key->getHeight() ?? ($key->isAccidental() ? $this->configuration->getAccidentalKeyHeight() : $this->configuration->getNaturalKeyHeight());

                $svg .= sprintf(
                    '<rect x="%d" y="0" width="%d" height="%d" fill="%s" stroke="%s" stroke-width="1"/>',
                    $x,
                    $width,
                    $height,
                    $color,
                    $border
                );

                $x += 22;
            }

            $x = 0;
            foreach ($group['black'] as $key) {
                $color = $key->getColor();
                $border = $key->getBorderColor();
                $width = $key->getWidth() ?? ($key->isAccidental() ? $this->configuration->getAccidentalKeyWidth() : $this->configuration->getNaturalKeyWidth());
                $height = $key->getHeight() ?? ($key->isAccidental() ? $this->configuration->getAccidentalKeyHeight() : $this->configuration->getNaturalKeyHeight());

                $svg .= sprintf(
                    '<rect x="%d" y="0" width="%d" height="%d" fill="%s" stroke="%s" stroke-width="1"/>',
                    $x + 15,
                    $width,
                    $height,
                    $color,
                    $border
                );

                $x += 22;
            }
        }

        $svg .= '</svg>';
        return $svg;
    }
}
