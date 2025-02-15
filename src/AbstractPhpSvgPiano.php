<?php

namespace Ucscode\PhpSvgPiano;

abstract class AbstractPhpSvgPiano
{
    protected const NOTE_REGEXP = '/^[A-G](?:\-|\+)?(?:\d{1,2})?$/';

    protected Configurable $configurable;

    protected int $whiteKeyWidth;
    protected int $whiteKeyHeight;
    protected int $blackKeyWidth;
    protected int $blackKeyHeight;
    protected int $pianoWidth;
    protected int $svgHeight;

    protected array $play = [];
    protected array $octaveRange = [];
    protected array $notesInOctave = [];

    /**
     * The Y axis of the element
     */
    protected int $y = 0;
    protected int $titleSize = 34;
    protected int $marginBottom = 20;
    protected string $canvas;
    protected string $svgName;

    public function resetPiano()
    {
        $this->octaveRange = $this->notesInOctave = [];
        $this->configurable->numberOfOctaves = 1;
        $this->y = 0;
    }

    /**
     * Play piano notes
     *
     * @param null|string|array $validNotes
     * @return void
     */
    protected function play(null|string|array $notes): void
    {
        $this->resetPiano();

        // convert string to array
        is_array($notes) ?: $notes = explode(",", $notes ?? '');

        // capture notes that matches music signature
        $validNotes = preg_grep(self::NOTE_REGEXP, array_map('strtoupper', array_map("trim", $notes)));

        // prepare notes that should be in a set of octave;
        $octaveNotes = [];

        foreach ($validNotes as $note) {
            $pitch = new Pitch($note);
            $accidentalNote = sprintf('%s%s', $pitch->getNote(), $pitch->getAccidental());

            if (in_array($pitch->getAccidentalNote(), array_keys(self::SUBSTITUTION))) {
                // substitute notes that shouldn't have accidentals
                $pitch->setNote(self::SUBSTITUTION[$pitch->getAccidentalNote()]);

                // determine if the substitution caused a change in octave
                switch ($pitch->getNote()) {
                    case 'C':
                        $pitch->getOctave($pitch->getOctave() + 1);
                        $pitch->setAccidental(null);
                        break;
                    case 'B':
                        $pitch->getOctave($pitch->getOctave() - 1);
                        $pitch->setAccidental(null);
                        break;
                }
            };

            // capture the octave;
            $this->octaveRange[] = $pitch->getOctave();

            // add to notes in octave;
            if (!isset($octaveNotes[$pitch->getOctave()])) {
                $octaveNotes[$pitch->getOctave()] = array();
            }
            $octaveNotes[$pitch->getOctave()][] = $noteExpression[0];

        };

        // get the range of octaves;
        if (!empty($this->octaveRange)) {
            $range = $this->octaveRange;
            $this->octaveRange = range(min($range), max($range));
        };

        // save the notes;
        $this->play = $validNotes;

        ksort($octaveNotes);

        foreach ($octaveNotes as $octaveNumber => $notename) {
            $this->notesInOctave[] = array(
                "octave" => $octaveNumber,
                "notes" => $notename
            );
        };

        $octaves = count($this->notesInOctave);

        if ($this->configurable->numberOfOctaves < $octaves) {
            $this->configurable->numberOfOctaves = $octaves;
        }
    }
}
