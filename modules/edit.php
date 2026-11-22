<?php
require_once '../database/connexion.php';

// Récupération de l'identifiant
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Chargement des données existantes
$stmt = $pdo->prepare("SELECT * FROM module WHERE id_module = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header('Location: index.php');
    exit;
}

$formations = $pdo->query("SELECT id_formation, titre FROM formation ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $nombre_heures = trim($_POST['nombre_heures'] ?? '');
    $id_formation = trim($_POST['id_formation'] ?? '');
    $row['titre'] = $titre;
    $row['nombre_heures'] = $nombre_heures;
    $row['id_formation'] = $id_formation;

    if ($titre === '' || $nombre_heures === '' || $id_formation === '') {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            // UPDATE avec clause WHERE
            $stmt = $pdo->prepare("UPDATE module SET titre = :titre, nombre_heures = :nombre_heures, id_formation = :id_formation WHERE id_module = :id");
            $stmt->execute([':titre' => $titre, ':nombre_heures' => $nombre_heures, ':id_formation' => $id_formation, ':id' => $id]);
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
    <title>Modifier - module</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Modifier : module</h1>
    <?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>

    <form method="post">
    <label for="titre">Titre du module</label>
    <input type="text" id="titre" name="titre" value="<?= h($row['titre']) ?>" required>
    <label for="nombre_heures">Nombre d'heures</label>
    <input type="number" id="nombre_heures" name="nombre_heures" min="1" value="<?= h($row['nombre_heures']) ?>" required>
    <label for="id_formation">Formation</label>
    <select id="id_formation" name="id_formation" required>
        <option value="">-- Choisir une formation --</option>
        <?php foreach ($formations as $f): ?>
            <option value="<?= $f['id_formation'] ?>" <?= ((string)$row['id_formation'] === (string)$f['id_formation']) ? 'selected' : '' ?>>
                <?= h($f['titre']) ?>
            </option>
        <?php endforeach; ?>
    </select>

        <br>
        <button type="submit" class="btn">Mettre à jour</button>
        <a class="btn btn-gray" href="index.php">Annuler</a>
    </form>
</body>
</html>
