<?php 
function pages ($tab, $racine, $niv, $num_actuel) {
    var_dump($tab);
    echo "<br/>";
    if($racine.$niv.$num_actuel == "A3B3C3D3")
        return $tab;
    if($niv == "A"){
        array_push($tab, "A".$num_actuel);
    }
    else{
        array_push($tab, $racine.$niv.$num_actuel);
    }
    if($num_actuel == 3){
        if($niv == "A"){
            pages($tab, "A1", 'B', 1);
        }
        else if(substr($racine, -1) == '3'){ //Cas où on atteint le dernier choix du niveau parent
            pages($tab, $racine.$niv.'1', chr((ord($niv)+1)), 1);
        }
        else{ //Cas où on atteint le dernier choix du niveau actuel mais pas parent
            pages($tab, substr($racine,0,strlen($racine)-1).((string)(substr($racine,-1) - '-1')), $niv, 1);
        }
    }
    else{
        if($niv == "A"){
            pages($tab, null, $niv, $num_actuel+1);
        }
        else{
            pages($tab, $racine, $niv, $num_actuel+1);
        }
    }
};
//echo (string)(substr("1",-1) - '-1');
$tab=array();
var_dump(pages($tab, null, 'A', 1));
?>