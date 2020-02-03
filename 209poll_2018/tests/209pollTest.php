<?php

include "../Poll.php";
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
  public function testPositiveInteger(Errors &$obj)
  {
    $this->assertSame(false, $obj->positiveInteger(-14));
    $this->assertSame(false, $obj->positiveInteger(0));

    $this->assertSame(true, $obj->positiveInteger(14));
  }

  /**
   * @depends testErrors
   */
  public function testNumeric(Errors &$obj)
  {
    $this->assertSame(84, $obj->error_handler(array("binary", "LOL3", 297514, 27912)));
    $this->assertSame(84, $obj->error_handler(array("binary", 1200, "MDR2", 2972912)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000, 29751, "GENRE")));

    $this->assertSame(0, $obj->error_handler(array("binary", 3, 2, 1)));
  }
  
  /**
   * @depends testErrors
   */
  public function testValues(Errors &$obj)
  {
    $this->assertSame(84, $obj->error_handler(array("binary", 0, 97514, 50)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000.01, 0, 50)));
    $this->assertSame(84, $obj->error_handler(array("binary", -9912000, 297514, 50)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12000.01, -297514, 50)));
    $this->assertSame(84, $obj->error_handler(array("binary", 12, 14, 50)));

    $this->assertSame(0, $obj->error_handler(array("binary", 3, 2, 1)));
  }

  public function testPoll()
  {
    $obj = new Poll(array("binary", 1, 2, 3));
    $this->assertSame(true, true);
    return $obj;
  }

  /**
   * @depends testPoll
   */
  public function testCorrectedVariance(Poll &$obj)
  {
    $this->assertSame(-3, $obj->CorrectedVariance(3, 2, 4));
    $this->assertSame(1.0, $obj->CorrectedVariance(0.5, 2, 0.5));
    $this->assertSame(0, $obj->CorrectedVariance(0, 2, 3));
  }

  /**
   * @depends testPoll
   */
  public function testFinitePopulationCorrection(Poll &$obj)
  {
    $this->assertSame(-0.5, $obj->FinitePopulationCorrection(3, 4));
    $this->assertSame(1 / 3, $obj->FinitePopulationCorrection(4, 3));
    $this->assertSame(0, $obj->FinitePopulationCorrection(4, 4));
  }

  /**
   * @depends testPoll
   */
  public function testConfidenceIntervals(Poll &$obj)
  {
    $this->assertSame(array(0, 1), $obj->ConfidenceIntervals(1, 2, 4));

    $this->assertSame(array(0.0, 0.0), $obj->ConfidenceIntervals(0, 0, 4));
  }
}

?>