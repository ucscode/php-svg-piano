<?php

namespace Ucscode\PhpSvgPiano;

class Configuration
{
    protected string $naturalKeyColor = '#fff';
    protected int $naturalKeyWidth = 100;
    protected int $naturalKeyHeight = 250;
    protected string $naturalKeyBorderColor = '#000';
    protected string $accidentalKeyColor = '#0c0c0c';
    protected int $accidentalKeyWidth = 80;
    protected int $accidentalKeyHeight = 200;
    protected string $accidentalKeyBorderColor = '#000';
    protected string $watermarkText = '';
    protected string $fontFamily = 'Arial';
    protected int $fontSize = 12;
    protected string $fontColor = '#000';

    public function getNaturalKeyColor(): string
    {
        return $this->naturalKeyColor;
    }

    public function setNaturalKeyColor(string $color): void
    {
        $this->naturalKeyColor = $color;
    }

    public function getNaturalKeyWidth(): int
    {
        return $this->naturalKeyWidth;
    }

    public function setNaturalKeyWidth(int $width): void
    {
        $this->naturalKeyWidth = $width;
    }

    public function getNaturalKeyHeight(): int
    {
        return $this->naturalKeyHeight;
    }

    public function setNaturalKeyHeight(int $height): void
    {
        $this->naturalKeyHeight = $height;
    }

    public function getNaturalKeyBorderColor(): string
    {
        return $this->naturalKeyBorderColor;
    }

    public function setNaturalKeyBorderColor(string $color): void
    {
        $this->naturalKeyBorderColor = $color;
    }

    public function getAccidentalKeyColor(): string
    {
        return $this->accidentalKeyColor;
    }

    public function setAccidentalKeyColor(string $color): void
    {
        $this->accidentalKeyColor = $color;
    }

    public function getAccidentalKeyWidth(): int
    {
        return $this->accidentalKeyWidth;
    }

    public function setAccidentalKeyWidth(int $width): void
    {
        $this->accidentalKeyWidth = $width;
    }

    public function getAccidentalKeyHeight(): int
    {
        return $this->accidentalKeyHeight;
    }

    public function setAccidentalKeyHeight(int $height): void
    {
        $this->accidentalKeyHeight = $height;
    }

    public function getAccidentalKeyBorderColor(): string
    {
        return $this->accidentalKeyBorderColor;
    }

    public function setAccidentalKeyBorderColor(string $color): void
    {
        $this->accidentalKeyBorderColor = $color;
    }

    public function getWatermarkText(): string
    {
        return $this->watermarkText;
    }

    public function setWatermarkText(string $text): void
    {
        $this->watermarkText = $text;
    }

    public function getFontFamily(): string
    {
        return $this->fontFamily;
    }

    public function setFontFamily(string $family): void
    {
        $this->fontFamily = $family;
    }

    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    public function setFontSize(int $size): void
    {
        $this->fontSize = $size;
    }

    public function getFontColor(): string
    {
        return $this->fontColor;
    }

    public function setFontColor(string $color): void
    {
        $this->fontColor = $color;
    }
}
