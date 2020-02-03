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
      printf("");
      $line = fgets(STDIN);
      $line = trim(preg_replace('/\s\s+/', ' ', $line));
      if ($line == NULL || strncmp($line, "END", 3) == 0)
        return (0);
      if ($this->error_stdin($line) == 84)
        continue;
      $line = floatval($line);
      printf("%d", $val->number_values());
      $tmp = $val->standard_deviation($line);
      printf("\t%.2f", $val->a - 2 * $tmp);
      printf("\t%.2f", $val->a + 2 * $tmp);
      printf("\t%.2f", $val->arithmetic_mean($line));
      printf("\t%.2f", $val->root_mean_square($line));
      printf("\t%.2f", $val->harmonic_mean($line));
      printf("\n");
    }
    return (0);
  }
}

?>