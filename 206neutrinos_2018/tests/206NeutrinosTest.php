<?php

include "../IO.php";
include "../Errors.php";

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
  public function testErrors()
  {
    $obj = new Errors();
    $this->assertSame(true, true);
    return $obj;
  }

  /**
   * @depends testErrors
   */
  public function testHandler(Errors &$obj)
  {
    $this->assertSame(84, $obj->error_handler(array("binary", "LOL3", 297514, 27912, 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", 1200, "MDR2", 2972912, 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000, 29751, "GENRE", 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000, 297514, 297912, "XD")));

    $this->assertSame(84, $obj->error_handler(array("binary", 12000.01, 297514, 297912, 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", -9912000, 297514, 297912, 4363)));

    $this->assertSame(84, $obj->error_handler(array("binary", 12000, 297514, -297912, 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000, -297514, 297912, 4363)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000, 297514, 297912, -4363)));

    $this->assertSame(0, $obj->error_handler(array("binary", 12000, 297514, 297912, 4363)));
  }

  public function testIO()
  {
    $obj = new IO();
    $this->assertSame(true, true);
    return $obj;
  }

  /**
   * @depends testIO
   */
  public function testStdin(IO &$obj)
  {
    $this->assertSame(84, $obj->error_stdin("TROLLEUR"));
    $this->assertSame(84, $obj->error_stdin(-42));

    $this->assertSame(0, $obj->error_stdin(206));
  }

  public function testNeutrinos()
  {
    $obj = new Neutrinos(array("binary", 12, 43, 55, 1));

    $this->assertSame(12, $obj->n);
    $this->assertSame(43, $obj->a);
    $this->assertSame(55, $obj->h);
    $this->assertSame(1, $obj->sd);
    return $obj;
  }

  /**
   * @depends testNeutrinos
   */
  public function testValues(Neutrinos &$obj)
  {
    $this->assertSame(13, $obj->number_values());
  }
}

?>