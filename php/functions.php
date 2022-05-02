<?php 
function pages (&$tab, $racine, $niv, $num_actuel) {
    //var_dump($tab);
    //echo "<br/>";
    if($racine.$niv.$num_actuel == "A3B3C3D3"){
        array_push($tab, "A3B3C3D3");
        var_dump($tab);
        return $tab;
    }
    if($niv == "A"){
        array_push($tab, "A".$num_actuel);
    }
    else{
        array_push($tab, $racine.$niv.$num_actuel);
    }
    if($num_actuel == 3){
        if($niv == "A"){ //Cas A3
            pages($tab, "A1", 'B', 1);
        }
        else if($niv == "B"){
            if(substr($racine, -1) == '3'){ //Cas A3B3
                pages($tab, "A1B1", 'C', 1);
            }
            else //Cas A1B3
                pages($tab, "A".((string)(substr($racine,-1) - '-1')), 'B', 1);
        }
        else if($niv =="C"){
            if(substr($racine, -1) == '3'){ 
                if(substr($racine, 1,1) == '3') //Cas A3B3C3
                    pages($tab, "A1B1C1", 'D', 1);
                else //Cas A1B3C3
                    pages($tab, "A".((string)(substr($racine,1,1) - '-1')) . 'B1', 'C', 1);
            }
            else { //Cas A1B1C3
                pages($tab, substr($racine, 0, 3) . ((string)(substr($racine,-1) - '-1')), 'C', 1);
            }
        }
        else if($niv =="D"){
            if(substr($racine, -1) == '3'){ //C3
                if(substr($racine, -3, 1) == '3')// B3C3
                    pages($tab, substr($racine, 0, 1) . ((string)(substr($racine,1,1) - '-1')) . 'B1C1', 'D', 1);
                else //Cas A3B1C3D3
                    pages($tab, substr($racine, 0, 3) . ((string)(substr($racine,3,1) - '-1')) . 'C1', 'D', 1);
            }
            else{
                if(substr($racine, -3, 1) == '3'){
                    if(substr($racine, 1,1) == '3') //Cas A3B3C1D3
                        pages($tab, 'A1B1C' . ((string)(substr($racine,-1) - '-1')), 'D', 1);
                }//Cas A1B3C1D3
                    pages($tab, substr($racine, 0, 1) . ((string)(substr($racine,1,1) - '-1')) . 'B1C1', 'D', 1);
                
            }
                }//Cas A3B3C3
                    /*pages($tab, "A1B1C1", 'D', 1);
                else //Cas A1B3C3
                    pages($tab, "A".((string)(substr($racine,1,1) - '-1')) . 'B1', 'C', 1);
            }*/
            else { //Cas A1B1C3
                pages($tab, substr($racine, 0, 3) . ((string)(substr($racine,-1) - '-1')), 'C', 1);
            }
        }
        else if(substr($racine, -1) == '3'){ //Cas où on atteint le dernier choix du niveau parent
            if(count($racine) == 2)
                pages($tab, $racine.$niv.'1', chr((ord($niv)+1)), 1);
        }
        else{ //Cas où on atteint le dernier choix du niveau actuel mais pas parent
            pages($tab, substr($racine,0,strlen($racine)-1).((string)(substr($racine,-1) - '-1')), $niv, 1);
        }
    }
function parentDepart($racine, $nivInter, $nivActu){
    if(count($racine) == 2)
        return substr($racine,-1).'1'.$nivInter.$nivActu.'1';
    else if(count($racine) == 2){
        return substr($racine,-1).((string)(substr($racine,-1) - '-1')).$nivInter.$nivActu.'1';
    }
    else if(substr($racine, -1) == '3'){
        parentDepart(substr($racine,0, strlen($racine)-2),substr($racine, -2,1).'1'.$nivInter, $nivActu);
    }
    else{
        parentDepart(substr($racine,0, strlen($racine)-2),substr($racine, -2,1).'1'.$nivInter, $nivActu);
    }
}
/*$tab = array();
pages($tab, '', 'A', 1);*/
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
                "A3B3C1D1", "A3B3C1D2", "A3B3C1D3", "A3B3C2D1", "A3B3C2D2", "A3B3C2D3", "A3B3C3D1", "A3B3C3D2", "A3B3C3D3",
                );
$pagesImpossible = array();
for($i = 0; $i < count($pagesARenseigner); $i++){ 
    //echo count($pagesARenseigner);
    //var_dump($pagesARenseigner[$i]); //Le str_contains ne fonctionne pas je ne sais pas pourquoi ...
    if($pagesARenseigner[$i] == 'A1' || (strpos($pagesARenseigner[$i], 'A1') !== false && strlen($pagesARenseigner[$i]) >= strlen('A1'))){
      array_push($pagesImpossible, $pagesARenseigner[$i]);
    }
  }
  var_dump($pagesImpossible);
  echo '<br/> ------------------------ <br/>';
  $pagesARenseigner = array_diff($pagesARenseigner, $pagesImpossible);
  var_dump($pagesARenseigner);