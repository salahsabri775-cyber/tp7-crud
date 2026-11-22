<?php
require_once '../database/connexion.php';

// Récupération de l'identifiant
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Chargement des données existantes
$stmt = $pdo->prepare("SELECT * FROM etudiant WHERE id_etudiant = :id");
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    header('Location: index.php');
    exit;
}

$formations = $pdo->query("SELECT id_formation, titre FROM formation ORDER BY titre")->fetchAll(PDO::FETCH_ASSOC);
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $id_formation = trim($_POST['id_formation'] ?? '');
    $row['nom'] = $nom;
    $row['prenom'] = $prenom;
    $row['email'] = $email;
    $row['id_formation'] = $id_formation;

    if ($nom === '' || $prenom === '' || $email === '' || $id_formation === '') {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } else {
        try {
            // UPDATE avec clause WHERE
            $stmt = $pdo->prepare("UPDATE etudiant SET nom = :nom, prenom = :prenom, email = :email, id_formation = :id_formation WHERE id_etudiant = :id");
            $stmt->execute([':nom' => $nom, ':prenom' => $prenom, ':email' => $email, ':id_formation' => $id_formation, ':id' => $id]);
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
    <title>Modifier - étudiant</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <nav>
        <a href="../index.php">Accueil</a>
        <a href="../formations/index.php">Formations</a>
        <a href="../etudiants/index.php">Étudiants</a>
        <a href="../modules/index.php">Modules</a>
    </nav>

    <h1>Modifier : étudiant</h1>
    <?php if ($erreur): ?><div class="erreur"><?= h($erreur) ?></div><?php endif; ?>

    <form method="post">
    <label for="nom">Nom</label>
    <input type="text" id="nom" name="nom" value="<?= h($row['nom']) ?>" required>
    <label for="prenom">Prénom</label>
    <input type="text" id="prenom" name="prenom" value="<?= h($row['prenom']) ?>" required>
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="<?= h($row['email']) ?>" required>
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
