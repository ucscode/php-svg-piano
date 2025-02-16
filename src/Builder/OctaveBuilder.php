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
        $this->svgGroup = new ElementNode('G', ['data-piano' => '']); // groups all octave

        foreach ($this->octaves as $octave) {
            $groupElement = $octave
                ->setX(0)
                ->arrangePianoKeys()
                ->createGroupElement()
            ;
            $this->svgGroup->appendChild($groupElement);
        }
    }

    public function getElement(): ElementNode
    {
        return $this->svgGroup;
    }

    /**
     * @param PianoKeys[] $pianoKeys
     */

}
