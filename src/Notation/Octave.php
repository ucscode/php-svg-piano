<?php

namespace Ucscode\PhpSvgPiano\Notation;

use Ucscode\PhpSvgPiano\Builder\Group;
use Ucscode\PhpSvgPiano\Traits\CoordinateTrait;
use Ucscode\PhpSvgPiano\Traits\DimensionTrait;
use Ucscode\UssElement\Enums\NodeTypeEnum;
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
            $pianoKey->setY($this->getY());

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

        $this->alignAccidentalKeys('3rd');
        $this->alignAccidentalKeys('4th');

        return $this;
    }

    public function createSvgElementGroup(): Group
    {
        return (new Group())
            ->set('element', $this->buildElementGroup(NodeTypeEnum::NODE_ELEMENT))
            ->set('text', $this->buildElementGroup(NodeTypeEnum::NODE_TEXT))
        ;
    }

    public function getOctaveGroup(): Group
    {
        $groupA = (new Group())
            ->set('natural', array_slice($this->naturalKeys, 0, 3))
            ->set('accidental', array_slice($this->accidentalKeys, 0, 2))
        ;

        $groupB = (new Group())
            ->set('natural', array_slice($this->naturalKeys, 3))
            ->set('accidental', array_slice($this->accidentalKeys, 2))
        ;

        return (new Group())
            ->set('3rd', $groupA)
            ->set('4th', $groupB)
        ;
    }

    protected function buildElementGroup(NodeTypeEnum $nodeTypeEnum): ElementNode
    {
        $elementGroup = new ElementNode('G', [
            'data-octave' => $this->interval
        ]);

        switch ($nodeTypeEnum) {
            case NodeTypeEnum::NODE_TEXT:
                $elementGroup->appendChild($this->processPianoKeysText($this->naturalKeys, PianoKey::TYPE_NATURAL));
                $elementGroup->appendChild($this->processPianoKeysText($this->accidentalKeys, PianoKey::TYPE_ACCIDENTAL));
                break;
            default:
                $elementGroup->appendChild($this->processPianoKeys($this->naturalKeys, PianoKey::TYPE_NATURAL));
                $elementGroup->appendChild($this->processPianoKeys($this->accidentalKeys, PianoKey::TYPE_ACCIDENTAL));
        }

        return $elementGroup;
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
            $pianoKeyGroup->appendChild($pianoKey->createKeyElement());
        }

        return $pianoKeyGroup;
    }

    /**
     * @param PianoKey[] $pianoKeys
     * @param integer $type
     * @return ElementNode
     */
    protected function processPianoKeysText(array $pianoKeys, int $type): ElementNode
    {
        $pianoTextGroup = new ElementNode('G', [
            'data-text' => $type === PianoKey::TYPE_NATURAL ? 'natural' : 'accidental',
        ]);

        foreach ($pianoKeys as $pianoKey) {
            $pianoTextGroup->appendChild($pianoKey->createTextElement());
        }

        return $pianoTextGroup;
    }

    protected function alignAccidentalKeys(string $groupName): void
    {
        /** @var Group $keyGroup */
        $keyGroup = $this->getOctaveGroup()->get($groupName);
        /** @var PianoKey[] $naturalKeys */
        $naturalKeys = $keyGroup->get('natural');
        /** @var PianoKey[] $accidentalKeys */
        $accidentalKeys = $keyGroup->get('accidental');

        $naturalWidth = array_reduce($naturalKeys, fn (int $width, PianoKey $pianoKey) => $width + $pianoKey->getWidth(), 0);
        $accidentalWidth = array_reduce($accidentalKeys, fn (int $width, PianoKey $pianoKey) => $width + $pianoKey->getWidth(), 0);

        $spaceDiff = ($naturalWidth - $accidentalWidth) / count($naturalKeys);
        $displacement = $naturalKeys[0]->getLeft() + $spaceDiff;

        foreach ($accidentalKeys as $pianoKey) {
            $pianoKey
                ->setX($displacement)
                ->setY($this->getY())
            ;
            $displacement = $pianoKey->getRight() + $spaceDiff;
        }
    }
}
