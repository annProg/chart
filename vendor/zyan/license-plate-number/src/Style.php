<?php

namespace Zyan\LicensePlateNumber;

use Intervention\Image\ImageManagerStatic as Image;

class Style
{
    protected string $savePath;
    protected array  $plateNumber;
    protected string $filename;
    protected string $fontColor;
    protected string $backgroundPath;
    protected \Intervention\Image\Image $image;

    protected array $style = [
        [
            'x' => 40,
            'y' => 80,
            'size' => 220,
            'font' => 'fonts/platech.ttf',
            'color' => '#FFFFFF'
        ],
        [
            'x' => 270,
            'y' => 40,
            'size' => 220,
            'font' => 'fonts/platech.ttf',
            'color' => '#FFFFFF'
        ]
    ];

    public function __construct(string $savePath, string ...$plateNumber)
    {
        $this->savePath = $savePath;
        $this->plateNumber = $plateNumber;

        $this->make();
    }


    protected function make()
    {
        $backgroundPath = Utils::resources($this->backgroundPath);
        $this->image = Image::make($backgroundPath);

        $this->region();
        $this->city();
        $this->plate();
        $this->save();
    }

    public function region()
    {
        $text = $this->plateNumber[0];
        $region = Image::make(Model::getWord($text, $this->fontColor));
        $this->image->insert($region, 'top-left', 30, 50);
    }

    protected function city()
    {
        $text = $this->plateNumber[1];
        $region = Image::make(Model::getLetter($text, $this->fontColor));
        $this->image->insert($region, 'top-left', 140, 50);
    }

    protected function plate()
    {
        $plateNumber = $this->plateNumber;
        $count = count($plateNumber);
        for ($i = 2;$i < $count;$i++) {
            $text = $plateNumber[$i];

            if (isset(Model::$letter[$text])) {
                $paht = Model::getLetter($text, $this->fontColor);
            } else {
                $paht = Model::getWord($text, $this->fontColor);
            }
            $region = Image::make($paht);
            $this->image->insert($region, 'top-left', 305 + (($i - 2) * 114), 50);
        }
    }

    protected function save()
    {
        $this->filename = $this->savePath.md5(join('', $this->plateNumber)).'.png';
        $this->image->save($this->filename);
    }

    public function getFilename()
    {
        return $this->filename;
    }
}
