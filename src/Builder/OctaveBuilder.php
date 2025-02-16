<?php

namespace Ucscode\PhpSvgPiano\Builder;

use Ucscode\PhpSvgPiano\Notation\Octave;
use Ucscode\PhpSvgPiano\Notation\PianoKey;
use Ucscode\UssElement\Node\ElementNode;
use Ucscode\UssElement\Node\TextNode;

class OctaveBuilder
{
    protected ElementNode $svgGroup;
    protected ?PianoKey $lastNaturalKey = null;
    protected ?PianoKey $lastAccidentalKey = null;

    /**
     * @param Octave[] $octaves
     */
    public function __construct(protected array $octaves)
    {
        $this->svgGroup = new ElementNode('G'); // groups all octave

        foreach ($this->octaves as $octave) {
            $octaveGroup = new ElementNode('G'); // groups an octave
            $octaveGroup->appendChild($this->processPianoKeys($octave->getNaturalKeys()));
            // $octaveGroup->appendChild($this->processPianoKeys($octave->getAccidentalKeys()));
            $this->svgGroup->appendChild($octaveGroup);
        }
    }

    public function getElement(): ElementNode
    {
        return $this->svgGroup;
    }

    /**
     * @param PianoKeys[] $pianoKeys
     */
    protected function processPianoKeys(array $pianoKeys): ElementNode
    {
        $pianoKeyGroup = new ElementNode('G'); // groups natural|accidental keys

        foreach ($pianoKeys as $pianoKey) {
            if ($this->lastNaturalKey) {
                $pianoKey->setX($this->lastNaturalKey->getRight());
            }

            $svgRectNode = new ElementNode('RECT', [
                'fill' => $pianoKey->getFill(),
                'stroke' => $pianoKey->getStroke(),
                'x' => $pianoKey->getX(),
                'y' => $pianoKey->getY(),
                'width' => $pianoKey->getWidth(),
                'height' => $pianoKey->getHeight(),
                'stroke-width' => $pianoKey->getStrokeWidth(),
                'class' => '',
                'data-label' => 'key-white'
            ]);

            $svgTextNode = new ElementNode('TEXT', [
                'x' => $pianoKey->getX() - 5,
                'y' => $pianoKey->getY() - 5,
                'fill' => $pianoKey->getFill(),
                'class' => '',
                'data-svg' => 'text-white'
            ]);

            $textNode = new TextNode($pianoKey->getPitch()->getIdentifier());

            $svgTextNode->appendChild($textNode);
            $svgRectNode->appendChild($svgTextNode);
            $pianoKeyGroup->appendChild($svgRectNode);

            $this->lastNaturalKey = $pianoKey;
        }

        return $pianoKeyGroup;
    }
}
