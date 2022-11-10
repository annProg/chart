<?php

namespace Zyan\LicensePlateNumber;

use Zyan\LicensePlateNumber\Style\Black;
use Zyan\LicensePlateNumber\Style\Blue;
use Zyan\LicensePlateNumber\Style\White;
use Zyan\LicensePlateNumber\Style\Yellow;

class LicensePlateNumber
{
    protected $number = [
        '0' => './resources/font_model/140_0.jpg',
        '1' => './resources/font_model/140_1.jpg',
    ];

    protected $savePath;

    public function __construct($savePath)
    {
        $this->savePath = $savePath;
    }

    public function blue(string ...$plateNumber)
    {
        return new Blue($this->savePath, ...$plateNumber);
    }

    public function black(string ...$plateNumber)
    {
        return new Black($this->savePath, ...$plateNumber);
    }

    public function white(string ...$plateNumber)
    {
        return new White($this->savePath, ...$plateNumber);
    }

    public function yellow(string ...$plateNumber)
    {
        return new Yellow($this->savePath, ...$plateNumber);
    }
}
