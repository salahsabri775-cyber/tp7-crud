<?php
require_once '../database/connexion.php';

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duree_mois = trim($_POST['duree_mois'] ?? '');

    if ($titre === '' || $duree_mois === '') {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            // CREATE : requête préparée
            $stmt = $pdo->prepare("INSERT INTO formation (titre, description, duree_mois) VALUES (:titre, :description, :duree_mois)");
            $stmt->execute([':titre' => $titre, ':description' => $description, ':duree_mois' => $duree_mois]);
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
    <title>Ajouter - formation</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Ajouter un(e) formation</h1>
    <?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>

    <form method="post">
    <label for="titre">Titre</label>
    <input type="text" id="titre" name="titre" value="<?= h($_POST['titre'] ?? '') ?>" required>
    <label for="description">Description</label>
    <textarea id="description" name="description" rows="3"><?= h($_POST['description'] ?? '') ?></textarea>
    <label for="duree_mois">Durée (en mois)</label>
    <input type="number" id="duree_mois" name="duree_mois" min="1" value="<?= h($_POST['duree_mois'] ?? '') ?>" required>

        <br>
        <button type="submit" class="btn">Enregistrer</button>
        <a class="btn btn-gray" href="index.php">Annuler</a>
    </form>
</body>
</html>
