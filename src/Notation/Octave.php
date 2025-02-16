<?php

namespace Ucscode\PhpSvgPiano\Notation;

class Octave
{
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
        $this->naturalKeys = $this->validateKeys($naturalKeys, 'natural', 7);
        $this->accidentalKeys = $this->validateKeys($accidentalKeys, 'accidental', 5);
    }

    public function getIndex(): int
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

    protected function validateKeys(array $pianoKeys, string $name, int $limit): array
    {
        if (count($pianoKeys) !== $limit) {
            throw new \LengthException(sprintf(
                'Expected exactly %d %s keys, got %d',
                $limit,
                $name,
                count($pianoKeys)
            ));
        }

        return $pianoKeys;
    }
}
