<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;
use Ucscode\UssElement\Node\ElementNode;

class Octave
{
    use CoordinateTrait;
    use DimensionTrait;

    /**
     * @var PianoKey[]
     */
    protected array $naturalKeys = [];

    /**
     * @var PianoKey[]
     */
    protected array $accidentalKeys = [];

    public function __construct(protected int $interval, array $naturalKeys, array $accidentalKeys)
    {
        $this->naturalKeys = $this->validateKeys($naturalKeys, PianoKey::TYPE_NATURAL, count(Pitch::NOTES));
        $this->accidentalKeys = $this->validateKeys($accidentalKeys, PianoKey::TYPE_ACCIDENTAL, count(Pitch::NOTES) - 2);
    }

    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @return PianoKey[]
     */
    public function getNaturalKeys(): array
    {
        return $this->naturalKeys;
    }

    /**
     * @return PianoKey[]
     */
    public function getAccidentalKeys(): array
    {
        return $this->accidentalKeys;
    }

    public function arrangePianoKeys(): static
    {
        foreach ($this->naturalKeys as $key => $pianoKey) {
            if (!$key) {
                $pianoKey->setX($this->getX());
                continue;
            }

            $previousPianoKey = $this->naturalKeys[$key - 1];
            $pianoKey->setX($previousPianoKey->getRight());
        }

        if (!empty($this->naturalKeys)) {
            $this->setWidth($this->naturalKeys[count($this->naturalKeys) - 1]->getRight());
        }
        
        // prepare accidental keys relative position
        // example: first black key will be between 0 and 1 natural keys
        $dimensionMapping = [
            0 => [0, 1],
            1 => [1, 2],
            2 => [3, 4],
            3 => [4, 5],
            4 => [5, 6],
        ];
        
        foreach ($this->accidentalKeys as $key => $pianoKey) {
            $relativeNaturals = array_map(fn (int $key) => $this->naturalKeys[$key], $dimensionMapping[$key]);
            $center = ($relativeNaturals[0]->getRight() + $relativeNaturals[1]->getX()) / 2;
            $accidentalX = $center - ($pianoKey->getWidth() / 2);
            $pianoKey->setX($accidentalX);
        }

        return $this;
    }

    public function createGroupElement(): ElementNode
    {
        $pianoKeysElement = new ElementNode('G', [
            'data-octave' => $this->interval
        ]);
        
        $naturalKeysElement = $this->processPianoKeys($this->naturalKeys, PianoKey::TYPE_NATURAL);
        $accidentalKeysElement = $this->processPianoKeys($this->accidentalKeys, PianoKey::TYPE_ACCIDENTAL);

        $pianoKeysElement->appendChild($naturalKeysElement);
        $pianoKeysElement->appendChild($accidentalKeysElement);

        return $pianoKeysElement;
    }

    /**
     * @param PianoKey[] $pianoKeys
     * @return PianoKey[]
     */
    protected function validateKeys(array $pianoKeys, int $type, int $limit): array
    {
        $typeName = PianoKey::TYPE_NATURAL ? 'natural' : 'accidental';

        if (count($pianoKeys) !== $limit) {
            throw new \LogicException(sprintf(
                'Expected exactly %d %s keys, got %d',
                $limit,
                $typeName,
                count($pianoKeys)
            ));
        }

        foreach ($pianoKeys as $pianoKey) {
            if (($limit === 7 && $pianoKey->isAccidental()) || ($limit === 5 && !$pianoKey->isAccidental())) {
                throw new \LogicException('Invalid %s key pairs:', $typeName);
            }
        }

        return $pianoKeys;
    }

    /**
     * @param PianoKey[] $pianoKeys
     * @param integer $type
     * @return ElementNode
     */
    protected function processPianoKeys(array $pianoKeys, int $type): ElementNode
    {
        $pianoKeyGroup = new ElementNode('G', [
            'data-notes' => $type === PianoKey::TYPE_NATURAL ? 'natural' : 'accidental',
        ]); 

        foreach ($pianoKeys as $pianoKey) {
            $pianoKeyGroup->appendChild($pianoKey->createElement());
        }

        return $pianoKeyGroup;
    }
}
