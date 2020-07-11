<?php

include_once('pdoConnect.php');

$req = $pdo->prepare('SELECT notes.id, idEtudiant, note, coefficient, firstname, lastname FROM notes RIGHT JOIN matiere on matiere.id = notes.idMatiere INNER JOIN etudiant on notes.idEtudiant = etudiant.id');
$req->execute();
$etudiantNotes = $req->fetchAll(PDO::FETCH_ASSOC);

$notesPerStudents = array();
foreach ($etudiantNotes as $key => $en) {
    foreach ($etudiantNotes as $k => $e) {
        // en = tableau qu'on veux comparer aux autres
        // e = les autres tableaux
        if ($en['idEtudiant'] == $e['idEtudiant']) { // Si l'étudiant est le même
            if ($en['id'] == $e['id']) { // Si la note comparée est la même 
                $notesPerStudents[$en['idEtudiant']][] = [
                    'note' => $en['note'],
                    'coefficient' => $en['coefficient'],
                    'firstname' => $en['firstname'],
                    'lastname' => $en['lastname']
                ];
            }
        }
    }
}

// Comparer toutes les notes d'un étudiant et les additionner entre elles

foreach ($notesPerStudents as $key => $studentAverage) {
    $total = 0;
    $totalCoef = 0;
    $notesPerStudents[$key]['moyenne'] = null;
    for ($i = 0; $i < sizeof($studentAverage); $i++) {
        $total += floatval($studentAverage[$i]['note']) * $studentAverage[$i]['coefficient'];
        $totalCoef += $studentAverage[$i]['coefficient'];
    }
    $notesPerStudents[$key]['moyenne'] = $total / $totalCoef;
}

// Récupérer le nom / prénom de l'étudiant et les mettres dans son objet sans faire de requêtes? 
// vérifier si la demande du dessus est réalisable
// sinon faire des requêtes en fonction de la key de l'array qui est = à l'id de l'étudiant.

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moyenne</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <?php include_once('navbar.php'); ?>
    <h1 class="text-center">Moyennes</h1>

    <div class="container">
        <div class="text-center">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Etudiant</th>
                        <th scope="col">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notesPerStudents as $n) : ?>
                        <tr>
                            <th><?= $n[0]['firstname'] . ' ' . $n[0]['lastname'] ?></th>
                            <th><?= $n['moyenne'] ?></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>