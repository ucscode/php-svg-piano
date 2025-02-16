<?php

namespace Ucscode\PhpSvgPiano\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Ucscode\PhpSvgPiano\Notation\NoteParser;

class PitchTest extends TestCase
{
    #[DataProvider('notesProvider')]
    public function testEnharmonicEquivalence(string $note1, string $note2): void
    {
        $noteParser = new NoteParser();

        $pitch1 = $noteParser->parse($note1);
        $pitch2 = $noteParser->parse($note2);
        
        $this->assertSame(
            $pitch1->getEnharmonicEquivalence()->getIdentifier(),
            $pitch2->getIdentifier()
        );

        $this->assertSame(
            $pitch2->getEnharmonicEquivalence()->getIdentifier(),
            $pitch1->getIdentifier()
        );
    }

    public function notesProvider(): array
    {
        return [
            ['C#', 'D_'],
            ['D#', 'E_'],
            ['F#', 'G_'],
            ['G#', 'A_'],
            ['A#', 'B_'],
        ];
    }
}