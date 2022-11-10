<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Zyan\LicensePlateNumber\LicensePlateNumber;
use Zyan\LicensePlateNumber\Style\Black;
use Zyan\LicensePlateNumber\Style\Blue;
use Zyan\LicensePlateNumber\Style\White;
use Zyan\LicensePlateNumber\Style\Yellow;

class LicensePlateNumberTest extends TestCase
{
    public function test_blue()
    {
        $plate = new LicensePlateNumber('./temp/');
        $res = $plate->blue('京', 'A', "1", "2", "3", "4", "5");
        $this->assertInstanceOf(Blue::class, $res);
        $this->assertSame('./temp/dbcab59f3f4b10cb698163685034b6d3.png', $res->getFilename());
    }

    public function test_black()
    {
        $plate = new LicensePlateNumber('./temp/');
        $res = $plate->black('粤', 'Z', "6", "7", "8", "9", "港");
        $this->assertInstanceOf(Black::class, $res);
        $this->assertSame('./temp/a0a0bcb8b21d7bf1cd3c20b3fc906bd8.png', $res->getFilename());
    }

    public function test_yellow()
    {
        $plate = new LicensePlateNumber('./temp/');
        $res = $plate->yellow('京', 'A', "6", "7", "8", "9", "0");
        $this->assertInstanceOf(Yellow::class, $res);
        $this->assertSame('./temp/6af8103b5c340489d550010a07f5b678.png', $res->getFilename());
    }

    public function test_white()
    {
        $plate = new LicensePlateNumber('./temp/');
        $res = $plate->white('京', 'B', "1", "2", "3", "4", "警");
        $this->assertInstanceOf(White::class, $res);
        $this->assertSame('./temp/d853feed3fc6943ea47737d26e3d9849.png', $res->getFilename());
    }

//    public function test_blue(){
//        $plate = new LicensePlateNumber('./temp/');
//
//        $a = ["京","津","冀","晋","蒙","辽","吉","黑","沪","苏","浙","皖","闽","赣","鲁","豫","鄂","湘","粤","桂","琼","渝","川","贵","云","藏","陕","甘","青","宁","新","港","澳","使","领","学","警"];
//        $b = "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
//
//        $style = [
//            'black',
//            'blue',
//            'white',
//            'yellow',
//        ];
//
//        foreach ($style as $val){
//            foreach ($a as $v){
//                $plate->$val($v,$b[rand(0,25)],$b[rand(0,35)],$b[rand(0,35)],$b[rand(0,35)],$b[rand(0,35)],$b[rand(0,35)]);
//            }
//        }
//
//        $this->assertTrue(!empty($res));
//    }
}
