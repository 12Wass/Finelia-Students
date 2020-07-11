<?php

include_once('pdoConnect.php'); // Fichier de connexion à PDO

// Vérification des champs envoyés en POST
if (isset($_POST['note']) && isset($_POST['matiere']) && isset($_POST['etudiant'])) {
    if ($_POST['note'] > 20 || $_POST['note'] < 0 || preg_match('#[^0-9]#', $_POST['note'])) {
        $error = 'Vous ne pouvez pas enregistrer une note inférieure à 0, supérieure à 20 ou composée d\'autre chose que des chiffres';
    } else {

        // Sécurisation des données envoyées
        $note = htmlspecialchars($_POST['note']);
        $idMatiere = htmlspecialchars($_POST['matiere']);
        $idEtudiant = htmlspecialchars($_POST['etudiant']);
        
        // Formattage de la note pour MySQL
        $note = floatval(str_replace(',', '.', str_replace('.', '', $note)));
        
        $req = $pdo->prepare('INSERT INTO notes(idMatiere, note, idEtudiant) VALUES (?, ?, ?)');
        $req->execute(array($idMatiere, $note, $idEtudiant));
    }
}

$req = $pdo->prepare('SELECT * FROM etudiant');
$req->execute();
$students = $req->fetchAll(PDO::FETCH_ASSOC);

$req = $pdo->prepare('SELECT * FROM matiere');
$req->execute();
$matieres = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire</title>
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
    <h1 class="text-center">Notes</h1>

    <div class="container">
        <div class="text-center">
            <form action="" method="post">
                <div class="form-group">
                    <label for="etudiant">Etudiant : </label>
                    <select id="etudiant" class="form-control" name="etudiant">
                        <?php foreach ($students as $s) : ?>
                            <option value="<?= $s['id'] ?>"><?= $s['firstname'] . ' ' . $s['lastname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="matiere">Matière : </label>
                    <select id="matiere" class="form-control" name="matiere">
                        <?php foreach ($matieres as $m) : ?>
                            <option value="<?= $m['id'] ?>"><?= $m['nom'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="note">Note : </label>
                    <input type="text" name="note" id="note" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>
</body>

</html>