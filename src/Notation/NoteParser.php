<?php

namespace Ucscode\PhpSvgPiano\Notation;

class NoteParser
{
    /**
     * @param string $input
     * @return Pitch[]
     */
    public function parseAll(string $input): array
    {
        $notes = preg_split('/[\s,]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
        $pitches = [];

        foreach ($notes as $note) {
            $pitches[] = $this->parse($note);
        }

        return $pitches;
    }

    public function parse(string $note): Pitch
    {
        if (preg_match($this->getNoteRegexp(), $note, $matches)) {
            $noteLetter = $matches[1];
            $accidental = $matches[2] ?: '';
            $octave = intval($matches[3] ?: 4); // Default octave is 4

            return new Pitch($noteLetter, $accidental, $octave);
        }

        throw new \InvalidArgumentException("Invalid note format: $note");
    }

    protected function getNoteRegexp(): string
    {
        return sprintf('/^([A-G])([%s%s]?)((?:\-?\d{1,2})?)$/', Pitch::ACCIDENTAL_SHARP, Pitch::ACCIDENTAL_FLAT);
    }
}
