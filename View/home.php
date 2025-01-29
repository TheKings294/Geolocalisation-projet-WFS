<?php
/**
 * @var array $totalSellPoint
 * @var array $totaluser
 */
?>

<div>
    <h1 class="text-center mt-3">Welcome: <?php echo $_SESSION['username']?></h1>
</div>
<div id="metrixs" class="border rounded mt-5">
    <h4 class="ms-1 mt-1">Metrixs</h4>
    <div class="d-flex justify-content-around">
        <p class="text-warning"><i class="fa-solid fa-shop text-success"></i> <?php echo $totalSellPoint['nb'] . ' Points de vente';?></p>
        <p class="text-warning"><i class="fa-solid fa-user text-success"></i> <?php echo $totaluser['nb'] . ' Utilisateurs'?></p>
    </div>
</div>
<div id="raccourcis" class="border rounded mt-5">
    <h4 class="ms-1 mt-1">Raccourcis</h4>
    <div class="d-flex justify-content-around mb-3">
        <a href="index.php?component=form-sell-point" class="btn btn-success text-warning">Ajouter un Point de vente <i class="fa-solid fa-plus"></i></a>
        <a href="index.php?component=form-user" class="btn btn-success text-warning">Ajouter un Utilisateur <i class="fa-solid fa-plus"></i></a>
    </div>
</div>
