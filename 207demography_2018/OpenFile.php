<?php
class OpenFile
{
  public $file = array();

  public function __construct($path, $delim)
  {
    $fn = fopen($path, "r");
    for ($i = 0; !feof($fn); $i++) {
      $res = fgets($fn);
      if ($res != NULL)
        $this->file[$i] = explode($delim, $res);
    }
    fclose($fn);
  }

  public function getFileContent()
  {
    return ($this->file);
  }
}
?>