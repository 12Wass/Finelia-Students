<?php

include_once('pdoConnect.php'); 

if (isset($_POST['deleteMatiere'])){
    $req = $pdo->prepare('DELETE FROM matiere WHERE id = ?');
    $req->execute(array($_POST['deleteMatiere']));
    $deleteTrue = "Matière supprimée.";
}

if (isset($_POST['matiere']) && isset($_POST['coefficient'])) {
    if (preg_match('#[^0-9]#', $_POST['coefficient'])) {
        $error = 'Vous ne pouvez insérer que des valuers numériques en tant que coefficient';
    } else {

        $coef = htmlspecialchars($_POST['coefficient']);
        $matiere = htmlspecialchars($_POST['matiere']);

        $coef = floatval(str_replace(',', '.', str_replace('.', '', $coef)));
        
        $req = $pdo->prepare('INSERT INTO matiere(nom, coefficient) VALUES (?, ?)');
        $req->execute(array($matiere, $coef));
        $addedTrue = 'Matière ajoutée';
    }
}

$req = $pdo->prepare('SELECT * FROM matiere');
$req->execute();
$matieres = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une matière</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <?php include_once('navbar.php'); ?> 
    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?= $error ?> 
        </div>
    <?php endif; ?> 
    <?php if (isset($deleteTrue)): ?>
        <div class="alert alert-danger">
            <?= $deleteTrue ?> 
        </div>
    <?php endif; ?> 
    <?php if (isset($addedTrue)): ?>
        <div class="alert alert-success">
            <?= $addedTrue ?> 
        </div>
    <?php endif; ?> 
    <h1 class="text-center">Ajouter une matière</h1>

    <div class="container">
        <div class="text-center">
            <form action="" method="post">
                <div class="form-group">
                    <label for="note">Matière : </label>
                    <input type="text" name="matiere" id="matiere" class="form-control">
                </div>              
                <div class="form-group">
                    <label for="note">Coefficient : </label>
                    <input type="text" name="coefficient" id="coefficient" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <h1 class="text-center">Supprimer une matière</h1>

<div class="container">
    <div class="text-center">
        <form action="" method="post">
        <div class="form-group">
                    <label for="deleteMatiere">Supprimer une matière : </label>
                    <select id="deleteMatiere" class="form-control" name="deleteMatiere">
                        <?php foreach ($matieres as $m) : ?>
                            <option value="<?= $m['id'] ?>"><?= $m['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
</body>

</html>