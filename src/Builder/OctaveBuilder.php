<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Configuration;
use Ucscode\PhpSvgPiano\Notation\PianoKey;
use Ucscode\UssElement\Node\ElementNode;

class OctaveBuilder
{
    /**
     * @var array{octave:int,natural:PianoKey[],accidental:PianoKey[]}
     */
    protected array $octaveComponent;
    protected ElementNode $octaveSvgGroup;
    protected Configuration $configuration;

    public function __construct(array $octaveComponent, Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->octaveComponent = $octaveComponent;
        $this->octaveSvgGroup = new ElementNode('G');
        $this->buildNaturalOctaveKeys();
        $this->buildAccidentalOctaveKeys();
    }

    public function getElement(): ElementNode
    {
        return $this->octaveSvgGroup;
    }

    protected function buildNaturalOctaveKeys(): void
    {
        $group = new ElementNode('G');

        foreach ($this->octaveComponent['natural'] as $posIndex => $pianoKey) {
            // set X axis of white key
            $pianoKey
                ->setWidth($this->configuration->getNaturalKeyWidth())
                ->setHeight($this->configuration->getNaturalKeyHeight())
                ->setXAxis($posIndex * $pianoKey->getWidth())
                ->setYAxis($this->configuration->getNaturalKeyHeight())
            ;

            $rectNode = new ElementNode('RECT', [
                'fill' => $pianoKey->getFill(),
                'stroke' => $pianoKey->getStroke(),
                'x' => $pianoKey->getXAxis(),
                'y' => $pianoKey->getYAxis(),
                'width' => $pianoKey->getWidth(),
                'height' => $pianoKey->getHeight(),
                'class' => '',
                'data-label' => 'key-white'
            ]);

            $textNode = new ElementNode('TEXT', [
                'x' => $pianoKey->getXAxis() - 5,
                'y' => $pianoKey->getYAxis() - 5,
                'fill' => $pianoKey->getFill(),
                'class' => '',
                'data-svg' => 'text-white'
            ]);

            $textNode->setInnerHtml($pianoKey->getPitch()->getIdentifier());
            $rectNode->appendChild($textNode);
            $group->appendChild($rectNode);
        }

        $this->octaveSvgGroup->appendChild($group);
    }

    protected function buildAccidentalOctaveKeys(): void
    {
        $group = new ElementNode('G');

        foreach ($this->octaveComponent['accidental'] as $posIndex => $pianoKey) {
            // set X axis of white key
            $pianoKey
                ->setWidth($this->configuration->getAccidentalKeyWidth())
                ->setHeight($this->configuration->getAccidentalKeyHeight())
                ->setXAxis($posIndex * $pianoKey->getWidth())
                ->setYAxis($this->configuration->getAccidentalKeyHeight())
            ;

            $rectNode = new ElementNode('RECT', [
                'fill' => $pianoKey->getFill(),
                'stroke' => $pianoKey->getStroke(),
                'x' => $pianoKey->getXAxis(),
                'y' => $pianoKey->getYAxis(),
                'width' => $pianoKey->getWidth(),
                'height' => $pianoKey->getHeight(),
                'class' => '',
                'data-label' => 'key-white'
            ]);

            $textNode = new ElementNode('TEXT', [
                'x' => $pianoKey->getXAxis() - 5,
                'y' => $pianoKey->getYAxis() - 5,
                'fill' => $pianoKey->getFill(),
                'class' => '',
                'data-svg' => 'text-white'
            ]);

            $textNode->setInnerHtml($pianoKey->getPitch()->getIdentifier());
            $rectNode->appendChild($textNode);
            $group->appendChild($rectNode);
        }

        $this->octaveSvgGroup->appendChild($group);
    }
}
