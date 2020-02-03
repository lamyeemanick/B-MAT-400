<?php

class Poll
{
  public $p;
  public $v;
  public $pop;
  public $etu;
  public $fpc;
  public $conf95 = array();
  public $conf99 = array();

  public function __construct($argv)
  {
    $this->pop = intval($argv[1]);
    $this->etu = intval($argv[2]);
    $this->p = floatval($argv[3]) / 100;
  }

  public function DisplayResults()
  {
    printf("Population size:\t%d\n", $this->pop);
    printf("Sample size:\t\t%d\n", $this->etu);
    printf("Voting intentions:\t%.2f%%\n", $this->p * 100);
    printf("Variance:\t\t%.6f\n", $this->v);
    printf("95%% confidence interval: [%.2f%%; %.2f%%]\n", $this->conf95[0] * 100, $this->conf95[1] * 100);
    printf("99%% confidence interval: [%.2f%%; %.2f%%]\n", $this->conf99[0] * 100, $this->conf99[1] * 100);
  }

  public function CorrectedVariance($p, $fpc, $n)
  {
    return (($p * (1 - $p) * $fpc) / $n);
  }
  
  public function FinitePopulationCorrection($N, $n)
  {
    return (($N - $n) / ($N - 1));
  }

  public function ConfidenceIntervals($p, $const, $v)
  {
    $result = array();

    $result[0] = ($p - ($const * sqrt($v)));
    $result[1] = ($p + ($const * sqrt($v)));
    for ($k = 0; $k != 2; $k ++) {
      if ($result[$k] < 0)
        $result[$k] = 0;
      if ($result[$k] > 1)
        $result[$k] = 1;
    }
    return ($result);
  }

  public function Run()
  {
    $this->fpc = $this->FinitePopulationCorrection($this->pop, $this->etu);
    $this->v = $this->CorrectedVariance($this->p, $this->fpc, $this->etu);
    $this->conf95 = $this->ConfidenceIntervals($this->p, 1.96, $this->v);
    $this->conf99 = $this->ConfidenceIntervals($this->p, 2.58, $this->v);
    $this->DisplayResults();
  }
}

?>