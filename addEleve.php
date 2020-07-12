<?php

include_once('pdoConnect.php'); 

if (isset($_POST['deleteEtudiant'])){
    $req = $pdo->prepare('DELETE FROM etudiant WHERE id = ?');
    $req->execute(array($_POST['deleteEtudiant']));
    $deleteTrue = "Etudiant supprimé.";
}

if (isset($_POST['firstname']) && isset($_POST['lastname'])) {
        $firstname = htmlspecialchars($_POST['firstname']);
        $lastname = htmlspecialchars($_POST['lastname']);

        
        $req = $pdo->prepare('INSERT INTO etudiant(firstname, lastname) VALUES (?, ?)');
        $req->execute(array($firstname, $lastname));
        $addedStudent = 'Etudiant ajouté';
}

$req = $pdo->prepare('SELECT * FROM etudiant');
$req->execute();
$etudiants = $req->fetchAll(PDO::FETCH_ASSOC);
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
    <?php if (isset($addedStudent)): ?>
        <div class="alert alert-success">
            <?= $addedStudent ?> 
        </div>
    <?php endif; ?> 
    <h1 class="text-center">Ajouter une matière</h1>

    <div class="container">
        <div class="text-center">
            <form action="" method="post">
                <div class="form-group">
                    <label for="firstname">Prénom : </label>
                    <input type="text" name="firstname" id="firstname" class="form-control">
                </div>              
                <div class="form-group">
                    <label for="lastname">Nom : </label>
                    <input type="text" name="lastname" id="lastname" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    </div>

    <h1 class="text-center">Supprimer un élève</h1>

<div class="container">
    <div class="text-center">
        <form action="" method="post">
        <div class="form-group">
                    <label for="deleteEtudiant">Supprimer un élève : </label>
                    <select id="deleteEtudiant" class="form-control" name="deleteEtudiant">
                        <?php foreach ($etudiants as $e) : ?>
                            <option value="<?= $e['id'] ?>"><?= $e['firstname'] . ' ' . $e['lastname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <button type="submit" class="btn btn-danger">Supprimer</button>
        </form>
    </div>
</div>
</body>

</html>