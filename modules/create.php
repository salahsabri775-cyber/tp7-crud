<?php
require_once '../database/connexion.php';

$formations = $pdo->query("SELECT id_formation, titre FROM formation ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $nombre_heures = trim($_POST['nombre_heures'] ?? '');
    $id_formation = trim($_POST['id_formation'] ?? '');

    if ($titre === '' || $nombre_heures === '' || $id_formation === '') {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            // CREATE : requête préparée
            $stmt = $pdo->prepare("INSERT INTO module (titre, nombre_heures, id_formation) VALUES (:titre, :nombre_heures, :id_formation)");
            $stmt->execute([':titre' => $titre, ':nombre_heures' => $nombre_heures, ':id_formation' => $id_formation]);
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
    <title>Ajouter - module</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Ajouter un(e) module</h1>
    <?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>

    <form method="post">
    <label for="titre">Titre du module</label>
    <input type="text" id="titre" name="titre" value="<?= h($_POST['titre'] ?? '') ?>" required>
    <label for="nombre_heures">Nombre d'heures</label>
    <input type="number" id="nombre_heures" name="nombre_heures" min="1" value="<?= h($_POST['nombre_heures'] ?? '') ?>" required>
    <label for="id_formation">Formation</label>
    <select id="id_formation" name="id_formation" required>
        <option value="">-- Choisir une formation --</option>
        <?php foreach ($formations as $f): ?>
            <option value="<?= $f['id_formation'] ?>" <?= ((string)($_POST['id_formation'] ?? '') === (string)$f['id_formation']) ? 'selected' : '' ?>>
                <?= h($f['titre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

        <br>
        <button type="submit" class="btn">Enregistrer</button>
        <a class="btn btn-gray" href="index.php">Annuler</a>
    </form>
</body>
</html>
