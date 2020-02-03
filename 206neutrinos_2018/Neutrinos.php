<?php
class Neutrinos
{
    public $n = 0;
    public $a = 0;
    public $h = 0;
    public $sd = 0;

    public function __construct($argv)
    {
      $this->n = $argv[1];
      $this->a = $argv[2];
      $this->h = $argv[3];
      $this->sd = $argv[4];
    }

    public function number_values()
    {
      $this->n += 1;
      return ($this->n);
    }

    public function standard_deviation($line)
    {
      $new_a = (($this->a * ($this->n - 1)) + $line) / $this->n;
      $tmp = (pow($this->sd, 2) + pow($this->a, 2)) * ($this->n - 1);

      $this->sd = sqrt((($tmp + pow($line, 2)) / $this->n) - pow($new_a, 2));
      return ($this->sd);
    }
    
    public function arithmetic_mean($line)
    {
      $this->a = (($this->a * ($this->n - 1)) + $line) / $this->n;
      return ($this->a);
    }

    public function root_mean_square($line)
    {
      $res = sqrt(pow($this->sd, 2) + pow($this->a, 2));
      return ($res);
    }

    public function harmonic_mean($line)
    {
      $this->h = $this->n / ((($this->n - 1) / $this->h) + (1 / $line));
      return ($this->h);
    }
}
?>