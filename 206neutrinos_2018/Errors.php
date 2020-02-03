<?php
class Errors
{
  public function error_handler($argv)
  {
    if (!is_numeric($argv[1]) || !is_numeric($argv[2]) ||
    !is_numeric($argv[3]) || !is_numeric($argv[4]))
      return (84);
    if ($argv[1] != intval($argv[1]) || $argv[1] < 0)
      return (84);
    if ($argv[2] < 0 || $argv[3] <= 0 || $argv[4] < 0)
      return (84);
    return (0);
  }
}

?>