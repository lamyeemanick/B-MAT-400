<?php
class Errors
{
  public function error_handler($argv)
  {
    for ($k = 1; $k != count($argv); $k++) {
      if (!is_numeric($argv[$k]))
        return (84);
      if ($argv[$k] != intval($argv[$k]))
        return (84);
    }
    return (0);
  }
}

?>