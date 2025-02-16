<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Notation\NoteParser;
use Ucscode\PhpSvgPiano\Notation\Octave;
use Ucscode\PhpSvgPiano\Notation\PianoKey;
use Ucscode\PhpSvgPiano\Notation\Pitch;
use Ucscode\UssElement\Enums\NodeNameEnum;
use Ucscode\UssElement\Node\ElementNode;

class PianoBuilder
{
    protected Configuration $configuration;
    protected array $options = [];

    protected int $minOctave = 1;
    protected int $maxOctave = 1;

    /**
     * @var Octave[]
     */
    protected array $octaves = [];

    /**
     * Notes inputed by user
     *
     * @var Pitch[]
     */
    protected array $inputPitches = [];

    public function __construct(Configuration $configuration, ?string $notes = null, array $options = [])
    {
        $this->configuration = $configuration ?? new Configuration();
        $this->options = $options;
        !$notes ?: $this->parseAndPressNotes($notes);
        $this->generateKeys();
    }

    protected function parseAndPressNotes(string $notes): void
    {
        $this->inputPitches = (new NoteParser())->parseAll($notes);

        $octaves = array_map(fn (Pitch $pitch) => $pitch->getOctave(), $this->inputPitches);

        $this->minOctave = min($octaves);
        $this->maxOctave = max($octaves);
    }

    protected function generateKeys(): void
    {
        /**
         * @var int $octaveNumber
         */
        foreach (range($this->minOctave, $this->maxOctave) as $octaveNumber) {
            $naturalKeys = [];
            $accidentalKeys = [];

            foreach (Pitch::NOTES as $note) {
                // Create white key
                $whiteKey = new PianoKey(new Pitch($note, null, $octaveNumber));
                $naturalKeys[] = $this->configurePianoKey($whiteKey);

                // Add black keys for accidentals
                if ($note !== 'E' && $note !== 'B') {
                    $blackKey = new PianoKey(new Pitch($note, Pitch::ACCIDENTAL_SHARP, $octaveNumber));
                    $accidentalKeys[] = $this->configurePianoKey($blackKey);
                }
            }

            $this->octaves[] = new Octave($octaveNumber, $naturalKeys, $accidentalKeys);
        }
    }

    protected function configurePianoKey(PianoKey $pianoKey): PianoKey
    {
        $pattern = $pianoKey->isAccidental() ?
            $this->configuration->getAccidentalKeyPattern() :
            $this->configuration->getNaturalKeyPattern()
        ;

        $pianoKey
            ->setWidth($pattern->getWidth())
            ->setHeight($pattern->getHeight())
            ->setX($pattern->getX())
            ->setY($pattern->getY())
            ->setStroke($pattern->getStroke())
            ->setFill($pattern->getFill())
            ->setStrokeWidth($pattern->getStrokeWidth())
        ;

        foreach ($this->inputPitches as $pitch) {
            $isPressed = in_array($pianoKey->getPitch()->getIdentifier(), [
                $pitch->getIdentifier(),
                $pitch->getEnharmonicEquivalence()->getIdentifier(),
            ], true);

            !$isPressed ?: $pianoKey->setPressed(true);
        }

        return $pianoKey;
    }

    public function render(): string
    {
        $title = new TextBuilder($this->options['title'] ?? '');
        $watermark = new TextBuilder($this->options['watermark'] ?? '');

        $svgElement = new ElementNode(NodeNameEnum::NODE_SVG, [
            'version' => '1.1',
            'xmlns' => 'http://www.w3.org/2000/svg',
            'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
            'viewBox' => sprintf('0 0 %s %s', $this->getPianoWidth(), $this->getPianoHeight()),
            'data-psvgp' => '{$this->svgname}',
        ]);

        $svgElement->appendChild($title->getElement());
        $svgElement->appendChild((new OctaveBuilder($this->octaves))->getElement());
        $svgElement->appendChild($watermark->getElement());

        return $svgElement->render(0);
    }

    protected function getPianoWidth(): int
    {
        return $this->configuration->getNaturalKeyPattern()->getWidth() * count(Pitch::NOTES) * count($this->octaves);
    }

    protected function getPianoHeight(): int
    {
        return $this->configuration->getNaturalKeyPattern()->getHeight();
    }
}
