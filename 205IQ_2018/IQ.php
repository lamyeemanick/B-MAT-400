<?php
class IQ
{
  public function density($x, $micro, $sigma)
  {
    $deno = exp((-1 * pow($x - $micro, 2)) / (2 * pow($sigma, 2)));
    $nomi = ($sigma * sqrt(2 * M_PI));
    return ($deno / $nomi);
  }

  public function errors_data_gen($av1, $av2)
  {
    if (!is_numeric($av1) || !is_numeric($av2))
      return (84);
    if ($av1 != intval($av1) || $av2 != intval($av2))
      return (84);
    if ($av1 <= 0 || $av1 > 200 || $av2 <= 0)
      return (84);
    return (0);
  }
  
  public function errors_iq($iq)
  {
    if (!is_numeric($iq))
      return (84);
    if ($iq < 0)
      return (84);
    return (0);
  }
  
  public function create_data($argv)
  {
    if ($this->errors_data_gen($argv[1], $argv[2]) == 84)
      return (84);
    for ($i = 0; $i != 201; $i++) {
      $dens = $this->density($i, $argv[1], $argv[2]);
      printf("%d %.5f\n", $i, $dens);
    }
    return (0);
  }
  
  public function minimal_calcul($argv)
  {
    if ($this->errors_data_gen($argv[1], $argv[2]) == 84)
      return (84);
    if ($this->errors_iq($argv[3]) == 84)
      return (84);
    $dens = 0;
    for ($i = 0.001; $i <= (intval($argv[3])); $i += 0.001)
      $dens += $this->density($i, intval($argv[1]), intval($argv[2]));
    printf("%.1f%% of people have an IQ inferior to %d\n", $dens / 10, $argv[3]);
    return (0);
  }
  
  public function interval_calcul($argv)
  {
    if ($this->errors_data_gen($argv[1], $argv[2]) == 84)
      return (84);
    if ($this->errors_iq($argv[3]) == 84 || $this->errors_iq($argv[4]) == 84)
      return (84);
    if (intval($argv[4]) < intval($argv[3]))
      return (84);
    $dens = 0;
    for ($i = intval($argv[3]); $i <= (intval($argv[4])); $i += 0.001)
      $dens += $this->density($i, intval($argv[1]), intval($argv[2]));
    printf("%.1f%% of people have an IQ between %d and %d\n", $dens / 10, $argv[3], $argv[4]);
    return (0);
  }
}

?>