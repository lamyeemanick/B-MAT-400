<?php

class Dowels
{
  public $av = array();
  public $x = array();
  public $Ox = array();
  public $Tx;
  public $p;
  public $chi;
  public $freedom;
  public $distribTable = array();

  public function __construct($argv, $file)
  {
    $this->av = $argv;
    for ($i = 1; $i != count($argv); $i++) {
      $this->Ox[$i - 1] = intval($argv[$i]);
      $this->x[$i - 1] = (string)($i - 1);
      $this->Tx[$i - 1] = 0;
    }
    if (array_sum($this->Ox) != 100)
      exit(84);
    $this->distribTable = $file;
  }

  public function observedArray()
  {
    if (min($this->Ox) >= 10)
      return;
    
    $k = 0;
    $i = 0;
    $tmpx = array();
    $tmpOx = array();
    $tmpTx = array();
    for ($k = 0; $k != count($this->Ox) && $this->Ox[$k] != min($this->Ox); $k++) {
      $tmpOx[$k] = $this->Ox[$k];
      $tmpx[$k] = $this->x[$k];
      $tmpTx[$k] = $this->Tx[$k];
    }
    if ($k == 0 || ($k != count($this->Ox) - 1 && $this->Ox[$k - 1] > $this->Ox[$k + 1])) {
      $tmpOx[$k] = $this->Ox[$k] + $this->Ox[$k + 1];
      $tmpTx[$k] = $this->Tx[$k] + $this->Tx[$k + 1];
      $tmpx[$k] = $this->x[$k] . "-" . $this->x[$k + 1];
      for ($k = $k + 1, $i = $k + 1; $i < count($this->Ox); $i++, $k++) {
        $tmpOx[$k] = $this->Ox[$i];
        $tmpx[$k] = $this->x[$i];
        $tmpTx[$k] = $this->Tx[$i];
      }
    } else if ($k == (count($this->Ox) - 1) || $this->Ox[$k - 1] < $this->Ox[$k + 1]) {
      $tmpOx[$k - 1] += $this->Ox[$k];
      $tmpTx[$k - 1] += $this->Tx[$k];
      $tmpx[$k - 1] .= "-" . $this->x[$k];
      for ($i = $k + 1; $i < count($this->Ox); $i++, $k++) {
        $tmpOx[$k] = $this->Ox[$i];
        $tmpx[$k] = $this->x[$i];
        $tmpTx[$k] = $this->Tx[$i];
      }
    }
    $this->x = $tmpx;
    $this->Ox = $tmpOx;
    $this->Tx = $tmpTx;
    return ($this->observedArray());
  }

  public function displayObservedArray()
  {
    printf("   x\t");
    for ($k = 0; $k != count($this->x) - 1; $k++)
      printf("| %s\t", $this->x[$k]);
    printf("| %s+\t", $this->x[$k]);
    printf("| Total\n");
    printf("  Ox\t");
    for ($k = 0; $k != count($this->Ox); $k++)
      printf("| %d\t", $this->Ox[$k]);
    printf("| %d\n", array_sum($this->Ox));
    printf("  Tx\t");
    for ($k = 0; $k != count($this->Tx); $k++)
      printf("| %.1f\t", $this->Tx[$k]);
    printf("| 100\n");
    printf("Distribution:\t\tB(100, %.4f)\n", $this->p);
  }

  public function cleanArray()
  {
    $k = 0;

    for ($k = 0; $k != count($this->x) - 1; $k++) {
      $tmp = explode('-', $this->x[$k]);
      if (count($tmp) > 2)
        $this->x[$k] = $tmp[0] . "-" . $tmp[count($tmp) - 1];
    }
    $tmp = explode('-', $this->x[$k]);
    if (count($tmp) > 1)
      $this->x[$k] = $tmp[0];
  }

  public function degreeOfFreedom()
  {
    $this->freedom = count($this->Ox) - 2;
    printf("Degrees of freedom:\t%d\n", $this->freedom);
  }

  public function theoreticalP()
  {
    $res = 0;

    for ($i = 1; $i != count($this->av); $i++) {
      $res += $i * $this->av[$i];
    }
    return (($res - 100) / 10000);
  }

  public function factoriel($val)
  {
    if ($val == 0)
      return (1);
    return (($val > 1) ? bcmul($val, $this->factoriel(bcsub($val, 1))) : $val);
  }  

  public function binomialCoef($n, $k)
  {
    $a = $this->factoriel($n);
    $b = $this->factoriel($k);
    $c = $this->factoriel($n - $k);
    return (bcdiv($a, bcmul($b, $c)));
  }

  public function binomialLaw()
  {
    $this->p = $this->theoreticalP();

    for ($k = 0; $k != 50; $k++) {
      $coef = $this->binomialCoef(100, $k);
      $coef = ($coef * (pow($this->p, $k)) * (pow((1 - $this->p), (100 - $k))));
      if ($k < 8)
          $this->Tx[$k] += $coef * 100;
      else
          $this->Tx[8] += $coef * 100;
    }
  }

  public function findInDistribution()
  {
    $k = 1;

    for ($k = 1; $k != count($this->distribTable[$this->freedom]); $k++) {
      if ($this->distribTable[$this->freedom][$k] > $this->chi)
        break;
    }
    printf("Fit validity:\t\t");
    if ($k == 1)
      printf("P > 99%%");
    else if ($k == count($this->distribTable[$this->freedom]))
      printf("P < 1%%");
    else {
      printf("%s < P < %s", $this->distribTable[0][$k], $this->distribTable[0][$k - 1]);
    }
    printf("\n");
  }

  public function chiSquare()
  {
    for ($k = 0; $k != count($this->Ox); $k++)
      $this->chi += pow(($this->Ox[$k] - $this->Tx[$k]), 2) / $this->Tx[$k];
    printf("Chi-squared:\t\t%.3f\n", $this->chi);
  }

  public function run()
  {
    $this->binomialLaw();
    $this->observedArray();
    $this->cleanArray();
    $this->displayObservedArray();
    $this->chiSquare();
    $this->degreeOfFreedom();
    $this->findInDistribution();
  }
}

?>