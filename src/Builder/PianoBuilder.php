<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Notation\NoteParser;
use Ucscode\PhpSvgPiano\Notation\Octave;
use Ucscode\PhpSvgPiano\Notation\PianoKey;
use Ucscode\PhpSvgPiano\Notation\Pitch;
use Ucscode\PhpSvgPiano\Builder\Option;
use Ucscode\PhpSvgPiano\Enums\AccidentalTypeEnum;
use Ucscode\PhpSvgPiano\Pattern\KeyPattern;
use Ucscode\UssElement\Enums\NodeNameEnum;
use Ucscode\UssElement\Node\ElementNode;

class PianoBuilder
{
    protected Configuration $configuration;
    protected Option $options;

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

    public function __construct(Configuration $configuration, ?string $notes = null, ?Option $options = null)
    {
        $this->configuration = $configuration ?? new Configuration();
        $this->options = $options ?? new Option();
        !$notes ?: $this->parseAndPressNotes($notes);
        $this->generateKeys();
    }

    public function render(): string
    {
        $title = new TextBuilder(
            $this->options->get('title') ?? 'Cmaj7',
            $this->options->get('titleAttributes')
        );

        $title->setSpaceBottom(10);

        $watermark = new TextBuilder(
            $this->options->get('watermark') ?? '',
            $this->options->get('watermarkAttributes')
        );

        $svgElement = new ElementNode(NodeNameEnum::NODE_SVG, [
            'version' => '1.1',
            'xmlns' => 'http://www.w3.org/2000/svg',
            'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
            'viewBox' => sprintf(
                '0 0 %s %s',
                $this->getPianoWidth(),
                $this->getPianoHeight() + $title->getOuterHeight() + $watermark->getOuterHeight()
            ),
            'data-psvgp' => '{$this->svgname}',
        ]);

        $svgElement->appendChild($title->getElement());
        $svgElement->appendChild($this->buildOctaveElement(0, $title->getOuterHeight()));
        $svgElement->appendChild($watermark->getElement());

        return $svgElement->render(0);
    }

    protected function parseAndPressNotes(string $notes): void
    {
        $this->inputPitches = (new NoteParser())->parseAll($notes);

        $octaves = array_map(fn (Pitch $pitch) => $pitch->getOctave(), $this->inputPitches);

        $this->minOctave = min($this->configuration->getOctaveStartPoint(), min($octaves));
        $this->maxOctave = max($this->configuration->getOctaveEndPoint(), max($octaves));
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
                    $blackKeyPitch = new Pitch($note, Pitch::ACCIDENTAL_SHARP, $octaveNumber);

                    if ($this->configuration->getDefaultAccidentalType() !== AccidentalTypeEnum::TYPE_SHARP) {
                        $blackKeyPitch = $blackKeyPitch->getEnharmonicEquivalence();
                    }

                    $accidentalKeys[] = $this->configurePianoKey(new PianoKey($blackKeyPitch));
                }
            }

            $this->octaves[] = new Octave($octaveNumber, $naturalKeys, $accidentalKeys, $this->configuration);
        }
    }

    protected function configurePianoKey(PianoKey $pianoKey): PianoKey
    {
        $renderPattern = $pianoKey->isAccidental() ?
            $this->configuration->getAccidentalKeyPattern() :
            $this->configuration->getNaturalKeyPattern()
        ;

        $this->updateKeyPattern($pianoKey, $renderPattern->getReleasedKeyPattern());

        foreach ($this->inputPitches as $pitch) {
            // Press key
            if ($pianoKey->getPitch()->matches($pitch)) {
                if ($pitch->getAccidental() !== $pianoKey->getPitch()->getAccidental()) {
                    $pianoKey = new PianoKey($pianoKey->getPitch()->getEnharmonicEquivalence());
                }

                $this->updateKeyPattern($pianoKey->setPressed(true), $renderPattern->getPressedKeyPattern());
            }
        }

        return $pianoKey;
    }

    protected function getPianoWidth(): int
    {
        $keyPattern = $this->configuration->getNaturalKeyPattern()->getReleasedKeyPattern();

        return $keyPattern->getWidth() * count(Pitch::NOTES) * count($this->octaves);
    }

    protected function getPianoHeight(): int
    {
        $keyPattern = $this->configuration->getNaturalKeyPattern()->getReleasedKeyPattern();

        return $keyPattern->getHeight();
    }

    protected function buildOctaveElement(float $initialX = 0, float $initialY = 0): ElementNode
    {
        $elementGroup = new ElementNode('G', ['data-piano' => '']); // groups all octave
        $diagramGroup = new ElementNode('G', ['data-diagram' => '']);
        $textGroup = new ElementNode('G', ['data-diagram-text' => '']);

        /** @var ?Octave $lastOctave */
        $lastOctave = null;

        foreach ($this->octaves as $octave) {
            $svgElementGroup = $octave
                ->setX($lastOctave?->getWidth() ?? $initialX)
                ->setY($initialY)
                ->arrangePianoKeys()
                ->createSvgElementGroup()
            ;

            $diagramGroup->appendChild($svgElementGroup->get('element'));

            if ($textGroupElement = $svgElementGroup->get('text')) {
                $textGroup->appendChild($textGroupElement);
            }

            $lastOctave = $octave;
        }

        $elementGroup->appendChild($diagramGroup);

        if ($textGroup->getChildNodes()->count()) {
            $elementGroup->appendChild($textGroup);
        }

        return $elementGroup;
    }

    protected function updateKeyPattern(PianoKey $pianoKey, KeyPattern $keyPattern): void
    {
        $pianoKey
            ->setWidth($keyPattern->getWidth())
            ->setHeight($keyPattern->getHeight())
            ->setX($keyPattern->getX())
            ->setY($keyPattern->getY())
            ->setStroke($keyPattern->getStroke())
            ->setFill($keyPattern->getFill())
            ->setStrokeWidth($keyPattern->getStrokeWidth())
        ;
    }
}
