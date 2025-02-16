<?php

namespace Ucscode\PhpSvgPiano\Notation;

class Octave
{
    protected int $interval;

    /**
     * @var PianoKey[]
     */
    protected array $naturalKeys = [];

    /**
     * @var PianoKey[]
     */
    protected array $accidentalKeys = [];

    public function __construct(int $interval, array $naturalKeys, array $accidentalKeys)
    {
        $this->interval = $interval;
        $this->naturalKeys = $this->validateKeys($naturalKeys, 'natural', 7);
        $this->accidentalKeys = $this->validateKeys($accidentalKeys, 'accidental', 5);
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
        return $this->naturalKeys;
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
