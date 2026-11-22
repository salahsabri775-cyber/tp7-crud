<?php
require_once '../database/connexion.php';

// Récupération de l'identifiant
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Chargement des données existantes
$stmt = $pdo->prepare("SELECT * FROM formation WHERE id_formation = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header('Location: index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duree_mois = trim($_POST['duree_mois'] ?? '');
    $row['titre'] = $titre;
    $row['description'] = $description;
    $row['duree_mois'] = $duree_mois;

    if ($titre === '' || $duree_mois === '') {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            // UPDATE avec clause WHERE
            $stmt = $pdo->prepare("UPDATE formation SET titre = :titre, description = :description, duree_mois = :duree_mois WHERE id_formation = :id");
            $stmt->execute([':titre' => $titre, ':description' => $description, ':duree_mois' => $duree_mois, ':id' => $id]);
            header('Location: index.php');
            exit;
        } catch (PDOException $ex) {
            $erreur = 'Erreur : données invalides ou déjà existantes.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier - formation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Modifier : formation</h1>
    <?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>

    <form method="post">
    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" value="<?= h($row['titre']) ?>" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="3"><?= h($row['description']) ?></textarea>
    <label for="duree_mois">Durée (en mois)</label>
    <input type="number" id="duree_mois" name="duree_mois" min="1" value="<?= h($row['duree_mois']) ?>" required>

        <br>
        <button type="submit" class="btn">Mettre à jour</button>
        <a class="btn btn-gray" href="index.php">Annuler</a>
    </form>
</body>
</html>
