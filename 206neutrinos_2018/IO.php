<?php

include "Neutrinos.php";

class IO
{
  public function error_stdin($line)
  {
    if (!is_numeric($line))
      return (84);
    if ($line < 0)
      return (84);
    return (0);
  }

  public function run($argv)
  {
    $val = new Neutrinos($argv);

    while (1) {
      printf("Enter next value: ");
      $line = fgets(STDIN);
      $line = trim(preg_replace('/\s\s+/', ' ', $line));
      if ($line == NULL || strncmp($line, "END", 3) == 0)
        return (0);
      if ($this->error_stdin($line) == 84)
        continue;
      $line = floatval($line);
      printf("\tNumber of values:\t%d\n", $val->number_values());
      printf("\tStandard deviation:\t%.2f\n", $val->standard_deviation($line));
      printf("\tArithmetic mean:\t%.2f\n", $val->arithmetic_mean($line));
      printf("\tRoot mean square:\t%.2f\n", $val->root_mean_square($line));
      printf("\tHarmonic mean:\t\t%.2f\n", $val->harmonic_mean($line));
      printf("\n");
    }
    return (0);
  }
}

?>