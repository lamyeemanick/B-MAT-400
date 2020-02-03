<?php

include "../IQ.php";

use PHPUnit\Framework\TestCase;

class IQTest extends TestCase
{
  public function testGetObj()
  {
    $obj = new IQ();
    $this->assertSame(true, true);
    return $obj;
  }

  /**
   * @depends testGetObj
   */
  public function testMicroAndSigma(IQ $obj)
  {
    $this->assertSame(0, $obj->errors_data_gen(100, 15));
    $this->assertSame(0, $obj->errors_data_gen(9999, 91));
    
    $this->assertSame(84, $obj->errors_data_gen(0, 1));
    $this->assertSame(84, $obj->errors_data_gen(-15, 95));
    $this->assertSame(84, $obj->errors_data_gen(90, 0));
  }

  /**
   * @depends testGetObj
   */
  public function testIqValue(IQ $obj)
  {
    $this->assertSame(0, $obj->errors_iq(15), 0);
    $this->assertSame(0, $obj->errors_iq(199), 0);
    $this->assertSame(0, $obj->errors_iq(0), 0);
    $this->assertSame(0, $obj->errors_iq(201), 0);

    $this->assertSame(84, $obj->errors_iq(-5), 0);
  }
}

?>