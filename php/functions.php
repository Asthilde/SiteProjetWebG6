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
  if((strpos($pagesARenseigner[$i], 'A1B1') !== false && strlen($pagesARenseigner[$i]) > strlen('A1B1'))){
    array_push($pagesImpossible, $pagesARenseigner[$i]);
  }
}
  //var_dump($pagesImpossible);
  echo '<br/> ------------------------ <br/>';
  $pagesARenseigner = array_diff($pagesARenseigner, $pagesImpossible);
  //var_dump($pagesARenseigner); ?>

<body>
<select id="pageChoisie">
  <?php foreach ($pagesARenseigner as $page) { ?>
      <option value="<?= $page ?>"><?= $page ?></option>
    <?php } ?>
</select>
<?php for ($i = 1; $i < 4; $i++) { ?>
<div id="choix<?= $i ?>" class="form-group">
  <label class="col-sm-4 control-label">Choix <?= $i ?> (si c'est la fin de la branche écrire FIN dans l'encadré)</label>
  <div class="col-sm-6">
    <input type="text" name="choix<?= $i ?>" value="" class="form-control" placeholder="Ecrivez le choix <?= $i ?>" <?php if ($i == 1) { ?>required <?php } ?> autofocus>
  </div>
  <div class="col-sm-6">
    <input type="checkbox" id="fin" name="fin<?= $i ?>" value="<?= $i ?>" class="form-control">
    <label for="fin<?= $i ?>">Fin de l'histoire ?</label>
  </div>
  <div class="col-sm-6">
    Nombre de points de vie perdus :
    <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="0" class="form-control" required>
    <label for="pdv<?= $i ?>">0</label>   
    <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="1" class="form-control">
    <label for="pdv<?= $i ?>">1</label> 
    <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="2" class="form-control">
    <label for="pdv<?= $i ?>">2</label> 
    <input type="radio" name="pdv<?= $i ?>" id="pdv<?= $i ?>" value="3" class="form-control">
    <label for="pdv<?= $i ?>">3</label>        
  </div>
</div>
<?php } ?>
<script src="../affichageChoix.js"></script>
</body>