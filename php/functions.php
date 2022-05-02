<?php
$pagesARenseigner = array("A1", "A2", "A3", 
                "A1B1", "A1B2", "A1B3", "A2B1", "A2B2", "A2B3", "A3B1", "A3B2", "A3B3", 
                "A1B1C1", "A1B1C2", "A1B1C3", "A1B2C1", "A1B2C2", "A1B2C3", "A1B3C1", "A1B3C2", "A1B3C3", 
                "A2B1C1", "A2B1C2", "A2B1C3", "A2B2C1", "A2B2C2", "A2B2C3", "A2B3C1", "A2B3C2", "A2B3C3",
                "A3B1C1", "A3B1C2", "A3B1C3", "A3B2C1", "A3B2C2", "A3B2C3", "A3B3C1", "A3B3C2", "A3B3C3",
                "A1B1C1D1", "A1B1C1D2", "A1B1C1D3", "A1B1C2D1", "A1B1C2D2", "A1B1C2D3", "A1B1C3D1", "A1B1C3D2", "A1B1C3D3",
                "A1B2C1D1", "A1B2C1D2", "A1B2C1D3", "A1B2C2D1", "A1B2C2D2", "A1B2C2D3", "A1B2C3D1", "A1B2C3D2", "A1B2C3D3",
                "A1B3C1D1", "A1B3C1D2", "A1B3C1D3", "A1B3C2D1", "A1B3C2D2", "A1B3C2D3", "A1B3C3D1", "A1B3C3D2", "A1B3C3D3",
                "A2B1C1D1", "A2B1C1D2", "A2B1C1D3", "A2B1C2D1", "A2B1C2D2", "A2B1C2D3", "A2B1C3D1", "A2B1C3D2", "A2B1C3D3",
                "A2B2C1D1", "A2B2C1D2", "A2B2C1D3", "A2B2C2D1", "A2B2C2D2", "A2B2C2D3", "A2B2C3D1", "A2B2C3D2", "A2B2C3D3",
                "A3B3C1D1", "A3B3C1D2", "A3B3C1D3", "A3B3C2D1", "A3B3C2D2", "A3B3C2D3", "A3B3C3D1", "A3B3C3D2", "A3B3C3D3");
$pagesImpossible = array();
for($i = 0; $i < count($pagesARenseigner); $i++){ 
  if($pagesARenseigner[$i] == 'A1' || (strpos($pagesARenseigner[$i], 'A1') !== false && strlen($pagesARenseigner[$i]) >= strlen('A1'))){
    array_push($pagesImpossible, $pagesARenseigner[$i]);
  }
}
  var_dump($pagesImpossible);
  echo '<br/> ------------------------ <br/>';
  $pagesARenseigner = array_diff($pagesARenseigner, $pagesImpossible);
  var_dump($pagesARenseigner);
?>