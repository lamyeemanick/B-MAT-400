<?php

class Errors
{
  public function positiveInteger($nb)
  {
    if ($nb != intval($nb))
      return (false);
    if ($nb <= 0)
      return (false);
    return (true);
  }

  public function error_handler($argv)
  {
    if (!is_numeric($argv[1]) || !is_numeric($argv[2]) ||
        !is_numeric($argv[3]))
      return (84);
    if ($this->positiveInteger($argv[1]) == false ||
        $this->positiveInteger($argv[2]) == false)
      return (84);
    if (floatval($argv[3]) < 0 || floatval($argv[3] > 100))
      return (84);
    if ($argv[1] < $argv[2])
      return (84);
    return (0);
  }
}

?>