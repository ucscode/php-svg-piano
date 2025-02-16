<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Notation\Octave;
use Ucscode\UssElement\Node\ElementNode;

class OctaveBuilder
{
    protected Octave $octave;
    protected ElementNode $octaveSvgGroup;

    public function __construct(Octave $octave, protected int $index)
    {
        $this->octave = $octave;
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

        foreach ($this->octave->getNaturalKeys() as $pianoKey) {
            // set X axis of white key

            $rectNode = new ElementNode('RECT', [
                'fill' => $pianoKey->getFill(),
                'stroke' => $pianoKey->getStroke(),
                'x' => $pianoKey->getX(),
                'y' => $pianoKey->getY(),
                'width' => $pianoKey->getWidth(),
                'height' => $pianoKey->getHeight(),
                'class' => '',
                'data-label' => 'key-white'
            ]);

            $textNode = new ElementNode('TEXT', [
                'x' => $pianoKey->getX() - 5,
                'y' => $pianoKey->getY() - 5,
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

        foreach ($this->octave->getAccidentalKeys() as $pianoKey) {
            // set X axis of white key
            $rectNode = new ElementNode('RECT', [
                'fill' => $pianoKey->getFill(),
                'stroke' => $pianoKey->getStroke(),
                'x' => $pianoKey->getX(),
                'y' => $pianoKey->getY(),
                'width' => $pianoKey->getWidth(),
                'height' => $pianoKey->getHeight(),
                'class' => '',
                'data-label' => 'key-white'
            ]);

            $textNode = new ElementNode('TEXT', [
                'x' => $pianoKey->getX() - 5,
                'y' => $pianoKey->getY() - 5,
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
