<?php

class Demography
{
  public $data = array();
  public $pop = array();
  public $year = array();

  public $arrx = array();
  public $arry = array();

  public $cov = array();
  
  public $fct1 = array();
  public $fct2 = array();

  public $ectx;
  public $ecty;

  public $a1;
  public $b1;
  public $rms1;

  public $a2;
  public $b2;
  public $rms2;

  public $r;

  public function __construct($data, $argv)
  {
    for ($i = 1; $i < sizeof($argv); $i++) {
      for ($k = 0; $k != sizeof($data); $k++) {
        if (strncmp($data[$k][1], $argv[$i], 3) == 0)
          $this->data[$argv[$i]] = $data[$k]; 
      }
    }
  }

  public function fit1Output()
  {
    printf("Fit1\n\t");
    printf("Y = %.2f X - %.2f\n\t", $this->a1 / 1000000, abs($this->b1 / 1000000));
    printf("Root-mean-square deviation: %.2f\n\t", $this->rms1 / 1000000);
    printf("Population in 2050: %.2f\n", (($this->a1 * 2050) - abs($this->b1)) / 1000000);
  }

  public function fit2Output()
  {
    printf("Fit2\n\t");
    printf("X = %.2f Y + %.2f\n\t", $this->a2 * 1000000, $this->b2);
    printf("Root-mean-square deviation: %.2f\n\t", $this->rms2 / 1000000);
    printf("Population in 2050: %.2f\n", ((2050 - $this->b2) / $this->a2) / 1000000);
  }

  public function correlationOutput()
  {
    printf("Correlation: %.4f\n", $this->r);
  }

  public function countryOutput()
  {
    printf("Country: ");
    $i = 0;
    foreach ($this->data as $country) {
      if ($i == 0)
        printf("%s", $country[0]);
      else
        printf(", %s", $country[0]);
      $i += 1;
    }
    printf("\n");
  }

  public function average($arr)
  {
    return (array_sum($arr) / count($arr));
  }
  
  public function correlation()
  {
    $this->r = $this->average($this->cov) / ($this->ectx * $this->ecty);

    $this->a1 = $this->average($this->cov) / pow($this->ecty, 2);
    $this->b1 = $this->average($this->pop) - $this->a1 * $this->average($this->year);

    $this->a2 = $this->average($this->cov) / pow($this->ectx, 2);
    $this->b2 = $this->average($this->year) - $this->a2 * $this->average($this->pop);
  }

  public function arraysDeviation()
  {
    $avx = $this->average($this->pop);
    $avy = $this->average($this->year);

    for ($k = 0; $k != count($this->pop); $k++)
      $this->arrx[$k] = ($this->pop[$k] - $avx);
    for ($k = 0; $k != count($this->year); $k++)
      $this->arry[$k] = ($this->year[$k] - $avy);
  }

  public function covariance()
  {
    for ($k = 0; $k != count($this->arrx); $k++)
      $this->cov[$k] = $this->arrx[$k] * $this->arry[$k];
  }

  public function standardDeviation()
  {
    $this->ectx = sqrt(array_sum($this->arrx) / count($this->arrx));
    $this->ecty = sqrt(array_sum($this->arry) / count($this->arry));
  }

  public function powerArrays()
  {
    for ($k = 0; $k != count($this->arrx); $k++)
      $this->arrx[$k] = pow($this->arrx[$k], 2);
    for ($k = 0; $k != count($this->arry); $k++)
      $this->arry[$k] = pow($this->arry[$k], 2);
  }

  public function rmsDeviation()
  {
    $sum1 = 0;
    $sum2 = 0;

    for ($k = 0; $k != count($this->fct1); $k++)
      $sum1 += pow($this->fct1[$k] - $this->pop[$k], 2);
    $this->rms1 = sqrt($sum1 / count($this->fct1));
    for ($k = 0; $k != count($this->fct2); $k++)
      $sum2 += pow($this->fct2[$k] - $this->pop[$k], 2);
    $this->rms2 = sqrt($sum2 / count($this->fct2));
  }

  public function linearFunction()
  {
    $this->arraysDeviation();
    $this->covariance();
    $this->powerArrays();
    $this->standardDeviation();
    $this->correlation();
  }

  public function mergeDatas()
  {  
    foreach ($this->data as $d) {
      $year = 1958;
      for ($k = 0; $k != sizeof($d) ; $k++, $year++) {
        if ($k < 2)
          continue;
        $this->pop[$k - 2] = 0;
        $this->year[$k - 2] = $year;
      }
    }
    foreach ($this->data as $d) {
      for ($k = 0; $k != sizeof($d) ; $k++) {
        if ($k < 2)
          continue;
        $this->pop[$k - 2] += intval($d[$k]);
      }
    }
  }

  public function estimatedArray()
  {
    $a1 = $this->a1;
    $b1 = abs($this->b1);
    $a2 = $this->a2;
    $b2 = abs($this->b2);

    for ($k = 0; $k != count($this->year); $k++)
      $this->fct1[$k] = ($a1 * $this->year[$k]) - $b1;
    for ($k = 0; $k != count($this->year); $k++)
      $this->fct2[$k] = ($this->year[$k] - $b2) / $a2;
    $this->rmsDeviation();
  }
  
  public function run()
  {
    $this->mergeDatas();
    $this->linearFunction();
    $this->estimatedArray();

    $this->countryOutput();
    $this->fit1Output();
    $this->fit2Output();
    $this->correlationOutput();
  }
}

?>